# ConnectU

ConnectU is a student collaboration platform that helps classmates connect, study together, share resources, exchange skills, and give feedback — all in one place.

Built with **Laravel**, **Livewire**, and **Flux UI**.

---

## Table of contents

- [Features](#features)
- [Tech stack](#tech-stack)
- [Installation guide](#installation-guide)
  - [Debian / Kali / Ubuntu](#install-on-debian--kali--ubuntu)
  - [macOS](#install-on-macos-homebrew)
  - [Windows](#install-on-windows)
  - [Node.js via NVM](#install-nodejs-via-nvm-any-linux--macos)
  - [Composer manual install](#install-composer-manually-if-apt-version-is-missing)
  - [MySQL (optional)](#optional-use-mysql-instead-of-sqlite)
- [Project setup](#project-setup)
- [Running the project](#running-the-project)
- [Using the app](#using-the-app)
- [Running tests](#running-tests)
- [Troubleshooting](#troubleshooting)

---

## Features

- **Authentication** — Register, login, password reset, email verification, two-factor auth
- **Academic profiles** — Course, bio, interests, skills, and availability
- **Peer matching** — Find study partners based on shared courses and interests
- **Study groups** — Create groups, browse listings, and join
- **Messaging** — Send and receive direct messages
- **Resource sharing** — Upload files or share links
- **Skill sharing** — Offer or discover skills to teach or learn
- **Feedback & ratings** — Rate peers and view received feedback
- **Account settings** — Profile, security, appearance, and team management

---

## Tech stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 13 |
| Auth | Laravel Fortify |
| UI | Livewire 4 + Flux UI 2 |
| Styling | Tailwind CSS 4 |
| Assets | Vite 8 |
| Database (default) | SQLite |
| Tests | Pest |

---

## Installation guide

This section covers everything you need to install **before** running ConnectU — system tools, PHP extensions, and project dependencies.

---

### What you need

| Tool | Minimum version | Purpose |
|------|-----------------|---------|
| PHP | 8.3+ (8.4 works) | Laravel backend |
| Composer | 2.x | PHP package manager |
| Node.js | 20+ | Frontend tooling (Vite) |
| npm | 10+ | JavaScript package manager |

### Required PHP extensions

| Extension | Package (Debian/Kali) | Why it's needed |
|-----------|----------------------|-----------------|
| `sqlite3` / `pdo_sqlite` | `php-sqlite3` | Default database |
| `mbstring` | `php-mbstring` | String handling |
| `xml` | `php-xml` | Laravel / XML parsing |
| `curl` | `php-curl` | HTTP requests |
| `zip` | `php-zip` | Composer / archives |
| `tokenizer` | included in `php` | Laravel framework |
| `ctype` | included in `php` | Laravel framework |
| `fileinfo` | `php-fileinfo` | File uploads |
| `openssl` | included in `php` | Encryption / HTTPS |

Check which extensions are loaded:

```bash
php -m | grep -E 'sqlite3|mbstring|xml|curl|zip|pdo|tokenizer|fileinfo|openssl'
```

---

### Install on Debian / Kali / Ubuntu

**Step 1 — Update package list:**

```bash
sudo apt update
```

**Step 2 — Install PHP, extensions, Composer, and Node:**

```bash
sudo apt install -y \
  php php-cli php-common \
  php-sqlite3 php-mbstring php-xml php-curl php-zip php-fileinfo \
  composer nodejs npm git unzip
```

**Step 3 — Verify everything installed:**

```bash
php --version
composer --version
node --version
npm --version
php -m | grep sqlite3
```

Expected output examples:

```
PHP 8.4.x ...
Composer version 2.x ...
v20.x or higher
10.x or higher
sqlite3
```

**If `php` points to an old version**, use the versioned binary explicitly:

```bash
php8.4 --version
# Then use php8.4 instead of php in artisan commands, e.g.:
php8.4 artisan migrate
```

Or set the default:

```bash
sudo update-alternatives --config php
```

---

### Install on macOS (Homebrew)

**Step 1 — Install Homebrew** (if not installed):

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

**Step 2 — Install dependencies:**

```bash
brew install php@8.4 composer node git
brew link php@8.4
```

**Step 3 — Verify:**

```bash
php --version
composer --version
node --version
npm --version
```

---

### Install on Windows

**Option A — Laravel Herd (easiest for Laravel on Windows)**

1. Download and install [Laravel Herd](https://herd.laravel.com/windows)
2. Herd includes PHP, Composer, and Node.js
3. Clone the repo into your Herd sites folder
4. Open a terminal in the project folder and continue with [Project setup](#project-setup) below

**Option B — Manual install**

1. **PHP** — Download from [windows.php.net](https://windows.php.net/download/) (8.3+ Thread Safe)
   - Enable extensions in `php.ini`: `sqlite3`, `pdo_sqlite`, `mbstring`, `openssl`, `curl`, `fileinfo`, `zip`
2. **Composer** — Download from [getcomposer.org](https://getcomposer.org/download/)
3. **Node.js** — Download LTS from [nodejs.org](https://nodejs.org/)
4. **Git** — Download from [git-scm.com](https://git-scm.com/download/win)

Verify in PowerShell or Command Prompt:

```powershell
php --version
composer --version
node --version
npm --version
```

---

### Install Node.js via NVM (any Linux / macOS)

Use this if your system Node.js is too old:

```bash
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.3/install.sh | bash
source ~/.bashrc   # or ~/.zshrc

nvm install 22
nvm use 22
node --version
npm --version
```

---

### Install Composer manually (if apt version is missing)

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
composer --version
```

---

### Optional: use MySQL instead of SQLite

ConnectU defaults to SQLite (no database server required). To use MySQL instead:

**1. Install MySQL:**

```bash
# Debian / Kali / Ubuntu
sudo apt install -y mysql-server php-mysql
sudo systemctl start mysql
```

**2. Create a database:**

```bash
sudo mysql -e "CREATE DATABASE connectu; CREATE USER 'connectu'@'localhost' IDENTIFIED BY 'your_password'; GRANT ALL ON connectu.* TO 'connectu'@'localhost'; FLUSH PRIVILEGES;"
```

**3. Update `.env`:**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=connectu
DB_USERNAME=connectu
DB_PASSWORD=your_password
```

**4. Run migrations:**

```bash
php artisan migrate
```

---

## Project setup

Once system dependencies are installed, set up the ConnectU project itself.

### 1. Get the code

```bash
git clone <repository-url> ConnectU
cd ConnectU
```

If you already have the project locally:

```bash
cd ~/vanessa/ConnectU
```

### 2. Install PHP dependencies

```bash
composer install
```

This installs Laravel, Livewire, Flux UI, Fortify, and all backend packages into `vendor/`.

> **Important:** `composer install` must complete before running `npm run build` or `npm run dev`, because the frontend imports CSS from `vendor/livewire/flux/`.

### 3. Install JavaScript dependencies

```bash
npm install
```

This installs Vite, Tailwind CSS, and frontend build tools into `node_modules/`.

### 4. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Default settings in `.env`:

```env
APP_NAME=ConnectU
DB_CONNECTION=sqlite
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

No separate database server is needed with SQLite.

### 5. Create and migrate the database

```bash
touch database/database.sqlite
php artisan migrate
```

### 6. Link storage (required for file uploads)

```bash
php artisan storage:link
```

Without this step, uploaded learning resources will not be downloadable.

### 7. Build frontend assets (optional for dev)

For development, `composer dev` handles this automatically. For a one-off production build:

```bash
npm run build
```

---

### Full setup — copy and paste

Run this entire block from the project root after system dependencies are installed:

```bash
cd ~/vanessa/ConnectU

composer install
npm install

cp .env.example .env
php artisan key:generate

touch database/database.sqlite
php artisan migrate
php artisan storage:link
```

Then start the app:

```bash
composer dev
```

Open **http://127.0.0.1:8000**

---

## Running the project

ConnectU has two parts that run during development:

| Part | What it does |
|------|----------------|
| **Backend** | Laravel server, queue worker, logs |
| **Frontend** | Vite dev server (CSS/JS hot reload) |

### Option A — One command (recommended)

From the project root:

```bash
composer dev
```

This starts everything at once:

- Laravel → http://127.0.0.1:8000
- Queue worker
- Log viewer (Pail)
- Vite dev server

Open **http://127.0.0.1:8000** in your browser.

Press `Ctrl+C` to stop all processes.

### Option B — Two terminals

**Terminal 1 — Backend:**

```bash
php artisan serve
php artisan queue:listen --tries=1
```

**Terminal 2 — Frontend:**

```bash
npm run dev
```

Then open **http://127.0.0.1:8000**.

### Production-style local run

Build assets once, then serve Laravel only:

```bash
npm run build
php artisan serve
```

---

## Using the app

1. Visit http://127.0.0.1:8000
2. Click **Get started** or **Register** to create an account
3. After login, you land on the **Dashboard**
4. Use the **sidebar** to navigate:
   - Dashboard
   - My Profile
   - Find Peers
   - Study Groups
   - Messages
   - Resources
   - Skills
   - Feedback
   - Account Settings

### Testing with two users

To test messaging, feedback, and peer matching:

1. Register a first account in your normal browser
2. Open a private/incognito window
3. Register a second account
4. Complete both academic profiles (`My Profile`)
5. Try peer matching, messaging, and feedback between the two accounts

---

## Running tests

```bash
composer test
```

This runs code style checks (Pint) and the full Pest test suite.

Run tests only:

```bash
php artisan test
```

---

## Common commands

```bash
# Clear all caches
php artisan optimize:clear

# Fix code style
composer lint

# Re-run migrations (fresh start — deletes all data)
php artisan migrate:fresh

# View routes
php artisan route:list
```

---

## Troubleshooting

| Problem | Solution |
|---------|----------|
| `php: command not found` | Install PHP — see [Installation guide](#installation-guide) |
| `composer: command not found` | Install Composer — see [Install Composer manually](#install-composer-manually-if-apt-version-is-missing) |
| `php8.4` works but `php` does not | Run `sudo update-alternatives --config php` or use `php8.4` in commands |
| Node.js version too old | Install via [NVM](#install-nodejs-via-nvm-any-linux--macos) or upgrade system Node |
| Vite/CSS not loading | Run `npm run dev` or `npm run build` |
| `Can't resolve flux.css` | Run `composer install` first (needs `vendor/`) |
| `npm install` fails | Ensure Node.js 20+ is installed: `node --version` |
| `composer install` fails on PHP version | Requires PHP 8.3+: `php --version` |
| Uploaded files won't download | Run `php artisan storage:link` |
| Database errors | Delete `database/database.sqlite`, run `touch database/database.sqlite` and `php artisan migrate` |
| Dashboard 403 after login | Log out and register again; a personal team is created on registration |
| Peer matching shows no results | Fill in your academic profile with interests/skills that overlap another user's profile |
| Port 8000 already in use | Stop the other process or run `php artisan serve --port=8001` |

---

## Project structure

```
ConnectU/
├── app/Http/Controllers/   # Feature controllers
├── app/Models/             # Database models
├── database/migrations/    # Database schema
├── resources/views/        # Blade templates (UI)
├── routes/web.php          # Main application routes
├── routes/settings.php     # Account & team settings
├── tests/                  # Pest feature tests
├── agents_build_guide.md   # Detailed guide for developers/agents
└── README.md               # This file
```

---

## Documentation

- **README.md** (this file) — Setup, dependencies, and how to run the project
- **agents_build_guide.md** — Architecture, routes, conventions, and agent/developer reference

---

## License

MIT
