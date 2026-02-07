const WebSocket = require('ws');
const { createVoiceSession, endVoiceSession, addTranscript } = require('../services/voiceService');

function setupVoiceServer(server) {
  const wss = new WebSocket.Server({ server, path: '/voice' });

  wss.on('connection', async (client, req) => {
    const ipAddress = req.headers['x-forwarded-for'] || req.socket.remoteAddress;
    const sessionId = await createVoiceSession(null, ipAddress);

    const openAiKey = process.env.OPENAI_API_KEY;
    const model = process.env.OPENAI_REALTIME_MODEL || 'gpt-realtime';
    const voice = process.env.OPENAI_REALTIME_VOICE || 'alloy';
    const transcribeModel = process.env.OPENAI_TRANSCRIBE_MODEL || 'whisper-1';

    if (!openAiKey) {
      client.send(JSON.stringify({ type: 'error', message: 'OPENAI_API_KEY not configured.' }));
      client.close();
      return;
    }

    const openAiSocket = new WebSocket(`wss://api.openai.com/v1/realtime?model=${model}`, {
      headers: {
        Authorization: `Bearer ${openAiKey}`
      }
    });

    let userTranscript = '';

    const sendToClient = (payload) => {
      if (client.readyState === WebSocket.OPEN) {
        client.send(JSON.stringify(payload));
      }
    };

    const sendToOpenAi = (payload) => {
      if (openAiSocket.readyState === WebSocket.OPEN) {
        openAiSocket.send(JSON.stringify(payload));
      }
    };

    openAiSocket.on('open', () => {
      sendToOpenAi({
        type: 'session.update',
        session: {
          type: 'realtime',
          model,
          instructions:
            'You are the TBI Website voice assistant. Answer questions about the company, projects, videos, and products. Suggest products when appropriate and guide users to request a quote or checkout. Keep responses concise and helpful.',
          voice,
          input_audio_format: 'pcm16',
          output_audio_format: 'pcm16',
          output_modalities: ['audio'],
          input_audio_transcription: { model: transcribeModel }
        }
      });
    });

    openAiSocket.on('message', async (message) => {
      let event;
      try {
        event = JSON.parse(message.toString());
      } catch (err) {
        return;
      }

      if (event.type === 'conversation.item.input_audio_transcription.delta') {
        userTranscript += event.delta;
        sendToClient({ type: 'user_transcript_delta', delta: event.delta });
      }

      if (event.type === 'conversation.item.input_audio_transcription.completed') {
        if (event.transcript) {
          userTranscript = event.transcript;
          sendToClient({ type: 'user_transcript_delta', delta: event.transcript });
        }
      }

      if (event.type === 'response.output_audio.delta') {
        sendToClient({ type: 'audio_delta', delta: event.delta });
      }

      if (event.type === 'response.output_text.delta') {
        sendToClient({ type: 'assistant_text_delta', delta: event.delta });
      }

      if (event.type === 'response.output_audio_transcript.delta') {
        sendToClient({ type: 'assistant_text_delta', delta: event.delta });
      }

      if (event.type === 'response.done') {
        const outputs = event.response?.output || [];
        const assistantTexts = [];
        for (const item of outputs) {
          if (item.type === 'message' && Array.isArray(item.content)) {
            for (const part of item.content) {
              if (part.type === 'output_text' && part.text) assistantTexts.push(part.text);
              if (part.type === 'output_audio' && part.transcript) assistantTexts.push(part.transcript);
            }
          }
        }

        const assistantTranscript = assistantTexts.join(' ').trim();
        if (userTranscript.trim()) {
          await addTranscript(sessionId, 'user', userTranscript.trim());
        }
        if (assistantTranscript) {
          await addTranscript(sessionId, 'assistant', assistantTranscript);
        }
        userTranscript = '';
      }
    });

    openAiSocket.on('close', () => {
      sendToClient({ type: 'status', message: 'Voice session ended.' });
    });

    openAiSocket.on('error', (err) => {
      sendToClient({ type: 'error', message: err.message || 'Voice error.' });
    });

    client.on('message', (message) => {
      let payload;
      try {
        payload = JSON.parse(message.toString());
      } catch (err) {
        return;
      }

      if (payload.type === 'audio_chunk') {
        sendToOpenAi({ type: 'input_audio_buffer.append', audio: payload.audio });
      }

      if (payload.type === 'commit') {
        sendToOpenAi({ type: 'input_audio_buffer.commit' });
        sendToOpenAi({ type: 'response.create' });
      }

      if (payload.type === 'text') {
        sendToOpenAi({
          type: 'conversation.item.create',
          item: {
            type: 'message',
            role: 'user',
            content: [{ type: 'input_text', text: payload.text }]
          }
        });
        sendToOpenAi({ type: 'response.create' });
      }

      if (payload.type === 'clear') {
        sendToOpenAi({ type: 'input_audio_buffer.clear' });
      }
    });

    client.on('close', async () => {
      if (openAiSocket.readyState === WebSocket.OPEN) {
        openAiSocket.close();
      }
      await endVoiceSession(sessionId);
    });
  });
}

module.exports = { setupVoiceServer };
