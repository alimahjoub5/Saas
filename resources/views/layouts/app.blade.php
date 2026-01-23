<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LeadPilot</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<header class="topbar">
    <div class="brand">
        <span class="brand-mark">LP</span>
        <div>
            <h1>LeadPilot</h1>
            <p>Freelance Client Acquisition OS</p>
        </div>
    </div>
    <div class="compliance">
        <span class="pill">Compliance Mode: ON</span>
    </div>
</header>

<nav class="nav">
    <a href="{{ route('dashboard') }}">Dashboard / Resumo</a>
    <a href="{{ route('leads.index') }}">Leads / Oportunidades</a>
    <a href="{{ route('proposals.generator') }}">Gerador de Propostas</a>
    <a href="{{ route('profile.index') }}">Perfil & Portfólio</a>
    <a href="{{ route('settings.index') }}">Configurações</a>
</nav>

<main class="container">
    @yield('content')
</main>
</body>
</html>
