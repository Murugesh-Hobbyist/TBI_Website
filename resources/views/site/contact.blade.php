@extends('layouts.site')

@section('title', 'Contact | TwinBot Innovations')
@section('meta_description', 'Connect with TwinBot Innovations for embedded automation projects, product enquiries, and technical consultation.')

@section('content')
    @php
        $c = config('twinbot.contact');
    @endphp

    <section class="tb-section pt-6 md:pt-10">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-panel p-6 md:p-10 tb-reveal">
                    <span class="tb-eyebrow">Request Proposal</span>
                    <div class="mt-3 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-[#4F6890]">
                        <span>Direct mail to</span>
                        <a href="mailto:{{ $c['email_primary'] }}" class="font-semibold text-[#1F6FD0] hover:text-[#16589F]">{{ $c['email_primary'] }}</a>
                        <span class="font-semibold text-[#7B95AE]">or</span>
                    </div>
                    <h1 class="tb-subheading mt-2">Tell us what you need</h1>
                    <p class="tb-lead mt-3">We review every request manually and reply with the right technical path.</p>

                    <form class="mt-6 grid gap-5 md:grid-cols-2" method="POST" action="{{ route('contact.submit') }}" data-contact-form>
                        @csrf

                        <div class="grid content-start gap-4">
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
                        </div>

                        <div class="flex flex-col">
                            <div class="flex-1">
                                <label class="tb-form-label">Message</label>
                                <textarea name="message" rows="12" class="tb-textarea h-full min-h-[18rem]" placeholder="Share your application, current challenge, and expected timeline.">{{ old('message') }}</textarea>
                                @error('message')<div class="mt-1 text-xs font-semibold text-red-700">{{ $message }}</div>@enderror
                            </div>
                            <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <p class="max-w-2xl text-xs leading-relaxed text-[#607C9A]">By submitting, you agree that TwinBot may use these details to respond to your request. Do not include PINs, OTPs, passwords, bank credentials, or identity documents. See our <a href="{{ route('policies.privacy') }}" class="font-semibold text-[#1F6FD0] hover:text-[#16589F]">Privacy Policy</a>.</p>
                                <button class="btn btn-primary shrink-0" type="submit" data-contact-submit>Send Request</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        (function(){var form=document.querySelector('[data-contact-form]');if(!form)return;form.addEventListener('submit',function(){if(!form.checkValidity())return;var button=form.querySelector('[data-contact-submit]');if(!button)return;button.disabled=true;button.textContent='Sending…';button.setAttribute('aria-busy','true')})})();
    </script>
@endpush
