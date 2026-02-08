import { useEffect, useRef, useState } from 'react';

function downsampleBuffer(buffer, inputSampleRate, outputSampleRate) {
  if (outputSampleRate === inputSampleRate) return buffer;
  const sampleRateRatio = inputSampleRate / outputSampleRate;
  const newLength = Math.round(buffer.length / sampleRateRatio);
  const result = new Float32Array(newLength);
  let offsetResult = 0;
  let offsetBuffer = 0;
  while (offsetResult < result.length) {
    const nextOffsetBuffer = Math.round((offsetResult + 1) * sampleRateRatio);
    let accum = 0;
    let count = 0;
    for (let i = offsetBuffer; i < nextOffsetBuffer && i < buffer.length; i += 1) {
      accum += buffer[i];
      count += 1;
    }
    result[offsetResult] = accum / count;
    offsetResult += 1;
    offsetBuffer = nextOffsetBuffer;
  }
  return result;
}

function floatTo16BitPCM(float32Array) {
  const output = new Int16Array(float32Array.length);
  for (let i = 0; i < float32Array.length; i += 1) {
    let s = Math.max(-1, Math.min(1, float32Array[i]));
    output[i] = s < 0 ? s * 0x8000 : s * 0x7fff;
  }
  return output;
}

function int16ToBase64(int16Array) {
  const bytes = new Uint8Array(int16Array.buffer);
  let binary = '';
  for (let i = 0; i < bytes.byteLength; i += 1) {
    binary += String.fromCharCode(bytes[i]);
  }
  return btoa(binary);
}

function base64ToInt16(base64) {
  const binary = atob(base64);
  const len = binary.length;
  const bytes = new Uint8Array(len);
  for (let i = 0; i < len; i += 1) {
    bytes[i] = binary.charCodeAt(i);
  }
  return new Int16Array(bytes.buffer);
}

export default function VoiceAssistant() {
  const [open, setOpen] = useState(false);
  const [connected, setConnected] = useState(false);
  const [listening, setListening] = useState(false);
  const [userDraft, setUserDraft] = useState('');
  const [assistantDraft, setAssistantDraft] = useState('');
  const [history, setHistory] = useState([]);
  const [textInput, setTextInput] = useState('');
  const [info, setInfo] = useState('');
  const wsRef = useRef(null);
  const audioContextRef = useRef(null);
  const processorRef = useRef(null);
  const sourceRef = useRef(null);
  const outputContextRef = useRef(null);
  const mountedRef = useRef(false);

  useEffect(() => {
    mountedRef.current = true;
    return () => {
      mountedRef.current = false;
    };
  }, []);

  useEffect(() => {
    if (!open) return;

    setInfo('Connecting...');
    const wsUrl = `${window.location.protocol === 'https:' ? 'wss' : 'ws'}://${window.location.host}/voice`;
    const ws = new WebSocket(wsUrl);
    wsRef.current = ws;

    ws.onopen = () => {
      if (!mountedRef.current) return;
      setConnected(true);
      setInfo('');
    };
    ws.onclose = () => {
      if (!mountedRef.current) return;
      setConnected(false);
      setListening(false);
      setInfo('Offline');
    };
    ws.onerror = () => {
      if (!mountedRef.current) return;
      setConnected(false);
      setInfo('Offline');
    };

    ws.onmessage = (event) => {
      let payload;
      try {
        payload = JSON.parse(event.data);
      } catch (_) {
        return;
      }

      if (payload.type === 'error') {
        setInfo(payload.message || 'Voice assistant error.');
      }
      if (payload.type === 'status') {
        setInfo(payload.message || '');
      }
      if (payload.type === 'assistant_text_delta') {
        setAssistantDraft((prev) => prev + payload.delta);
      }
      if (payload.type === 'user_transcript_delta') {
        setUserDraft((prev) => prev + payload.delta);
      }
      if (payload.type === 'audio_delta') {
        playAudioDelta(payload.delta);
      }
      if (payload.type === 'turn_done') {
        const userText = (payload.user || '').trim();
        const assistantText = (payload.assistant || '').trim();
        setHistory((prev) => [
          ...prev,
          ...(userText ? [{ role: 'user', text: userText }] : []),
          ...(assistantText ? [{ role: 'assistant', text: assistantText }] : [])
        ]);
        setUserDraft('');
        setAssistantDraft('');
      }
    };

    return () => {
      try {
        ws.close();
      } catch (_) {
        // ignore
      }
    };
  }, [open]);

  const playAudioDelta = (base64) => {
    if (!outputContextRef.current) {
      outputContextRef.current = new (window.AudioContext || window.webkitAudioContext)({ sampleRate: 24000 });
    }
    const outputContext = outputContextRef.current;
    const int16 = base64ToInt16(base64);
    const float32 = new Float32Array(int16.length);
    for (let i = 0; i < int16.length; i += 1) {
      float32[i] = int16[i] / 0x8000;
    }
    const buffer = outputContext.createBuffer(1, float32.length, 24000);
    buffer.getChannelData(0).set(float32);
    const source = outputContext.createBufferSource();
    source.buffer = buffer;
    source.connect(outputContext.destination);
    source.start();
  };

  const startListening = async () => {
    if (!wsRef.current || wsRef.current.readyState !== WebSocket.OPEN) return;
    setUserDraft('');
    setAssistantDraft('');

    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
    audioContextRef.current = audioContext;
    const source = audioContext.createMediaStreamSource(stream);
    sourceRef.current = source;

    const processor = audioContext.createScriptProcessor(4096, 1, 1);
    processorRef.current = processor;

    processor.onaudioprocess = (event) => {
      const input = event.inputBuffer.getChannelData(0);
      const downsampled = downsampleBuffer(input, audioContext.sampleRate, 24000);
      const int16 = floatTo16BitPCM(downsampled);
      const base64 = int16ToBase64(int16);
      wsRef.current.send(JSON.stringify({ type: 'audio_chunk', audio: base64 }));
    };

    source.connect(processor);
    processor.connect(audioContext.destination);
    setListening(true);
  };

  const stopListening = () => {
    if (processorRef.current) {
      processorRef.current.disconnect();
    }
    if (sourceRef.current) {
      sourceRef.current.disconnect();
    }
    if (audioContextRef.current) {
      audioContextRef.current.close();
    }
    if (wsRef.current && wsRef.current.readyState === WebSocket.OPEN) {
      wsRef.current.send(JSON.stringify({ type: 'commit' }));
    }
    setListening(false);
  };

  const sendText = () => {
    const text = String(textInput || '').trim();
    if (!text) return;
    if (!wsRef.current || wsRef.current.readyState !== WebSocket.OPEN) return;

    setHistory((prev) => [...prev, { role: 'user', text }]);
    setTextInput('');
    setInfo('');
    wsRef.current.send(JSON.stringify({ type: 'text', text }));
  };

  const offlineHelp =
    'Voice requires the Node backend (WebSocket /voice). In static deployments, the voice assistant will show Offline.';

  return (
    <>
      {open && <div className="voice-backdrop" onClick={() => setOpen(false)} aria-hidden="true" />}

      {open && (
        <div className="voice-panel" role="dialog" aria-label="Voice assistant">
          <div className="voice-panel-header">
            <div>
              <div className="voice-title">Talk to us</div>
              <div className="voice-sub">Ask about products, ECS, Sail OS, quotes, or checkout.</div>
            </div>
            <div className="voice-status">
              <span className="badge">{connected ? 'Connected' : 'Offline'}</span>
              <button className="icon-btn" onClick={() => setOpen(false)} aria-label="Close voice assistant">
                X
              </button>
            </div>
          </div>

          <div className="voice-body">
            {info && <div className="voice-info">{info}</div>}
            {!connected && <div className="voice-hint">{offlineHelp}</div>}

            <div className="voice-history" aria-live="polite">
              {history.length === 0 && !userDraft && !assistantDraft ? (
                <div className="voice-empty">Start a voice session or type a question.</div>
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
                <button className="btn" onClick={startListening} disabled={!connected}>
                  Start Mic
                </button>
              ) : (
                <button className="btn outline" onClick={stopListening}>
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
