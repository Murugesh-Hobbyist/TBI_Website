# TwinBot Website — Status and Handover

Last updated: 2026-08-30

## Active project location

The active website project is this folder:

```text
H:\TwinBot_Git\Development\TBI_Website\Live_Push
```

Do all website edits, Git commands, and future commits from this folder.

`H:\TwinBot_Git\Development\TBI_Website` is the previous container/location. It is not the active Git working directory and should not be used for website development or deployment.

## Git mapping

| Item | Value |
| --- | --- |
| Local repository root | `H:\TwinBot_Git\Development\TBI_Website\Live_Push` |
| Remote | `https://github.com/Murugesh-Hobbyist/TBI_Website.git` |
| Active branch | `main` |
| Upstream tracking | `origin/main` |
| Hosting deployment | Hostinger Git deployment |
| Hostinger deployment root | `public_html` |

The folder is mapped directly to the `TBI_Website` GitHub repository. A normal publishing workflow is:

```powershell
git status
git add <changed-files>
git commit -m "Describe the change"
git push origin main
```

Hostinger native auto-deployment is enabled for the `main` branch. A successful push to `main` is expected to deploy automatically. The old GitHub webhook deployment workflow was removed because Hostinger native auto-deployment was verified to work without it.

## Application overview

This is a Laravel 10 website for `https://twinbot.in`.

| Area | Main location |
| --- | --- |
| Routes | `routes/web.php`, `routes/api.php` |
| Public site layout and footer | `resources/views/layouts/site.blade.php` |
| Site pages | `resources/views/site/` |
| Products | `resources/views/products/`, `app/Http/Controllers/ProductController.php` |
| AI assistant widget | `resources/views/partials/assistant_widget.blade.php` |
| AI assistant browser behavior | `resources/js/app.js` and deployed copy `public/assets/app.js` |
| AI assistant API | `app/Http/Controllers/Api/AssistantController.php` |
| OpenAI HTTP client | `app/Services/OpenAiClient.php` |
| Site/company data | `config/twinbot.php` |
| AI configuration | `config/assistant.php` |
| Public assets | `public/assets/`, `public/twinbot/` |

`vendor/` is intentionally committed because the Hostinger Git deployment does not run Composer during deployment. Do not remove it unless the hosting deployment process is changed to run `composer install` reliably.

## Public navigation and pages

The header is intentionally limited to:

- Home — `/`
- Products — `/products`
- Solutions — `/solutions`
- Videos — `/videos`
- About — `/about`

Pricing has been removed from the navigation. `/pricing` redirects to `/products`.

Smart Vending Automation is available under Products:

```text
/products/smart-vending-automation
```

The site also contains policy/support pages linked from the simplified three-column footer:

- Contact / Request Quote
- Terms and Conditions
- Privacy Policy
- Refund and Cancellation
- Shipping and Delivery
- Warranty and Support
- Vending Payment Policy
- Grievance Redressal

The footer headings are **Explore**, **Support**, and **Legal**.

## AI assistant — current behavior

The floating launcher is labelled **Ask TwinBot AI**.

- It starts minimized on every fresh page load.
- Opening it always uses **Chat mode**.
- The old continuous **Voice mode** is hidden from visitors and forced off in browser state.
- **Hold to talk** remains available inside Chat mode.
- In supporting Chrome/Edge browsers, hold-to-talk uses browser speech recognition first and places interim/final text in the chat input.
- The server audio-transcription endpoint remains as a fallback.

Relevant API endpoints:

```text
POST /api/assistant/chat
POST /api/assistant/transcribe
POST /api/assistant/speak
GET  /api/healthz
```

### AI credit limitation

At the last verification, the OpenAI API account had no remaining credits. When an OpenAI quota/billing error is detected, the visitor-facing message is intentionally:

```text
AI Feature is currently disabled.
```

Technical OpenAI billing/quota text is not shown to visitors. Browser speech recognition may still fill the chat input, but AI chat answers and server-generated speech require a funded valid `OPENAI_API_KEY` on the Hostinger environment.

Do not commit `.env` or an OpenAI API key. `.env` is intentionally ignored by Git.

## Environment and deployment notes

Local configuration is in `.env`; the tracked template is `.env.example`.

Important environment variables include:

```text
APP_ENV
APP_URL
DB_*
OPENAI_API_KEY
OPENAI_BASE_URL
OPENAI_CHAT_MODEL
OPENAI_TRANSCRIBE_MODEL
OPENAI_TTS_MODEL
OPENAI_TTS_VOICE
OPENAI_TIMEOUT_SECONDS
INSTALL_TOKEN
ADMIN_EMAIL
ADMIN_PASSWORD
```

The public document root on Hostinger is `public_html`. The Laravel `public/` directory contains the public entry point and static assets used by the application.

## Local development

The project requires PHP 8.1 or later and Composer when dependencies need to be refreshed.

Typical local setup:

```powershell
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

The local machine may not have PHP or Node on its PATH. If so, use the installed toolchain or verify through the deployed environment. The committed `public/assets/app.js` must be updated alongside `resources/js/app.js` when changing assistant JavaScript, unless a frontend build process is restored and run.

## Git and Windows ownership

This folder previously suffered from Windows ACL/ownership issues. Ownership was repaired for the project files and Git metadata.

If Git later shows a `detected dubious ownership` error, use this safe-directory command for the active project only:

```powershell
git config --global --add safe.directory H:/TwinBot_Git/Development/TBI_Website/Live_Push
```

Do not run Git commands from the parent `H:\TwinBot_Git` repository when working on the website. It is a separate, broad repository with unrelated engineering files and unrelated pending changes.

## Recent confirmed commits

| Commit | Purpose |
| --- | --- |
| `2c36a5e` | Enforce chat-only assistant interface |
| `f63bdbc` | Hide assistant voice mode |
| `4c28282` | Show friendly message when AI credits are unavailable |
| `fe39ea1` | Fix hold-to-talk transcription behavior |
| `45e3502` | Remove obsolete deployment workflow |
| `f45c489` | Start AI assistant minimized |
| `b57819f` | Add Smart Vending content and simplify site navigation |

## Operational checklist before pushing

1. Run `git status` from `Live_Push` and confirm only intended files are changed.
2. Keep secrets and runtime files untracked: `.env`, Laravel logs, session files, compiled views, and `tmp/`.
3. When changing assistant JavaScript, update both `resources/js/app.js` and `public/assets/app.js`.
4. Commit with a clear message and push only to `main`.
5. Confirm Hostinger shows a completed automatic deployment if deployment verification is needed.

