# Finboard Website (Laravel)

This repository is a Laravel application at the repository root.

## Local Setup
Requirements: PHP 8.2+, Composer, Node.js 18+, MySQL (recommended).

```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

Run dev:

```bash
npm run dev
php artisan serve
```

## Admin
- URL: `/admin`
- Email: `admin@finboard.local`
- Password: `Admin123!`

## AI Assistant
- Widget: "Ask AI" (text + push-to-talk voice)
- API endpoints:
  - `POST /api/assistant/chat`
  - `POST /api/assistant/transcribe`
  - `POST /api/assistant/speak`

## Legacy Node/Next
The previous Node.js implementation was removed from the main tree (it remains in git history).
