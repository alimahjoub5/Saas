@extends('layouts.app')

@section('content')
<section class="hero">
    <div>
        <h2>Welcome, Ali Mahjoub 👋</h2>
        <p>Focus on compliant lead sources: email alerts, RSS feeds, official APIs, and manual imports.</p>
        <div class="cta-row">
            <a class="button" href="{{ route('leads.index') }}">Review new leads</a>
            <a class="button secondary" href="{{ route('proposals.generator') }}">Generate proposal</a>
        </div>
    </div>
    <div class="stat-grid">
        <div class="stat-card">
            <p class="label">New Leads</p>
            <h3>12</h3>
            <p class="muted">Last 7 days</p>
        </div>
        <div class="stat-card">
            <p class="label">Qualified</p>
            <h3>5</h3>
            <p class="muted">Score ≥ 70</p>
        </div>
        <div class="stat-card">
            <p class="label">Proposals Drafted</p>
            <h3>3</h3>
            <p class="muted">Awaiting review</p>
        </div>
    </div>
</section>

<section class="section">
    <h3>Pipeline (Kanban)</h3>
    <div class="kanban">
        @foreach (['New', 'Qualified', 'Proposal Drafted', 'Sent', 'Follow-up', 'Call', 'Won', 'Lost'] as $stage)
            <div class="kanban-column">
                <h4>{{ $stage }}</h4>
                <div class="kanban-card">Placeholder lead</div>
            </div>
        @endforeach
    </div>
</section>
@endsection
