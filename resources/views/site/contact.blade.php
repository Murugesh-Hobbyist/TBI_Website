@extends('layouts.site')

@section('title', 'Contact - '.config('twinbot.site.domain'))
@section('meta_description', 'Let\'s connect. Contact TwinBot Innovations for industrial automation, ECS solutions, and product enquiries.')

@section('content')
    @php
        $c = config('twinbot.contact');
    @endphp

    <section class="mx-auto max-w-6xl px-4 pt-10 pb-16">
        <div class="grid gap-6 md:grid-cols-2">
            <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-10">
                <h1 class="font-display text-4xl tracking-tight text-[#0F172A]">Let's Connect</h1>
                <p class="mt-4 text-sm text-[#364151]">
                    At TwinBot Innovations, we believe that collaboration drives success. Whether you are looking to enhance your operations,
                    explore innovative solutions, or simply have a conversation, we are here for it.
                </p>

                <div class="mt-6 rounded-2xl border border-black/10 bg-[#E7F6FF] p-5 text-sm text-[#364151]">
                    <div class="font-semibold text-[#0F172A]">Location</div>
                    <div class="mt-1">{{ $c['location'] ?? '' }}</div>
                </div>
            </div>

            <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-10">
                <h2 class="font-display text-2xl text-[#0F172A]">Get in touch</h2>
                <div class="mt-5 grid gap-3">
                    <a href="tel:{{ $c['phone_tel'] }}" class="rounded-2xl border border-black/10 bg-white px-5 py-4 hover:bg-[#E7F6FF]">
                        <div class="text-xs font-semibold text-[#364151]">Phone</div>
                        <div class="mt-1 font-semibold text-[#0F172A]">{{ $c['phone_display'] }}</div>
                    </a>

                    <a href="mailto:{{ $c['email_sales'] }}" class="rounded-2xl border border-black/10 bg-white px-5 py-4 hover:bg-[#E7F6FF]">
                        <div class="text-xs font-semibold text-[#364151]">Email</div>
                        <div class="mt-1 font-semibold text-[#0F172A]">{{ $c['email_sales'] }}</div>
                    </a>

                    <a href="{{ $c['whatsapp_url'] }}" class="rounded-2xl border border-black/10 bg-white px-5 py-4 hover:bg-[#E7F6FF]">
                        <div class="text-xs font-semibold text-[#364151]">Whatsapp</div>
                        <div class="mt-1 font-semibold text-[#0F172A]">{{ $c['phone_display'] }}</div>
                    </a>

                    <a href="mailto:{{ $c['email_primary'] }}" class="rounded-2xl border border-black/10 bg-white px-5 py-4 hover:bg-[#E7F6FF]">
                        <div class="text-xs font-semibold text-[#364151]">Support</div>
                        <div class="mt-1 font-semibold text-[#0F172A]">{{ $c['email_primary'] }}</div>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-8 grid gap-6 md:grid-cols-2 md:items-start">
            <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-10">
                <h2 class="font-display text-2xl text-[#0F172A]">Request a Quote</h2>
                <p class="mt-3 text-sm text-[#364151]">
                    Share your requirements and timeline. We'll respond with next steps.
                </p>

                <form class="mt-6 grid gap-3" method="POST" action="{{ route('contact.submit') }}">
                    @csrf
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="text-xs font-semibold text-[#364151]">Name</label>
                            <input name="name" value="{{ old('name') }}" class="mt-1 w-full rounded-2xl border border-black/10 bg-white px-4 py-3 text-sm text-[#0F172A] focus:outline-none focus:ring-2 focus:ring-[#0067FF]/30" required />
                            @error('name')<div class="mt-1 text-xs text-red-700">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-[#364151]">Company</label>
                            <input name="company" value="{{ old('company') }}" class="mt-1 w-full rounded-2xl border border-black/10 bg-white px-4 py-3 text-sm text-[#0F172A] focus:outline-none focus:ring-2 focus:ring-[#0067FF]/30" />
                            @error('company')<div class="mt-1 text-xs text-red-700">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="text-xs font-semibold text-[#364151]">Email</label>
                            <input name="email" type="email" value="{{ old('email') }}" class="mt-1 w-full rounded-2xl border border-black/10 bg-white px-4 py-3 text-sm text-[#0F172A] focus:outline-none focus:ring-2 focus:ring-[#0067FF]/30" />
                            @error('email')<div class="mt-1 text-xs text-red-700">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-[#364151]">Phone</label>
                            <input name="phone" value="{{ old('phone') }}" class="mt-1 w-full rounded-2xl border border-black/10 bg-white px-4 py-3 text-sm text-[#0F172A] focus:outline-none focus:ring-2 focus:ring-[#0067FF]/30" />
                            @error('phone')<div class="mt-1 text-xs text-red-700">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-[#364151]">Message</label>
                        <textarea name="message" rows="6" class="mt-1 w-full rounded-2xl border border-black/10 bg-white px-4 py-3 text-sm text-[#0F172A] focus:outline-none focus:ring-2 focus:ring-[#0067FF]/30" placeholder="Tell us what you want to automate, quantities/channels, I/O needs, and any drawings/specs you can share.">{{ old('message') }}</textarea>
                        @error('message')<div class="mt-1 text-xs text-red-700">{{ $message }}</div>@enderror
                    </div>

                    <button class="btn btn-primary" type="submit">Send Request</button>
                </form>
            </div>

            <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-10">
                <h3 class="font-display text-xl text-[#0F172A]">What to include</h3>
                <div class="mt-4 grid gap-3 text-sm text-[#364151]">
                    <div class="rounded-2xl border border-black/10 bg-[#E7F6FF] p-5">
                        <div class="font-semibold text-[#0F172A]">Project details</div>
                        <div class="mt-2">
                            Application, environment, channels, sensors, interfaces, and expected output.
                        </div>
                    </div>
                    <div class="rounded-2xl border border-black/10 bg-[#E7F6FF] p-5">
                        <div class="font-semibold text-[#0F172A]">Timeline</div>
                        <div class="mt-2">
                            When you need a prototype and when you need production-ready delivery.
                        </div>
                    </div>
                    <div class="rounded-2xl border border-black/10 bg-[#E7F6FF] p-5">
                        <div class="font-semibold text-[#0F172A]">Product enquiries</div>
                        <div class="mt-2">
                            If your enquiry is about a specific product, mention the product name or visit the
                            <a href="{{ route('products.index') }}" class="font-semibold text-[#0067FF] hover:text-[#005EE9]">Products</a>
                            page and submit an enquiry from the product detail screen.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 rounded-3xl border border-black/10 bg-white p-6 md:p-10">
            <h2 class="font-display text-2xl text-[#0F172A]">Frequently Asked Questions</h2>
            <div class="mt-6 grid gap-4 md:grid-cols-2">
                @foreach (config('twinbot.faqs', []) as $faq)
                    <div class="rounded-2xl border border-black/10 bg-white p-5">
                        <div class="font-semibold text-[#0F172A]">{{ $faq['q'] }}</div>
                        <div class="mt-2 text-sm text-[#364151]">{{ $faq['a'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
