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
                    <h1 class="tb-subheading mt-4">Let us shape your next automation milestone.</h1>
                    <p class="tb-lead mt-5">Share your challenge, your timeline, and your target outcome. Our engineering team will respond with practical next steps.</p>

                    <div class="mt-6 grid gap-3">
                        <a href="mailto:{{ $c['email_primary'] }}" class="tb-panel-soft p-4 hover:border-[#9CC6EA]">
                            <div class="text-xs font-bold uppercase tracking-[0.1em] text-[#607B9B]">Support</div>
                            <div class="mt-1 font-semibold text-[#1B4A74]">{{ $c['email_primary'] }}</div>
                        </a>
                    </div>

                    <div class="mt-5 rounded-2xl border border-[#C6DCEF] bg-[#F2F9FF] p-5">
                        <div class="text-xs font-bold uppercase tracking-[0.1em] text-[#607B9B]">Location</div>
                        <div class="mt-1 text-sm font-semibold text-[#1B4A74]">{{ $c['location'] }}</div>
                    </div>
                </div>

                <div class="tb-panel p-6 md:p-10 tb-reveal">
                    <span class="tb-eyebrow">Request Proposal</span>
                    <h2 class="tb-subheading mt-3">Tell us what you need</h2>
                    <p class="tb-lead mt-3">We review every request manually and reply with the right technical path.</p>

                    <form class="mt-6 grid gap-4" method="POST" action="{{ route('contact.submit') }}" data-contact-form>
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

                        <div>
                            <label class="tb-form-label">Subject</label>
                            <input name="subject" value="{{ old('subject') }}" class="tb-input" required />
                            @error('subject')<div class="mt-1 text-xs font-semibold text-red-700">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="tb-form-label">Email</label>
                            <input name="email" type="email" value="{{ old('email') }}" class="tb-input" />
                            @error('email')<div class="mt-1 text-xs font-semibold text-red-700">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label class="tb-form-label">Message</label>
                            <textarea name="message" rows="6" class="tb-textarea" placeholder="Share your application, channels/sensors, current challenge, and expected timeline.">{{ old('message') }}</textarea>
                            @error('message')<div class="mt-1 text-xs font-semibold text-red-700">{{ $message }}</div>@enderror
                        </div>

                        <button class="btn btn-primary" type="submit" data-contact-submit>Send Request</button>
                        <p class="text-xs leading-relaxed text-[#607C9A]">By submitting, you agree that TwinBot may use these details to respond to your request. Do not include PINs, OTPs, passwords, bank credentials, or identity documents. See our <a href="{{ route('policies.privacy') }}" class="font-semibold text-[#1F6FD0] hover:text-[#16589F]">Privacy Policy</a>.</p>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        (function(){var form=document.querySelector('[data-contact-form]');if(!form)return;form.addEventListener('submit',function(){if(!form.checkValidity())return;var button=form.querySelector('[data-contact-submit]');if(!button)return;button.disabled=true;button.textContent='Sending…';button.setAttribute('aria-busy','true')})})();
    </script>
@endpush
