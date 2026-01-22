<?php

use App\Jobs\AnalyzeLeadJob;
use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;

uses(RefreshDatabase::class);

it('creates a lead and queues analysis', function (): void {
    Bus::fake();

    $user = \App\Models\User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/leads', [
        'title' => 'Restaurant website redesign',
        'description' => 'Need a responsive redesign with WhatsApp integration.',
        'budget' => 1200,
        'skills' => ['Laravel', 'React'],
    ]);

    $response->assertCreated();
    expect(Lead::count())->toBe(1);
    Bus::assertDispatched(AnalyzeLeadJob::class);
});
