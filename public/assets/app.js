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

  async function assistantTranscribe(blob, filename) {
    const fd = new FormData();
    fd.append('audio', blob, filename || 'voice.webm');

    const res = await fetch('/api/assistant/transcribe', { method: 'POST', body: fd });
    const json = await res.json().catch(function () {
      return {};
    });

    if (!res.ok || !json.ok) throw new Error('Transcription failed.');
    return json.text || '';
  }

  async function assistantSpeak(text, options) {
    const opts = options || {};
    const res = await fetch('/api/assistant/speak', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        text: text,
        voice: opts.voice || 'onyx',
        speed: typeof opts.speed === 'number' ? opts.speed : 1.35,
      }),
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
    const stopSpeakBtn = el('assistant-stop-speech');
    const voiceStatus = el('assistant-voice-status');
    const voiceLastUser = el('assistant-voice-last-user');
    const voiceLastAssistant = el('assistant-voice-last-assistant');
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
    const IS_MOBILE = /android|iphone|ipad|ipod|mobile/i.test(String(navigator.userAgent || '').toLowerCase());
    const preferredLang =
      (Array.isArray(navigator.languages) && navigator.languages.length ? navigator.languages[0] : navigator.language) ||
      'en-US';
    const RECOGNITION_LANG = /^en\b/i.test(String(preferredLang || '')) ? preferredLang : 'en-US';
    const VOICE_RATE = 1.35;
    const VOICE_PITCH = 0.96;
    const OPENAI_VOICE = 'onyx';
    const PREFER_OPENAI_AUDIO_IN_VOICE_MODE = true;
    const USE_RECORDER_VOICE_MODE = true;
    const INTERIM_COMMIT_DELAY_MS = IS_MOBILE ? 1700 : 1200;
    const VOICE_DUPLICATE_WINDOW_MS = 1500;
    const VOICE_SEGMENT_MAX_MS = 8000;
    const VOICE_SEGMENT_MIN_MS = 450;
    const VOICE_SILENCE_COMMIT_MS = IS_MOBILE ? 950 : 700;
    const PREFERRED_MALE_VOICE_HINTS = [
      'male',
      'man',
      'david',
      'mark',
      'guy',
      'daniel',
      'alex',
      'ryan',
      'tom',
      'onyx',
      'echo',
      'fable',
      'english (india)',
    ];

    const state = {
      mode: storeGet(assistantStore.mode) === 'voice' ? 'voice' : 'chat',
      voiceActive: storeGet(assistantStore.voiceActive) === '1',
      recognition: null,
      recognitionRunning: false,
      recognitionStopExpected: false,
      recognitionRestartTimer: null,
      processingVoice: false,
      speaking: false,
      speakingStartedAt: 0,
      playbackController: null,
      preferredBrowserVoice: null,
      monitorStarting: false,
      monitorInterval: null,
      monitorAudioContext: null,
      monitorSource: null,
      monitorAnalyser: null,
      monitorStream: null,
      monitorData: null,
      monitorSpeechHits: 0,
      monitorNoiseFloor: 0.012,
      monitorLastInterruptAt: 0,
      currentSpokenText: '',
      pendingInterimText: '',
      interimCommitTimer: null,
      recognitionRetryDelayMs: IS_MOBILE ? 650 : 120,
      lastVoiceText: '',
      lastVoiceAt: 0,
      voiceRecorderStarting: false,
      voiceRecorderStream: null,
      voiceRecorder: null,
      voiceRecorderChunks: [],
      voiceRecorderMimeType: '',
      voiceRecorderFilename: 'voice.webm',
      voiceRecorderSegmentStartedAt: 0,
      voiceRecorderSpeechSeen: false,
      voiceRecorderLastSpeechAt: 0,
      voiceRecorderDiscardSegment: false,
      voiceRecorderAudioContext: null,
      voiceRecorderAnalyser: null,
      voiceRecorderSource: null,
      voiceRecorderData: null,
      voiceRecorderMonitorTimer: null,
      voiceRecorderNoiseFloor: 0.008,
    };

    const setVoiceStatus = function (text) {
      voiceStatus.textContent = text;
    };

    const setVoiceLastUser = function (text) {
      if (!voiceLastUser) return;
      const value = normalizeUtterance(text);
      voiceLastUser.textContent = value || '-';
    };

    const setVoiceLastAssistant = function (text) {
      if (!voiceLastAssistant) return;
      const value = normalizeUtterance(text);
      voiceLastAssistant.textContent = value || '-';
    };

    const normalizeUtterance = function (rawText) {
      return String(rawText || '')
        .replace(/\s+/g, ' ')
        .trim();
    };

    const getPreferredRecordingFormat = function () {
      const preferredMimes = ['audio/webm;codecs=opus', 'audio/mp4', 'audio/webm', 'audio/ogg;codecs=opus'];
      let selectedMime = '';
      if (window.MediaRecorder && typeof window.MediaRecorder.isTypeSupported === 'function') {
        for (let i = 0; i < preferredMimes.length; i += 1) {
          if (window.MediaRecorder.isTypeSupported(preferredMimes[i])) {
            selectedMime = preferredMimes[i];
            break;
          }
        }
      }

      let filename = 'voice.webm';
      if (selectedMime.indexOf('mp4') >= 0) {
        filename = 'voice.m4a';
      } else if (selectedMime.indexOf('ogg') >= 0) {
        filename = 'voice.ogg';
      }

      return {
        mimeType: selectedMime || 'audio/webm',
        filename: filename,
      };
    };

    const isLikelyNoisyUtterance = function (rawText) {
      const text = normalizeUtterance(rawText);
      if (!text) return false;
      if (text.indexOf('\uFFFD') >= 0) return true;
      if (text.length > 220) return true;

      const chars = Array.from(text);
      if (chars.length >= 10) {
        const nonAscii = chars.filter(function (ch) {
          return ch.charCodeAt(0) > 127;
        }).length;
        if (nonAscii / chars.length > 0.26) {
          return true;
        }
      }

      const words = text
        .toLowerCase()
        .split(/\s+/)
        .filter(function (w) {
          return w.length > 1;
        });

      if (words.length >= 6) {
        const freq = {};
        let top = 0;
        words.forEach(function (w) {
          freq[w] = (freq[w] || 0) + 1;
          if (freq[w] > top) top = freq[w];
        });
        if (top / words.length > 0.58) {
          return true;
        }
      }

      return false;
    };

    const applyModeButtonState = function (button, isActive) {
      button.classList.remove('bg-[#1f6fd0]', 'text-white', 'shadow', 'text-[#365B82]', 'hover:bg-white');
      if (isActive) {
        button.classList.add('bg-[#1f6fd0]', 'text-white', 'shadow');
      } else {
        button.classList.add('text-[#365B82]', 'hover:bg-white');
      }
    };

    const getPreferredBrowserVoice = function () {
      if (!window.speechSynthesis || typeof window.speechSynthesis.getVoices !== 'function') {
        return null;
      }

      if (state.preferredBrowserVoice) {
        return state.preferredBrowserVoice;
      }

      const voices = window.speechSynthesis.getVoices() || [];
      if (!voices.length) {
        return null;
      }

      const englishVoices = voices.filter(function (voice) {
        return typeof voice.lang === 'string' && voice.lang.toLowerCase().indexOf('en') === 0;
      });
      const candidateVoices = englishVoices.length ? englishVoices : voices;

      let preferred = null;
      for (let i = 0; i < candidateVoices.length; i += 1) {
        const voice = candidateVoices[i];
        const haystack = ((voice.name || '') + ' ' + (voice.lang || '')).toLowerCase();
        if (
          PREFERRED_MALE_VOICE_HINTS.some(function (hint) {
            return haystack.indexOf(hint) >= 0;
          })
        ) {
          preferred = voice;
          break;
        }
      }

      if (!preferred) {
        preferred = candidateVoices[0] || null;
      }

      state.preferredBrowserVoice = preferred;
      return preferred;
    };

    if (window.speechSynthesis && typeof window.speechSynthesis.addEventListener === 'function') {
      window.speechSynthesis.addEventListener('voiceschanged', function () {
        state.preferredBrowserVoice = null;
      });
    }

    const scrollLogToLatest = function () {
      log.scrollTop = log.scrollHeight;
    };

    const ensureLogStaysAtBottom = function () {
      scrollLogToLatest();
      if (typeof window.requestAnimationFrame === 'function') {
        window.requestAnimationFrame(scrollLogToLatest);
      }
      setTimeout(scrollLogToLatest, 0);
      setTimeout(scrollLogToLatest, 120);
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
          ensureLogStaysAtBottom();
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
      state.recognitionStopExpected = true;
      try {
        state.recognition.stop();
      } catch (e) {}
      state.recognitionRunning = false;
    };

    const stopCurrentPlayback = function () {
      if (state.playbackController && typeof state.playbackController.stop === 'function') {
        try {
          state.playbackController.stop();
        } catch (e) {}
      }
      state.playbackController = null;

      if (window.speechSynthesis) {
        try {
          window.speechSynthesis.cancel();
        } catch (e) {}
      }

      state.speaking = false;
    };

    const stopAssistantSpeech = function (announce) {
      const wasSpeaking = state.speaking;
      stopCurrentPlayback();
      setVoiceStatus(shouldContinueVoice() ? 'Listening...' : 'Voice mode ready. Tap Start voice.');

      if (shouldContinueVoice() && !state.processingVoice) {
        if (USE_RECORDER_VOICE_MODE) {
          if (state.voiceRecorderStream) {
            startVoiceRecorderSegment();
          } else {
            startVoiceRecorderLoop().catch(function () {});
          }
        } else if (!state.recognitionRunning) {
          scheduleRecognitionRestart(IS_MOBILE ? 650 : 80);
        }
      }

      if (announce && wasSpeaking) {
        appendLog('system', 'Assistant speech stopped.');
      }
    };

    const stopInterruptMonitor = function () {
      if (state.monitorInterval) {
        clearInterval(state.monitorInterval);
        state.monitorInterval = null;
      }

      if (state.monitorSource && typeof state.monitorSource.disconnect === 'function') {
        try {
          state.monitorSource.disconnect();
        } catch (e) {}
      }
      state.monitorSource = null;

      state.monitorAnalyser = null;
      state.monitorData = null;
      state.monitorSpeechHits = 0;
      state.monitorNoiseFloor = 0.012;
      state.monitorLastInterruptAt = 0;

      if (state.monitorAudioContext && typeof state.monitorAudioContext.close === 'function') {
        try {
          state.monitorAudioContext.close();
        } catch (e) {}
      }
      state.monitorAudioContext = null;

      if (state.monitorStream) {
        try {
          state.monitorStream.getTracks().forEach(function (track) {
            track.stop();
          });
        } catch (e) {}
      }
      state.monitorStream = null;
      state.monitorStarting = false;
    };

    const startInterruptMonitor = async function () {
      if (IS_MOBILE) {
        return;
      }
      if (state.monitorInterval || state.monitorStarting) {
        return;
      }
      if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        return;
      }

      const AudioContextCtor = window.AudioContext || window.webkitAudioContext;
      if (!AudioContextCtor) {
        return;
      }

      state.monitorStarting = true;

      try {
        const stream = await navigator.mediaDevices.getUserMedia({
          audio: {
            echoCancellation: true,
            noiseSuppression: true,
            autoGainControl: true,
          },
        });

        const audioContext = new AudioContextCtor();
        if (audioContext.state === 'suspended' && typeof audioContext.resume === 'function') {
          try {
            await audioContext.resume();
          } catch (e) {}
        }

        const source = audioContext.createMediaStreamSource(stream);
        const analyser = audioContext.createAnalyser();
        analyser.fftSize = 1024;
        source.connect(analyser);

        state.monitorStream = stream;
        state.monitorAudioContext = audioContext;
        state.monitorSource = source;
        state.monitorAnalyser = analyser;
        state.monitorData = new Uint8Array(analyser.fftSize);
        state.monitorSpeechHits = 0;
        state.monitorNoiseFloor = 0.012;
        state.monitorLastInterruptAt = 0;

        state.monitorInterval = setInterval(function () {
          if (!state.monitorAnalyser || !state.monitorData) {
            return;
          }

          state.monitorAnalyser.getByteTimeDomainData(state.monitorData);
          let energy = 0;
          for (let i = 0; i < state.monitorData.length; i += 1) {
            const sample = (state.monitorData[i] - 128) / 128;
            energy += sample * sample;
          }
          const rms = Math.sqrt(energy / state.monitorData.length);

          if (!shouldContinueVoice() || !state.speaking || state.processingVoice) {
            state.monitorSpeechHits = 0;
            // Learn room noise when assistant is not speaking.
            state.monitorNoiseFloor = state.monitorNoiseFloor * 0.92 + rms * 0.08;
            return;
          }

          if (Date.now() - state.speakingStartedAt < 140) {
            return;
          }

          const threshold = Math.max(0.016, state.monitorNoiseFloor * 1.8);
          if (rms > threshold) {
            state.monitorSpeechHits += 1;
          } else {
            state.monitorSpeechHits = Math.max(0, state.monitorSpeechHits - 1);
          }

          if (state.monitorSpeechHits >= 2) {
            const now = Date.now();
            if (now - state.monitorLastInterruptAt < 240) {
              return;
            }
            state.monitorLastInterruptAt = now;
            state.monitorSpeechHits = 0;
            stopCurrentPlayback();
            setVoiceStatus('Listening...');
            if (!state.recognitionRunning && !startRecognitionNow()) {
              scheduleRecognitionRestart(IS_MOBILE ? 650 : 40);
            }
          }
        }, 50);
      } catch (e) {
        // If monitor permission fails, voice mode still works without barge-in detection.
      } finally {
        state.monitorStarting = false;
      }
    };

    const startRecognitionNow = function () {
      if (USE_RECORDER_VOICE_MODE) {
        return false;
      }
      if (!state.recognition || state.recognitionRunning || !shouldContinueVoice() || state.processingVoice || state.speaking) {
        return false;
      }

      try {
        state.recognition.start();
        state.recognitionRetryDelayMs = IS_MOBILE ? 650 : 120;
        return true;
      } catch (e) {
        const msg = String((e && e.message) || e || '').toLowerCase();
        if (msg.indexOf('already') === -1) {
          setVoiceStatus('Tap Start voice to continue.');
        }
        return false;
      }
    };

    const scheduleRecognitionRestart = function (delayMs) {
      if (USE_RECORDER_VOICE_MODE) {
        return;
      }
      if (!state.recognition) return;

      if (state.recognitionRestartTimer) {
        clearTimeout(state.recognitionRestartTimer);
      }

      const waitMs =
        typeof delayMs === 'number'
          ? delayMs
          : IS_MOBILE
            ? Math.max(450, state.recognitionRetryDelayMs)
            : 120;

      state.recognitionRestartTimer = setTimeout(function () {
        if (!shouldContinueVoice() || state.processingVoice || state.speaking || state.recognitionRunning) {
          return;
        }

        const started = startRecognitionNow();
        if (!started && shouldContinueVoice() && !state.processingVoice && !state.speaking) {
          state.recognitionRetryDelayMs = Math.min(2600, Math.floor(state.recognitionRetryDelayMs * 1.35));
          scheduleRecognitionRestart(state.recognitionRetryDelayMs);
        }
      }, waitMs);
    };

    const clearInterimCommitTimer = function () {
      state.pendingInterimText = '';
      if (state.interimCommitTimer) {
        clearTimeout(state.interimCommitTimer);
        state.interimCommitTimer = null;
      }
    };

    const processVoiceInput = function (rawText) {
      if (!shouldContinueVoice() || state.processingVoice) {
        return;
      }

      const finalText = normalizeUtterance(rawText);
      if (!finalText) {
        return;
      }

      if (state.speaking) {
        return;
      }

      const now = Date.now();
      if (state.lastVoiceText === finalText && now - state.lastVoiceAt < VOICE_DUPLICATE_WINDOW_MS) {
        return;
      }
      state.lastVoiceText = finalText;
      state.lastVoiceAt = now;

      setVoiceLastUser(finalText);
      state.processingVoice = true;
      setVoiceStatus('Thinking...');

      submitMessage(finalText, {
        speakReply: true,
      })
        .catch(function (e) {
          appendLog('assistant', 'Error: ' + (e && e.message ? e.message : String(e)));
        })
        .finally(function () {
          state.processingVoice = false;
          if (shouldContinueVoice() && !state.speaking) {
            setVoiceStatus('Listening...');
            if (USE_RECORDER_VOICE_MODE) {
              startVoiceRecorderSegment();
            } else if (!state.recognitionRunning) {
              scheduleRecognitionRestart(IS_MOBILE ? 650 : 120);
            }
          }
        });
    };

    const scheduleInterimCommit = function (rawText) {
      const text = normalizeUtterance(rawText);
      if (!text || state.processingVoice || state.speaking) {
        return;
      }

      state.pendingInterimText = text;

      if (state.interimCommitTimer) {
        clearTimeout(state.interimCommitTimer);
      }

      state.interimCommitTimer = setTimeout(function () {
        const pending = normalizeUtterance(state.pendingInterimText);
        clearInterimCommitTimer();
        if (!pending || !shouldContinueVoice() || state.processingVoice || state.speaking) {
          return;
        }

        processVoiceInput(pending);
      }, INTERIM_COMMIT_DELAY_MS);
    };

    const stopVoiceRecorderLoop = function (discardSegment, keepStream) {
      if (state.voiceRecorderMonitorTimer) {
        clearInterval(state.voiceRecorderMonitorTimer);
        state.voiceRecorderMonitorTimer = null;
      }

      if (discardSegment) {
        state.voiceRecorderDiscardSegment = true;
      }

      if (state.voiceRecorder && state.voiceRecorder.state !== 'inactive') {
        try {
          state.voiceRecorder.stop();
        } catch (e) {}
      }
      state.voiceRecorder = null;
      state.voiceRecorderChunks = [];
      state.voiceRecorderSpeechSeen = false;
      state.voiceRecorderLastSpeechAt = 0;

      if (keepStream) {
        return;
      }

      if (state.voiceRecorderSource && typeof state.voiceRecorderSource.disconnect === 'function') {
        try {
          state.voiceRecorderSource.disconnect();
        } catch (e) {}
      }
      state.voiceRecorderSource = null;
      state.voiceRecorderAnalyser = null;
      state.voiceRecorderData = null;

      if (state.voiceRecorderAudioContext && typeof state.voiceRecorderAudioContext.close === 'function') {
        try {
          state.voiceRecorderAudioContext.close();
        } catch (e) {}
      }
      state.voiceRecorderAudioContext = null;

      if (state.voiceRecorderStream) {
        try {
          state.voiceRecorderStream.getTracks().forEach(function (track) {
            track.stop();
          });
        } catch (e) {}
      }
      state.voiceRecorderStream = null;
      state.voiceRecorderStarting = false;
    };

    const startVoiceRecorderSegment = function () {
      if (
        !USE_RECORDER_VOICE_MODE ||
        !shouldContinueVoice() ||
        !state.voiceRecorderStream ||
        state.processingVoice ||
        state.speaking ||
        state.voiceRecorder ||
        state.voiceRecorderStarting
      ) {
        return;
      }

      state.voiceRecorderDiscardSegment = false;
      state.voiceRecorderChunks = [];
      state.voiceRecorderSpeechSeen = false;
      state.voiceRecorderLastSpeechAt = 0;
      state.voiceRecorderSegmentStartedAt = Date.now();

      const recorder = state.voiceRecorderMimeType
        ? new MediaRecorder(state.voiceRecorderStream, { mimeType: state.voiceRecorderMimeType })
        : new MediaRecorder(state.voiceRecorderStream);
      state.voiceRecorder = recorder;

      recorder.ondataavailable = function (event) {
        if (event.data && event.data.size > 0) {
          state.voiceRecorderChunks.push(event.data);
        }
      };

      recorder.onerror = function () {
        state.voiceRecorder = null;
        if (shouldContinueVoice() && !state.processingVoice && !state.speaking) {
          setTimeout(startVoiceRecorderSegment, 220);
        }
      };

      recorder.onstop = async function () {
        if (state.voiceRecorderMonitorTimer) {
          clearInterval(state.voiceRecorderMonitorTimer);
          state.voiceRecorderMonitorTimer = null;
        }

        state.voiceRecorder = null;
        const segmentDuration = Date.now() - state.voiceRecorderSegmentStartedAt;
        const discardSegment = state.voiceRecorderDiscardSegment;
        state.voiceRecorderDiscardSegment = false;
        const chunks = state.voiceRecorderChunks.slice();
        state.voiceRecorderChunks = [];

        let submittedFromSegment = false;
        if (!discardSegment && chunks.length) {
          const blob = new Blob(chunks, { type: state.voiceRecorderMimeType || 'audio/webm' });
          const hadSpeech = state.voiceRecorderSpeechSeen || blob.size > 1200;

          if (hadSpeech && segmentDuration >= VOICE_SEGMENT_MIN_MS && blob.size > 500) {
            try {
              const transcript = normalizeUtterance(await assistantTranscribe(blob, state.voiceRecorderFilename));
              if (transcript !== '') {
                submittedFromSegment = true;
                processVoiceInput(transcript);
              }
            } catch (e) {
              appendLog('assistant', 'Error: ' + (e && e.message ? e.message : String(e)));
            }
          }
        }

        if (!submittedFromSegment && shouldContinueVoice() && !state.processingVoice && !state.speaking) {
          setVoiceStatus('Listening...');
          setTimeout(startVoiceRecorderSegment, 120);
        }
      };

      recorder.start(250);
      setVoiceStatus('Listening...');

      if (state.voiceRecorderAnalyser && state.voiceRecorderData) {
        state.voiceRecorderMonitorTimer = setInterval(function () {
          if (!state.voiceRecorder || state.voiceRecorder.state !== 'recording') {
            return;
          }

          const now = Date.now();
          const segmentAge = now - state.voiceRecorderSegmentStartedAt;
          state.voiceRecorderAnalyser.getByteTimeDomainData(state.voiceRecorderData);

          let energy = 0;
          for (let i = 0; i < state.voiceRecorderData.length; i += 1) {
            const sample = (state.voiceRecorderData[i] - 128) / 128;
            energy += sample * sample;
          }
          const rms = Math.sqrt(energy / state.voiceRecorderData.length);

          if (!state.voiceRecorderSpeechSeen) {
            state.voiceRecorderNoiseFloor = state.voiceRecorderNoiseFloor * 0.92 + rms * 0.08;
          }

          const threshold = Math.max(0.008, state.voiceRecorderNoiseFloor * 1.35);
          if (rms > threshold) {
            state.voiceRecorderSpeechSeen = true;
            state.voiceRecorderLastSpeechAt = now;
          }

          if (
            state.voiceRecorderSpeechSeen &&
            segmentAge >= VOICE_SEGMENT_MIN_MS &&
            now - state.voiceRecorderLastSpeechAt >= VOICE_SILENCE_COMMIT_MS
          ) {
            try {
              state.voiceRecorder.stop();
            } catch (e) {}
            return;
          }

          if (!state.voiceRecorderSpeechSeen && segmentAge >= 2600) {
            try {
              state.voiceRecorder.stop();
            } catch (e) {}
            return;
          }

          if (segmentAge >= VOICE_SEGMENT_MAX_MS) {
            try {
              state.voiceRecorder.stop();
            } catch (e) {}
          }
        }, 90);
      } else {
        state.voiceRecorderMonitorTimer = setInterval(function () {
          if (!state.voiceRecorder || state.voiceRecorder.state !== 'recording') {
            return;
          }
          if (Date.now() - state.voiceRecorderSegmentStartedAt >= VOICE_SEGMENT_MAX_MS) {
            try {
              state.voiceRecorder.stop();
            } catch (e) {}
          }
        }, 120);
      }
    };

    const startVoiceRecorderLoop = async function () {
      if (
        !USE_RECORDER_VOICE_MODE ||
        !shouldContinueVoice() ||
        state.voiceRecorderStarting ||
        state.voiceRecorderStream ||
        state.processingVoice ||
        state.speaking
      ) {
        return;
      }

      if (
        !navigator.mediaDevices ||
        !navigator.mediaDevices.getUserMedia ||
        typeof window.MediaRecorder !== 'function'
      ) {
        stopVoiceConversation(false);
        setVoiceStatus('Continuous voice not supported in this browser.');
        appendLog('system', 'Continuous voice mode is not supported in this browser. Use Chat mode or Hold to talk.');
        return;
      }

      state.voiceRecorderStarting = true;
      try {
        const stream = await navigator.mediaDevices.getUserMedia({
          audio: {
            echoCancellation: true,
            noiseSuppression: true,
            autoGainControl: true,
            channelCount: 1,
          },
        });

        const format = getPreferredRecordingFormat();
        state.voiceRecorderMimeType = format.mimeType;
        state.voiceRecorderFilename = format.filename;
        state.voiceRecorderStream = stream;
        state.voiceRecorderNoiseFloor = 0.008;

        const AudioContextCtor = window.AudioContext || window.webkitAudioContext;
        if (AudioContextCtor) {
          const audioContext = new AudioContextCtor();
          if (audioContext.state === 'suspended' && typeof audioContext.resume === 'function') {
            try {
              await audioContext.resume();
            } catch (e) {}
          }
          const source = audioContext.createMediaStreamSource(stream);
          const analyser = audioContext.createAnalyser();
          analyser.fftSize = 1024;
          source.connect(analyser);
          state.voiceRecorderAudioContext = audioContext;
          state.voiceRecorderSource = source;
          state.voiceRecorderAnalyser = analyser;
          state.voiceRecorderData = new Uint8Array(analyser.fftSize);
        }

        startVoiceRecorderSegment();
      } catch (e) {
        appendLog('assistant', 'Error: ' + (e && e.message ? e.message : String(e)));
        stopVoiceRecorderLoop(true, false);
      } finally {
        state.voiceRecorderStarting = false;
      }
    };

    const stopVoiceConversation = function (announce) {
      state.voiceActive = false;
      storeSet(assistantStore.voiceActive, '0');
      state.currentSpokenText = '';
      clearInterimCommitTimer();
      state.recognitionStopExpected = false;
      state.recognitionRetryDelayMs = IS_MOBILE ? 650 : 120;

      if (state.recognitionRestartTimer) {
        clearTimeout(state.recognitionRestartTimer);
        state.recognitionRestartTimer = null;
      }

      stopRecognition();
      stopVoiceRecorderLoop(true, false);
      stopCurrentPlayback();
      stopInterruptMonitor();
      voiceToggleBtn.textContent = 'Start voice';
      setVoiceStatus('Voice mode idle.');
      setVoiceLastUser('');
      setVoiceLastAssistant('');

      if (announce) {
        appendLog('system', 'Voice mode disabled.');
      }
    };

    const startVoiceConversation = function (silentMessage, immediateStart) {
      const hasSpeechRecognition = Boolean(SpeechRecognitionCtor);
      const hasRecorderSupport =
        Boolean(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) &&
        typeof window.MediaRecorder === 'function';
      const isSupported = USE_RECORDER_VOICE_MODE ? hasRecorderSupport : hasSpeechRecognition;

      if (!isSupported) {
        state.voiceActive = false;
        storeSet(assistantStore.voiceActive, '0');
        setVoiceStatus('Continuous voice not supported in this browser.');
        appendLog('system', 'Continuous voice mode is not supported in this browser. Use Chat mode or Hold to talk.');
        return;
      }

      state.voiceActive = true;
      storeSet(assistantStore.voiceActive, '1');
      state.recognitionRetryDelayMs = IS_MOBILE ? 650 : 120;
      voiceToggleBtn.textContent = 'Stop voice';
      setVoiceStatus('Listening...');

      if (!silentMessage) {
        appendLog('system', 'Voice mode enabled. I will keep listening until you stop voice mode.');
      }

      clearInterimCommitTimer();
      setVoiceLastUser('');
      setVoiceLastAssistant('');
      stopInterruptMonitor();

      if (USE_RECORDER_VOICE_MODE) {
        if (immediateStart) {
          startVoiceRecorderLoop().catch(function () {});
        } else {
          setTimeout(function () {
            startVoiceRecorderLoop().catch(function () {});
          }, IS_MOBILE ? 450 : 40);
        }
      } else if (immediateStart) {
        const started = startRecognitionNow();
        if (!started) {
          scheduleRecognitionRestart(IS_MOBILE ? 650 : 40);
        }
      } else {
        scheduleRecognitionRestart(IS_MOBILE ? 650 : 40);
      }
    };

    const maybeSpeak = async function (text) {
      if (!text) return;

      const speakWithBrowserVoice = async function () {
        if (!window.speechSynthesis || typeof window.SpeechSynthesisUtterance !== 'function') {
          return false;
        }

        const voice = getPreferredBrowserVoice();
        let failed = false;

        await new Promise(function (resolve) {
          const utterance = new SpeechSynthesisUtterance(text);
          if (voice) {
            utterance.voice = voice;
            if (voice.lang) {
              utterance.lang = voice.lang;
            }
          }
          utterance.rate = VOICE_RATE;
          utterance.pitch = VOICE_PITCH;
          utterance.volume = 1;

          let done = false;
          const finish = function () {
            if (done) return;
            done = true;
            resolve();
          };

          utterance.onend = function () {
            finish();
          };
          utterance.onerror = function () {
            failed = true;
            finish();
          };

          state.playbackController = {
            type: 'browser_tts',
            stop: function () {
              try {
                window.speechSynthesis.cancel();
              } catch (e) {}
              finish();
            },
          };

          window.speechSynthesis.cancel();
          window.speechSynthesis.speak(utterance);
        });

        return !failed;
      };

      const speakWithServerVoice = async function () {
        const audioBlob = await assistantSpeak(text, { voice: OPENAI_VOICE, speed: VOICE_RATE });
        if (!audioBlob) {
          return false;
        }

        const url = URL.createObjectURL(audioBlob);
        let playbackFailed = false;

        await new Promise(function (resolve) {
          const audio = new Audio(url);
          let done = false;
          const finish = function () {
            if (done) return;
            done = true;
            resolve();
          };

          state.playbackController = {
            type: 'openai_audio',
            stop: function () {
              try {
                audio.pause();
                audio.src = '';
              } catch (e) {}
              finish();
            },
          };

          audio.addEventListener('ended', finish, { once: true });
          audio.addEventListener(
            'error',
            function () {
              playbackFailed = true;
              finish();
            },
            { once: true }
          );
          const playPromise = audio.play();
          if (playPromise && typeof playPromise.catch === 'function') {
            playPromise.catch(function () {
              playbackFailed = true;
              finish();
            });
          }
        });

        URL.revokeObjectURL(url);

        return !playbackFailed;
      };

      stopCurrentPlayback();
      if (USE_RECORDER_VOICE_MODE) {
        stopVoiceRecorderLoop(true, true);
      }
      setVoiceLastAssistant(text);
      state.speaking = true;
      state.speakingStartedAt = Date.now();
      state.currentSpokenText = String(text || '').toLowerCase();
      if (state.recognitionRunning) {
        stopRecognition();
      }
      if (state.mode === 'voice') {
        setVoiceStatus('Speaking...');
      }

      try {
        if (state.mode === 'voice' && PREFER_OPENAI_AUDIO_IN_VOICE_MODE) {
          const serverSuccess = await speakWithServerVoice();
          if (!serverSuccess) {
            await speakWithBrowserVoice();
          }
        } else {
          const browserSuccess = await speakWithBrowserVoice();
          if (!browserSuccess) {
            await speakWithServerVoice();
          }
        }
      } finally {
        state.speaking = false;
        state.currentSpokenText = '';
        state.playbackController = null;
        if (shouldContinueVoice() && !state.processingVoice) {
          if (USE_RECORDER_VOICE_MODE) {
            if (state.voiceRecorderStream) {
              startVoiceRecorderSegment();
            } else {
              startVoiceRecorderLoop().catch(function () {});
            }
          } else if (!state.recognitionRunning) {
            scheduleRecognitionRestart(IS_MOBILE ? 650 : 100);
          }
        }
      }
    };

    const runAssistantAction = async function (action) {
      if (!action || typeof action !== 'object' || !action.type) return false;

      if (action.type === 'navigate' && action.url) {
        const label = action.label || 'requested page';
        const openingText = 'Switching to ' + label + '.';
        setVoiceLastAssistant(openingText);
        if (state.mode === 'voice') {
          setVoiceStatus(openingText);
          await maybeSpeak(openingText);
        } else {
          appendLog('system', openingText);
        }

        storeSet(assistantStore.open, '1');
        storeSet(assistantStore.mode, state.mode);
        storeSet(assistantStore.voiceActive, state.voiceActive ? '1' : '0');

        setTimeout(function () {
          window.location.assign(action.url);
        }, state.mode === 'voice' ? 80 : 450);

        return true;
      }

      if (action.type === 'scroll') {
        const mode = String(action.mode || '').toLowerCase();
        const direction = String(action.direction || '').toLowerCase() === 'up' ? 'up' : 'down';
        const ratioRaw = Number(action.ratio);
        const ratio = Number.isFinite(ratioRaw) ? Math.max(0.15, Math.min(1.6, ratioRaw)) : 0.75;

        let openingText = 'Scrolling ' + direction + '.';
        if (mode === 'top') {
          openingText = 'Scrolling to top.';
        } else if (mode === 'bottom') {
          openingText = 'Scrolling to bottom.';
        }
        setVoiceLastAssistant(openingText);

        if (state.mode === 'voice') {
          await maybeSpeak(openingText);
        } else {
          appendLog('system', openingText);
        }

        if (mode === 'top') {
          window.scrollTo({ top: 0, behavior: 'smooth' });
          return true;
        }

        if (mode === 'bottom') {
          window.scrollTo({ top: document.documentElement.scrollHeight, behavior: 'smooth' });
          return true;
        }

        const delta = Math.round(window.innerHeight * ratio);
        window.scrollBy({ top: direction === 'up' ? -delta : delta, behavior: 'smooth' });
        return true;
      }

      return false;
    };

    const submitMessage = async function (message, options) {
      const opts = options || {};
      const msg = String(message || '').trim();
      if (!msg) return;
      setVoiceLastUser(msg);

      if (opts.logUser !== false) {
        appendLog('user', msg);
      }

      const result = await assistantChat(msg);
      const reply = (result && result.text ? result.text : '').trim();
      setVoiceLastAssistant(reply || '(no response)');
      if (opts.logAssistant !== false) {
        appendLog('assistant', reply || '(no response)');
      }

      const didNavigate = await runAssistantAction(result ? result.action : null);
      if (!didNavigate && opts.speakReply && reply) {
        await maybeSpeak(reply);
      }

      if (shouldContinueVoice() && !didNavigate && !state.processingVoice && !state.speaking) {
        setVoiceStatus('Listening...');
        if (USE_RECORDER_VOICE_MODE) {
          startVoiceRecorderSegment();
        } else if (!state.recognitionRunning) {
          scheduleRecognitionRestart(IS_MOBILE ? 650 : 120);
        }
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
        startVoiceConversation(true, false);
      } else if (
        (USE_RECORDER_VOICE_MODE &&
          Boolean(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) &&
          typeof window.MediaRecorder === 'function') ||
        (!USE_RECORDER_VOICE_MODE && SpeechRecognitionCtor)
      ) {
        setVoiceStatus('Voice mode ready. Tap Start voice.');
      } else {
        setVoiceStatus('Continuous voice not supported in this browser.');
      }
    };

    if (!USE_RECORDER_VOICE_MODE && SpeechRecognitionCtor) {
      state.recognition = new SpeechRecognitionCtor();
      state.recognition.continuous = !IS_MOBILE;
      state.recognition.interimResults = true;
      state.recognition.maxAlternatives = 1;
      state.recognition.lang = RECOGNITION_LANG;

      state.recognition.onstart = function () {
        state.recognitionRunning = true;
        state.recognitionStopExpected = false;
        state.recognitionRetryDelayMs = IS_MOBILE ? 650 : 120;
        if (shouldContinueVoice() && !state.processingVoice && !state.speaking) {
          setVoiceStatus('Listening...');
        }
      };

      state.recognition.onresult = function (event) {
        if (!shouldContinueVoice() || state.processingVoice) {
          return;
        }

        let transcript = '';
        let interimTranscript = '';
        for (let i = event.resultIndex; i < event.results.length; i += 1) {
          const result = event.results[i];
          if (!result[0] || !result[0].transcript) {
            continue;
          }
          if (result.isFinal) {
            transcript += result[0].transcript + ' ';
          } else {
            interimTranscript += result[0].transcript + ' ';
          }
        }

        const finalText = normalizeUtterance(transcript);
        const interimText = normalizeUtterance(interimTranscript);

        if (!finalText && interimText && !state.speaking) {
          setVoiceStatus('Listening...');
          setVoiceLastUser(interimText + ' ...');
          scheduleInterimCommit(interimText);
        }

        if (!finalText) {
          return;
        }

        clearInterimCommitTimer();
        processVoiceInput(finalText);
      };

      state.recognition.onerror = function (event) {
        state.recognitionRunning = false;
        const error = (event && event.error) || 'unknown';
        const expectedStop = state.recognitionStopExpected;

        if (expectedStop && error === 'aborted') {
          return;
        }

        if (!shouldContinueVoice()) return;

        if (error === 'not-allowed' || error === 'service-not-allowed') {
          stopVoiceConversation(false);
          setVoiceStatus('Microphone permission blocked. Allow mic and start voice.');
          appendLog('system', 'Microphone permission is blocked. Please allow microphone access and start voice again.');
          return;
        }

        if (error === 'audio-capture') {
          setVoiceStatus('Microphone device not found. Check mic and restart voice mode.');
          appendLog('system', 'No active microphone was detected. Connect/select a mic and start voice again.');
          return;
        }

        if (!state.processingVoice && !state.speaking) {
          state.recognitionRetryDelayMs = Math.min(2600, Math.floor(state.recognitionRetryDelayMs * 1.25));
          scheduleRecognitionRestart(IS_MOBILE ? state.recognitionRetryDelayMs : 180);
        }
      };

      state.recognition.onend = function () {
        state.recognitionRunning = false;
        const expectedStop = state.recognitionStopExpected;
        state.recognitionStopExpected = false;

        if (expectedStop && state.speaking) {
          return;
        }

        if (shouldContinueVoice() && !state.processingVoice && !state.speaking) {
          state.recognitionRetryDelayMs = Math.min(2600, Math.floor(state.recognitionRetryDelayMs * 1.15));
          scheduleRecognitionRestart(IS_MOBILE ? state.recognitionRetryDelayMs : 100);
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
      startVoiceConversation(wasActive, true);
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
        startVoiceConversation(false, true);
      }
    });
    if (stopSpeakBtn) {
      stopSpeakBtn.addEventListener('click', function () {
        stopAssistantSpeech(true);
      });
    }

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
    let recordingMimeType = 'audio/webm';
    let recordingFilename = 'voice.webm';
    let recordingStartedAt = 0;

    const startRecording = async function () {
      if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        appendLog('assistant', 'Voice recording not supported in this browser.');
        return;
      }

      const stream = await navigator.mediaDevices.getUserMedia({
        audio: {
          echoCancellation: true,
          noiseSuppression: true,
          autoGainControl: true,
          channelCount: 1,
        },
      });
      chunks = [];
      const format = getPreferredRecordingFormat();
      recordingMimeType = format.mimeType;
      recordingFilename = format.filename;

      recorder = recordingMimeType ? new MediaRecorder(stream, { mimeType: recordingMimeType }) : new MediaRecorder(stream);
      recorder.ondataavailable = function (e) {
        if (e.data && e.data.size > 0) {
          chunks.push(e.data);
        }
      };
      recorder.onstop = async function () {
        stream.getTracks().forEach(function (t) {
          t.stop();
        });

        const durationMs = Date.now() - recordingStartedAt;
        if (durationMs < 280) {
          appendLog('assistant', 'Voice input was too short. Hold and speak a bit longer.');
          return;
        }

        const blob = new Blob(chunks, { type: recordingMimeType });

        try {
          const text = normalizeUtterance(await assistantTranscribe(blob, recordingFilename));
          if (text === '') {
            appendLog('assistant', 'I could not transcribe that. Try again.');
            return;
          }

          await submitMessage(text, { speakReply: true });
        } catch (e) {
          appendLog('assistant', 'Error: ' + (e && e.message ? e.message : String(e)));
        }
      };

      recordingStartedAt = Date.now();
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
      ensureLogStaysAtBottom();
    } else {
      appendLog(
        'assistant',
        'Hi. Ask about TwinBot, say "go to products page", or say "scroll down / top / bottom".'
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

