# LeadPilot (Freelance Client Acquisition OS)

## A) High-level architecture diagram (text-based)

```
[Sources]
  ├─ Gmail OAuth → Email Alerts
  ├─ RSS Feeds
  ├─ Official APIs (Plugins)
  ├─ Manual Job URL / Form
  └─ CSV Import
        │
        ▼
[Ingestion Layer]
  - Source connectors (compliance-checked)
  - Raw payload store (audit)
  - Normalizer & Deduper
        │
        ▼
[Lead Core]
  - Lead schema + tags + attachments
  - CRM Pipeline (Kanban)
        │
        ▼
[AI Layer]
  - OpenAI Service + Prompt Logs
  - Summaries, skills extraction, language detection
  - Fit scoring + red flags
        │
        ▼
[Proposal Studio]
  - Multi-tone proposals (short/medium/WhatsApp)
  - Placeholders + CTA + questions
        │
        ▼
[User Actions]
  - Manual review & send via platform
  - Follow-up scheduler (templates only)

[Observability]
  - Audit trail, logs, rate-limit metrics

[Compliance Mode]
  - Allowlist: API/RSS/Email/Manual/CSV
  - Blocks mass messaging & ToS violations
```

## B) Database schema (tables + key fields)

- `users`: id, name, email, password, locale, compliance_mode, created_at
- `profiles`: user_id, bio, services, pricing_packs, tech_stack, languages, positioning
- `portfolio_items`: profile_id, title, description, url, tags, industry
- `lead_sources`: id, user_id, name, type (email/rss/api/manual/csv), config (json), last_synced_at
- `leads`: id, user_id, source_id, title, description, budget, skills (json), platform, url, posted_at, client_country, language, tags (json), raw_text, dedupe_hash, status, created_at
- `lead_attachments`: lead_id, filename, path, mime_type, size
- `lead_analyses`: lead_id, summary (json), skills (json), language, red_flags (json), scoring (json), prompt_log_id
- `proposals`: lead_id, tone, short_text, medium_text, whatsapp_text, placeholders (json), status
- `crm_stages`: id, name, order
- `lead_activities`: lead_id, user_id, type, metadata (json), created_at
- `tasks`: lead_id, user_id, title, due_at, status
- `prompt_logs`: id, user_id, model, prompt (json), response (json), tokens_in, tokens_out, created_at
- `audit_logs`: user_id, action, subject_type, subject_id, metadata (json), created_at

## C) Laravel folder/module structure

```
app/
  Http/
    Controllers/
      LeadController.php
      SourceController.php
      ProposalController.php
    Middleware/
      ComplianceMode.php
  Jobs/
    IngestEmailJob.php
    AnalyzeLeadJob.php
    GenerateProposalJob.php
  Models/
    Lead.php
    LeadSource.php
    LeadAnalysis.php
    Proposal.php
    Profile.php
    PortfolioItem.php
  Policies/
    LeadPolicy.php
    SourcePolicy.php
  Services/
    OpenAIService.php
    LeadScoringService.php
    EmailParserService.php
    ComplianceService.php
    ProposalTemplateService.php
config/
  leadpilot.php
  services.php
routes/
  api.php
  web.php
resources/
  views/ (optional)
```

## D) Key flows

### Ingest email → parse → create lead → dedupe → queue AI analysis → score → proposal drafts
1. `IngestEmailJob` fetches Gmail alert messages via OAuth (read-only scope).
2. `EmailParserService` extracts job fields (title, budget, URL, raw text).
3. Normalize into `leads` schema.
4. Deduplicate by URL + fuzzy hash of title/description.
5. Create or update lead and log activity.
6. Dispatch `AnalyzeLeadJob` → OpenAI summary, skills, language, red flags.
7. `LeadScoringService` computes transparent score.
8. Dispatch `GenerateProposalJob` to create proposal drafts (short/medium/WhatsApp).

## E) OpenAI prompt templates

### 1) Lead extraction
**System**
```
You are a compliance-first assistant. Extract structured job data from untrusted text. Do not fabricate fields.
Return strict JSON.
```
**User**
```
Source: {{source_name}}
Raw text:
"""
{{raw_text}}
"""
Extract:
- title
- description
- budget (number or null)
- skills (array)
- platform
- url
- posted_at (ISO8601 or null)
- client_country
- language (PT/EN/FR/other)
```

### 2) Lead scoring
**System**
```
You are a scoring assistant. Use the provided formula. Be transparent and conservative.
Return strict JSON.
```
**User**
```
Lead:
{{lead_json}}
Profile:
{{profile_json}}
Formula:
Score = (skills_match*0.4 + budget_fit*0.2 + urgency*0.1 + clarity*0.1 + niche_match*0.2) - red_flags_penalty
Return:
- skills_match (0-100)
- budget_fit (0-100)
- urgency (0-100)
- clarity (0-100)
- niche_match (0-100)
- red_flags (array)
- red_flags_penalty (0-30)
- score (0-100)
- rationale (array of 3 bullets)
```

### 3) Proposal generation
**System**
```
You are a proposal writer. Do not claim you already built the project. Include placeholders.
Always include “customizable / adaptável”, a CTA, and 2-3 quick questions.
Return strict JSON with short, medium, whatsapp versions.
```
**User**
```
Lead:
{{lead_json}}
Profile:
{{profile_json}}
Portfolio:
{{portfolio_json}}
Tone: {{tone}}
Language: {{language}}
Placeholders: {{placeholders}}
```

## F) Code skeleton (representative examples)

See `app/`, `database/migrations/`, and `tests/Feature/` for concrete examples.

## G) UI pages list (minimal)

- Dashboard (Resumo / Insights)
- Leads list + detail (Leads / Detalhes)
- Proposal generator (Gerador de Propostas)
- Profile/Portfolio manager (Perfil / Portfólio)
- Settings (Configurações: OpenAI key, sources)

## H) Step-by-step setup (shared hosting + VPS)

### Shared hosting (limited queue support)
1. Upload codebase and configure `.env` with DB/OpenAI keys.
2. Run migrations via CLI or hosting panel.
3. Configure a cron job for `php artisan schedule:run` every minute.
4. Use database or sync queue driver if Redis is unavailable.
5. Enable HTTPS.

### VPS (recommended)
1. Install Docker + Docker Compose.
2. Copy `.env.example` to `.env` and set secrets.
3. Run `docker compose up -d --build`.
4. Run `docker compose exec app php artisan migrate --seed`.
5. Run `docker compose exec app php artisan horizon` for queues.
6. Configure Nginx reverse proxy for HTTPS.
