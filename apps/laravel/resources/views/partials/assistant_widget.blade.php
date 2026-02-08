<div class="fixed bottom-5 right-5 z-50">
    <button id="assistant-open" type="button" class="btn btn-ghost shadow-lg">
        Ask AI
    </button>
</div>

<div id="assistant-modal" class="fixed inset-0 z-50 hidden">
    <div id="assistant-backdrop" class="absolute inset-0 bg-black/70"></div>
    <div class="absolute bottom-0 left-0 right-0 mx-auto max-w-2xl p-4 md:bottom-10">
        <div class="card overflow-hidden">
            <div class="flex items-center justify-between border-b border-white/10 px-4 py-3">
                <div>
                    <div class="font-display text-lg">Finboard Assistant</div>
                    <div class="text-xs text-white/60">Answers using your Projects, Products, and Knowledge Base.</div>
                </div>
                <button id="assistant-close" type="button" class="rounded-lg px-3 py-2 text-sm text-white/70 hover:bg-white/10 hover:text-white">Close</button>
            </div>
            <div class="px-4 py-3">
                <div id="assistant-log" class="h-64 space-y-3 overflow-auto rounded-xl border border-white/10 bg-black/20 p-3 text-sm"></div>
                <div class="mt-3 flex flex-col gap-2 md:flex-row">
                    <input id="assistant-input" type="text" class="w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-400/40" placeholder="Ask about products, projects, or automation..." />
                    <div class="flex gap-2">
                        <button id="assistant-send" type="button" class="btn btn-primary">Send</button>
                        <button id="assistant-ptt" type="button" class="btn btn-ghost">Push-to-talk</button>
                    </div>
                </div>
                <div class="mt-2 text-xs text-white/50">
                    Voice is push-to-talk (record, transcribe, answer). Realtime call-style voice is a later phase.
                </div>
            </div>
        </div>
    </div>
</div>

