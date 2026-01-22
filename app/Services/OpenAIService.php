<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\PromptLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    public function analyzeLead(Lead $lead): array
    {
        $payload = [
            'model' => config('leadpilot.openai.model'),
            'temperature' => 0.2,
            'messages' => [
                ['role' => 'system', 'content' => $this->systemPrompt('analysis')],
                ['role' => 'user', 'content' => $this->leadAnalysisPrompt($lead)],
            ],
        ];

        $response = $this->request($payload, $lead->user_id);

        return [
            'summary' => $response['summary'] ?? [],
            'skills' => $response['skills'] ?? [],
            'language' => $response['language'] ?? null,
            'red_flags' => $response['red_flags'] ?? [],
            'prompt_log_id' => $response['prompt_log_id'] ?? null,
        ];
    }

    public function generateProposal(Lead $lead, string $tone, array $placeholders): array
    {
        $payload = [
            'model' => config('leadpilot.openai.model'),
            'temperature' => 0.4,
            'messages' => [
                ['role' => 'system', 'content' => $this->systemPrompt('proposal')],
                ['role' => 'user', 'content' => $this->proposalPrompt($lead, $tone, $placeholders)],
            ],
        ];

        return $this->request($payload, $lead->user_id);
    }

    protected function request(array $payload, ?int $userId): array
    {
        $promptLog = PromptLog::create([
            'user_id' => $userId,
            'model' => $payload['model'],
            'prompt' => $payload,
        ]);

        $response = Http::withToken(config('leadpilot.openai.key'))
            ->retry(3, 500, function ($exception): bool {
                return str_contains($exception->getMessage(), '429');
            })
            ->post(config('leadpilot.openai.endpoint'), $payload);

        if ($response->failed()) {
            Log::warning('OpenAI request failed', ['status' => $response->status(), 'body' => $response->body()]);
            return [];
        }

        $json = $response->json();
        $content = $json['choices'][0]['message']['content'] ?? '{}';
        $decoded = json_decode($content, true) ?? [];

        $promptLog->update([
            'response' => $json,
            'tokens_in' => $json['usage']['prompt_tokens'] ?? null,
            'tokens_out' => $json['usage']['completion_tokens'] ?? null,
        ]);

        $decoded['prompt_log_id'] = $promptLog->id;

        return $decoded;
    }

    protected function systemPrompt(string $type): string
    {
        if ($type === 'proposal') {
            return 'You are a proposal writer. Do not claim you already built the project. Include placeholders. Always include "customizable / adaptável", a CTA, and 2-3 quick questions. Return strict JSON.';
        }

        return 'You are a compliance-first assistant. Summarize the job in 5 bullets, extract required skills, detect language (PT/EN/FR/other), and list red flags. Return strict JSON.';
    }

    protected function leadAnalysisPrompt(Lead $lead): string
    {
        return "Lead:\n" . json_encode([
            'title' => $lead->title,
            'description' => $lead->description,
            'budget' => $lead->budget,
            'skills' => $lead->skills,
            'platform' => $lead->platform,
            'url' => $lead->url,
            'posted_at' => optional($lead->posted_at)->toIso8601String(),
            'client_country' => $lead->client_country,
            'language' => $lead->language,
        ], JSON_PRETTY_PRINT);
    }

    protected function proposalPrompt(Lead $lead, string $tone, array $placeholders): string
    {
        $payload = [
            'lead' => [
                'title' => $lead->title,
                'description' => $lead->description,
                'budget' => $lead->budget,
                'skills' => $lead->skills,
                'language' => $lead->language,
            ],
            'tone' => $tone,
            'placeholders' => $placeholders,
        ];

        return 'Generate proposal JSON for: ' . json_encode($payload, JSON_PRETTY_PRINT);
    }
}
