<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyzeLeadJob;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LeadController extends Controller
{
    public function index(Request $request): Response
    {
        $leads = Lead::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return response($leads);
    }

    public function store(Request $request): Response
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'budget' => ['nullable', 'numeric'],
            'skills' => ['nullable', 'array'],
            'platform' => ['nullable', 'string'],
            'url' => ['nullable', 'url'],
            'posted_at' => ['nullable', 'date'],
            'client_country' => ['nullable', 'string', 'max:255'],
            'language' => ['nullable', 'string', 'max:10'],
            'tags' => ['nullable', 'array'],
            'raw_text' => ['nullable', 'string'],
        ]);

        $dedupeHash = hash('sha256', strtolower(($validated['title'] ?? '') . '|' . ($validated['description'] ?? '')));

        $lead = Lead::create([
            'user_id' => $request->user()->id,
            'source_id' => null,
            'dedupe_hash' => $dedupeHash,
            'status' => 'new',
            ...$validated,
        ]);

        AnalyzeLeadJob::dispatch($lead->id);

        return response($lead, 201);
    }
}
