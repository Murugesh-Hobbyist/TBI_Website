(function () {
  'use strict';

  function el(id) {
    return document.getElementById(id);
  }

  function luminance(rgb) {
    const m = rgb.match(/\d+/g);
    if (!m || m.length < 3) return 255;
    const r = Number(m[0]);
    const g = Number(m[1]);
    const b = Number(m[2]);
    return 0.2126 * r + 0.7152 * g + 0.0722 * b;
  }

  function forceLightThemeIfNeeded() {
    if (!document.body || !document.body.classList.contains('tb-site')) return;

    const bg = window.getComputedStyle(document.body).backgroundColor;
    if (luminance(bg) > 85) return;

    if (el('tb-force-light-style')) return;

    const style = document.createElement('style');
    style.id = 'tb-force-light-style';
    style.textContent = `
      html, body.tb-site {
        color-scheme: light !important;
        background: #f6fbff !important;
        color: #11284a !important;
      }
      body.tb-site::before,
      .tb-background,
      .tb-orb { opacity: 0 !important; }
      .tb-header,
      .tb-topline,
      #tb-mobile-nav,
      .tb-panel,
      .tb-panel-soft,
      .tb-card,
      .tb-compare,
      .tb-compare-item,
      .tb-cta,
      .tb-stat,
      .tb-logo-card,
      .tb-product-thumb {
        background: #ffffff !important;
        color: #11284a !important;
        border-color: #c8d9eb !important;
      }
      .tb-lead,
      .tb-muted,
      .tb-compare-copy,
      .tb-form-label,
      .tb-nav-link,
      .tb-mini-link,
      .tb-step p,
      .tb-list li {
        color: #4f6890 !important;
      }
      .btn-primary {
        background: linear-gradient(130deg, #0f7c8a, #1f6fd0 55%, #3687dc) !important;
        color: #ffffff !important;
      }
      .btn-ghost {
        background: #f0f7ff !important;
        color: #2c5688 !important;
        border-color: #b7d2ea !important;
      }
    `;

    document.head.appendChild(style);
  }

  function appendLog(role, text) {
    const log = el('assistant-log');
    if (!log) return;

    const wrap = document.createElement('div');
    const isUser = role === 'user';
    wrap.className = 'rounded-2xl border border-black/10 p-3 ' + (isUser ? 'bg-[#E7F4FF]' : 'bg-white');

    const meta = document.createElement('div');
    meta.className = 'text-xs text-[#4A6587]';
    meta.textContent = isUser ? 'You' : 'AI';

    const body = document.createElement('div');
    body.className = 'mt-1 whitespace-pre-wrap text-[#142847]';
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
      body: JSON.stringify({ message: message }),
    });

    const json = await res.json().catch(function () {
      return {};
    });

    if (!res.ok || !json.ok) {
      throw new Error((json && json.message) || 'Assistant request failed.');
    }

    return json.text || '';
  }

  async function assistantTranscribe(blob) {
    const fd = new FormData();
    fd.append('audio', blob, 'voice.webm');

    const res = await fetch('/api/assistant/transcribe', { method: 'POST', body: fd });
    const json = await res.json().catch(function () {
      return {};
    });

    if (!res.ok || !json.ok) throw new Error('Transcription failed.');
    return json.text || '';
  }

  async function assistantSpeak(text) {
    const res = await fetch('/api/assistant/speak', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ text: text }),
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

    const open = function () {
      modal.classList.remove('hidden');
      setTimeout(function () {
        input.focus();
      }, 0);
    };

    const close = function () {
      modal.classList.add('hidden');
    };

    openBtn.addEventListener('click', open);
    closeBtn.addEventListener('click', close);
    backdrop.addEventListener('click', close);

    const send = async function () {
      const msg = (input.value || '').trim();
      if (!msg) return;
      input.value = '';
      appendLog('user', msg);

      try {
        const reply = await assistantChat(msg);
        appendLog('assistant', reply || '(no response)');

        const audioBlob = await assistantSpeak(reply);
        if (audioBlob) {
          const url = URL.createObjectURL(audioBlob);
          const audio = new Audio(url);
          audio.play().catch(function () {});
          audio.addEventListener('ended', function () {
            URL.revokeObjectURL(url);
          });
        }
      } catch (e) {
        appendLog('assistant', 'Error: ' + (e && e.message ? e.message : String(e)));
      }
    };

    sendBtn.addEventListener('click', send);
    input.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') send();
    });

    let recorder = null;
    let chunks = [];

    const startRecording = async function () {
      if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        appendLog('assistant', 'Voice recording not supported in this browser.');
        return;
      }

      const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
      chunks = [];
      recorder = new MediaRecorder(stream, { mimeType: 'audio/webm' });
      recorder.ondataavailable = function (e) {
        chunks.push(e.data);
      };
      recorder.onstop = async function () {
        stream.getTracks().forEach(function (t) {
          t.stop();
        });

        const blob = new Blob(chunks, { type: 'audio/webm' });

        try {
          appendLog('user', '[voice message]');
          const text = await assistantTranscribe(blob);
          if (String(text).trim() === '') {
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
            audio.play().catch(function () {});
            audio.addEventListener('ended', function () {
              URL.revokeObjectURL(url);
            });
          }
        } catch (e) {
          appendLog('assistant', 'Error: ' + (e && e.message ? e.message : String(e)));
        }
      };

      recorder.start();
      pttBtn.textContent = 'Recording...';
    };

    const stopRecording = async function () {
      if (!recorder) return;
      const r = recorder;
      recorder = null;
      pttBtn.textContent = 'Push-to-talk';
      r.stop();
    };

    pttBtn.addEventListener('mousedown', function () {
      startRecording().catch(function (e) {
        appendLog('assistant', 'Error: ' + (e && e.message ? e.message : String(e)));
      });
    });
    pttBtn.addEventListener('mouseup', function () {
      stopRecording().catch(function () {});
    });
    pttBtn.addEventListener('mouseleave', function () {
      stopRecording().catch(function () {});
    });
    pttBtn.addEventListener(
      'touchstart',
      function (e) {
        e.preventDefault();
        startRecording().catch(function (err) {
          appendLog('assistant', 'Error: ' + (err && err.message ? err.message : String(err)));
        });
      },
      { passive: false }
    );
    pttBtn.addEventListener(
      'touchend',
      function (e) {
        e.preventDefault();
        stopRecording().catch(function () {});
      },
      { passive: false }
    );

    appendLog('assistant', 'Hi. Ask me about products, projects, or automation capabilities.');
  }

  function initMobileMenu() {
    const toggle = el('tb-menu-toggle');
    const mobileNav = el('tb-mobile-nav');
    if (!toggle || !mobileNav) return;

    toggle.addEventListener('click', function () {
      const isOpen = !mobileNav.classList.contains('hidden');
      if (isOpen) {
        mobileNav.classList.add('hidden');
        toggle.setAttribute('aria-expanded', 'false');
      } else {
        mobileNav.classList.remove('hidden');
        toggle.setAttribute('aria-expanded', 'true');
      }
    });
  }

  function initRevealMotion() {
    const revealItems = document.querySelectorAll('.tb-reveal');
    if (!revealItems.length) return;

    if (!('IntersectionObserver' in window)) {
      revealItems.forEach(function (item) {
        item.classList.add('tb-inview');
      });
      return;
    }

    const observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('tb-inview');
            observer.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.15,
      }
    );

    revealItems.forEach(function (item) {
      observer.observe(item);
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    forceLightThemeIfNeeded();
    initMobileMenu();
    initRevealMotion();
    initAssistantWidget();
  });

  window.addEventListener('load', forceLightThemeIfNeeded);
})();
