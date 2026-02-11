@extends('layouts.site')

@section('title', ($product['title'] ?? 'Product').' - '.config('twinbot.site.domain'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((string) ($product['summary'] ?? config('twinbot.site.tagline'))), 160))

@section('content')
    @php
        $img = $product['image'] ?? null;
        $src = $img && \Illuminate\Support\Str::startsWith($img, ['http://', 'https://']) ? $img : ($img ? asset($img) : null);
        $c = config('twinbot.contact');
    @endphp

    <section class="mx-auto max-w-6xl px-4 pt-10 pb-16">
        <a href="{{ route('products.index') }}" class="text-sm font-semibold text-[#0067FF] hover:text-[#005EE9]">Back to Products</a>

        <div class="mt-6 grid gap-6 md:grid-cols-2 md:items-start">
            <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-8">
                <div class="text-xs font-semibold text-[#364151]">{{ $product['series'] ?? 'Product' }}</div>
                <h1 class="mt-2 font-display text-4xl tracking-tight text-[#0F172A]">{{ $product['title'] ?? 'Product' }}</h1>
                @if (!empty($product['summary']))
                    <p class="mt-4 text-sm text-[#364151]">{{ $product['summary'] }}</p>
                @endif

                @if ($src)
                    <div class="mt-6 overflow-hidden rounded-2xl border border-black/10 bg-white">
                        <img src="{{ $src }}" alt="" class="h-72 w-full object-contain p-6" />
                    </div>
                @endif

                @if (!empty($product['body']))
                    <div class="mt-6 rounded-2xl border border-black/10 bg-[#E7F6FF] p-5">
                        <div class="font-semibold text-[#0F172A]">Details</div>
                        <div class="mt-2 whitespace-pre-wrap text-sm text-[#364151]">{{ $product['body'] }}</div>
                    </div>
                @endif
            </div>

            <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-8">
                <h2 class="font-display text-2xl text-[#0F172A]">Send us your enquiry</h2>
                <p class="mt-2 text-sm text-[#364151]">
                    Share your requirements. We will respond with next steps.
                </p>

                <form class="mt-5 grid gap-3" method="POST" action="{{ route('products.enquiry', ['product' => $product['slug'] ?? '']) }}">
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
                        <textarea name="message" rows="5" class="mt-1 w-full rounded-2xl border border-black/10 bg-white px-4 py-3 text-sm text-[#0F172A] focus:outline-none focus:ring-2 focus:ring-[#0067FF]/30">{{ old('message') }}</textarea>
                        @error('message')<div class="mt-1 text-xs text-red-700">{{ $message }}</div>@enderror
                    </div>

                    <button class="btn btn-primary" type="submit">Send us your enquiry</button>
                </form>

                <div class="mt-6 rounded-2xl border border-black/10 bg-[#E7F6FF] p-5">
                    <div class="font-semibold text-[#0F172A]">Prefer direct contact?</div>
                    <div class="mt-2 text-sm text-[#364151]">
                        Phone: <a class="font-semibold text-[#0067FF] hover:text-[#005EE9]" href="tel:{{ $c['phone_tel'] }}">{{ $c['phone_display'] }}</a><br>
                        Email: <a class="font-semibold text-[#0067FF] hover:text-[#005EE9]" href="mailto:{{ $c['email_primary'] }}">{{ $c['email_primary'] }}</a><br>
                        Whatsapp: <a class="font-semibold text-[#0067FF] hover:text-[#005EE9]" href="{{ $c['whatsapp_url'] }}">{{ $c['phone_display'] }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

