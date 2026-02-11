# TwinBot Website (Laravel)

This repository contains the Laravel application powering `dev.twinbot.in`.

## Local Setup
Requirements: PHP 8.1+, Composer (optional), MySQL (optional for public pages).

```bash
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

## Public Site Without DB
Home + Products pages render using `config/twinbot.php` if the database is unavailable.

## Admin
- URL: `/admin/login`
- Installer (creates admin user): `/api/_install?token=YOUR_TOKEN`
  - Set `INSTALL_TOKEN` in `.env` first.
  - Admin email comes from `ADMIN_EMAIL`.
  - Admin password comes from `ADMIN_PASSWORD` (if empty, a random password is generated and printed once by the installer).

## Deployment Notes (Shared Hosting)
- `vendor/` is committed to support Git deployments where Composer is not executed on the server.
- On first request (non-local host), the app will auto-create `.env` from `.env.example` and generate `APP_KEY` if missing.
- Configure database credentials (`DB_*`) and (optional) `OPENAI_API_KEY` in `.env`.

## AI Assistant
- Widget is controlled by `ASSISTANT_WIDGET_ENABLED` (default: false).
- API endpoints:
  - `POST /api/assistant/chat`
  - `POST /api/assistant/transcribe`
  - `POST /api/assistant/speak`

