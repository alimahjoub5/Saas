<?php

use App\Models\Lead;
use App\Services\LeadScoringService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('scores a lead with the transparent formula', function (): void {
    $lead = Lead::factory()->make([
        'budget' => 1500,
        'skills' => ['Laravel', 'SEO'],
    ]);

    $analysis = [
        'skills' => ['Laravel', 'SEO', 'React'],
        'red_flags' => ['low_budget'],
    ];

    $service = new LeadScoringService();
    $score = $service->score($lead, $analysis);

    expect($score['score'])->toBeGreaterThan(0);
    expect($score['skills_match'])->toBeGreaterThan(0);
});
