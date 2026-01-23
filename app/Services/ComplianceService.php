<?php

namespace App\Services;

class ComplianceService
{
    public function allowedSourceTypes(): array
    {
        return ['email', 'rss', 'api', 'manual', 'csv'];
    }

    public function isAllowedSource(string $type): bool
    {
        return in_array($type, $this->allowedSourceTypes(), true);
    }
}
