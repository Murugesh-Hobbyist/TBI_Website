import { useEffect, useRef, useState } from 'react';
import { SITE } from '../lib/siteData';

function safeJsonParse(text) {
  try {
    return JSON.parse(text);
  } catch (_) {
    return null;
  }
}

function normalizeText(input) {
  return String(input || '')
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, ' ')
    .replace(/\s+/g, ' ')
    .trim();
}

function buildLocalAnswer(question) {
  const q = normalizeText(question);
  const has = (...words) => words.some((w) => q.includes(w));

  if (!q) {
    return 'Ask about DigiDial Console, FitSense, Sail OS, ECS vs PLC, pricing, or how to request a quote.';
  }

  if (has('contact', 'email', 'phone', 'whatsapp', 'call', 'support', 'address', 'location')) {
    return `You can reach TwinBot at ${SITE.contact.email} or call ${SITE.contact.phoneDisplay}. We are based in ${SITE.contact.location}. If you prefer WhatsApp, use the Contact page.`;
  }

  if (has('quote', 'quotation', 'rfq', 'enquiry', 'inquiry')) {
    return 'For a tailored quote, open the Quote Request page and share product, quantity, tolerances, and timeline. We will respond with pricing and lead time.';
  }

  if (has('price', 'pricing', 'cost', 'rate', 'budget')) {
    return 'Pricing depends on channels, sensors, tolerances, logging, and integration scope. Open the Quote Request page and we will confirm the best configuration and price.';
  }

  if (has('plc', 'ecs', 'embedded')) {
    return 'ECS is a compact Embedded Control System designed to reduce PLC cost and complexity while improving integration and customization. If you share your line details and I/O requirements, I can recommend the right approach.';
  }

  if (has('sail', 'dashboard', 'hdmi', 'report', 'logging')) {
    return 'Sail OS is TwinBot\'s industrial dashboard layer: real-time visualization, troubleshooting, and data logging with reporting. It helps operators see what changed and act quickly.';
  }

  const wantsDigiDial = has('digidial', 'digimatic', 'dial', 'console', 'gauge', 'inspection');
  const wantsFitSense = has('fitsense', 'displacement', 'probe');
  const wantsCable = has('mitutoyo', 'cable');

  const pickByRegex = (re) => re.test(q);
  const is8 = pickByRegex(/\b8\s*ch\b|\b8ch\b/);
  const is12 = pickByRegex(/\b12\s*ch\b|\b12ch\b/);
  const is16 = pickByRegex(/\b16\s*ch\b|\b16ch\b/);

  if (wantsDigiDial || is8 || is12 || is16) {
    const preferred = is8 ? 101 : is12 ? 102 : is16 ? 103 : null;
    const product = preferred
      ? SITE.productsFallback.find((p) => p.id === preferred)
      : SITE.productsFallback.find((p) => normalizeText(p.name).includes('digidial'));

    if (product) {
      return `${product.name}: ${product.description} If you tell me required channels and tolerances, I can suggest the best configuration and guide you to request a quote.`;
    }

    return 'DigiDial Console automates dimensional inspection using Mitutoyo Digimatic dials with tolerance checks, OK/Fail decisions, and SD logging. Tell me 8CH, 12CH, or 16CH and your measurement workflow.';
  }

  if (wantsFitSense) {
    const product = SITE.productsFallback.find((p) => normalizeText(p.name).includes('fitsense ultra')) || SITE.productsFallback.find((p) => normalizeText(p.name).includes('fitsense'));
    if (product) {
      return `${product.name}: ${product.description} If you share probe count and display size preference, I can recommend Lite, Pro, or Ultra.`;
    }
    return 'FitSense is a displacement measurement station family (Lite, Pro, Ultra) designed for fast operator decisions. Share probe count and display requirement.';
  }

  if (wantsCable) {
    const product = SITE.productsFallback.find((p) => normalizeText(p.name).includes('digimatic cable'));
    if (product) {
      return `${product.name}: ${product.description} If you tell me your device model and data interface, I can confirm compatibility.`;
    }
    return 'Mitutoyo Digimatic cable is used to connect Digimatic measuring devices to data interfaces for transfer and logging.';
  }

  if (has('order', 'checkout', 'cart', 'buy', 'purchase')) {
    return 'You can browse Products, add items to Cart, and proceed to Checkout. For custom configurations, use Quote Request instead of checkout.';
  }

  // Try a lightweight product match by name tokens.
  const tokens = new Set(q.split(' '));
  let best = null;
  let bestScore = 0;
  for (const p of SITE.productsFallback) {
    const nameTokens = normalizeText(p.name).split(' ');
    let score = 0;
    for (const t of nameTokens) {
      if (tokens.has(t)) score += 2;
    }
    if (score > bestScore) {
      bestScore = score;
      best = p;
    }
  }
  if (best && bestScore >= 4) {
    return `${best.name}: ${best.description} Want pricing and lead time? Open Quote Request.`;
  }

  return 'I can help with products (DigiDial Console, FitSense), Sail OS dashboards, ECS vs PLC, pricing, or quotes. Ask for a specific product name or tell me your use case.';
}

export default function VoiceAssistant() {
  const [open, setOpen] = useState(false);
  const [connected, setConnected] = useState(false);
  const [connecting, setConnecting] = useState(false);
  const [listening, setListening] = useState(false);
  const [localMode, setLocalMode] = useState(false);

  const [userDraft, setUserDraft] = useState('');
  const [assistantDraft, setAssistantDraft] = useState('');
  const [history, setHistory] = useState([]);
  const [textInput, setTextInput] = useState('');
  const [info, setInfo] = useState('');

  const pcRef = useRef(null);
  const dcRef = useRef(null);
  const micStreamRef = useRef(null);
  const audioElRef = useRef(null);

  const recognitionRef = useRef(null);

  // Data channel event handling must not depend on stale React state.
  const userDraftRef = useRef('');
  const assistantDraftRef = useRef('');

  const stopSpeechSynthesis = () => {
    try {
      if (typeof window !== 'undefined' && window.speechSynthesis) {
        window.speechSynthesis.cancel();
      }
    } catch (_) {
      // ignore
    }
  };

  const speak = (text) => {
    try {
      if (typeof window === 'undefined') return;
      if (!window.speechSynthesis) return;

      stopSpeechSynthesis();
      const utterance = new SpeechSynthesisUtterance(text);
      utterance.lang = 'en-IN';
      utterance.rate = 1.0;
      utterance.pitch = 1.0;
      window.speechSynthesis.speak(utterance);
    } catch (_) {
      // ignore
    }
  };

  const disconnect = async () => {
    setConnecting(false);
    setConnected(false);
    setListening(false);

    try {
      if (recognitionRef.current) {
        recognitionRef.current.onresult = null;
        recognitionRef.current.onerror = null;
        recognitionRef.current.onend = null;
        recognitionRef.current.stop();
      }
    } catch (_) {
      // ignore
    }

    stopSpeechSynthesis();

    try {
      if (dcRef.current) dcRef.current.close();
    } catch (_) {
      // ignore
    }

    try {
      if (pcRef.current) pcRef.current.close();
    } catch (_) {
      // ignore
    }

    try {
      if (micStreamRef.current) {
        micStreamRef.current.getTracks().forEach((t) => t.stop());
      }
    } catch (_) {
      // ignore
    }

    try {
      if (audioElRef.current) {
        audioElRef.current.srcObject = null;
      }
    } catch (_) {
      // ignore
    }

    pcRef.current = null;
    dcRef.current = null;
    micStreamRef.current = null;

    userDraftRef.current = '';
    assistantDraftRef.current = '';
    setUserDraft('');
    setAssistantDraft('');
  };

  useEffect(() => {
    if (open) return;
    disconnect();
  }, [open]);

  useEffect(() => {
    return () => {
      disconnect();
    };
  }, []);

  const flushTurn = () => {
    const u = (userDraftRef.current || '').trim();
    const a = (assistantDraftRef.current || '').trim();

    if (!u && !a) return;

    setHistory((prev) => [
      ...prev,
      ...(u ? [{ role: 'user', text: u }] : []),
      ...(a ? [{ role: 'assistant', text: a }] : [])
    ]);

    userDraftRef.current = '';
    assistantDraftRef.current = '';
    setUserDraft('');
    setAssistantDraft('');
  };

  const handleServerEvent = (event) => {
    if (!event || typeof event.type !== 'string') return;

    if (event.type === 'error') {
      setInfo(event.error?.message || event.message || 'Voice error.');
      return;
    }

    if (event.type === 'input_audio_buffer.speech_started') {
      userDraftRef.current = '';
      assistantDraftRef.current = '';
      setUserDraft('');
      setAssistantDraft('');
      return;
    }

    if (event.type === 'conversation.item.input_audio_transcription.delta') {
      userDraftRef.current = (userDraftRef.current || '') + (event.delta || '');
      setUserDraft(userDraftRef.current);
      return;
    }

    if (event.type === 'conversation.item.input_audio_transcription.completed') {
      if (event.transcript) {
        userDraftRef.current = event.transcript;
        setUserDraft(event.transcript);
      }
      return;
    }

    if (event.type === 'response.created') {
      assistantDraftRef.current = '';
      setAssistantDraft('');
      return;
    }

    if (event.type === 'response.output_text.delta') {
      assistantDraftRef.current = (assistantDraftRef.current || '') + (event.delta || '');
      setAssistantDraft(assistantDraftRef.current);
      return;
    }

    if (event.type === 'response.output_audio_transcript.delta') {
      assistantDraftRef.current = (assistantDraftRef.current || '') + (event.delta || '');
      setAssistantDraft(assistantDraftRef.current);
      return;
    }

    if (event.type === 'response.done') {
      flushTurn();
    }
  };

  const connectSession = async () => {
    if (connecting || connected) return;

    setInfo('Connecting...');
    setConnecting(true);

    try {
      const pc = new RTCPeerConnection({
        iceServers: [{ urls: ['stun:stun.l.google.com:19302', 'stun:stun1.l.google.com:19302'] }]
      });
      pcRef.current = pc;

      pc.onconnectionstatechange = () => {
        const s = pc.connectionState;
        if (s === 'connected') {
          setConnected(true);
          setLocalMode(false);
          setInfo('');
        }
        if (s === 'failed' || s === 'disconnected' || s === 'closed') {
          setConnected(false);
        }
      };

      pc.ontrack = (e) => {
        if (!audioElRef.current) {
          audioElRef.current = new Audio();
          audioElRef.current.autoplay = true;
        }
        if (e.streams && e.streams[0]) {
          audioElRef.current.srcObject = e.streams[0];
        }
      };

      const mic = await navigator.mediaDevices.getUserMedia({ audio: true });
      micStreamRef.current = mic;
      mic.getAudioTracks().forEach((track) => {
        track.enabled = true;
        pc.addTrack(track, mic);
      });

      const dc = pc.createDataChannel('oai-events');
      dcRef.current = dc;
      dc.onmessage = (e) => {
        const parsed = safeJsonParse(e.data);
        if (parsed) handleServerEvent(parsed);
      };

      const offer = await pc.createOffer();
      await pc.setLocalDescription(offer);

      const offerSdp = pc.localDescription?.sdp;
      if (!offerSdp) throw new Error('Failed to create SDP offer.');

      const res = await fetch('/api/voice/session', {
        method: 'POST',
        headers: { 'Content-Type': 'application/sdp' },
        body: offerSdp
      });

      if (!res.ok) {
        if (res.status === 404) {
          throw new Error('BACKEND_MISSING');
        }
        const txt = await res.text();
        const json = safeJsonParse(txt);
        const msg = json?.error || json?.details || txt || `HTTP ${res.status}`;
        throw new Error(msg);
      }

      const answerSdp = await res.text();
      await pc.setRemoteDescription({ type: 'answer', sdp: answerSdp });

      setConnected(true);
      setLocalMode(false);
      setListening(true);
      setInfo('');
    } catch (err) {
      const message = err && err.message ? err.message : 'Unable to connect.';
      if (message === 'BACKEND_MISSING') {
        setLocalMode(true);
        setInfo('Voice backend is not available (static deployment). Using local assistant.');
      } else {
        // If OpenAI config is missing or any other server-side error occurs, keep the UI usable.
        setLocalMode(true);
        setInfo(`GPT voice unavailable. Using local assistant. (${message})`);
      }
      await disconnect();
    } finally {
      setConnecting(false);
    }
  };

  const startLocalMic = async () => {
    if (typeof window === 'undefined') return;

    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (!SpeechRecognition) {
      setInfo('Your browser does not support speech recognition. Use text input instead.');
      setListening(false);
      return;
    }

    if (!recognitionRef.current) {
      const rec = new SpeechRecognition();
      rec.lang = 'en-IN';
      rec.interimResults = true;
      rec.continuous = false;

      rec.onresult = (event) => {
        let interim = '';
        let finalText = '';

        for (let i = event.resultIndex; i < event.results.length; i += 1) {
          const r = event.results[i];
          const t = r[0] && r[0].transcript ? r[0].transcript : '';
          if (r.isFinal) finalText += t;
          else interim += t;
        }

        const draft = (finalText || interim).trim();
        setUserDraft(draft);

        if (finalText && finalText.trim()) {
          const userText = finalText.trim();
          const answer = buildLocalAnswer(userText);

          setHistory((prev) => [...prev, { role: 'user', text: userText }, { role: 'assistant', text: answer }]);
          speak(answer);
          setUserDraft('');
          setAssistantDraft('');
        }
      };

      rec.onerror = (e) => {
        setInfo(`Speech recognition error: ${e.error || 'unknown'}`);
        setListening(false);
      };

      rec.onend = () => {
        setListening(false);
      };

      recognitionRef.current = rec;
    }

    setInfo('');
    setUserDraft('');
    setAssistantDraft('');
    setListening(true);

    try {
      recognitionRef.current.start();
    } catch (_) {
      // If already started, ignore.
    }
  };

  const stopLocalMic = () => {
    try {
      if (recognitionRef.current) recognitionRef.current.stop();
    } catch (_) {
      // ignore
    }
    stopSpeechSynthesis();
    setListening(false);
  };

  const startMic = async () => {
    if (localMode) {
      await startLocalMic();
      return;
    }

    if (!connected) {
      await connectSession();
      return;
    }

    if (micStreamRef.current) {
      micStreamRef.current.getAudioTracks().forEach((t) => {
        t.enabled = true;
      });
    }
    setListening(true);
  };

  const stopMic = () => {
    if (localMode) {
      stopLocalMic();
      return;
    }

    if (micStreamRef.current) {
      micStreamRef.current.getAudioTracks().forEach((t) => {
        t.enabled = false;
      });
    }
    setListening(false);
  };

  const sendEvent = (payload) => {
    const dc = dcRef.current;
    if (!dc || dc.readyState !== 'open') {
      setInfo('Not connected. Click Start Mic to connect.');
      return false;
    }
    dc.send(JSON.stringify(payload));
    return true;
  };

  const sendLocalText = () => {
    const text = String(textInput || '').trim();
    if (!text) return;

    const answer = buildLocalAnswer(text);
    setHistory((prev) => [...prev, { role: 'user', text }, { role: 'assistant', text: answer }]);
    setTextInput('');
    setInfo('');
    speak(answer);
  };

  const sendText = () => {
    if (localMode) {
      sendLocalText();
      return;
    }

    const text = String(textInput || '').trim();
    if (!text) return;

    userDraftRef.current = '';
    setUserDraft('');

    const ok = sendEvent({
      type: 'conversation.item.create',
      item: {
        type: 'message',
        role: 'user',
        content: [{ type: 'input_text', text }]
      }
    });
    if (!ok) return;

    setHistory((prev) => [...prev, { role: 'user', text }]);
    setTextInput('');

    assistantDraftRef.current = '';
    setAssistantDraft('');
    setInfo('');

    sendEvent({ type: 'response.create' });
  };

  const closePanel = async () => {
    setOpen(false);
  };

  const badgeText = connected ? 'Connected' : localMode ? 'Local' : connecting ? 'Connecting' : 'Offline';
  const canType = connected || localMode;

  return (
    <>
      {open && <div className="voice-backdrop" onClick={closePanel} aria-hidden="true" />}

      {open && (
        <div className="voice-panel" role="dialog" aria-label="Voice assistant">
          <div className="voice-panel-header">
            <div>
              <div className="voice-title">Talk to us</div>
              <div className="voice-sub">Ask about products, ECS, Sail OS, quotes, or checkout.</div>
            </div>
            <div className="voice-status">
              <span className="badge">{badgeText}</span>
              <button className="icon-btn" onClick={closePanel} aria-label="Close voice assistant">
                X
              </button>
            </div>
          </div>

          <div className="voice-body">
            {info && <div className="voice-info">{info}</div>}

            <div className="voice-history" aria-live="polite">
              {history.length === 0 && !userDraft && !assistantDraft ? (
                <div className="voice-empty">Click Start Mic and ask your question.</div>
              ) : null}
              {history.map((m, idx) => (
                <div key={`${m.role}-${idx}`} className={`voice-bubble ${m.role}`}>
                  <div className="voice-bubble-role">{m.role === 'user' ? 'You' : 'Assistant'}</div>
                  <div className="voice-bubble-text">{m.text}</div>
                </div>
              ))}
              {userDraft ? (
                <div className="voice-bubble user">
                  <div className="voice-bubble-role">You</div>
                  <div className="voice-bubble-text">{userDraft}</div>
                </div>
              ) : null}
              {assistantDraft ? (
                <div className="voice-bubble assistant">
                  <div className="voice-bubble-role">Assistant</div>
                  <div className="voice-bubble-text">{assistantDraft}</div>
                </div>
              ) : null}
            </div>
          </div>

          <div className="voice-panel-footer">
            <div className="voice-controls">
              {!listening ? (
                <button className="btn" onClick={startMic} disabled={connecting}>
                  Start Mic
                </button>
              ) : (
                <button className="btn outline" onClick={stopMic}>
                  Stop
                </button>
              )}
            </div>
            <div className="voice-text">
              <input
                value={textInput}
                onChange={(e) => setTextInput(e.target.value)}
                placeholder="Type a question..."
                onKeyDown={(e) => {
                  if (e.key === 'Enter') sendText();
                }}
                aria-label="Type a question"
                disabled={!canType}
              />
              <button className="btn outline" onClick={sendText} disabled={!canType}>
                Send
              </button>
            </div>
          </div>
        </div>
      )}

      <button
        className="voice-fab"
        onClick={() => setOpen((v) => !v)}
        aria-label={open ? 'Close voice assistant' : 'Open voice assistant'}
        type="button"
      >
        <span aria-hidden="true">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <path
              d="M12 14a3 3 0 0 0 3-3V6a3 3 0 1 0-6 0v5a3 3 0 0 0 3 3Z"
              stroke="currentColor"
              strokeWidth="2"
              strokeLinecap="round"
              strokeLinejoin="round"
            />
            <path
              d="M19 11a7 7 0 0 1-14 0"
              stroke="currentColor"
              strokeWidth="2"
              strokeLinecap="round"
              strokeLinejoin="round"
            />
            <path
              d="M12 18v3"
              stroke="currentColor"
              strokeWidth="2"
              strokeLinecap="round"
              strokeLinejoin="round"
            />
          </svg>
        </span>
      </button>
    </>
  );
}
