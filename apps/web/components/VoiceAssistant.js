import { useEffect, useRef, useState } from 'react';

function safeJsonParse(text) {
  try {
    return JSON.parse(text);
  } catch (_) {
    return null;
  }
}

export default function VoiceAssistant() {
  const [open, setOpen] = useState(false);
  const [connected, setConnected] = useState(false);
  const [connecting, setConnecting] = useState(false);
  const [listening, setListening] = useState(false);
  const [userDraft, setUserDraft] = useState('');
  const [assistantDraft, setAssistantDraft] = useState('');
  const [history, setHistory] = useState([]);
  const [textInput, setTextInput] = useState('');
  const [info, setInfo] = useState('');

  const pcRef = useRef(null);
  const dcRef = useRef(null);
  const micStreamRef = useRef(null);
  const audioElRef = useRef(null);

  // Data channel event handling must not depend on stale React state.
  const userDraftRef = useRef('');
  const assistantDraftRef = useRef('');

  const disconnect = async () => {
    setConnecting(false);
    setConnected(false);
    setListening(false);

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
          throw new Error('Voice backend is not available (static deployment). Deploy as a Node app to enable voice.');
        }
        const txt = await res.text();
        const json = safeJsonParse(txt);
        const msg = json?.error || json?.details || txt || `HTTP ${res.status}`;
        throw new Error(`Voice session failed: ${msg}`);
      }

      const answerSdp = await res.text();
      await pc.setRemoteDescription({ type: 'answer', sdp: answerSdp });

      setConnected(true);
      setListening(true);
      setInfo('');
    } catch (err) {
      setInfo(err.message || 'Unable to connect.');
      await disconnect();
    } finally {
      setConnecting(false);
    }
  };

  const startMic = async () => {
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

  const sendText = () => {
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

    // Capture typed input in history right away.
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
              <span className="badge">{connected ? 'Connected' : connecting ? 'Connecting' : 'Offline'}</span>
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
                disabled={!connected}
              />
              <button className="btn outline" onClick={sendText} disabled={!connected}>
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
