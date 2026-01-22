<?php

namespace App\Http\Controllers;

use App\Models\LeadSource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SourceController extends Controller
{
    public function index(Request $request): Response
    {
        $sources = LeadSource::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response($sources);
    }

    public function store(Request $request): Response
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:email,rss,api,manual,csv'],
            'config' => ['nullable', 'array'],
        ]);

        $source = LeadSource::create([
            'user_id' => $request->user()->id,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'config' => $validated['config'] ?? null,
        ]);

        return response($source, 201);
    }
}
