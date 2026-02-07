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
  const [connected, setConnected] = useState(false);
  const [listening, setListening] = useState(false);
  const [userText, setUserText] = useState('');
  const [assistantText, setAssistantText] = useState('');
  const wsRef = useRef(null);
  const audioContextRef = useRef(null);
  const processorRef = useRef(null);
  const sourceRef = useRef(null);
  const outputContextRef = useRef(null);

  useEffect(() => {
    const ws = new WebSocket(`${window.location.protocol === 'https:' ? 'wss' : 'ws'}://${window.location.host}/voice`);
    wsRef.current = ws;

    ws.onopen = () => setConnected(true);
    ws.onclose = () => {
      setConnected(false);
      setListening(false);
    };
    ws.onerror = () => setConnected(false);

    ws.onmessage = (event) => {
      const payload = JSON.parse(event.data);
      if (payload.type === 'assistant_text_delta') {
        setAssistantText((prev) => prev + payload.delta);
      }
      if (payload.type === 'user_transcript_delta') {
        setUserText((prev) => prev + payload.delta);
      }
      if (payload.type === 'audio_delta') {
        playAudioDelta(payload.delta);
      }
    };

    return () => {
      ws.close();
    };
  }, []);

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
    setUserText('');
    setAssistantText('');

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

  return (
    <div className="voice">
      <div className="voice-header">
        <h3>Talk to us</h3>
        <span className={connected ? 'badge ok' : 'badge'}>{connected ? 'Connected' : 'Offline'}</span>
      </div>
      <p className="voice-sub">Ask about products, quotes, or help with checkout.</p>
      <div className="voice-controls">
        {!listening ? (
          <button className="btn" onClick={startListening} disabled={!connected}>
            Start
          </button>
        ) : (
          <button className="btn outline" onClick={stopListening}>
            Stop
          </button>
        )}
      </div>
      <div className="voice-transcripts">
        <div>
          <h4>You</h4>
          <p>{userText || '...'}</p>
        </div>
        <div>
          <h4>Assistant</h4>
          <p>{assistantText || '...'}</p>
        </div>
      </div>
    </div>
  );
}
