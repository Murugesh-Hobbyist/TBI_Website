import './bootstrap';

function el(id) {
  return document.getElementById(id);
}

function appendLog(role, text) {
  const log = el('assistant-log');
  if (!log) return;

  const wrap = document.createElement('div');
  wrap.className = 'rounded-xl border border-white/10 bg-white/5 p-3';

  const meta = document.createElement('div');
  meta.className = 'text-xs text-white/50';
  meta.textContent = role === 'user' ? 'You' : 'AI';

  const body = document.createElement('div');
  body.className = 'mt-1 whitespace-pre-wrap text-white/90';
  body.textContent = text;

  wrap.appendChild(meta);
  wrap.appendChild(body);
  log.appendChild(wrap);
  log.scrollTop = log.scrollHeight;
}

async function assistantChat(message) {
  const res = await fetch('/api/assistant/chat', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ message }),
  });

  const json = await res.json().catch(() => ({}));
  if (!res.ok || !json.ok) {
    throw new Error(json?.message || 'Assistant request failed.');
  }
  return json.text || '';
}

async function assistantTranscribe(blob) {
  const fd = new FormData();
  fd.append('audio', blob, 'voice.webm');

  const res = await fetch('/api/assistant/transcribe', { method: 'POST', body: fd });
  const json = await res.json().catch(() => ({}));
  if (!res.ok || !json.ok) throw new Error('Transcription failed.');
  return json.text || '';
}

async function assistantSpeak(text) {
  const res = await fetch('/api/assistant/speak', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ text }),
  });
  if (!res.ok) return null;
  const buf = await res.arrayBuffer();
  return new Blob([buf], { type: 'audio/mpeg' });
}

function initAssistantWidget() {
  const openBtn = el('assistant-open');
  const modal = el('assistant-modal');
  const closeBtn = el('assistant-close');
  const backdrop = el('assistant-backdrop');
  const input = el('assistant-input');
  const sendBtn = el('assistant-send');
  const pttBtn = el('assistant-ptt');

  if (!openBtn || !modal || !closeBtn || !backdrop || !input || !sendBtn || !pttBtn) return;

  const open = () => {
    modal.classList.remove('hidden');
    setTimeout(() => input.focus(), 0);
  };
  const close = () => modal.classList.add('hidden');

  openBtn.addEventListener('click', open);
  closeBtn.addEventListener('click', close);
  backdrop.addEventListener('click', close);

  const send = async () => {
    const msg = (input.value || '').trim();
    if (!msg) return;
    input.value = '';
    appendLog('user', msg);

    try {
      const reply = await assistantChat(msg);
      appendLog('assistant', reply || '(no response)');

      // Optional voice reply
      const audioBlob = await assistantSpeak(reply);
      if (audioBlob) {
        const url = URL.createObjectURL(audioBlob);
        const audio = new Audio(url);
        audio.play().catch(() => {});
        audio.addEventListener('ended', () => URL.revokeObjectURL(url));
      }
    } catch (e) {
      appendLog('assistant', `Error: ${e.message || e}`);
    }
  };

  sendBtn.addEventListener('click', send);
  input.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') send();
  });

  let recorder = null;
  let chunks = [];

  const startRecording = async () => {
    if (!navigator.mediaDevices?.getUserMedia) {
      appendLog('assistant', 'Voice recording not supported in this browser.');
      return;
    }

    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
    chunks = [];
    recorder = new MediaRecorder(stream, { mimeType: 'audio/webm' });
    recorder.ondataavailable = (e) => chunks.push(e.data);
    recorder.onstop = async () => {
      stream.getTracks().forEach((t) => t.stop());
      const blob = new Blob(chunks, { type: 'audio/webm' });

      try {
        appendLog('user', '[voice message]');
        const text = await assistantTranscribe(blob);
        if (text.trim() === '') {
          appendLog('assistant', 'I could not transcribe that. Try again.');
          return;
        }
        appendLog('user', text);
        const reply = await assistantChat(text);
        appendLog('assistant', reply || '(no response)');

        const audioBlob = await assistantSpeak(reply);
        if (audioBlob) {
          const url = URL.createObjectURL(audioBlob);
          const audio = new Audio(url);
          audio.play().catch(() => {});
          audio.addEventListener('ended', () => URL.revokeObjectURL(url));
        }
      } catch (e) {
        appendLog('assistant', `Error: ${e.message || e}`);
      }
    };

    recorder.start();
    pttBtn.textContent = 'Recording...';
  };

  const stopRecording = async () => {
    if (!recorder) return;
    const r = recorder;
    recorder = null;
    pttBtn.textContent = 'Push-to-talk';
    r.stop();
  };

  pttBtn.addEventListener('mousedown', () => startRecording().catch((e) => appendLog('assistant', `Error: ${e.message || e}`)));
  pttBtn.addEventListener('mouseup', () => stopRecording().catch(() => {}));
  pttBtn.addEventListener('mouseleave', () => stopRecording().catch(() => {}));
  pttBtn.addEventListener('touchstart', (e) => {
    e.preventDefault();
    startRecording().catch((err) => appendLog('assistant', `Error: ${err.message || err}`));
  }, { passive: false });
  pttBtn.addEventListener('touchend', (e) => {
    e.preventDefault();
    stopRecording().catch(() => {});
  }, { passive: false });

  appendLog('assistant', 'Hi. Ask me about products, projects, or automation capabilities.');
}

document.addEventListener('DOMContentLoaded', initAssistantWidget);
