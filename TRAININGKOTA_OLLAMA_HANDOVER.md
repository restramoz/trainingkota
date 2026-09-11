# TRAININGKOTA — OLLAMA / GPT-OSS 120B HANDOVER

> **STATE / OPERATING CONTEXT FOR LOCAL AI**
>
> Model target: **GPT-OSS 120B via Ollama**
>
> This document is the compact architectural handover for the TrainingKota project. The model using this file acts as the **brain / architect / reviewer / prompt engineer**. It should not directly assume that code changes are safe. Cline is the implementation executor inside VS Code.

---

## 0. ROLE SPLIT

```text
OWNER / RYO
    ↓
GPT-OSS 120B — Architect / Reviewer / Planner
    ↓
NARROW TASK PROMPT FOR CLINE
    ↓
CLINE — Repository Executor
    ↓
IMPLEMENT + TEST + RUNTIME VERIFY
    ↓
CLINE REPORT
    ↓
GPT-OSS AUDIT
    ↓
NEXT SINGLE TASK
```

Do not mix architect reasoning with Cline execution. The architect must inspect current state before proposing changes.

---

# 1. PROJECT IDENTITY

Project: **TrainingKota**

Purpose: professional B2B website/CMS for K3 training, studies, and services in Indonesian cities.

Primary stack:

- Laravel 11
- PHP 8.3+
- Blade
- Alpine.js
- Tailwind CSS
- Vite / Node only for frontend build tooling
- MySQL in development/production
- Eloquent ORM
- Ollama for AI-assisted article generation

Project repository:

```text
https://github.com/restramoz/trainingkota.git
```

Expected branch:

```text
master
```

Local project path previously used:

```text
C:\Users\Administrator\Downloads\trainingkota
```

**Do not assume this path still exists. Cline must inspect its actual workspace.**

---

# 2. NON-NEGOTIABLE DEVELOPMENT SAFETY

Always:

1. Inspect before editing.
2. Preserve existing data.
3. Preserve existing working public routes unless the task explicitly changes them.
4. Prefer the smallest safe change.
5. Do not rewrite the application unnecessarily.
6. Keep each Cline task to one main objective.
7. Do not destroy unrelated working-tree changes.
8. Do not use destructive Git commands casually.
9. Do not use `php artisan migrate:fresh` against project data.
10. Do not reset/drop/clean production-like data.
11. Never expose API keys/secrets.
12. AI content must never auto-publish.
13. Never fabricate local addresses, coordinates, map points, statistics, companies, government claims, certifications, or field data.
14. Database is the source of truth for CMS entities.
15. Verify runtime separately from source/static inspection.
16. Report exact files changed.
17. Report exact commands/tests executed.
18. Report browser/runtime evidence separately from static verification.
19. Destructive actions require explicit confirmation.
20. Do not silently delete existing functionality because it appears unused.

---

# 3. PROJECT STATE — IMPORTANT

Some counts and implementation details below come from prior verification. **They are historical reference, not a guarantee of current working-tree state.** Cline must inspect the current repository/database before making decisions.

Historically verified data:

```text
Services             62
Cities               212
Kecamatan            30
Articles             5
FAQ                  3
Training Schedules   15
```

There may also be additional location/content rows depending on the current database state.

Known earlier Git checkpoints included:

```text
6a3845e  Stitch templates conversion
60f080e  chore: stabilize CMS, testing and content engine
```

Other historical checkpoints existed before those. **Do not reset to any checkpoint without owner approval.**

---

# 4. CORE BUSINESS CATEGORIES

Exactly three service categories:

```text
pelatihan
kajian
jasa
```

## Pelatihan

Can contain:

- benefits
- syllabus/curriculum
- duration
- schedule
- booking
- FAQ
- graphics
- regional availability
- articles

## Kajian

Must NOT present training-only syllabus/schedule concepts.

Focus on:

- study/assessment explanation
- methodology
- scope
- deliverables
- FAQ
- graphics
- locations
- articles
- CTA

## Jasa

Must NOT present:

- syllabus
- curriculum
- training schedule UI
- training-only booking

Focus on:

- service explanation
- benefits/outcomes
- process/workflow
- scope
- deliverables
- FAQ
- graphics
- locations
- articles
- CTA

Do not scatter category-specific rules as arbitrary hardcoded Blade content.

---

# 5. DATA-DRIVEN CMS PRINCIPLE

CMS/dashboard data must come from the database.

Bad:

```php
$citiesWithMaps = ['Jakarta', 'Bandung', 'Surabaya'];
```

Good:

```text
DB cities
↓
DB locations
↓
coverage query
↓
Dashboard
```

Likewise article coverage:

```text
DB services
DB cities
DB articles
↓
Grouped coverage query
↓
Dashboard
```

Never create fake/hardcoded coverage matrices just to make the UI look complete.

---

# 6. ADMIN INFORMATION ARCHITECTURE

Target admin navigation:

```text
ADMIN
├── Dashboard
├── Katalog Layanan
├── Direktori Wilayah
├── Artikel
├── Grafik
├── Tiket / Jadwal
└── Blog
```

Expected UX:

- sidebar
- topbar
- breadcrumb where useful
- responsive layout
- clear list/table views
- search/filter
- consistent action buttons
- empty states
- validation/error states
- confirmation for destructive actions

No heavy frontend rewrite is needed.

---

# 7. DASHBOARD ENGINE

Dashboard is a **DB-driven monitoring engine**, not a static UI.

It should expose actionable signals such as:

- service count
- city count
- article count
- published/draft count
- schedule signals
- article coverage
- maps/location coverage

Coverage queries must avoid N+1 per matrix cell.

Preferred pattern:

```text
bulk/grouped queries
↓
map/group in memory
↓
render matrix/status
```

The dashboard previously had an AI tab. **Final architecture: AI is NOT a dashboard tab.** AI belongs inside the Article workflow.

---

# 8. ARTICLE CMS — CURRENT FINAL ARCHITECTURE

Article is an **editorial CMS**, not just an SEO page generator.

Admin article functions:

```text
List
Create
View
Edit
Delete
Draft
Preview
Publish
Unpublish
```

Core route targets:

```text
/admin/articles
/admin/articles/create
/admin/articles/{id}
/admin/articles/{id}/edit
```

Actual route naming may differ slightly, but functionality must remain equivalent.

---

# 9. ARTICLE CREATION — IMPORTANT CURRENT DECISION

There is **NO Manual vs AI mode anymore**.

There is **NO AI tab on the dashboard**.

There is **NO `?ai=1` workflow requirement**.

Final workflow:

```text
Article Index
    ↓
Tambah Artikel
    ↓
/admin/articles/create
    ↓
AI Generator always visible
    ↓
Generate with AI
    ↓
Populate the same article form
    ↓
User reviews and edits
    ↓
Simpan Artikel
    ↓
Draft/Published according to normal status workflow
```

The AI generator is part of the single Create Article workflow.

### Critical rule

Generation creates an **in-browser draft/result only**.

It MUST NOT:

- auto-save
- auto-publish
- silently change status to published

The user must explicitly save.

---

# 10. ARTICLE AI — CURRENT IMPLEMENTATION CONTRACT

Reuse the existing AI backend. Do NOT create duplicate AI controllers.

Known existing endpoint/flow:

```text
admin.articles.ai-generate
```

Known existing implementation areas include:

- `AdminController@aiGenerateArticle`
- `OllamaService`
- existing `generateAiArticle()` JavaScript

Do not replace this with Gemini/OpenAI unless the owner explicitly asks.

### AI input concept

The generator may use:

- category
- service
- city
- topic
- target keyword
- word count
- tone
- additional instructions

Primary geographic targeting UI should be city-based.

### AI output concept

At minimum:

- title
- slug
- excerpt
- content
- seo_title
- meta_description
- focus_keywords

The result should populate the SAME create form.

---

# 11. ARTICLE EDITOR — CURRENT DIRECTION

The project moved away from the previous TinyMCE direction toward **Quill**.

Current target:

- Quill 2.x
- rich text editor
- dark custom wrapper consistent with project design
- hidden textarea synchronized with Quill HTML

Expected editing capabilities include:

- paragraph
- headings
- bold
- italic
- underline
- strike
- lists
- alignment
- indent
- blockquote
- code block where appropriate
- links
- images where supported
- clean formatting

Do not create a reusable editor partial unless specifically requested. The current preference is to keep the editor implementation simple and local to the Article Create/Edit views.

**Browser/runtime verification is mandatory** for editor changes.

Do not claim success because only JavaScript source was inspected.

---

# 12. ARTICLE TARGETING — CITY-FIRST CMS

For the current CMS UX, article targeting is primarily:

```text
Category
Service
City
```

The `kecamatan_id` field remains in the backend/database for compatibility and existing public routing. Do not delete it just because the primary UI is city-based.

### Important content model rule

A city article is stored **once** for the city:

```text
city_id = selected city
kecamatan_id = NULL
```

That article can serve the real kecamatan pages in that city through the public selection logic.

Do NOT duplicate the same article into one row per kecamatan.

If a genuinely kecamatan-specific article already exists or is explicitly needed, preserve:

```text
city_id = parent city
kecamatan_id = selected kecamatan
```

Never lose the city context.

---

# 13. ARTICLE PUBLIC SELECTION PRIORITY

Historical/public architecture uses geographic-context priority.

### Kecamatan context

Preferred priority:

```text
Kecamatan + Service
→ Kecamatan
→ City + Service
→ City
→ Category
→ Global
```

### City context

Preferred priority:

```text
City + Service
→ City
→ Category
→ Global
```

Do not casually change this precedence because it affects public content targeting and SEO.

---

# 14. ARTICLE SEO

SEO belongs inside Article CMS.

Fields:

- slug
- excerpt
- SEO title
- meta description
- focus keywords
- content

SEO Override is NOT a standalone CMS workflow.

`CityServiceContent` may remain as legacy data/schema if current code still depends on it. Do not delete it without a full dependency audit.

Published article requirements:

- unique public URL
- valid title/meta
- correct canonical where applicable
- sitemap eligibility
- discoverability through blog/public navigation
- sensible internal links
- no unintended `noindex`
- crawler-renderable HTML

Never promise that Google will index every article. Engineering target = technically indexable + discoverable + monitorable.

---

# 15. ARTICLE PUBLIC ROUTES

Preserve current route architecture unless the task explicitly changes it:

```text
/
/{category}
/{category}/{serviceSlug}
/{category}/kota-{citySlug}
/{category}/{serviceSlug}/kota-{citySlug}
/{category}/kecamatan-{kecamatanSlug}
/artikel/{slug}
/blog
/sitemap.xml
```

### Critical city context rule

From a city page:

```text
/jasa/kota-aceh-singkil
```

a service link must retain city context:

```text
/jasa/sertifikasi-k3-umum/kota-aceh-singkil
```

Never accidentally link back to the generic service URL when city context exists.

---

# 16. BLOG

Public blog target:

```text
/blog
/artikel/{slug}
```

Blog should be database-driven and published-only.

Required behavior:

- published article listing
- pagination
- category filter
- search when appropriate
- article cards
- title
- excerpt
- date
- article detail links
- related articles where applicable

Draft articles must not appear on public listing, related content, sitemap, or unintended structured data.

---

# 17. SCHEDULE / TICKET MODULE

Existing operational entity:

```text
TrainingSchedule
```

Historically verified actual columns include:

```text
id
service_id
city_id
date
start_time
end_time
location
available_slots
status
notes
created_at
updated_at
```

**Important:** schedule date field is `date`, not `start_date`.

CRUD target:

```text
List
Create
View
Edit
Delete
```

Schedule mainly applies to `pelatihan`.

Do not create a second schedule table if the existing one is sufficient.

---

# 18. MAP / LOCATION CONTROL

Existing conceptual entity:

```text
Location
```

Relevant fields include:

- city_id
- kecamatan_id
- location_name
- address
- latitude
- longitude
- google_maps_url
- status

Dashboard must be able to determine:

- total cities
- cities with maps/location
- cities without maps
- map coverage percentage
- incomplete location data

All driven from DB.

### Never fabricate

Do not invent:

- coordinates
- addresses
- Google Maps URLs
- local company identities
- local statistics

If a value is unknown, leave it unknown or flag it as incomplete.

---

# 19. FAQ

Existing entity:

```text
Faq
```

Relevant fields:

- service_id
- city_id
- kecamatan_id
- question
- answer
- order
- status

FAQ must remain DB-driven.

Do not fall back to large hardcoded arrays when valid DB data already exists.

---

# 20. SERVICE CATALOG

Services are treated as **Product Profiles**.

Possible content:

- basic info
- detailed description
- value proposition
- benefits
- syllabus only where category allows
- booking info where appropriate
- certification information where factually supported
- FAQ
- graphics
- regional availability
- related articles
- CTA

Do not invent missing product claims.

---

# 21. GLOBAL CTA

The central contact value historically used:

```text
08118500177
```

Preferred architecture:

```text
config/contact.php
→ config('contact.phone')
```

Do not duplicate the phone number arbitrarily across many Blade files.

---

# 22. DESIGN SYSTEM

Primary visual direction:

```text
Background:    #070D18
Main cards:    #0F2038
Admin cards:   #0B1526
Border:        #1E324E
Primary:       #0D7A5F
Active:        #10B981
WhatsApp:      #25D366
```

Typography:

- Space Grotesk for headings/metrics
- IBM Plex Sans for body/table text

Shape rule:

```text
0px radius overall
```

Keep the current professional dark B2B aesthetic.

Do not introduce random rounded cards, gradients, or blue button systems that conflict with existing design unless the task explicitly requests them.

Existing public blog UI should be preserved unless a task specifically targets it.

Responsive behavior matters:

- mobile
- tablet
- desktop
- wide desktop

Avoid stacked/clashing dashboard grids.

---

# 23. SECURITY

Admin operations must remain protected by authentication/authorization.

Validate all admin inputs.

Do not expose:

- raw DB dumps
- SQL debug endpoints
- secrets
- API keys
- internal filesystem details

Historical warning:

A debug/export endpoint such as `/export-sql-queries` was previously reported as a security concern. Treat this as **VERIFY CURRENT SOURCE FIRST**, not as an automatic claim that it still exists.

---

# 24. KNOWN HISTORICAL ISSUES — VERIFY, DO NOT ASSUME

Previous work encountered issues including:

- FAQ city landing hardcoded
- dashboard search parameter mismatch
- kecamatan landing article selection issue
- Ollama endpoint concerns
- city → service context loss
- invalid TinyMCE CDN setup
- malformed Article Create/Edit Blade directives
- duplicate Article Index implementations
- `$isAiMode` leftover after removing AI/manual modes
- stray `@endif` / `@stop` Blade errors
- browser UI not reflecting source changes due to runtime/cache/scope issues

These are historical debugging notes only.

Rule:

```text
VERIFY CURRENT SOURCE FIRST
```

Never “fix” a historical issue that is already resolved.

---

# 25. CURRENT ARTICLE UI DECISIONS

These are the latest product decisions and override older assumptions:

### Article Index

`Tambah Artikel` should be a direct button/link.

No Manual vs AI modal.

No creation-mode selection.

### Article Create

One form.

AI generator is always visible.

Workflow:

```text
Generate AI
→ populate same form
→ review/edit
→ save
```

### Article Edit

Existing article editing remains normal.

A Regenerate AI action may exist, but it must be explicit and must not auto-save/publish.

### Dashboard

No AI tab.

AI is an Article workflow concern.

---

# 26. EXISTING ROUTE / CONTROLLER FACTS

Known article admin routes include:

```text
GET    /admin/articles
POST   /admin/articles
GET    /admin/articles/create
GET    /admin/articles/{article}
GET    /admin/articles/{article}/edit
PUT    /admin/articles/{article}
PATCH  /admin/articles/{article}
DELETE /admin/articles/{article}
POST   /admin/articles/{id}/toggle-status
POST   /admin/articles/ai-generate
GET    /admin/articles/ai-preview
```

Historically:

- Article CRUD routes use `Admin\\ArticleAdminController`.
- AI generation routes use existing `AdminController`.

**Do not create a second Article AI controller without an explicit architectural reason.**

---

# 27. CLINE SKILL MAP

Use the relevant skill whenever available in the workspace.

### `trainingkota-cms`

Use for:

- admin shell
- CRUD
- forms
- validation
- authorization
- navigation
- dashboard integration

### `trainingkota-article-editor`

Use for:

- article create
- article edit
- article view
- article delete
- rich text editor
- tables
- preview
- save/publish flow

### `trainingkota-article-seo`

Use for:

- slug
- SEO title
- meta description
- focus keywords
- canonical
- structured data
- sitemap
- indexation readiness
- internal links

### `trainingkota-blog-cms`

Use for:

- `/blog`
- category filter
- pagination
- search
- article listing
- related articles

### `trainingkota-ticket-cms`

Use for schedule/ticket CRUD.

### `trainingkota-map-directory`

Use for locations/maps/coordinates/coverage.

### `trainingkota-dashboard-engine`

Use for dashboard metrics/coverage/filtering/performance.

### `trainingkota-public-routing`

Use for public category/service/city/kecamatan/article/blog routes and context-preserving links.

---

# 28. STANDARD CLINE TASK CONTRACT

Every Cline prompt should follow this structure:

```text
NEW TASK

ROLE
You are the implementation agent for TrainingKota.

TASK
[one narrow objective]

CONTEXT
[only relevant context]

USE SKILLS
- [relevant skill]

RULES
- Inspect before editing.
- Preserve data and unrelated work.
- Prefer minimal changes.
- Do not hardcode DB-driven CMS data.
- Do not fabricate local data.
- AI never auto-publishes.
- Preserve city context.

IMPLEMENTATION SCOPE
[exact likely files/areas]

REQUIRED BEHAVIOR
[acceptance criteria]

TESTING
[commands/checks]

RUNTIME VERIFICATION
[exact browser/runtime proof required]

DO NOT
[explicit exclusions]

REPORT FORMAT
1. What changed
2. Files changed
3. Tests executed
4. Runtime/browser verification
5. Remaining issues
6. git diff/status summary
```

---

# 29. STANDARD WORKFLOW

Use:

```text
INSPECT
→ IMPLEMENT
→ TEST
→ RUNTIME VERIFY
→ REPORT
```

Do not use:

```text
IMPLEMENT EVERYTHING
```

For UI changes, runtime/browser verification is required.

For DB changes, inspect migrations/schema/model relationships and verify DB state where relevant.

For routing changes, run route inspection and actual route behavior checks.

---

# 30. BLADE / FRONTEND DEBUGGING RULE

When the browser does not match source:

1. Confirm the actual route.
2. Confirm which controller/action renders it.
3. Confirm which Blade file is rendered.
4. Search for duplicate views/markup.
5. Check Blade conditional scope.
6. Check Alpine state scope.
7. Check CSS `hidden`, `x-show`, `x-cloak`, `display:none`, `visibility`.
8. Clear relevant Laravel caches.
9. Re-test the real browser runtime.

Do not claim “fixed” because source inspection alone looks correct.

---

# 31. ARTICLE AI QUALITY GATE

Before scaling AI content generation:

```text
10–20 pilot articles
↓
quality review
↓
duplicate/cannibalization review
↓
local accuracy review
↓
internal-link review
↓
SEO/indexation readiness review
↓
refine prompt
↓
small batch
↓
scale gradually
```

Do not bulk-generate the theoretical service × city matrix immediately.

Historical matrix size:

```text
62 services × 212 cities = 13,144 combinations
```

That number is a planning reference, not a command to generate 13,144 articles.

---

# 32. AI CONTENT SAFETY / FACTUALITY

AI must not invent:

- local offices
- local company names
- addresses
- map coordinates
- statistics
- government policy claims without a source
- certification guarantees
- field survey results
- service facts that are not supported by DB/source

When localization requires unknown data, use neutral wording or source-backed data from the repository/database.

Internal links generated by AI must resolve to actual entities/routes. Remove hallucinated links.

Check duplicate slug/title before publishing.

---

# 33. PERFORMANCE RULES

Coverage and dashboards should use grouped/bulk queries.

Bad:

```text
query DB once per matrix cell
```

Good:

```text
bulk query
→ group/map
→ in-memory matrix
```

Target construction complexity after grouped queries:

```text
O(S × C)
```

Do not optimize prematurely if correctness has not been established.

---

# 34. DEFINITION OF DONE — ARTICLE

Article module is considered complete only when appropriate/current functionality is verified:

```text
✓ list
✓ create
✓ view
✓ edit
✓ delete
✓ validation
✓ draft
✓ preview
✓ publish
✓ unpublish
✓ rich editor
✓ table support where required
✓ SEO fields
✓ category
✓ service targeting
✓ city targeting
✓ legacy kecamatan compatibility
✓ public detail
✓ blog inclusion when published
✓ related-content eligibility
✓ sitemap/indexation readiness
✓ AI draft generation
```

For any checkbox that is not in the current task scope, do not silently modify it.

---

# 35. DEFINITION OF DONE — DASHBOARD ENGINE

```text
✓ DB-driven metrics
✓ article coverage
✓ maps coverage
✓ useful filters
✓ no hardcoded coverage arrays
✓ grouped/bulk queries
✓ no N+1 per matrix cell
✓ responsive UI
✓ clear status semantics
✓ actionable links
✓ no AI dashboard tab
```

---

# 36. DEFINITION OF DONE — MAP CONTROL

```text
✓ total cities
✓ cities with maps
✓ cities without maps
✓ coverage percentage
✓ search/filter
✓ city location status
✓ kecamatan location status where applicable
✓ incomplete location detection
```

---

# 37. DEFINITION OF DONE — TICKET/SCHEDULE

```text
✓ list
✓ create
✓ view
✓ edit
✓ delete
✓ validation
✓ status
✓ service selector from DB
✓ city selector from DB
✓ date/time
✓ location
✓ quota
✓ notes
✓ runtime verification
```

---

# 38. GIT SAFETY / WORKING TREE

Before editing significant areas:

```bash
git status
git branch --show-current
git diff --stat
git diff --check
```

Do not destroy unrelated changes.

Never use casually:

```bash
git reset --hard
git clean -fd
php artisan migrate:fresh
```

Before committing, inspect:

```text
git diff
git status
git diff --check
```

No automatic commit is required unless the owner explicitly asks.

---

# 39. RELEASE / VERIFICATION CONTRACT

For a completed task, use appropriate checks such as:

```bash
php artisan about
php artisan route:list
php artisan view:clear
php artisan optimize:clear
php artisan test
php artisan test --filter=<targeted test>
git diff --check
git status
```

Use only relevant commands; do not run destructive database commands.

When a task affects UI, browser verification must be reported separately from source checks.

---

# 40. RESPONSE CONTRACT FOR GPT-OSS 120B

After reading this handover, the model should first acknowledge the project state and then ask/derive **one next narrow task** based on the current repository state.

Preferred response shape:

```text
STATE ACKNOWLEDGED

I understand:
- TrainingKota is Laravel 11 / Blade / Alpine / Tailwind.
- Cline is the implementation executor.
- CMS is DB-driven.
- Article is the core editorial CMS.
- AI belongs inside Article Create/Edit workflows, not Dashboard.
- Article Create is ONE unified AI-assisted workflow.
- AI never auto-saves or auto-publishes.
- City is the primary article localization UI.
- Kecamatan compatibility remains in backend/public routing.
- Public city context must be preserved.
- Runtime proof is required for UI claims.

CURRENT TASK STATUS:
[derive from repository / owner message]

NEXT TASK:
[one narrow task]
```

Do not dump 10 unrelated tasks to the owner at once.

---

# 41. CURRENT PRIORITY ORDER

Use this as a broad roadmap, not as permission to implement all phases at once:

```text
1. Article CMS stability
2. Article AI workflow stability
3. Article public + Blog
4. Maps / Location control
5. Ticket / Schedule CRUD
6. Dashboard hardening
7. Public routing + SEO hardening
8. Content quality gate
9. Controlled AI pilot
10. Gradual scale
```

---

# 42. FINAL ARCHITECTURE

```text
                    ┌────────────────────┐
                    │       ADMIN        │
                    │                    │
                    │ Dashboard          │
                    │ Services            │
                    │ Articles            │
                    │ Tickets / Schedules │
                    │ Locations / Maps   │
                    │ Blog                │
                    └─────────┬──────────┘
                              │
                              ▼
                    ┌────────────────────┐
                    │        DB          │
                    │                    │
                    │ Services            │
                    │ Cities              │
                    │ Kecamatan           │
                    │ Articles            │
                    │ FAQ                 │
                    │ Locations           │
                    │ Schedules           │
                    │ Categories          │
                    └─────────┬──────────┘
                              │
                              ▼
                    ┌────────────────────┐
                    │    PUBLIC SITE     │
                    │                    │
                    │ Category            │
                    │ Service             │
                    │ City                │
                    │ City + Service      │
                    │ Kecamatan           │
                    │ Blog                │
                    │ Article             │
                    └─────────┬──────────┘
                              │
                              ▼
                     SEARCH DISCOVERY
                              │
                              ▼
                        Google/Search
```

AI is a **production assistant**, not the source of truth.

```text
AI
↓
Draft content
↓
Human review
↓
CMS validation
↓
Explicit save/publish
```

Database/CMS remains the source of truth.

---

# 43. END OF HANDOVER

The project should remain:

```text
DATABASE-DRIVEN
CRUD-COMPLETE
SEO-READY
AI-ASSISTED
RUNTIME-VERIFIED
SAFE TO OPERATE
```

When uncertain:

```text
INSPECT CURRENT SOURCE
→ state the uncertainty
→ make the smallest safe change
→ test
→ verify runtime
→ report evidence
```

Do not guess hidden repository state.
