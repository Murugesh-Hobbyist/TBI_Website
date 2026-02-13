@extends('layouts.site')

@section('title', 'Forum | TwinBot Innovations')
@section('meta_description', 'TwinBot community forum is under preparation. Reach our team directly for technical help and product guidance.')

@section('content')
    <section class="tb-section pt-6 md:pt-10 pb-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-panel p-6 md:p-10 tb-reveal">
                <span class="tb-eyebrow">Community</span>
                <h1 class="tb-heading mt-4">Forum is under construction.</h1>
                <p class="tb-lead mt-5 max-w-3xl">We are building a proper space for knowledge sharing, troubleshooting playbooks, and application discussions around TwinBot systems. Until then, our team is available directly.</p>

                <div class="mt-7 grid gap-4 md:grid-cols-3">
                    <div class="tb-card">
                        <h2 class="font-display text-xl text-[#122E53]">Technical Queries</h2>
                        <p class="mt-2 text-sm text-[#4F6890]">Get support on integration, sensors, communication, and diagnostics.</p>
                    </div>
                    <div class="tb-card">
                        <h2 class="font-display text-xl text-[#122E53]">Product Selection</h2>
                        <p class="mt-2 text-sm text-[#4F6890]">Find the right TwinBot platform based on your process and quality requirements.</p>
                    </div>
                    <div class="tb-card">
                        <h2 class="font-display text-xl text-[#122E53]">Project Planning</h2>
                        <p class="mt-2 text-sm text-[#4F6890]">Discuss timelines, deployment strategy, and phased scaling approach.</p>
                    </div>
                </div>

                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('contact') }}" class="btn btn-primary">Contact Engineering Team</a>
                    <a href="{{ route('products.index') }}" class="btn btn-ghost">Explore Products</a>
                </div>
            </div>
        </div>
    </section>
@endsection

