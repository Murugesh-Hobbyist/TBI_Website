@extends('layouts.site')

@section('title', 'Finboard | Automation & Innovation')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-14">
        <div class="grid gap-10 md:grid-cols-2 md:items-center">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs text-white/70">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    Built for decision makers
                </div>
                <h1 class="mt-5 font-display text-4xl tracking-tight md:text-5xl">
                    Turn automation into an asset people can trust.
                </h1>
                <p class="mt-5 max-w-xl text-base text-white/70">
                    Finboard is a premium, dynamic platform to present your products, proven projects, and automation videos with the kind of clarity that builds confidence fast.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('quote') }}" class="btn btn-primary">Request Quote</a>
                    <a href="{{ route('projects.index') }}" class="btn btn-ghost">View Projects</a>
                </div>
                <div class="mt-8 grid grid-cols-3 gap-3 text-xs text-white/55">
                    <div class="card px-4 py-3">
                        <div class="text-white/90">Dynamic CMS</div>
                        <div class="mt-1">Projects, products, videos</div>
                    </div>
                    <div class="card px-4 py-3">
                        <div class="text-white/90">Lead Pipeline</div>
                        <div class="mt-1">Contact, quote, orders</div>
                    </div>
                    <div class="card px-4 py-3">
                        <div class="text-white/90">AI Assistant</div>
                        <div class="mt-1">Text + push-to-talk</div>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <div class="rounded-2xl border border-white/10 bg-gradient-to-br from-white/10 to-white/0 p-6">
                    <div class="text-xs text-white/60">What investors and buyers want to see</div>
                    <div class="mt-4 space-y-3 text-sm text-white/75">
                        <div class="flex items-start gap-3">
                            <div class="mt-1 h-2 w-2 rounded-full bg-emerald-400"></div>
                            <div><span class="text-white/90">Proof:</span> projects with measurable outcomes.</div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="mt-1 h-2 w-2 rounded-full bg-sky-400"></div>
                            <div><span class="text-white/90">Clarity:</span> products with pricing and specs.</div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="mt-1 h-2 w-2 rounded-full bg-orange-400"></div>
                            <div><span class="text-white/90">Confidence:</span> a responsive AI assistant trained on your own data.</div>
                        </div>
                    </div>
                    <div class="mt-6 rounded-xl border border-white/10 bg-black/20 p-4 text-xs text-white/60">
                        Tip: Use the “Ask AI” button to test the assistant once you publish a few KB articles.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto mt-16 max-w-6xl px-4">
        <div class="flex items-end justify-between gap-6">
            <div>
                <h2 class="font-display text-2xl">Featured Projects</h2>
                <p class="mt-2 text-sm text-white/60">Recent work that proves capability and delivery.</p>
            </div>
            <a href="{{ route('projects.index') }}" class="text-sm text-white/70 hover:text-white">All projects</a>
        </div>
        <div class="mt-6 grid gap-4 md:grid-cols-3">
            @forelse ($featuredProjects as $p)
                <a href="{{ route('projects.show', $p) }}" class="card p-5 hover:bg-white/10">
                    <div class="text-sm text-white/55">Project</div>
                    <div class="mt-2 font-semibold text-white">{{ $p->title }}</div>
                    <div class="mt-2 text-sm text-white/65">{{ \Illuminate\Support\Str::limit(strip_tags((string) $p->summary), 120) }}</div>
                </a>
            @empty
                <div class="card p-6 text-sm text-white/60 md:col-span-3">
                    No published projects yet. Add them in `Admin -> Projects`.
                </div>
            @endforelse
        </div>
    </section>

    <section class="mx-auto mt-16 max-w-6xl px-4">
        <div class="flex items-end justify-between gap-6">
            <div>
                <h2 class="font-display text-2xl">Featured Products</h2>
                <p class="mt-2 text-sm text-white/60">A clean catalog that supports both ecommerce and quotes.</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm text-white/70 hover:text-white">All products</a>
        </div>
        <div class="mt-6 grid gap-4 md:grid-cols-3">
            @forelse ($featuredProducts as $p)
                <a href="{{ route('products.show', $p) }}" class="card p-5 hover:bg-white/10">
                    <div class="text-sm text-white/55">Product</div>
                    <div class="mt-2 font-semibold text-white">{{ $p->title }}</div>
                    <div class="mt-2 text-sm text-white/65">{{ \Illuminate\Support\Str::limit(strip_tags((string) $p->summary), 120) }}</div>
                    <div class="mt-4 text-sm text-white/80">
                        {{ $p->currency }} {{ number_format(((int) $p->price_cents) / 100, 2) }}
                    </div>
                </a>
            @empty
                <div class="card p-6 text-sm text-white/60 md:col-span-3">
                    No published products yet. Add them in `Admin -> Products`.
                </div>
            @endforelse
        </div>
    </section>

    <section class="mx-auto mt-16 max-w-6xl px-4 pb-16">
        <div class="flex items-end justify-between gap-6">
            <div>
                <h2 class="font-display text-2xl">Automation Videos</h2>
                <p class="mt-2 text-sm text-white/60">Show, don’t tell: demonstrate outcomes visually.</p>
            </div>
            <a href="{{ route('videos.index') }}" class="text-sm text-white/70 hover:text-white">All videos</a>
        </div>
        <div class="mt-6 grid gap-4 md:grid-cols-3">
            @forelse ($featuredVideos as $v)
                <a href="{{ route('videos.show', $v) }}" class="card p-5 hover:bg-white/10">
                    <div class="text-sm text-white/55">Video</div>
                    <div class="mt-2 font-semibold text-white">{{ $v->title }}</div>
                    <div class="mt-2 text-sm text-white/65">{{ \Illuminate\Support\Str::limit(strip_tags((string) $v->summary), 120) }}</div>
                </a>
            @empty
                <div class="card p-6 text-sm text-white/60 md:col-span-3">
                    No published videos yet. Add them in `Admin -> Videos`.
                </div>
            @endforelse
        </div>
    </section>
@endsection

