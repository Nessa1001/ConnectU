# ConnectU — Agent Build Guide

This document helps any AI agent or developer understand the ConnectU codebase, what has been built, how the frontend and backend fit together, and how to run and test the application locally.

---

## 1. Project overview

**ConnectU** is a student collaboration platform built as a **Laravel monolith** (not a separate SPA + JSON API). The UI is rendered with:

| Layer | Technology |
|-------|------------|
| Backend framework | Laravel 13 |
| Auth | Laravel Fortify |
| Interactive UI | Livewire 4 |
| Design system | Flux UI 2 |
| Styling | Tailwind CSS 4 |
| Asset bundler | Vite 8 |
| Database (default) | SQLite |
| Tests | Pest |

### Team responsibilities (original plan)

| Person | Role |
|--------|------|
| Mark | Backend logic, database, controllers, validation, tests |
| Vanessa | Frontend/UI, Livewire interfaces, responsiveness, branding |

As of the latest frontend build, **all ConnectU feature pages use Flux UI** via a shared layout component. Auth and account settings were already provided by the Laravel Livewire starter kit.

---

## 2. Architecture

```
Browser
   │
   ▼
Laravel routes (web.php, settings.php, Fortify)
   │
   ├── Controllers → Blade views (ConnectU features)
   ├── Livewire components (account settings, teams)
   └── Fortify (login, register, 2FA, password reset)
   │
   ▼
Eloquent models → SQLite (default) / MySQL / PostgreSQL
```

### Important distinction: two profile systems

| Route name | URL | Purpose |
|------------|-----|---------|
| `connectu.profile.edit` | `/profile/edit` | **Academic profile** (course, bio, interests, skills, availability) |
| `connectu.profile.update` | `POST /profile/update` | Saves academic profile |
| `profile.edit` | `/settings/profile` | **Account settings** (name, email) — Livewire |
| `security.edit` | `/settings/security` | Password, 2FA |
| `teams.index` | `/settings/teams` | Team management (starter kit) |

Do **not** confuse `profile.edit` with `connectu.profile.edit`. The route name conflict was resolved by renaming the academic profile routes.

---

## 3. Database

### Default configuration

From `.env.example`:

```env
DB_CONNECTION=sqlite
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
APP_NAME=ConnectU
```

SQLite file location: `database/database.sqlite`

### Supported alternatives

`config/database.php` also defines MySQL, MariaDB, PostgreSQL, and SQL Server. Change `DB_CONNECTION` and related env vars to switch.

### Tables

| Table | Purpose |
|-------|---------|
| `users` | Authentication accounts |
| `profiles` | Academic profiles for peer matching |
| `study_groups` | Study group metadata |
| `group_members` | Group membership |
| `messages` | Direct messages |
| `resources` | Uploaded files and external links |
| `skills` | Skill-sharing listings |
| `feedback` | Ratings and comments |
| `teams`, `memberships`, `team_invitations` | Starter-kit multi-tenancy |
| `sessions`, `cache`, `jobs` | Laravel infrastructure |

### Migrations

All migrations live in `database/migrations/`. Run:

```bash
php artisan migrate
```

---

## 4. Routes reference

### Public

| Method | URI | Name | View |
|--------|-----|------|------|
| GET | `/` | `home` | `welcome.blade.php` |

### Authentication (Fortify)

| Feature | Route names |
|---------|-------------|
| Login | `login`, `login.store` |
| Register | `register`, `register.store` |
| Logout | `logout` |
| Password reset | `password.request`, `password.reset`, `password.update` |
| Email verification | `verification.notice` |
| Two-factor | `two-factor.login` |
| Confirm password | `password.confirm` |

Auth views: `resources/views/pages/auth/`

### Authenticated ConnectU features

All routes below use `auth` middleware.

| Method | URI | Route name | Controller |
|--------|-----|------------|------------|
| GET | `/{team}/dashboard` | `dashboard` | view only |
| GET | `/profile/edit` | `connectu.profile.edit` | `ProfileController@edit` |
| POST | `/profile/update` | `connectu.profile.update` | `ProfileController@update` |
| GET | `/study-groups` | `study-groups.index` | `StudyGroupController@index` |
| GET | `/study-groups/create` | `study-groups.create` | `StudyGroupController@create` |
| POST | `/study-groups` | `study-groups.store` | `StudyGroupController@store` |
| POST | `/study-groups/{studyGroup}/join` | `study-groups.join` | `StudyGroupController@join` |
| GET | `/peer-matching` | `peer-matching.index` | `PeerMatchingController@index` |
| GET | `/messages` | `messages.index` | `MessageController@index` |
| POST | `/messages` | `messages.store` | `MessageController@store` |
| GET | `/resources` | `resources.index` | `ResourceController@index` |
| POST | `/resources` | `resources.store` | `ResourceController@store` |
| GET | `/skills` | `skills.index` | `SkillController@index` |
| POST | `/skills` | `skills.store` | `SkillController@store` |
| GET | `/feedback` | `feedback.index` | `FeedbackController@index` |
| POST | `/feedback` | `feedback.store` | `FeedbackController@store` |

### Settings / teams (Livewire)

Defined in `routes/settings.php`:

| Route name | Path |
|------------|------|
| `profile.edit` | `/settings/profile` |
| `appearance.edit` | `/settings/appearance` |
| `security.edit` | `/settings/security` |
| `teams.index` | `/settings/teams` |
| `teams.edit` | `/settings/teams/{team}` |
| `invitations.accept` | `/invitations/{invitation}/accept` |

---

## 5. Frontend structure

### Layout components

| File | Usage |
|------|-------|
| `resources/views/layouts/app.blade.php` | Authenticated app shell (sidebar) |
| `resources/views/layouts/app/sidebar.blade.php` | Sidebar navigation |
| `resources/views/layouts/guest.blade.php` | Public/marketing pages |
| `resources/views/layouts/auth.blade.php` | Login/register pages |
| `resources/views/components/connectu-layout.blade.php` | **Shared wrapper for all ConnectU feature pages** |

### ConnectU feature views

| Feature | View path |
|---------|-----------|
| Homepage | `resources/views/welcome.blade.php` |
| Dashboard | `resources/views/dashboard.blade.php` |
| Academic profile | `resources/views/profile/edit.blade.php` |
| Study groups list | `resources/views/study-groups/index.blade.php` |
| Study group create | `resources/views/study-groups/create.blade.php` |
| Peer matching | `resources/views/peer-matching/index.blade.php` |
| Messages | `resources/views/messages/index.blade.php` |
| Resources | `resources/views/resources/index.blade.php` |
| Skills | `resources/views/skills/index.blade.php` |
| Feedback | `resources/views/feedback/index.blade.php` |

### Sidebar navigation

The sidebar (`layouts/app/sidebar.blade.php`) links to all ConnectU features plus Account Settings.

### Branding

App name is **ConnectU**, set in `.env.example` (`APP_NAME=ConnectU`) and `resources/views/components/app-logo.blade.php`.

---

## 6. Controllers and validation

### ProfileController

Fields: `course` (required), `bio`, `interests`, `skills`, `availability`

Note: `profiles.profile_picture` exists in the database but **no upload endpoint is implemented yet**.

### StudyGroupController

Create fields: `group_name`, `course`, `description`, `max_members`, `meeting_schedule`

Join logic checks: already joined, group full.

### PeerMatchingController

Requires academic profile. Scores peers by course, shared interests, shared skills, and availability.

### MessageController

Fields: `receiver_id`, `message`

### ResourceController

Fields: `title`, `course`, `description`, `resource_file`, `resource_link`

Requires at least one of file or link. Files stored in `storage/app/public/resources`.

### SkillController

Fields: `skill_name`, `description`, `skill_level` (Beginner/Intermediate/Advanced), `availability`

### FeedbackController

Fields: `receiver_id`, `rating` (1–5), `comment`. One rating per giver/receiver pair.

---

## 7. First-time setup

### Prerequisites

| Tool | Minimum version |
|------|-----------------|
| PHP | 8.3+ |
| Composer | 2.x |
| Node.js | 20+ |
| npm | 10+ |
| SQLite extension | enabled |

Optional: `php-sqlite3`, `php-mbstring`, `php-xml`, `php-curl`, `php-zip`

### Step-by-step setup

```bash
# 1. Clone and enter the project
cd /path/to/ConnectU

# 2. Install PHP dependencies
composer install

# 3. Environment file
cp .env.example .env
php artisan key:generate

# 4. Create SQLite database
touch database/database.sqlite

# 5. Run migrations
php artisan migrate

# 6. Link public storage (required for resource file downloads)
php artisan storage:link

# 7. Install frontend dependencies
npm install

# 8. Build assets (production)
npm run build
```

---

## 8. Running the application for testing

ConnectU has **two runtime processes** that must run together during development:

| Process | Purpose | Command |
|---------|---------|---------|
| **Backend** | Laravel HTTP server, queue, logs | `composer dev` |
| **Frontend** | Vite dev server (hot reload for CSS/JS) | included in `composer dev` |

### Recommended: run everything with one command

```bash
composer dev
```

This starts concurrently:

1. `php artisan serve` — Laravel at **http://127.0.0.1:8000**
2. `php artisan queue:listen` — background jobs
3. `php artisan pail` — log tailing
4. `npm run dev` — Vite HMR

### Manual split (two terminals)

If you prefer separate terminals:

**Terminal 1 — Backend:**

```bash
php artisan serve
php artisan queue:listen --tries=1
```

**Terminal 2 — Frontend:**

```bash
npm run dev
```

Then open: **http://127.0.0.1:8000**

### Production-style local test

```bash
npm run build
php artisan serve
```

No Vite dev server needed; assets are compiled to `public/build`.

---

## 9. Testing

### Run full test suite

```bash
composer test
```

This runs:

1. `php artisan config:clear`
2. Laravel Pint (code style)
3. `php artisan test` (Pest)

### Run tests only

```bash
php artisan test
```

### Run a specific test file

```bash
php artisan test tests/Feature/Auth/RegistrationTest.php
```

Tests use in-memory SQLite (`phpunit.xml`).

---

## 10. Manual QA checklist

After starting the app, verify these flows:

1. **Homepage** — Visit `/`, confirm ConnectU branding and login/register links.
2. **Register** — Create account, confirm redirect to team dashboard.
3. **Academic profile** — `/profile/edit`, save course/interests/skills.
4. **Peer matching** — `/peer-matching`, confirm matches appear after profiles exist.
5. **Study groups** — Create a group, join from another account.
6. **Messages** — Send message between two users.
7. **Resources** — Upload a PDF or paste a URL, confirm download/link works.
8. **Skills** — Share a skill, confirm it appears in the list.
9. **Feedback** — Rate another user, confirm received/given lists update.
10. **Sidebar** — All nav links work from any authenticated page.
11. **Account settings** — `/settings/profile` still edits name/email separately.

### Creating a second test user

Register a second account in a private/incognito window to test messaging, feedback, and peer matching.

---

## 11. Common issues

| Problem | Solution |
|---------|----------|
| `php: command not found` | Install PHP 8.3+ (`sudo apt install php php-sqlite3 php-mbstring php-xml php-curl composer`) |
| Vite assets 404 | Run `npm run dev` or `npm run build` |
| Uploaded files not accessible | Run `php artisan storage:link` |
| `SQLSTATE[HY000] database disk image is malformed` | Delete `database/database.sqlite`, recreate, re-migrate |
| Dashboard 403 after login | User needs a team; registration flow should create a personal team |
| `route('dashboard')` fails | User must be authenticated with a `currentTeam` set |
| Peer matching empty | Complete academic profile with interests/skills that overlap another user |
| Resource upload validation error | Provide a file **or** a link (at least one required) |

---

## 12. Guidelines for future agents

### Do

- Use `<x-connectu-layout>` for new authenticated ConnectU pages.
- Use Flux components (`flux:button`, `flux:input`, `flux:select`, etc.) for consistency.
- Keep academic profile routes prefixed with `connectu.profile.*`.
- Match existing Tailwind/Flux patterns in `resources/views/`.
- Run `composer test` before finishing backend changes.
- Run `npm run build` to verify frontend compiles.

### Do not

- Rename `profile.edit` (account settings) — tests depend on it.
- Create a separate JSON API unless explicitly requested.
- Commit `.env`, `database/database.sqlite`, or `vendor/`.
- Use `git push --force` on `main`.

### Adding a new ConnectU feature

1. Create migration + model (backend).
2. Add controller with validation.
3. Register routes in `routes/web.php` under `auth` middleware.
4. Create Blade view using `<x-connectu-layout>`.
5. Add sidebar link in `resources/views/layouts/app/sidebar.blade.php`.
6. Add dashboard card in `resources/views/dashboard.blade.php`.
7. Add Pest feature tests.

### File upload features

1. Store with `$request->file(...)->store('folder', 'public')`.
2. Serve via `asset('storage/' . $path)`.
3. Ensure `php artisan storage:link` is documented.

---

## 13. Key file map

```
ConnectU/
├── app/
│   ├── Http/Controllers/     # ConnectU feature controllers
│   ├── Models/               # Eloquent models
│   └── Providers/
│       └── FortifyServiceProvider.php
├── routes/
│   ├── web.php               # ConnectU routes
│   └── settings.php          # Account/team settings
├── resources/
│   ├── views/
│   │   ├── components/connectu-layout.blade.php
│   │   ├── dashboard.blade.php
│   │   ├── welcome.blade.php
│   │   ├── profile/
│   │   ├── study-groups/
│   │   ├── peer-matching/
│   │   ├── messages/
│   │   ├── resources/
│   │   ├── skills/
│   │   ├── feedback/
│   │   └── pages/            # Auth + settings Livewire
│   ├── css/app.css
│   └── js/app.js
├── database/migrations/
├── tests/Feature/
├── .env.example
├── composer.json             # "composer dev" script
├── package.json              # "npm run dev" / "npm run build"
└── agents_build_guide.md     # This file
```

---

## 14. Quick command reference

```bash
# Full first-time setup
composer install && cp .env.example .env && php artisan key:generate && touch database/database.sqlite && php artisan migrate && php artisan storage:link && npm install

# Development (backend + frontend together)
composer dev

# Backend only
php artisan serve

# Frontend only
npm run dev

# Production asset build
npm run build

# Run tests
composer test

# Code style fix
composer lint

# Clear caches
php artisan optimize:clear
```

---

## 15. Expected outcome

A working ConnectU prototype with:

- Authentication (register, login, 2FA, password reset)
- Academic profiles and peer matching
- Study groups (create, list, join)
- Messaging
- Resource sharing (files + links)
- Skill sharing
- Feedback and ratings
- Responsive Flux UI with sidebar navigation
- Account settings and teams (starter kit)

---

*Last updated: June 2026 — after full ConnectU frontend build.*
