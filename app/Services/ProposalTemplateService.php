<?php

namespace App\Services;

class ProposalTemplateService
{
    public function defaultPlaceholders(): array
    {
        return [
            'client_name' => '{{client_name}}',
            'project_name' => '{{project_name}}',
            'portfolio_link_1' => '{{portfolio_link_1}}',
            'portfolio_link_2' => '{{portfolio_link_2}}',
        ];
    }
}
