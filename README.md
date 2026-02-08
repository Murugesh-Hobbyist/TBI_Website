# Finboard Website

This repo now contains a Laravel rewrite of the website in `apps/laravel`.

## Laravel (Recommended)
See `apps/laravel/README.md`.

### What’s implemented
- Dynamic pages: Home, Solutions, Projects, Products, Videos, About, Contact, Quote
- Simple admin panel (login + CRUD) for:
  - Projects, Products, Videos, Knowledge Base (KB)
  - Leads (contact/quote requests)
  - Orders (phase 1 checkout without payments)
- AI assistant:
  - Text chat and push-to-talk voice (record -> transcribe -> answer -> optional TTS reply)

## Legacy Node/Next (Deprecated)
The old Node.js platform remains in `apps/server` + `apps/web` for reference/migration, but the intended direction is Laravel.
