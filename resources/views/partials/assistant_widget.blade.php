<div id="assistant-dock" class="fixed bottom-4 right-4 z-[70] flex flex-col items-end gap-3">
    <div id="assistant-panel" class="hidden w-[min(92vw,390px)] overflow-hidden rounded-3xl border border-[#C5DAED] bg-white/95 shadow-2xl backdrop-blur">
        <div class="bg-gradient-to-r from-[#eef7ff] via-[#eaf7f3] to-[#edf1ff] px-4 py-3">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <div class="font-display text-base text-[#122E53]">{{ config('twinbot.site.name') }} AI</div>
                    <div class="text-xs text-[#4F6E91]">Ask anything and I can open pages for you.</div>
                </div>
                <button id="assistant-close" type="button" class="rounded-xl border border-[#C9DCEF] bg-white px-2.5 py-1.5 text-xs font-semibold text-[#315980] hover:bg-[#F3F9FF]">
                    Minimize
                </button>
            </div>
        </div>

        <div class="space-y-3 px-4 py-3">
            <div class="grid grid-cols-2 gap-2 rounded-xl border border-[#CFE0F0] bg-[#F3F9FF] p-1">
                <button id="assistant-mode-chat" type="button" class="rounded-lg px-2 py-1.5 text-xs font-semibold text-[#365B82]">Chat mode</button>
                <button id="assistant-mode-voice" type="button" class="rounded-lg px-2 py-1.5 text-xs font-semibold text-[#365B82]">Voice mode</button>
            </div>

            <div id="assistant-log" class="h-72 space-y-3 overflow-auto rounded-2xl border border-[#D1E2F2] bg-[#F8FCFF] p-3 text-sm"></div>

            <div id="assistant-chat-controls" class="space-y-2">
                <div class="flex gap-2">
                    <input id="assistant-input" type="text" class="tb-input flex-1" placeholder="Try: Go to products page or ask any question..." />
                    <button id="assistant-send" type="button" class="btn btn-primary">Send</button>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <button id="assistant-ptt" type="button" class="btn btn-ghost text-xs">Hold to talk</button>
                    <div class="text-[11px] text-[#5F7F9F]">Chat mode: type or hold-to-talk.</div>
                </div>
            </div>

            <div id="assistant-voice-controls" class="hidden rounded-2xl border border-[#CFE1F3] bg-[#F2F9FF] p-3">
                <div id="assistant-voice-status" class="text-xs font-semibold text-[#2D5986]">Voice mode ready.</div>
                <div class="mt-2 flex items-center justify-between gap-2">
                    <button id="assistant-voice-toggle" type="button" class="btn btn-primary text-xs">Start voice</button>
                    <div class="text-[11px] text-[#5F7F9F]">Continuous listen + reply + page control.</div>
                </div>
            </div>
        </div>
    </div>

    <button id="assistant-open" type="button" class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-[#ff7a33] via-[#18bf8d] to-[#2e6bff] px-4 py-3 text-sm font-semibold text-white shadow-xl shadow-[#1b3a6733]">
        <span class="inline-block h-2.5 w-2.5 rounded-full bg-white/90"></span>
        Ask TwinBot AI
    </button>
</div>
