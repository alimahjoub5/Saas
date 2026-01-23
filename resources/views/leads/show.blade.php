@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <div>
            <h2>Restaurant website redesign</h2>
            <p class="muted">Manual • PT • Posted 2 days ago</p>
        </div>
        <div class="cta-row">
            <a class="button secondary" href="{{ route('proposals.generator') }}">Generate Proposal</a>
            <button class="button">Move Stage</button>
        </div>
    </div>

    <div class="grid-2">
        <div class="card">
            <h3>Summary</h3>
            <ul>
                <li>Redesign a modern restaurant website.</li>
                <li>Needs WhatsApp integration and booking form.</li>
                <li>SEO-ready pages in Portuguese.</li>
                <li>Mobile-first design.</li>
                <li>Budget confirmed for a 3-week delivery.</li>
            </ul>
        </div>
        <div class="card">
            <h3>Scoring</h3>
            <p><strong>Score:</strong> 82</p>
            <p>Skills match: 90 • Budget fit: 80 • Clarity: 75</p>
            <p class="muted">Formula: (skills*0.4 + budget*0.2 + urgency*0.1 + clarity*0.1 + niche*0.2) - red flags</p>
        </div>
    </div>

    <div class="grid-2">
        <div class="card">
            <h3>Details</h3>
            <p><strong>Budget:</strong> €1,200</p>
            <p><strong>Skills:</strong> Laravel, React, SEO, WhatsApp API</p>
            <p><strong>Client Country:</strong> Portugal</p>
            <p><strong>URL:</strong> https://example.com/job/lead-123</p>
        </div>
        <div class="card">
            <h3>Notes & Tasks</h3>
            <textarea class="textarea" rows="5" placeholder="Add notes or next steps..."></textarea>
            <button class="button secondary">Add follow-up task</button>
        </div>
    </div>
</section>
@endsection
