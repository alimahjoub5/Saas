<?php

namespace App\Jobs;

use App\Models\Lead;
use App\Services\EmailParserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IngestEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public int $userId,
        public int $sourceId,
        public string $rawEmail
    ) {
    }

    public function handle(EmailParserService $parser): void
    {
        $normalized = $parser->parse($this->rawEmail);
        $dedupeHash = hash('sha256', strtolower(($normalized['title'] ?? '') . '|' . ($normalized['description'] ?? '')));

        Lead::updateOrCreate(
            ['user_id' => $this->userId, 'url' => $normalized['url'] ?? null],
            [
                'source_id' => $this->sourceId,
                'title' => $normalized['title'] ?? 'Untitled lead',
                'description' => $normalized['description'] ?? null,
                'budget' => $normalized['budget'] ?? null,
                'skills' => $normalized['skills'] ?? [],
                'platform' => $normalized['platform'] ?? null,
                'posted_at' => $normalized['posted_at'] ?? null,
                'client_country' => $normalized['client_country'] ?? null,
                'language' => $normalized['language'] ?? null,
                'tags' => $normalized['tags'] ?? [],
                'raw_text' => $normalized['raw_text'] ?? $this->rawEmail,
                'dedupe_hash' => $dedupeHash,
                'status' => 'new',
            ]
        );
    }
}
