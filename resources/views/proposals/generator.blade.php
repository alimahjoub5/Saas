@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <div>
            <h2>Proposal Generator / Gerador de Propostas</h2>
            <p class="muted">Generate compliant drafts with placeholders and a clear CTA.</p>
        </div>
        <button class="button">Generate Draft</button>
    </div>

    <div class="grid-2">
        <div class="card">
            <h3>Inputs</h3>
            <label class="field">
                Language
                <select>
                    <option>Português</option>
                    <option>English</option>
                    <option>Français</option>
                </select>
            </label>
            <label class="field">
                Tone
                <select>
                    <option>Professional</option>
                    <option>Friendly</option>
                    <option>Consultative</option>
                </select>
            </label>
            <label class="field">
                Portfolio links
                <input type="text" placeholder="https://portfolio.example.com">
            </label>
            <label class="field">
                CTA
                <input type="text" value="Would you like a quick call to align on scope?">
            </label>
        </div>
        <div class="card">
            <h3>Draft preview</h3>
            <div class="preview">
                <p><strong>Short (<= 900 chars)</strong></p>
                <p>Hello {{ '{{client_name}}' }}, I can help redesign your restaurant site with a clean, mobile-first UI and WhatsApp booking. This is customizable / adaptável. Could we align on timeline and content availability? What is your preferred launch date? Would you like to review my recent restaurant demos {{ '{{portfolio_link_1}}' }}?</p>
                <p class="muted">CTA: {{ '{{cta}}' }}</p>
            </div>
        </div>
    </div>
</section>
@endsection
