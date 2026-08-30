@extends('layouts.site')

@section('title', 'Contact | TwinBot Innovations')
@section('meta_description', 'Connect with TwinBot Innovations for embedded automation projects, product enquiries, and technical consultation.')

@section('content')
    @php
        $c = config('twinbot.contact');
    @endphp

    <section class="tb-section pt-6 md:pt-10">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-panel p-5 md:p-7 tb-reveal">
                    <a href="mailto:{{ $c['email_primary'] }}" class="tb-contact-direct">
                        <span>Direct mail</span>
                        <strong>{{ $c['email_primary'] }}</strong>
                    </a>
                    <span class="tb-eyebrow">Request Proposal</span>
                    <h1 class="tb-subheading mt-2">Tell us what you need</h1>
                    <p class="tb-lead mt-2">We review every request manually and reply with the right technical path.</p>

                    <form class="mt-5 grid gap-4 sm:grid-cols-2" method="POST" action="{{ route('contact.submit') }}" data-contact-form>
                        @csrf

                        <div class="grid content-start gap-3 sm:grid-cols-2">
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
                        <p class="sm:col-span-2 mt-1 max-w-xl text-xs leading-relaxed text-[#607C9A]">By submitting, you agree that TwinBot may use these details to respond to your request. Do not include PINs, OTPs, passwords, bank credentials, or identity documents. See our <a href="{{ route('policies.privacy') }}" class="font-semibold text-[#1F6FD0] hover:text-[#16589F]">Privacy Policy</a>.</p>
                        </div>

                        <div class="flex flex-col">
                            <div class="flex-1">
                                <label class="tb-form-label">Message</label>
                                <textarea name="message" rows="12" class="tb-textarea h-full min-h-[18rem]" placeholder="Share your application, current challenge, and expected timeline.">{{ old('message') }}</textarea>
                                @error('message')<div class="mt-1 text-xs font-semibold text-red-700">{{ $message }}</div>@enderror
                            </div>
                            <div class="mt-3 flex justify-end">
                                <button class="btn btn-primary shrink-0" type="submit" data-contact-submit>Send Request</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </section>

    <style>
        .tb-contact-direct{display:inline-flex;align-items:center;gap:.55rem;margin-bottom:.75rem;border:1px solid #88dcd1;border-radius:999px;padding:.45rem .75rem;background:linear-gradient(100deg,#e5fbf7,#edf6ff);color:#187b82;font-size:.76rem;transition:transform .2s ease,box-shadow .2s ease}.tb-contact-direct strong{color:#1f6fd0}.tb-contact-direct:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(29,133,180,.16)}
    </style>
@endsection

@push('scripts')
    <script>
        (function(){var form=document.querySelector('[data-contact-form]');if(!form)return;form.addEventListener('submit',function(){if(!form.checkValidity())return;var button=form.querySelector('[data-contact-submit]');if(!button)return;button.disabled=true;button.textContent='Sending…';button.setAttribute('aria-busy','true')})})();
    </script>
@endpush
