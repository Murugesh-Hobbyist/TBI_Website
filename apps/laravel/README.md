# Finboard (Laravel)

This is the Laravel rewrite of the Finboard website.

## Requirements
- PHP 8.2+
- Composer
- Node.js 18+ (for Vite assets)
- MySQL 8+ (recommended) or SQLite (dev)

## Local Setup
1. From repo root, go to `apps/laravel`.
2. Copy `.env.example` to `.env` and set:
   - `APP_KEY` (run `php artisan key:generate`)
   - `DB_*`
   - `OPENAI_API_KEY` (optional, for the assistant)
3. Install dependencies:

```bash
composer install
npm install
```

4. Migrate + seed admin user:

```bash
php artisan migrate
php artisan db:seed
```

5. Run:

```bash
npm run dev
php artisan serve
```

## Admin
- URL: `/admin`
- Email: `admin@finboard.local`
- Password: `Admin123!`

Change this after first login.

## AI Assistant
The site includes an “Ask AI” widget (text + push-to-talk voice).

Endpoints:
- `POST /api/assistant/chat` JSON `{ "message": "..." }`
- `POST /api/assistant/transcribe` multipart `audio` file
- `POST /api/assistant/speak` JSON `{ "text": "..." }` returns `audio/mpeg`

The assistant uses:
- Projects + Products + Knowledge Base (KB articles) as its context
- OpenAI Responses API for text generation

Configure in `.env`:
- `OPENAI_CHAT_MODEL`
- `OPENAI_TRANSCRIBE_MODEL`
- `OPENAI_TTS_MODEL`
- `OPENAI_TTS_VOICE`

