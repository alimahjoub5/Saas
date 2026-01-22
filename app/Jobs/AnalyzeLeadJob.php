<?php

namespace App\Jobs;

use App\Models\Lead;
use App\Models\LeadAnalysis;
use App\Services\LeadScoringService;
use App\Services\OpenAIService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AnalyzeLeadJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public int $leadId)
    {
    }

    public function handle(OpenAIService $openAI, LeadScoringService $scoring): void
    {
        $lead = Lead::query()->findOrFail($this->leadId);

        $analysis = $openAI->analyzeLead($lead);
        $scorePayload = $scoring->score($lead, $analysis);

        LeadAnalysis::updateOrCreate(
            ['lead_id' => $lead->id],
            [
                'summary' => $analysis['summary'] ?? [],
                'skills' => $analysis['skills'] ?? [],
                'language' => $analysis['language'] ?? null,
                'red_flags' => $analysis['red_flags'] ?? [],
                'scoring' => $scorePayload,
                'prompt_log_id' => $analysis['prompt_log_id'] ?? null,
            ]
        );
    }
}
