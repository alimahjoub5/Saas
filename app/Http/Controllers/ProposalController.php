<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateProposalJob;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProposalController extends Controller
{
    public function store(Request $request, Lead $lead): Response
    {
        $this->authorize('view', $lead);

        $validated = $request->validate([
            'tone' => ['nullable', 'string', 'max:50'],
            'placeholders' => ['nullable', 'array'],
        ]);

        GenerateProposalJob::dispatch(
            leadId: $lead->id,
            tone: $validated['tone'] ?? 'professional',
            placeholders: $validated['placeholders'] ?? []
        );

        return response(['status' => 'queued'], 202);
    }
}
