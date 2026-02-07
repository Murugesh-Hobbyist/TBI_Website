# TBI Website

Single Node.js platform with Express + Next.js + MySQL and an OpenAI realtime voice assistant.

## Requirements
- Node.js 18 or 20 LTS
- MySQL 8+

## Local Setup
1. Create a database and user in MySQL.
2. Copy `.env.example` to `.env` and fill in values.
3. Install dependencies:

```bash
npm install
```

4. Run migrations and seed the admin user:

```bash
npm run db:migrate
```

5. Start the app:

```bash
npm run dev
```

App runs at `http://localhost:3000`.

## Default Admin
- Email: `admin@tbi.local`
- Password: `Admin123!`

## Notes
- Uploads are stored in `apps/server/uploads` and served from `/uploads`.
- Voice assistant uses WebSocket at `/voice` and OpenAI Realtime API.
- `OPENAI_TRANSCRIBE_MODEL` controls the transcription model used for user audio.
- To deploy on Hostinger Business Node.js Web App, set `NODE_ENV=production` and use `npm run build` then `npm start`.
  - Hostinger hint: set the app root to the repository root so `package.json` is detected, and use `npm start` (startup file `index.js`).
