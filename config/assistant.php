<?php

return [
    'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com'),
    'openai_api_key' => env('OPENAI_API_KEY', ''),

    // Models (adjust in .env to your preference)
    'chat_model' => env('OPENAI_CHAT_MODEL', 'gpt-4.1-mini'),
    'transcribe_model' => env('OPENAI_TRANSCRIBE_MODEL', 'whisper-1'),
    'transcribe_language' => env('OPENAI_TRANSCRIBE_LANGUAGE', 'en'),
    'transcribe_prompt' => env(
        'OPENAI_TRANSCRIBE_PROMPT',
        'Transcribe clear spoken English commands for the TwinBot website assistant. Avoid guessing unclear words.'
    ),
    'tts_model' => env('OPENAI_TTS_MODEL', 'gpt-4o-mini-tts'),
    'tts_voice' => env('OPENAI_TTS_VOICE', 'onyx'),

    'timeout_seconds' => (int) env('OPENAI_TIMEOUT_SECONDS', 45),

    'system_prompt' => env('ASSISTANT_SYSTEM_PROMPT', "You are TwinBot Innovations' AI assistant.\n- Be concise and practical.\n- Prefer answering using the provided Context (site profile, pages, products, projects, videos, and knowledge base).\n- If the user asks to navigate, confirm the destination briefly in one sentence.\n- If the Context is insufficient, ask a clarifying question.\n- Do not invent company details.\n"),

    // Set true only during development.
    'debug_raw' => (bool) env('ASSISTANT_DEBUG_RAW', false),
];
