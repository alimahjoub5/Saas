# LeadPilot (Freelance Client Acquisition OS)

LeadPilot is a compliance-first system to help freelancers acquire clients using **only allowed sources** (official APIs, RSS, email alerts, CSV imports, and manual links). No scraping behind login, no paywall bypass, and no automated spam.

## Milestones

**Milestone 1 (MVP)**
- Lead ingestion (manual + CSV)
- CRM pipeline + notes/tasks
- Proposal generator (manual, language-aware)

**Milestone 2**
- Email ingestion (Gmail OAuth)
- AI scoring + portfolio matching
- Follow-up scheduler (templates only)

## Quick Start (Docker)

```bash
cp .env.example .env
docker compose up -d --build
docker compose exec app php artisan migrate --seed
```

## Compliance Guardrails
- Allowed sources: API, RSS, Email alerts, Manual inputs, CSV
- No automated mass messaging
- No scraping behind login
- No bypassing platform rules

## UI (Portuguese hints)
- Dashboard (Resumo)
- Leads (Leads)
- Proposal Generator (Gerador de Propostas)
- Profile/Portfolio (Perfil/Portfólio)
- Settings (Configurações)
