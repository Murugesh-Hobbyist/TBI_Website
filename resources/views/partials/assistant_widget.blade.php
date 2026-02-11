<div class="fixed bottom-5 right-5 z-50">
    <button id="assistant-open" type="button" class="btn btn-primary shadow-lg">Ask AI</button>
</div>

<div id="assistant-modal" class="fixed inset-0 z-50 hidden">
    <div id="assistant-backdrop" class="absolute inset-0 bg-black/60"></div>
    <div class="absolute bottom-0 left-0 right-0 mx-auto max-w-2xl p-4 md:bottom-10">
        <div class="overflow-hidden rounded-3xl border border-black/10 bg-white">
            <div class="flex items-center justify-between border-b border-black/10 px-4 py-3">
                <div>
                    <div class="font-display text-lg">{{ config('twinbot.site.name') }} Assistant</div>
                    <div class="text-xs text-[#364151]">Answers using your Knowledge Base and published content.</div>
                </div>
                <button id="assistant-close" type="button" class="rounded-xl px-3 py-2 text-sm font-semibold text-[#364151] hover:bg-[#E7F6FF] hover:text-[#0F172A]">Close</button>
            </div>
            <div class="px-4 py-3">
                <div id="assistant-log" class="h-64 space-y-3 overflow-auto rounded-2xl border border-black/10 bg-white p-3 text-sm"></div>
                <div class="mt-3 flex flex-col gap-2 md:flex-row">
                    <input id="assistant-input" type="text" class="w-full rounded-2xl border border-black/10 bg-white px-4 py-3 text-sm text-[#0F172A] placeholder:text-[#364151]/60 focus:outline-none focus:ring-2 focus:ring-[#0067FF]/30" placeholder="Ask about products, automation, or support..." />
                    <div class="flex gap-2">
                        <button id="assistant-send" type="button" class="btn btn-primary">Send</button>
                        <button id="assistant-ptt" type="button" class="btn btn-ghost">Push-to-talk</button>
                    </div>
                </div>
                <div class="mt-2 text-xs text-[#364151]">Voice is push-to-talk (record, transcribe, answer).</div>
            </div>
        </div>
    </div>
</div>
