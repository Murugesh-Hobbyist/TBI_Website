@extends('layouts.site')

@section('title', 'Contact | TwinBot Innovations')
@section('meta_description', 'Connect with TwinBot Innovations for embedded automation projects, product enquiries, and technical consultation.')

@section('content')
    @php
        $c = config('twinbot.contact');
    @endphp

    <section class="tb-section pt-6 md:pt-10">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid gap-5 md:grid-cols-2">
                <div class="tb-panel p-6 md:p-10 tb-reveal">
                    <span class="tb-eyebrow">Contact TwinBot</span>
                    <h1 class="tb-heading mt-4">Let us shape your next automation milestone.</h1>
                    <p class="tb-lead mt-5">Share your challenge, your timeline, and your target outcome. Our engineering team will respond with practical next steps.</p>

                    <div class="mt-6 grid gap-3">
                        <a href="tel:{{ $c['phone_tel'] }}" class="tb-panel-soft p-4 hover:border-[#9CC6EA]">
                            <div class="text-xs font-bold uppercase tracking-[0.1em] text-[#5B7698]">Phone</div>
                            <div class="mt-1 font-semibold text-[#173D68]">{{ $c['phone_display'] }}</div>
                        </a>
                        <a href="mailto:{{ $c['email_sales'] }}" class="tb-panel-soft p-4 hover:border-[#9CC6EA]">
                            <div class="text-xs font-bold uppercase tracking-[0.1em] text-[#5B7698]">Sales</div>
                            <div class="mt-1 font-semibold text-[#173D68]">{{ $c['email_sales'] }}</div>
                        </a>
                        <a href="mailto:{{ $c['email_primary'] }}" class="tb-panel-soft p-4 hover:border-[#9CC6EA]">
                            <div class="text-xs font-bold uppercase tracking-[0.1em] text-[#5B7698]">Support</div>
                            <div class="mt-1 font-semibold text-[#173D68]">{{ $c['email_primary'] }}</div>
                        </a>
                        <a href="{{ $c['whatsapp_url'] }}" class="tb-panel-soft p-4 hover:border-[#9CC6EA]">
                            <div class="text-xs font-bold uppercase tracking-[0.1em] text-[#5B7698]">WhatsApp</div>
                            <div class="mt-1 font-semibold text-[#173D68]">Chat with us instantly</div>
                        </a>
                    </div>

                    <div class="mt-5 rounded-2xl border border-[#C8DDED] bg-[#F4FAFF] p-5">
                        <div class="text-xs font-bold uppercase tracking-[0.1em] text-[#5B7698]">Location</div>
                        <div class="mt-1 text-sm font-semibold text-[#173D68]">{{ $c['location'] }}</div>
                    </div>
                </div>

                <div class="tb-panel p-6 md:p-10 tb-reveal">
                    <span class="tb-eyebrow">Request Proposal</span>
                    <h2 class="tb-subheading mt-3">Tell us what you need</h2>
                    <p class="tb-lead mt-3">We review every request manually and reply with the right technical path.</p>

                    <form class="mt-6 grid gap-4" method="POST" action="{{ route('contact.submit') }}">
                        @csrf

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div>
                                <label class="tb-form-label">Name</label>
                                <input name="name" value="{{ old('name') }}" class="tb-input" required />
                                @error('name')<div class="mt-1 text-xs font-semibold text-red-700">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="tb-form-label">Company</label>
                                <input name="company" value="{{ old('company') }}" class="tb-input" />
                                @error('company')<div class="mt-1 text-xs font-semibold text-red-700">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div>
                                <label class="tb-form-label">Email</label>
                                <input name="email" type="email" value="{{ old('email') }}" class="tb-input" />
                                @error('email')<div class="mt-1 text-xs font-semibold text-red-700">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="tb-form-label">Phone</label>
                                <input name="phone" value="{{ old('phone') }}" class="tb-input" />
                                @error('phone')<div class="mt-1 text-xs font-semibold text-red-700">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="tb-form-label">Message</label>
                            <textarea name="message" rows="6" class="tb-textarea" placeholder="Share your application, channels/sensors, current challenge, and expected timeline.">{{ old('message') }}</textarea>
                            @error('message')<div class="mt-1 text-xs font-semibold text-red-700">{{ $message }}</div>@enderror
                        </div>

                        <button class="btn btn-primary" type="submit">Send Request</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid gap-5 md:grid-cols-2">
                <div class="tb-panel p-6 md:p-8 tb-reveal">
                    <span class="tb-eyebrow">Share Useful Inputs</span>
                    <h2 class="tb-subheading mt-3">What helps us respond faster</h2>
                    <div class="mt-5 grid gap-3">
                        <div class="tb-panel-soft p-4">
                            <div class="font-semibold text-[#173D68]">Application context</div>
                            <p class="mt-1 text-sm text-[#4C6686]">Machine type, environment, product profile, and throughput expectation.</p>
                        </div>
                        <div class="tb-panel-soft p-4">
                            <div class="font-semibold text-[#173D68]">Technical signals</div>
                            <p class="mt-1 text-sm text-[#4C6686]">Channels, probes/sensors, communication protocols, and integration points.</p>
                        </div>
                        <div class="tb-panel-soft p-4">
                            <div class="font-semibold text-[#173D68]">Delivery timeline</div>
                            <p class="mt-1 text-sm text-[#4C6686]">Desired pilot date, production date, and support expectations.</p>
                        </div>
                    </div>
                </div>

                <div class="tb-panel p-6 md:p-8 tb-reveal">
                    <span class="tb-eyebrow">FAQ</span>
                    <h2 class="tb-subheading mt-3">Quick answers</h2>
                    <div class="mt-5 grid gap-3">
                        @foreach (config('twinbot.faqs', []) as $faq)
                            <details class="tb-compare" @if($loop->first) open @endif>
                                <summary>{{ $faq['q'] }}</summary>
                                <div class="tb-compare-body">
                                    <div class="tb-compare-item">
                                        <p class="tb-compare-copy">{{ $faq['a'] }}</p>
                                    </div>
                                </div>
                            </details>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section pb-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-cta tb-reveal">
                <span class="tb-eyebrow">Need Immediate Help?</span>
                <h2 class="tb-subheading mt-3">Call or WhatsApp for faster triage.</h2>
                <p class="tb-lead mt-3 max-w-2xl">For urgent production issues or active deployment support, reach us directly and we will prioritize response.</p>
                <div class="mt-5 flex flex-wrap gap-3">
                    <a href="tel:{{ $c['phone_tel'] }}" class="btn btn-primary">Call {{ $c['phone_display'] }}</a>
                    <a href="{{ $c['whatsapp_url'] }}" class="btn btn-ghost">Open WhatsApp</a>
                </div>
            </div>
        </div>
    </section>
@endsection
