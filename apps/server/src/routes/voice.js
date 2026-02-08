const express = require('express');
const { instructions } = require('../voice/assistantInstructions');

const router = express.Router();

router.get('/healthz', (req, res) => {
  res.json({
    ok: true,
    mode: 'webrtc',
    model: process.env.OPENAI_REALTIME_MODEL || 'gpt-realtime-mini',
    voice: process.env.OPENAI_REALTIME_VOICE || 'marin'
  });
});

router.post(
  '/session',
  express.text({ type: ['application/sdp', 'text/plain'], limit: '2mb' }),
  async (req, res) => {
    const openAiKey = process.env.OPENAI_API_KEY;
    if (!openAiKey) {
      return res.status(500).json({ error: 'OPENAI_API_KEY not configured.' });
    }

    const offerSdp = req.body;
    if (!offerSdp || typeof offerSdp !== 'string') {
      return res.status(400).json({ error: 'Missing SDP offer.' });
    }

    const model = process.env.OPENAI_REALTIME_MODEL || 'gpt-realtime-mini';
    const voice = process.env.OPENAI_REALTIME_VOICE || 'marin';
    const transcribeModel = process.env.OPENAI_TRANSCRIBE_MODEL || 'whisper-1';

    if (typeof fetch !== 'function' || typeof FormData !== 'function') {
      return res.status(500).json({
        error: 'Server runtime missing fetch/FormData. Use Node.js 18+.'
      });
    }

    const session = {
      type: 'realtime',
      model,
      instructions,
      // Audio responses include a transcript; enabling text modality is optional.
      output_modalities: ['audio'],
      audio: {
        input: {
          format: { type: 'audio/pcm', rate: 24000 },
          transcription: { model: transcribeModel },
          // Let the server detect turn boundaries and auto-create responses.
          turn_detection: {
            type: 'server_vad',
            create_response: true,
            interrupt_response: true,
            prefix_padding_ms: 300,
            silence_duration_ms: 450
          }
        },
        output: {
          format: { type: 'audio/pcm', rate: 24000 },
          voice,
          speed: 1.0
        }
      }
    };

    try {
      const form = new FormData();
      form.set('sdp', offerSdp);
      form.set('session', JSON.stringify(session));

      const upstream = await fetch('https://api.openai.com/v1/realtime/calls', {
        method: 'POST',
        headers: { Authorization: `Bearer ${openAiKey}` },
        body: form
      });

      const answerSdp = await upstream.text();
      if (!upstream.ok) {
        return res.status(502).json({
          error: 'OpenAI Realtime call failed.',
          status: upstream.status,
          details: answerSdp.slice(0, 4000)
        });
      }

      res.setHeader('Content-Type', 'application/sdp');
      return res.status(200).send(answerSdp);
    } catch (err) {
      return res.status(500).json({ error: err.message || 'Voice session error.' });
    }
  }
);

module.exports = router;
