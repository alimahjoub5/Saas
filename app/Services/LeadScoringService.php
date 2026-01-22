<?php

namespace App\Services;

use App\Models\Lead;

class LeadScoringService
{
    public function score(Lead $lead, array $analysis): array
    {
        $skillsMatch = $analysis['skills_match'] ?? $this->estimateSkillsMatch($lead, $analysis);
        $budgetFit = $analysis['budget_fit'] ?? $this->estimateBudgetFit($lead);
        $urgency = $analysis['urgency'] ?? 50;
        $clarity = $analysis['clarity'] ?? 50;
        $nicheMatch = $analysis['niche_match'] ?? 50;
        $redFlagsPenalty = $analysis['red_flags_penalty'] ?? min(count($analysis['red_flags'] ?? []) * 5, 30);

        $score = (
            ($skillsMatch * 0.4)
            + ($budgetFit * 0.2)
            + ($urgency * 0.1)
            + ($clarity * 0.1)
            + ($nicheMatch * 0.2)
        ) - $redFlagsPenalty;

        return [
            'skills_match' => $skillsMatch,
            'budget_fit' => $budgetFit,
            'urgency' => $urgency,
            'clarity' => $clarity,
            'niche_match' => $nicheMatch,
            'red_flags' => $analysis['red_flags'] ?? [],
            'red_flags_penalty' => $redFlagsPenalty,
            'score' => max(0, min(100, round($score))),
        ];
    }

    protected function estimateSkillsMatch(Lead $lead, array $analysis): int
    {
        $skills = collect($analysis['skills'] ?? [])->map(fn ($skill) => strtolower((string) $skill));
        $leadSkills = collect($lead->skills ?? [])->map(fn ($skill) => strtolower((string) $skill));

        if ($skills->isEmpty() || $leadSkills->isEmpty()) {
            return 50;
        }

        $intersection = $skills->intersect($leadSkills)->count();
        $ratio = $intersection / max($leadSkills->count(), 1);

        return (int) round($ratio * 100);
    }

    protected function estimateBudgetFit(Lead $lead): int
    {
        if (! $lead->budget) {
            return 50;
        }

        if ($lead->budget >= 1000) {
            return 80;
        }

        if ($lead->budget >= 500) {
            return 65;
        }

        return 40;
    }
}
