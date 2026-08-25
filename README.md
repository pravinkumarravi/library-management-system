# Library Management System

A complete Library Management System built with **CodeIgniter 3**, **BladeOne** (Blade templating), **Tailwind CSS v4**, **Alpine.js** and the **TailAdmin** design system. SQLite is pre-configured so the app runs with zero setup.

## Features

- Dashboard with live stats, charts (ApexCharts) and collection widgets
- Manage **Books**, **Categories** and **Members**
- **Issue / Return** books with due dates and automatic overdue fines
- **Issue History** and **Overdue** tracking
- Responsive **TailAdmin** UI with **dark mode**
- CLI migrations for schema management
- Default login: `admin` / `admin123`

## Tech Stack

| Layer    | Technology                              |
| -------- | --------------------------------------- |
| Backend  | PHP 8, CodeIgniter 3 (HMVC-ready)      |
| Templating | BladeOne (Laravel Blade syntax)       |
| Frontend | Tailwind CSS v4, Alpine.js, ApexCharts  |
| Database | SQLite (default), MySQL schema included |

## Setup

Requirements: **PHP 8+**, **Node.js + npm**, **Composer** (only if `vendor/` is missing).

```bash
# 1. Install PHP dependencies (skip if vendor/ is committed)
composer install

# 2. Install JS dependencies and build CSS/JS bundles
npm install
npm run build

# 3. Start the dev server
php -S localhost:8000

# 4. Create the database tables (CLI)
php index.php migrate
```

Then open http://localhost:8000 and log in with **admin / admin123**.

## Database Migrations (CLI)

Migrations live in `application/migrations/` and are CLI-only.

```bash
php index.php migrate            # migrate to the latest version
php index.php migrate version 3  # migrate up/down to a specific version
```

> Rolling back a migration runs its `down()` method, which drops the table — use with caution.

## Project Structure

```
application/
├── config/        # CI3 config (base_url auto-detects, migrations enabled)
├── controllers/   # Auth, Books, Categories, Members, Issues, Dashboard
├── core/          # App_Controller / App_Model base classes
├── migrations/    # 001–005 schema migrations (CLI)
├── models/        # Book, Category, Issue, Member, User models
└── views/         # Blade templates (layouts, auth, dashboard, crud)
assets/
├── css/           # Tailwind v4 source + compiled app.min.css
├── js/            # Alpine/ApexCharts bundles + dashboard.js
└── images/        # TailAdmin logo, icons, avatars
sql/
└── library.sql    # MySQL schema (alternative to SQLite)
```

## Scripts

| Command          | Description                          |
| ---------------- | ------------------------------------ |
| `npm run build`  | Build CSS + JS bundles               |
| `npm run build:css` | Build only the Tailwind CSS       |
| `npm run build:js`  | Build only the Alpine/ApexCharts bundles |
| `php index.php migrate` | Run database migrations (CLI) |

## License

This project is for educational use.
