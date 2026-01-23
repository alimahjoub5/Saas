<?php

namespace App\Jobs;

use App\Models\Lead;
use App\Models\Proposal;
use App\Services\OpenAIService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateProposalJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public int $leadId,
        public string $tone = 'professional',
        public array $placeholders = []
    ) {
    }

    public function handle(OpenAIService $openAI): void
    {
        $lead = Lead::query()->with('analysis')->findOrFail($this->leadId);

        $proposalPayload = $openAI->generateProposal(
            lead: $lead,
            tone: $this->tone,
            placeholders: $this->placeholders
        );

        Proposal::create([
            'lead_id' => $lead->id,
            'tone' => $this->tone,
            'short_text' => $proposalPayload['short'] ?? null,
            'medium_text' => $proposalPayload['medium'] ?? null,
            'whatsapp_text' => $proposalPayload['whatsapp'] ?? null,
            'placeholders' => $proposalPayload['placeholders'] ?? $this->placeholders,
            'status' => 'draft',
        ]);
    }
}
