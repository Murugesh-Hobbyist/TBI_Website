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
- Voice assistant uses OpenAI Realtime (WebRTC). Backend endpoint: `POST /api/voice/session`.
- `OPENAI_TRANSCRIBE_MODEL` controls the transcription model used for user audio.

## Hostinger Deployment Notes
- If Hostinger is publishing your app as a static Next preset (no running Node server):
  - This repo's `npm run build` post-processes the Next build output so Hostinger can serve it from `.next/` (adds `index.html`, `/_next/static`, and route folders).
  - Quick verify: `GET /__export_marker.txt` should return `200`.
  - In this static mode, Express APIs, MySQL, and the voice assistant will not work.
- For full dynamic features (API, MySQL, admin, quotes, and voice):
  - Deploy as a Node app and run `npm start` (starts `apps/server/server.js`).
  - Health check: `GET /api/healthz` returns JSON `{ ok: true }`.
  - Voice health: `GET /api/voice/healthz` returns `{ ok: true, mode: 'webrtc', ... }`.
