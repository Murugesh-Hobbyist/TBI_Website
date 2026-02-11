@extends('layouts.site')

@section('title', 'Solutions - '.config('twinbot.site.domain'))
@section('meta_description', 'Custom industrial automation solutions powered by embedded control systems.')

@section('content')
    <section class="mx-auto max-w-6xl px-4 pt-10 pb-16">
        <div class="rounded-3xl border border-black/10 bg-white p-6 md:p-10">
            <h1 class="font-display text-4xl tracking-tight text-[#0F172A]">Solutions</h1>
            <div class="mt-4 max-w-4xl space-y-3 text-sm text-[#364151]">
                <p>
                    Our solutions are fully customized to client needs and are not publicly disclosed.
                    They are shared individually with business professionals based on specific requirements.
                </p>
                <p>
                    Contact us to get verified and explore our solutions.
                </p>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('contact') }}" class="btn btn-primary">Contact Us</a>
                <a href="{{ route('products.index') }}" class="btn btn-ghost">View Products</a>
            </div>
        </div>

        <div class="mt-8 rounded-3xl border border-black/10 bg-white p-6 md:p-8">
            <h2 class="font-display text-2xl text-[#0F172A]">Approved Sample Projects</h2>
            <p class="mt-2 text-sm text-[#364151]">
                We share verified references and relevant samples during discussions, based on your industry and scope.
            </p>
        </div>
    </section>
@endsection

