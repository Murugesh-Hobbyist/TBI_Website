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
            <div id="assistant-log" class="h-72 space-y-3 overflow-auto rounded-2xl border border-[#D1E2F2] bg-[#F8FCFF] p-3 text-sm"></div>

            <div class="flex gap-2">
                <input id="assistant-input" type="text" class="tb-input flex-1" placeholder="Try: Go to products page or ask any question..." />
                <button id="assistant-send" type="button" class="btn btn-primary">Send</button>
            </div>

            <div class="flex items-center justify-between gap-2">
                <button id="assistant-ptt" type="button" class="btn btn-ghost text-xs">Hold to talk</button>
                <div class="text-[11px] text-[#5F7F9F]">AI can answer + navigate pages.</div>
            </div>
        </div>
    </div>

    <button id="assistant-open" type="button" class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-[#ff7a33] via-[#18bf8d] to-[#2e6bff] px-4 py-3 text-sm font-semibold text-white shadow-xl shadow-[#1b3a6733]">
        <span class="inline-block h-2.5 w-2.5 rounded-full bg-white/90"></span>
        Ask TwinBot AI
    </button>
</div>
