<div class="fixed bottom-5 right-5 z-50">
    <button id="assistant-open" type="button" class="btn btn-primary shadow-lg">Ask TwinBot AI</button>
</div>

<div id="assistant-modal" class="fixed inset-0 z-50 hidden">
    <div id="assistant-backdrop" class="absolute inset-0 bg-black/50"></div>
    <div class="absolute bottom-0 left-0 right-0 mx-auto max-w-2xl p-4 md:bottom-8">
        <div class="overflow-hidden rounded-3xl border border-[#C5DAED] bg-white shadow-2xl">
            <div class="flex items-start justify-between border-b border-[#D4E3F1] px-4 py-3">
                <div>
                    <div class="font-display text-lg text-[#112743]">{{ config('twinbot.site.name') }} Assistant</div>
                    <div class="text-xs text-[#547091]">Ask about products, use cases, and TwinBot capabilities.</div>
                </div>
                <button id="assistant-close" type="button" class="rounded-xl px-3 py-2 text-sm font-semibold text-[#4C6686] hover:bg-[#EEF6FF] hover:text-[#143357]">Close</button>
            </div>

            <div class="px-4 py-3">
                <div id="assistant-log" class="h-64 space-y-3 overflow-auto rounded-2xl border border-[#D1E2F2] p-3 text-sm"></div>
                <div class="mt-3 flex flex-col gap-2 md:flex-row">
                    <input id="assistant-input" type="text" class="tb-input" placeholder="Ask about products, automation, or support..." />
                    <div class="flex gap-2">
                        <button id="assistant-send" type="button" class="btn btn-primary">Send</button>
                        <button id="assistant-ptt" type="button" class="btn btn-ghost">Push-to-talk</button>
                    </div>
                </div>
                <div class="mt-2 text-xs text-[#607A99]">Voice is push-to-talk (record, transcribe, then reply).</div>
            </div>
        </div>
    </div>
</div>
