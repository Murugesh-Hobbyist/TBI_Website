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

  const assistantStore = {
    open: 'tb.assistant.open',
    mode: 'tb.assistant.mode',
    voiceActive: 'tb.assistant.voiceActive',
    log: 'tb.assistant.log',
  };

  function storeGet(key) {
    try {
      return window.localStorage.getItem(key);
    } catch (e) {
      return null;
    }
  }

  function storeSet(key, value) {
    try {
      window.localStorage.setItem(key, value);
    } catch (e) {}
  }

  function readAssistantLogHistory() {
    const raw = storeGet(assistantStore.log);
    if (!raw) return [];

    try {
      const parsed = JSON.parse(raw);
      if (!Array.isArray(parsed)) return [];
      return parsed
        .filter(function (entry) {
          return entry && typeof entry.role === 'string' && typeof entry.text === 'string';
        })
        .slice(-60);
    } catch (e) {
      return [];
    }
  }

  function writeAssistantLogHistory(entries) {
    const limited = Array.isArray(entries) ? entries.slice(-60) : [];
    storeSet(assistantStore.log, JSON.stringify(limited));
  }

  function appendLog(role, text, options) {
    const log = el('assistant-log');
    if (!log) return;

    const opts = options || {};
    const wrap = document.createElement('div');
    const isUser = role === 'user';
    const isSystem = role === 'system';
    wrap.className =
      'rounded-2xl border p-3 ' +
      (isUser
        ? 'border-[#B8D8F4] bg-[#E7F4FF]'
        : isSystem
          ? 'border-[#D2DFEE] bg-[#F1F7FF]'
          : 'border-[#D6E3F1] bg-white');

    const meta = document.createElement('div');
    meta.className = 'text-xs text-[#4A6587]';
    meta.textContent = isUser ? 'You' : isSystem ? 'System' : 'TwinBot AI';

    const body = document.createElement('div');
    body.className = 'mt-1 whitespace-pre-wrap text-[#142847]';
    body.textContent = text;

    wrap.appendChild(meta);
    wrap.appendChild(body);
    log.appendChild(wrap);
    log.scrollTop = log.scrollHeight;

    if (!opts.skipPersist) {
      const history = readAssistantLogHistory();
      history.push({ role: role, text: text });
      writeAssistantLogHistory(history);
    }
  }

  async function assistantChat(message) {
    const res = await fetch('/api/assistant/chat', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        message: message,
        current_path: window.location.pathname,
        current_title: document.title,
      }),
    });

    const json = await res.json().catch(function () {
      return {};
    });

    if (!res.ok || !json.ok) {
      throw new Error((json && json.message) || 'Assistant request failed.');
    }

    return {
      text: json.text || '',
      action: json.action || null,
    };
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
    const panel = el('assistant-panel');
    const closeBtn = el('assistant-close');
    const modeChatBtn = el('assistant-mode-chat');
    const modeVoiceBtn = el('assistant-mode-voice');
    const chatControls = el('assistant-chat-controls');
    const voiceControls = el('assistant-voice-controls');
    const voiceToggleBtn = el('assistant-voice-toggle');
    const voiceStatus = el('assistant-voice-status');
    const log = el('assistant-log');
    const input = el('assistant-input');
    const sendBtn = el('assistant-send');
    const pttBtn = el('assistant-ptt');

    if (
      !openBtn ||
      !panel ||
      !closeBtn ||
      !modeChatBtn ||
      !modeVoiceBtn ||
      !chatControls ||
      !voiceControls ||
      !voiceToggleBtn ||
      !voiceStatus ||
      !log ||
      !input ||
      !sendBtn ||
      !pttBtn
    ) {
      return;
    }

    const SpeechRecognitionCtor = window.SpeechRecognition || window.webkitSpeechRecognition || null;
    const state = {
      mode: storeGet(assistantStore.mode) === 'voice' ? 'voice' : 'chat',
      voiceActive: storeGet(assistantStore.voiceActive) === '1',
      recognition: null,
      recognitionRunning: false,
      recognitionRestartTimer: null,
      processingVoice: false,
      speaking: false,
      lastVoiceText: '',
      lastVoiceAt: 0,
    };

    const setVoiceStatus = function (text) {
      voiceStatus.textContent = text;
    };

    const applyModeButtonState = function (button, isActive) {
      button.classList.remove('bg-[#1f6fd0]', 'text-white', 'shadow', 'text-[#365B82]', 'hover:bg-white');
      if (isActive) {
        button.classList.add('bg-[#1f6fd0]', 'text-white', 'shadow');
      } else {
        button.classList.add('text-[#365B82]', 'hover:bg-white');
      }
    };

    const setPanelOpen = function (shouldOpen) {
      if (shouldOpen) {
        panel.classList.remove('hidden');
        openBtn.classList.add('hidden');
      } else {
        panel.classList.add('hidden');
        openBtn.classList.remove('hidden');
      }

      storeSet(assistantStore.open, shouldOpen ? '1' : '0');

      if (shouldOpen) {
        setTimeout(function () {
          if (state.mode === 'chat') {
            input.focus();
          }
        }, 0);
      }
    };

    const open = function () {
      setPanelOpen(true);
    };

    const close = function () {
      setPanelOpen(false);
    };

    const shouldContinueVoice = function () {
      return state.mode === 'voice' && state.voiceActive;
    };

    const stopRecognition = function () {
      if (!state.recognition || !state.recognitionRunning) return;
      try {
        state.recognition.stop();
      } catch (e) {}
      state.recognitionRunning = false;
    };

    const scheduleRecognitionRestart = function (delayMs) {
      if (!state.recognition) return;

      if (state.recognitionRestartTimer) {
        clearTimeout(state.recognitionRestartTimer);
      }

      state.recognitionRestartTimer = setTimeout(function () {
        if (!shouldContinueVoice() || state.processingVoice || state.speaking || state.recognitionRunning) {
          return;
        }

        try {
          state.recognition.start();
        } catch (e) {
          const msg = String((e && e.message) || e || '').toLowerCase();
          if (msg.indexOf('already') === -1) {
            setVoiceStatus('Tap Start voice to continue.');
          }
        }
      }, typeof delayMs === 'number' ? delayMs : 250);
    };

    const stopVoiceConversation = function (announce) {
      state.voiceActive = false;
      storeSet(assistantStore.voiceActive, '0');

      if (state.recognitionRestartTimer) {
        clearTimeout(state.recognitionRestartTimer);
        state.recognitionRestartTimer = null;
      }

      stopRecognition();
      voiceToggleBtn.textContent = 'Start voice';
      setVoiceStatus('Voice mode idle.');

      if (announce) {
        appendLog('system', 'Voice mode disabled.');
      }
    };

    const startVoiceConversation = function (silentMessage) {
      if (!SpeechRecognitionCtor) {
        state.voiceActive = false;
        storeSet(assistantStore.voiceActive, '0');
        setVoiceStatus('Continuous voice not supported in this browser.');
        appendLog('system', 'Continuous voice mode is not supported in this browser. Use Chat mode or Hold to talk.');
        return;
      }

      state.voiceActive = true;
      storeSet(assistantStore.voiceActive, '1');
      voiceToggleBtn.textContent = 'Stop voice';
      setVoiceStatus('Listening...');

      if (!silentMessage) {
        appendLog('system', 'Voice mode enabled. I will keep listening until you stop voice mode.');
      }

      scheduleRecognitionRestart(100);
    };

    const maybeSpeak = async function (text) {
      if (!text) return;

      const audioBlob = await assistantSpeak(text);
      if (!audioBlob) return;

      state.speaking = true;
      stopRecognition();
      if (state.mode === 'voice') {
        setVoiceStatus('Speaking...');
      }

      const url = URL.createObjectURL(audioBlob);
      try {
        await new Promise(function (resolve) {
          const audio = new Audio(url);
          let done = false;
          const finish = function () {
            if (done) return;
            done = true;
            resolve();
          };

          audio.addEventListener('ended', finish, { once: true });
          audio.addEventListener('error', finish, { once: true });
          const playPromise = audio.play();
          if (playPromise && typeof playPromise.catch === 'function') {
            playPromise.catch(finish);
          }
        });
      } finally {
        URL.revokeObjectURL(url);
        state.speaking = false;
      }
    };

    const runAssistantAction = function (action) {
      if (!action || action.type !== 'navigate' || !action.url) return false;

      appendLog('system', 'Opening ' + (action.label || 'requested page') + '...');
      storeSet(assistantStore.open, '1');
      storeSet(assistantStore.mode, state.mode);
      storeSet(assistantStore.voiceActive, state.voiceActive ? '1' : '0');

      setTimeout(function () {
        window.location.assign(action.url);
      }, 450);

      return true;
    };

    const submitMessage = async function (message, options) {
      const opts = options || {};
      const msg = String(message || '').trim();
      if (!msg) return;

      if (opts.logUser !== false) {
        appendLog('user', msg);
      }

      const result = await assistantChat(msg);
      const reply = (result && result.text ? result.text : '').trim();
      appendLog('assistant', reply || '(no response)');

      const didNavigate = runAssistantAction(result ? result.action : null);
      if (!didNavigate && opts.speakReply && reply) {
        await maybeSpeak(reply);
      }

      if (shouldContinueVoice() && !didNavigate && !state.processingVoice && !state.speaking) {
        setVoiceStatus('Listening...');
        scheduleRecognitionRestart(300);
      }
    };

    const applyMode = function (mode) {
      state.mode = mode === 'voice' ? 'voice' : 'chat';
      storeSet(assistantStore.mode, state.mode);

      applyModeButtonState(modeChatBtn, state.mode === 'chat');
      applyModeButtonState(modeVoiceBtn, state.mode === 'voice');
      chatControls.classList.toggle('hidden', state.mode !== 'chat');
      voiceControls.classList.toggle('hidden', state.mode !== 'voice');

      if (state.mode === 'chat') {
        stopVoiceConversation(false);
      } else if (state.voiceActive) {
        startVoiceConversation(true);
      } else if (SpeechRecognitionCtor) {
        setVoiceStatus('Voice mode ready. Tap Start voice.');
      } else {
        setVoiceStatus('Continuous voice not supported in this browser.');
      }
    };

    if (SpeechRecognitionCtor) {
      state.recognition = new SpeechRecognitionCtor();
      state.recognition.continuous = true;
      state.recognition.interimResults = true;
      state.recognition.lang = 'en-US';

      state.recognition.onstart = function () {
        state.recognitionRunning = true;
        if (shouldContinueVoice() && !state.processingVoice && !state.speaking) {
          setVoiceStatus('Listening...');
        }
      };

      state.recognition.onresult = function (event) {
        if (!shouldContinueVoice() || state.processingVoice || state.speaking) {
          return;
        }

        let transcript = '';
        for (let i = event.resultIndex; i < event.results.length; i += 1) {
          const result = event.results[i];
          if (result.isFinal && result[0] && result[0].transcript) {
            transcript += result[0].transcript + ' ';
          }
        }

        const finalText = transcript.trim();
        if (!finalText) return;

        const now = Date.now();
        if (state.lastVoiceText === finalText && now - state.lastVoiceAt < 1400) {
          return;
        }
        state.lastVoiceText = finalText;
        state.lastVoiceAt = now;

        state.processingVoice = true;
        setVoiceStatus('Thinking...');
        stopRecognition();

        submitMessage(finalText, { speakReply: true })
          .catch(function (e) {
            appendLog('assistant', 'Error: ' + (e && e.message ? e.message : String(e)));
          })
          .finally(function () {
            state.processingVoice = false;
            if (shouldContinueVoice() && !state.speaking) {
              setVoiceStatus('Listening...');
              scheduleRecognitionRestart(320);
            }
          });
      };

      state.recognition.onerror = function (event) {
        state.recognitionRunning = false;
        if (!shouldContinueVoice()) return;

        const error = (event && event.error) || 'unknown';
        if (error === 'not-allowed' || error === 'service-not-allowed') {
          stopVoiceConversation(false);
          setVoiceStatus('Microphone permission blocked. Allow mic and start voice.');
          appendLog('system', 'Microphone permission is blocked. Please allow microphone access and start voice again.');
          return;
        }

        if (!state.processingVoice && !state.speaking) {
          scheduleRecognitionRestart(900);
        }
      };

      state.recognition.onend = function () {
        state.recognitionRunning = false;
        if (shouldContinueVoice() && !state.processingVoice && !state.speaking) {
          scheduleRecognitionRestart(420);
        }
      };
    }

    openBtn.addEventListener('click', open);
    closeBtn.addEventListener('click', close);
    modeChatBtn.addEventListener('click', function () {
      applyMode('chat');
    });
    modeVoiceBtn.addEventListener('click', function () {
      const wasActive = state.voiceActive;
      state.voiceActive = false;
      applyMode('voice');
      startVoiceConversation(wasActive);
      setPanelOpen(true);
    });
    voiceToggleBtn.addEventListener('click', function () {
      if (state.mode !== 'voice') {
        state.mode = 'voice';
        applyMode('voice');
      }

      if (state.voiceActive) {
        stopVoiceConversation(true);
      } else {
        startVoiceConversation(false);
      }
    });

    const send = async function () {
      const msg = (input.value || '').trim();
      if (!msg) return;
      input.value = '';

      try {
        await submitMessage(msg, { speakReply: true });
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

          await submitMessage(text, { speakReply: true });
        } catch (e) {
          appendLog('assistant', 'Error: ' + (e && e.message ? e.message : String(e)));
        }
      };

      recorder.start();
      pttBtn.textContent = 'Listening...';
    };

    const stopRecording = async function () {
      if (!recorder) return;
      const r = recorder;
      recorder = null;
      pttBtn.textContent = 'Hold to talk';
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

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        close();
      }
    });

    log.innerHTML = '';
    const history = readAssistantLogHistory();
    if (history.length) {
      history.forEach(function (entry) {
        appendLog(entry.role, entry.text, { skipPersist: true });
      });
    } else {
      appendLog(
        'assistant',
        'Hi. Ask about products, projects, pricing, or say "go to products page" and I will open it.'
      );
    }

    applyMode(state.mode);

    if (storeGet(assistantStore.open) === '1') {
      setPanelOpen(true);
    }

    if (state.mode === 'voice' && state.voiceActive) {
      setPanelOpen(true);
    }
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
