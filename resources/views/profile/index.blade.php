@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <div>
            <h2>Perfil & Portfólio</h2>
            <p class="muted">Ali Mahjoub • Independent Web Developer / MDev Solutions</p>
        </div>
        <button class="button">Edit Profile</button>
    </div>

    <div class="grid-2">
        <div class="card">
            <h3>Profile snapshot</h3>
            <p><strong>Markets:</strong> Portugal, EU</p>
            <p><strong>Languages:</strong> Português, Français, English, Tunisian Arabic</p>
            <p><strong>Services:</strong> Website redesign, SEO-ready landing pages, reservation systems, WhatsApp integration</p>
        </div>
        <div class="card">
            <h3>Portfolio highlights</h3>
            <ul>
                <li>Restaurant website redesign (PT)</li>
                <li>Modern SaaS landing page demo</li>
                <li>Reservation system with WhatsApp follow-ups</li>
            </ul>
        </div>
    </div>
</section>
@endsection
