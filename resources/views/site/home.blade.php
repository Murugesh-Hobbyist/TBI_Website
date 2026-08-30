@extends('layouts.site')

@section('title', 'TwinBot Innovations | Embedded Automation')
@section('meta_description', 'TwinBot Innovations develops embedded control, inspection, and traceability systems for industrial automation.')

@section('content')
    <section class="tb-section pt-6 md:pt-10 pb-10">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-flow-shell tb-flow-reveal p-6 md:p-10">
                <div class="mx-auto max-w-4xl text-center">
                    <span class="tb-flow-kicker">TwinBot Innovations · Embedded Control Systems</span>
                    <h1>TwinBot turns production complexity into <span>clear, confident execution.</span></h1>
                    <p>TwinBot develops embedded control, inspection, and traceability platforms that connect the operator, machine, and production evidence in one focused system.</p>
                </div>

                <div class="tb-flow-map mt-10">
                    <article class="tb-flow-start"><small>START HERE</small><strong>Production challenge</strong><span>Manual checks · unclear operator flow · disconnected data</span></article>
                    <div class="tb-flow-arrow tb-flow-arrow-down" aria-hidden="true"><i></i></div>
                    <article class="tb-flow-core"><small>TWINBOT ECS</small><strong>Embedded control core</strong><span>Purpose-built electronics + firmware</span></article>
                    <div class="tb-flow-branches" aria-hidden="true"><i></i><i></i><i></i></div>
                    <div class="tb-flow-solutions">
                        <article><b>01</b><h2>Operator-clear interfaces</h2><p>Fewer clicks, visible pass/fail states, predictable execution.</p></article>
                        <article><b>02</b><h2>Inspection in context</h2><p>Measurement logic and quality decisions where the work happens.</p></article>
                        <article><b>03</b><h2>Actionable visibility</h2><p>Traceable events and diagnostics that give teams evidence.</p></article>
                    </div>
                    <div class="tb-flow-arrow tb-flow-arrow-down" aria-hidden="true"><i></i></div>
                    <article class="tb-flow-outcome"><span></span><small>OUTCOME</small><strong>Confident production</strong><p>From pilot station to full rollout—with a system designed for the floor.</p></article>
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section pb-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-customers tb-flow-reveal p-6 md:p-8">
                <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between"><div><span class="tb-flow-kicker">Trusted collaborations</span><h2>Teams building with TwinBot</h2></div><p>Industrial teams and institutions working with TwinBot systems.</p></div>
                <div class="tb-customer-grid mt-7">
                    @foreach (config('twinbot.assets.trusted_logos', []) as $logo)
                        <article class="tb-customer-card"><img src="{{ asset($logo) }}" alt="TwinBot trusted collaboration" /></article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <style>
        .tb-flow-shell,.tb-customers{border:1px solid #c7def3;border-radius:1.7rem;box-shadow:0 22px 48px rgba(24,84,141,.12)}.tb-flow-shell{position:relative;overflow:hidden;background:radial-gradient(circle at 50% 8%,rgba(37,209,186,.16),transparent 30%),linear-gradient(145deg,#fafdff,#eaf6ff)}.tb-flow-shell:before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(33,112,208,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(33,112,208,.055) 1px,transparent 1px);background-size:30px 30px}.tb-flow-shell>*{position:relative;z-index:1}.tb-flow-kicker{display:inline-flex;border:1px solid #b7d6f0;border-radius:999px;padding:.45rem .75rem;background:#f4fbff;color:#215788;font-size:.68rem;font-weight:800;letter-spacing:.11em;text-transform:uppercase}.tb-flow-shell h1{margin-top:1rem;color:#133157;font-family:'Chakra Petch',sans-serif;font-size:clamp(2.05rem,4.2vw,3.85rem);line-height:1.06}.tb-flow-shell h1 span{color:#179cae}.tb-flow-shell>div>p{margin:1.1rem auto 0;max-width:43rem;color:#4b6d91;line-height:1.75}.tb-flow-map{display:flex;flex-direction:column;align-items:center}.tb-flow-start,.tb-flow-core,.tb-flow-outcome{max-width:29rem;text-align:center;border:1px solid #bdd9f0;border-radius:1rem;padding:1rem 1.2rem;background:#fff;box-shadow:0 10px 22px rgba(23,85,142,.08)}.tb-flow-start small,.tb-flow-core small,.tb-flow-outcome small{display:block;color:#52789d;font-size:.62rem;font-weight:800;letter-spacing:.12em}.tb-flow-start strong,.tb-flow-core strong,.tb-flow-outcome strong{display:block;margin-top:.35rem;color:#13365e;font-family:'Chakra Petch',sans-serif;font-size:1.35rem}.tb-flow-start span,.tb-flow-core span{display:block;margin-top:.35rem;color:#587a9b;font-size:.78rem}.tb-flow-core{border-color:#82ded1;background:linear-gradient(145deg,#e5fbf7,#f8ffff);box-shadow:0 0 0 6px rgba(43,205,183,.09),0 14px 28px rgba(28,176,158,.15)}.tb-flow-core strong{color:#117b80}.tb-flow-arrow{position:relative;width:2px;height:3.1rem;background:#bdd8ee;overflow:hidden}.tb-flow-arrow i{display:block;width:100%;height:33%;background:linear-gradient(#2171d0,#26c5aa);animation:tb-flow-pulse-line 1.6s ease-in-out infinite}.tb-flow-branches{display:grid;grid-template-columns:repeat(3,1fr);width:min(100%,52rem);height:3rem}.tb-flow-branches i{position:relative;border-top:2px solid #bdd8ee}.tb-flow-branches i:after{content:'';position:absolute;left:50%;top:0;width:2px;height:100%;background:#bdd8ee}.tb-flow-solutions{display:grid;gap:1rem;width:100%}.tb-flow-solutions article{position:relative;min-height:11.5rem;border:1px solid #c7e0f4;border-radius:1.1rem;padding:1.2rem;background:linear-gradient(150deg,#fff,#eef8ff);box-shadow:0 11px 22px rgba(27,89,145,.08);transition:transform .3s ease,box-shadow .3s ease}.tb-flow-solutions article:hover{transform:translateY(-6px);box-shadow:0 20px 34px rgba(27,89,145,.15)}.tb-flow-solutions b{display:inline-grid;place-items:center;width:2rem;height:2rem;border-radius:.55rem;background:linear-gradient(135deg,#2171d0,#26c5aa);color:#fff;font-size:.72rem}.tb-flow-solutions h2{margin-top:.9rem;color:#15365e;font-family:'Chakra Petch',sans-serif;font-size:1.22rem}.tb-flow-solutions p{margin-top:.55rem;color:#537595;font-size:.86rem;line-height:1.6}.tb-flow-outcome{border-color:#82ded1;background:#e9fbf7}.tb-flow-outcome span{display:inline-block;width:.6rem;height:.6rem;border-radius:50%;background:#1dc6a9;box-shadow:0 0 0 .35rem rgba(29,198,169,.13);animation:tb-outcome-pulse 2s infinite}.tb-flow-outcome p{margin-top:.45rem;color:#447384;font-size:.84rem}.tb-customers{background:#fff}.tb-customers h2{margin-top:.8rem;color:#133157;font-family:'Chakra Petch',sans-serif;font-size:clamp(1.8rem,3vw,2.5rem)}.tb-customers p{color:#537595;font-size:.9rem}.tb-customer-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.8rem}.tb-customer-card{display:grid;place-items:center;min-height:6.7rem;border:1px solid #d1e4f5;border-radius:1rem;background:linear-gradient(145deg,#fff,#f2faff);transition:transform .3s ease}.tb-customer-card:hover{transform:translateY(-5px)}.tb-customer-card img{max-width:78%;max-height:3rem;object-fit:contain}.tb-motion-ready .tb-flow-reveal{opacity:0;transform:translateY(20px);transition:opacity .7s ease,transform .7s ease}.tb-motion-ready .tb-flow-reveal.tb-visible{opacity:1;transform:none}@keyframes tb-flow-pulse-line{from{transform:translateY(-115%)}to{transform:translateY(320%)}}@keyframes tb-outcome-pulse{70%{box-shadow:0 0 0 .65rem rgba(29,198,169,0)}100%{box-shadow:0 0 0 0 rgba(29,198,169,0)}}@media(min-width:768px){.tb-flow-solutions{grid-template-columns:repeat(3,1fr)}.tb-customer-grid{grid-template-columns:repeat(4,minmax(0,1fr))}}@media(max-width:767px){.tb-flow-branches{display:none}}@media(prefers-reduced-motion:reduce){*,*:before,*:after{animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important}}
    </style>
@endsection

@push('scripts')
    <script>
        (function(){if(!('IntersectionObserver' in window)||window.matchMedia('(prefers-reduced-motion: reduce)').matches)return;document.documentElement.classList.add('tb-motion-ready');var o=new IntersectionObserver(function(e){e.forEach(function(x){if(x.isIntersecting){x.target.classList.add('tb-visible');o.unobserve(x.target)}})},{threshold:.15});document.querySelectorAll('.tb-flow-reveal').forEach(function(x){o.observe(x)})})();
    </script>
@endpush
