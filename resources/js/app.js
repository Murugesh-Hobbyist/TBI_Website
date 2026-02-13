import './bootstrap';

(function () {
  'use strict';

  function el(id) {
    return document.getElementById(id);
  }

  function parseRgbColor(value) {
    if (!value) return null;

    const match = String(value)
      .trim()
      .match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)/i);

    if (!match) return null;

    return {
      r: Number(match[1]),
      g: Number(match[2]),
      b: Number(match[3]),
    };
  }

  function luminance(rgb) {
    if (!rgb) return null;
    return (0.2126 * rgb.r + 0.7152 * rgb.g + 0.0722 * rgb.b) / 255;
  }

  function isThemeBeingDarkForced() {
    if (!document.body || !document.body.classList.contains('tb-site')) return false;

    const rootStyle = window.getComputedStyle(document.documentElement);
    const bodyStyle = window.getComputedStyle(document.body);

    const rootFilter = String(rootStyle.filter || '').toLowerCase();
    const bodyFilter = String(bodyStyle.filter || '').toLowerCase();
    const hasInvertFilter = rootFilter.includes('invert(') || bodyFilter.includes('invert(');

    const rootClass = String(document.documentElement.className || '').toLowerCase();
    const bodyClass = String(document.body.className || '').toLowerCase();

    const hasDarkReaderMarkers = Boolean(
      document.querySelector('[data-darkreader-mode]') ||
        document.querySelector('style.darkreader') ||
        rootClass.includes('darkreader') ||
        bodyClass.includes('darkreader')
    );

    const bgLum = luminance(parseRgbColor(bodyStyle.backgroundColor));
    const textLum = luminance(parseRgbColor(bodyStyle.color));
    const contrastLooksInverted = bgLum !== null && textLum !== null && bgLum < 0.45 && textLum > 0.72;

    return hasInvertFilter || hasDarkReaderMarkers || contrastLooksInverted;
  }

  function recoverLightThemeIfNeeded() {
    if (!document.body || !document.body.classList.contains('tb-site')) return;

    const existing = el('tb-light-recovery-style');
    const needsRecovery = isThemeBeingDarkForced();

    if (!needsRecovery) {
      if (existing) {
        existing.remove();
      }
      return;
    }

    if (existing) return;

    const style = document.createElement('style');
    style.id = 'tb-light-recovery-style';
    style.textContent = `
      html, body {
        color-scheme: only light !important;
        forced-color-adjust: none !important;
      }
      html {
        filter: none !important;
        background: #f7fbff !important;
      }
      body.tb-site {
        filter: none !important;
        color: #0f2744 !important;
        background:
          radial-gradient(920px 520px at -8% -18%, rgba(255, 106, 61, 0.24), transparent 67%),
          radial-gradient(860px 520px at 108% -4%, rgba(0, 166, 255, 0.25), transparent 64%),
          radial-gradient(740px 500px at 52% 122%, rgba(38, 201, 126, 0.2), transparent 66%),
          linear-gradient(170deg, #fcfeff 0%, #f7fbff 58%, #edf5ff 100%) !important;
      }
      body.tb-site::before {
        opacity: 0.2 !important;
      }
      .tb-site h1,
      .tb-site h2,
      .tb-site h3,
      .tb-site p,
      .tb-site li,
      .tb-site span,
      .tb-site a,
      .tb-site label,
      .tb-site small {
        opacity: 1 !important;
      }
    `;

    document.head.appendChild(style);
  }

  function watchThemeForOverrides() {
    if (!document.body || !document.body.classList.contains('tb-site')) return;

    const observer = new MutationObserver(function () {
      recoverLightThemeIfNeeded();
    });

    observer.observe(document.documentElement, {
      attributes: true,
      attributeFilter: ['class', 'style', 'data-darkreader-mode'],
    });

    observer.observe(document.body, {
      attributes: true,
      attributeFilter: ['class', 'style'],
    });

    setTimeout(function () {
      recoverLightThemeIfNeeded();
    }, 320);
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
    document.body.classList.add('tb-motion-ready');

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
    recoverLightThemeIfNeeded();
    watchThemeForOverrides();
    initMobileMenu();
    initRevealMotion();
    initAssistantWidget();
  });

  window.addEventListener('load', function () {
    recoverLightThemeIfNeeded();
    setTimeout(recoverLightThemeIfNeeded, 320);
  });
})();
