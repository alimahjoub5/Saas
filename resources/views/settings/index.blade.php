@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <div>
            <h2>Settings / Configurações</h2>
            <p class="muted">Manage OpenAI keys, compliance mode, and lead sources.</p>
        </div>
        <button class="button">Save settings</button>
    </div>

    <div class="grid-2">
        <div class="card">
            <h3>OpenAI</h3>
            <label class="field">
                API Key
                <input type="password" placeholder="sk-...">
            </label>
            <label class="field">
                Model
                <input type="text" value="gpt-4o-mini">
            </label>
        </div>
        <div class="card">
            <h3>Compliance Mode</h3>
            <p class="muted">Only allow official APIs, RSS, email alerts, manual links, and CSV imports.</p>
            <label class="field inline">
                <input type="checkbox" checked>
                Compliance Mode (ON)
            </label>
        </div>
    </div>
</section>
@endsection
