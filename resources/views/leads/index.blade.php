@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <div>
            <h2>Leads</h2>
            <p class="muted">Showing compliant sources only (email/RSS/API/manual/CSV).</p>
        </div>
        <button class="button">Add Lead / Adicionar</button>
    </div>

    <div class="filters">
        <label>
            Stage
            <select>
                <option>All</option>
                <option>New</option>
                <option>Qualified</option>
                <option>Proposal Drafted</option>
            </select>
        </label>
        <label>
            Language
            <select>
                <option>Any</option>
                <option>Português</option>
                <option>Français</option>
                <option>English</option>
            </select>
        </label>
        <label>
            Platform
            <select>
                <option>All</option>
                <option>Upwork (email alert)</option>
                <option>Malt (RSS)</option>
                <option>Manual</option>
            </select>
        </label>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Platform</th>
            <th>Budget</th>
            <th>Language</th>
            <th>Score</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Restaurant website redesign</td>
            <td>Manual</td>
            <td>€1,200</td>
            <td>PT</td>
            <td><span class="pill success">82</span></td>
            <td><a href="{{ route('leads.show', 1) }}">View</a></td>
        </tr>
        <tr>
            <td>Landing page + SEO setup</td>
            <td>LinkedIn alert</td>
            <td>€800</td>
            <td>EN</td>
            <td><span class="pill">68</span></td>
            <td><a href="{{ route('leads.show', 2) }}">View</a></td>
        </tr>
        </tbody>
    </table>
</section>
@endsection
