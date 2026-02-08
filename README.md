# Finboard Website (Laravel)

This repository is a Laravel application at the repository root.

## Local Setup
Requirements: PHP 8.1+, Composer (optional), MySQL (recommended).

```bash
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

Run dev:

```bash
php artisan serve
```

## Admin
- URL: `/admin`
- Email: `admin@finboard.local`
- Password: `Admin123!`

## Deployment Notes (Hostinger)
- `vendor/` is committed to support Git deployments where Composer is not executed on the server.
- On first request (non-local host), the app will auto-create `.env` from `.env.example` and generate `APP_KEY` if missing.
- You should still configure database credentials (`DB_*`) and (optional) `OPENAI_API_KEY` in `.env`.

## AI Assistant
- Widget: "Ask AI" (text + push-to-talk voice)
- API endpoints:
  - `POST /api/assistant/chat`
  - `POST /api/assistant/transcribe`
  - `POST /api/assistant/speak`

## Legacy Node/Next
The previous Node.js implementation was removed from the main tree (it remains in git history).
