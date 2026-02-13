@extends('layouts.site')

@section('title', ($product['title'] ?? 'Product').' | TwinBot Innovations')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((string) ($product['summary'] ?? config('twinbot.site.tagline'))), 160))

@section('content')
    @php
        $img = $product['image'] ?? null;
        $src = $img && \Illuminate\Support\Str::startsWith($img, ['http://', 'https://']) ? $img : ($img ? asset($img) : null);
        $c = config('twinbot.contact');
    @endphp

    <section class="tb-section pt-6 md:pt-10 pb-16">
        <div class="tb-wrap">
            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-[#1F6FD0] hover:text-[#16589F]">&larr; Back to Products</a>

            <div class="grid gap-5 mt-5 md:grid-cols-[1.05fr_0.95fr] md:items-start">
                <article class="tb-panel p-6 md:p-8 tb-reveal">
                    <span class="tb-eyebrow">{{ $product['series'] ?? 'Product' }}</span>
                    <h1 class="tb-heading mt-4">{{ $product['title'] ?? 'Product' }}</h1>
                    @if (!empty($product['summary']))
                        <p class="tb-lead mt-4">{{ $product['summary'] }}</p>
                    @endif

                    @if ($src)
                        <div class="mt-6 tb-product-thumb h-[260px] md:h-[320px]">
                            <img src="{{ $src }}" alt="{{ $product['title'] }}" class="h-full w-full object-contain" />
                        </div>
                    @endif

                    @if (!empty($product['body']))
                        <div class="mt-6 tb-panel-soft p-5">
                            <h2 class="font-display text-xl text-[#122E53]">Product Overview</h2>
                            <p class="mt-2 whitespace-pre-wrap text-sm leading-relaxed text-[#4F6890]">{{ $product['body'] }}</p>
                        </div>
                    @endif
                </article>

                <aside class="space-y-5">
                    <div class="tb-panel p-6 md:p-8 tb-reveal">
                        <span class="tb-eyebrow">Enquiry</span>
                        <h2 class="tb-subheading mt-3">Send your requirement</h2>
                        <p class="tb-lead mt-3">We will review your use case and suggest the right variant or customization path.</p>

                        <form class="mt-6 grid gap-4" method="POST" action="{{ route('products.enquiry', ['product' => $product['slug'] ?? '']) }}">
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
                                <textarea name="message" rows="5" class="tb-textarea" placeholder="Share quantity, use case, technical constraints, and expected timeline.">{{ old('message') }}</textarea>
                                @error('message')<div class="mt-1 text-xs font-semibold text-red-700">{{ $message }}</div>@enderror
                            </div>

                            <button class="btn btn-primary" type="submit">Send Enquiry</button>
                        </form>
                    </div>

                    <div class="tb-panel-soft p-5 tb-reveal">
                        <div class="text-sm font-semibold text-[#1B4A74]">Prefer direct communication?</div>
                        <div class="mt-3 text-sm leading-relaxed text-[#4F6890]">
                            Phone: <a class="font-semibold text-[#1F6FD0] hover:text-[#16589F]" href="tel:{{ $c['phone_tel'] }}">{{ $c['phone_display'] }}</a><br>
                            Email: <a class="font-semibold text-[#1F6FD0] hover:text-[#16589F]" href="mailto:{{ $c['email_primary'] }}">{{ $c['email_primary'] }}</a><br>
                            WhatsApp: <a class="font-semibold text-[#1F6FD0] hover:text-[#16589F]" href="{{ $c['whatsapp_url'] }}">Start chat</a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection


