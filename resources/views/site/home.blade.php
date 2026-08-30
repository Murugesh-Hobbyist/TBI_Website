@extends('layouts.site')

@section('title', 'TwinBot Innovations | Inspection Automation Platforms')
@section('meta_description', 'TwinBot Innovations builds ECS, TBIMetrix, and computer-vision inspection platforms for confident production decisions.')

@section('content')
    <section class="tb-section pt-6 md:pt-10 pb-10">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-pitch-flow tb-pitch-reveal p-6 md:p-10">
                <header class="mx-auto max-w-4xl text-center">
                    <span class="tb-pitch-kicker">TwinBot Innovations · Inspection Automation</span>
                    <h1>One inspection need.<br><span>Three TwinBot platforms.</span></h1>
                    <p>Embedded Control Systems designed to turn production inspection into clear operation, traceable evidence, and confident decisions.</p>
                </header>

                <div class="tb-pitch-map mt-9">
                    <div class="tb-pitch-origin"><small>INSPECTION REQUIREMENT</small><strong>What does your production line need to inspect?</strong></div>
                    <div class="tb-pitch-line tb-flow-input" aria-hidden="true"><i></i></div>
                    <div class="tb-pitch-core"><span>TBI</span><div><small>TWINBOT ECS CORE</small><strong>Embedded control architecture</strong></div></div>
                    <div class="tb-pitch-compare"><span>Conventional PLC stack: more layers, separate tools</span><b>→</b><strong>TwinBot ECS: compact, integrated, custom</strong></div>
                    <div class="tb-pitch-line tb-flow-core" aria-hidden="true"><i></i></div>
                    <div class="tb-pitch-split" aria-hidden="true"><i></i><i></i><i></i></div>

                    <div class="tb-product-streams">
                        <div class="tb-product-stream"><span class="tb-stream-no">01</span><small>CONTACT INSPECTION</small><h2>Standalone ECS</h2><p>Auto · Manual · Mastering</p><div>Touch HMI · Fingerprint access · SD-card inspection history</div></div>
                        <div class="tb-product-stream"><span class="tb-stream-no">02</span><small>CONTACT + PC INSPECTION</small><h2>ECS + TBIMetrix</h2><p>Specialised inspection</p><div>Database records · Production analysis · Excel export</div></div>
                        <div class="tb-product-stream"><span class="tb-stream-no">03</span><small>NON-CONTACT INSPECTION</small><h2>Computer Vision</h2><p>TwinBot vision application</p><div>Detection · Measurement · Quality evidence</div></div>
                    </div>

                    <div class="tb-pitch-merge" aria-hidden="true"><i></i><i></i><i></i></div>
                    <div class="tb-pitch-shared">Custom operator UI <b>·</b> Access control <b>·</b> Fast multicore control <b>·</b> Remote updates <b>·</b> Traceable production data</div>
                    <div class="tb-pitch-line tb-flow-output" aria-hidden="true"><i></i></div>
                    <div class="tb-pitch-outcome"><span></span><small>OUTCOME</small><strong>Clear operation. Proof in every part. Ready to scale.</strong></div>
                </div>
            </div>
        </div>
    </section>

    <section class="tb-section pb-12">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-customers tb-pitch-reveal p-6 md:p-8">
                <div><span class="tb-pitch-kicker">Our Customers</span></div>
                <div class="tb-customer-grid mt-5">@foreach (config('twinbot.assets.trusted_logos', []) as $logo)<div class="tb-customer-logo"><img src="{{ asset($logo) }}" alt="TwinBot customer logo" /></div>@endforeach</div>
            </div>
        </div>
    </section>

    <style>
        .tb-pitch-flow,.tb-customers{border:1px solid #c7def3;border-radius:1.7rem;box-shadow:0 22px 48px rgba(24,84,141,.12)}.tb-pitch-flow{position:relative;overflow:hidden;background:radial-gradient(circle at 50% 12%,rgba(38,204,184,.18),transparent 26%),linear-gradient(145deg,#fbfeff,#eaf6ff)}.tb-pitch-flow:before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(33,112,208,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(33,112,208,.055) 1px,transparent 1px);background-size:30px 30px}.tb-pitch-flow>*{position:relative;z-index:1}.tb-pitch-kicker{display:inline-flex;border:1px solid #b7d6f0;border-radius:999px;padding:.45rem .75rem;background:#f4fbff;color:#215788;font-size:.68rem;font-weight:800;letter-spacing:.11em;text-transform:uppercase}.tb-pitch-flow h1{margin-top:1rem;color:#133157;font-family:'Chakra Petch',sans-serif;font-size:clamp(2.05rem,4.2vw,3.75rem);line-height:1.06}.tb-pitch-flow h1 span{color:#179cae}.tb-pitch-flow header p{margin:1.1rem auto 0;max-width:42rem;color:#4b6d91;line-height:1.75}.tb-pitch-map{display:flex;flex-direction:column;align-items:center}.tb-pitch-origin,.tb-pitch-core,.tb-pitch-outcome{text-align:center}.tb-pitch-origin small,.tb-pitch-core small,.tb-pitch-outcome small{display:block;color:#537a9d;font-size:.62rem;font-weight:800;letter-spacing:.12em}.tb-pitch-origin strong{display:block;margin-top:.4rem;color:#173860;font-family:'Chakra Petch',sans-serif;font-size:1.35rem}.tb-pitch-line{width:2px;height:2.6rem;overflow:hidden;background:#bdd8ee}.tb-pitch-line i{display:block;width:100%;height:35%;background:linear-gradient(#2171d0,#26c5aa);animation:tb-pitch-pulse 1.6s ease-in-out infinite}.tb-pitch-core{display:flex;align-items:center;gap:.75rem;border-radius:999px;padding:.8rem 1.1rem;background:linear-gradient(135deg,#e3fbf6,#f9ffff);box-shadow:0 0 0 6px rgba(43,205,183,.1)}.tb-pitch-core>span{display:grid;place-items:center;width:2.7rem;height:2.7rem;border-radius:50%;background:linear-gradient(135deg,#2171d0,#26c5aa);color:#fff;font-family:'Chakra Petch',sans-serif;font-weight:800}.tb-pitch-core strong{display:block;margin-top:.2rem;color:#137c80;font-family:'Chakra Petch',sans-serif;font-size:1.18rem}.tb-pitch-compare{display:flex;flex-wrap:wrap;justify-content:center;gap:.45rem;margin:1.1rem 0;color:#597998;font-size:.72rem;text-align:center}.tb-pitch-compare b{color:#1ba8aa}.tb-pitch-compare strong{color:#167d83}.tb-pitch-split,.tb-pitch-merge{display:grid;grid-template-columns:repeat(3,1fr);width:min(100%,52rem);height:2.5rem}.tb-pitch-split i,.tb-pitch-merge i{position:relative;border-top:2px solid #bdd8ee}.tb-pitch-split i:after,.tb-pitch-merge i:after{content:'';position:absolute;left:50%;top:0;width:2px;height:100%;background:#bdd8ee}.tb-product-streams{display:grid;gap:1.1rem;width:100%}.tb-product-stream{position:relative;padding:1rem .4rem;text-align:center}.tb-stream-no{display:inline-grid;place-items:center;width:2.1rem;height:2.1rem;border:1px solid #95dcd2;border-radius:50%;color:#167d83;font-family:'Chakra Petch',sans-serif;font-size:.75rem;font-weight:800}.tb-product-stream small{display:block;margin-top:.65rem;color:#587d9f;font-size:.62rem;font-weight:800;letter-spacing:.1em}.tb-product-stream h2{margin-top:.35rem;color:#15375f;font-family:'Chakra Petch',sans-serif;font-size:1.35rem}.tb-product-stream p{margin-top:.35rem;color:#1b9a9f;font-size:.82rem;font-weight:800}.tb-product-stream div{margin:1rem auto 0;max-width:15rem;color:#587898;font-size:.78rem;line-height:1.55}.tb-pitch-shared{max-width:50rem;border-top:1px solid #b9dced;padding-top:1.1rem;color:#286184;font-size:.76rem;font-weight:800;text-align:center}.tb-pitch-shared b{padding:0 .4rem;color:#1dbba5}.tb-pitch-outcome{border-radius:999px;padding:.95rem 1.25rem;background:#e8fbf6}.tb-pitch-outcome span{display:inline-block;width:.6rem;height:.6rem;border-radius:50%;background:#1dc6a9;box-shadow:0 0 0 .35rem rgba(29,198,169,.13);animation:tb-outcome-pulse 2s infinite}.tb-pitch-outcome strong{display:block;margin-top:.3rem;color:#137c80;font-family:'Chakra Petch',sans-serif;font-size:1.08rem}.tb-customers{background:#fff}.tb-customers h2{margin-top:.8rem;color:#133157;font-family:'Chakra Petch',sans-serif;font-size:clamp(1.8rem,3vw,2.5rem)}.tb-customers p{color:#537595;font-size:.88rem}.tb-customer-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.8rem}.tb-customer-logo{display:grid;place-items:center;min-height:6.7rem;border:1px solid #d1e4f5;border-radius:1rem;background:#fafdff;transition:transform .25s ease}.tb-customer-logo:hover{transform:translateY(-5px)}.tb-customer-logo img{max-width:78%;max-height:3rem;object-fit:contain}.tb-motion-ready .tb-pitch-reveal{opacity:0;transform:translateY(20px);transition:opacity .7s ease,transform .7s ease}.tb-motion-ready .tb-pitch-reveal.tb-visible{opacity:1;transform:none}@keyframes tb-pitch-pulse{from{transform:translateY(-115%)}to{transform:translateY(320%)}}@keyframes tb-outcome-pulse{70%{box-shadow:0 0 0 .65rem rgba(29,198,169,0)}100%{box-shadow:0 0 0 0 rgba(29,198,169,0)}}@media(min-width:768px){.tb-product-streams{grid-template-columns:repeat(3,1fr)}.tb-customer-grid{grid-template-columns:repeat(4,minmax(0,1fr))}}@media(max-width:767px){.tb-pitch-split,.tb-pitch-merge{display:none}.tb-product-streams{margin-top:1rem}}@media(prefers-reduced-motion:reduce){*,*:before,*:after{animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important}}
        /* Compact customer strip and interactive flow signals. */
        .tb-customers{padding:1.15rem!important}
        .tb-customer-grid{grid-template-columns:repeat(3,minmax(0,1fr));gap:.55rem}
        .tb-customer-logo{min-height:4.6rem;border-radius:.7rem}
        .tb-customer-logo img{max-width:76%;max-height:2.2rem}
        .tb-pitch-split i,.tb-pitch-merge i{overflow:hidden}
        /* The connectors and the three product lanes share one width, so every vertical pulse lands on its product. */
        .tb-product-streams{width:min(100%,52rem)}
        .tb-pitch-split i:before,.tb-pitch-merge i:before{content:'';position:absolute;z-index:2;top:-.7rem;left:calc(50% - 3px);width:6px;height:.82rem;border-radius:999px;background:linear-gradient(#1677d2,#24c6aa);box-shadow:0 0 10px rgba(22,119,210,.9),0 0 18px rgba(36,198,170,.75);animation:tb-branch-spark 2.1s linear infinite}
        .tb-pitch-split i:nth-child(2):before,.tb-pitch-merge i:nth-child(2):before{animation-delay:.5s}
        .tb-pitch-split i:nth-child(3):before,.tb-pitch-merge i:nth-child(3):before{animation-delay:1s}
        .tb-pitch-split i:before,.tb-pitch-merge i:before{transition:opacity .25s ease,filter .25s ease}
        .tb-pitch-map:has(.tb-product-stream:nth-child(1):hover) .tb-pitch-split i:not(:nth-child(1)):before,.tb-pitch-map:has(.tb-product-stream:nth-child(2):hover) .tb-pitch-split i:not(:nth-child(2)):before,.tb-pitch-map:has(.tb-product-stream:nth-child(3):hover) .tb-pitch-split i:not(:nth-child(3)):before{opacity:.14;filter:saturate(.25)}
        .tb-pitch-map:has(.tb-product-stream:nth-child(1):hover) .tb-pitch-split i:nth-child(1):before,.tb-pitch-map:has(.tb-product-stream:nth-child(2):hover) .tb-pitch-split i:nth-child(2):before,.tb-pitch-map:has(.tb-product-stream:nth-child(3):hover) .tb-pitch-split i:nth-child(3):before{background:#1267bd;box-shadow:0 0 16px #24c6aa,0 0 28px #1267bd}
        .tb-product-stream{transition:transform .3s ease}
        .tb-product-stream:before{content:'';position:absolute;z-index:3;left:calc(50% - .18rem);top:-2.6rem;width:.36rem;height:.82rem;border-radius:999px;background:#fff;box-shadow:0 0 10px #25c8ae,0 0 22px #2171d0;opacity:0;pointer-events:none}
        .tb-product-stream:hover:before{opacity:1;animation:tb-target-signal 1s linear infinite}
        .tb-product-stream:hover{transform:translateY(-7px)}
        .tb-product-stream:hover .tb-stream-no{background:#1dbda7;color:#fff;box-shadow:0 0 18px rgba(29,189,167,.45)}
        @keyframes tb-branch-spark{from{transform:translateY(0)}to{transform:translateY(3.15rem)}}
        @keyframes tb-target-signal{from{transform:translateY(0)}to{transform:translateY(2.55rem)}}
        @media(min-width:768px){.tb-customer-grid{grid-template-columns:repeat(6,minmax(0,1fr))}}

        /* One sequenced pulse: input, core, three parallel platforms, merge, capabilities, outcome. */
        .tb-pitch-map{--tb-flow-cycle:10.5s}
        .tb-pitch-line i,.tb-pitch-split i:before,.tb-pitch-merge i:before,.tb-product-stream:before{animation:none!important;opacity:0}
        .tb-flow-input i{animation:tb-flow-input var(--tb-flow-cycle) linear infinite!important}
        .tb-flow-core i{animation:tb-flow-core var(--tb-flow-cycle) linear infinite!important}
        .tb-pitch-split i:before{top:0;left:calc(50% - 3px);width:6px;height:.82rem;background:linear-gradient(#1677d2,#24c6aa);animation:tb-flow-split var(--tb-flow-cycle) linear infinite!important}
        .tb-pitch-merge i:before{top:0;left:calc(50% - 3px);width:6px;height:.82rem;background:linear-gradient(#1677d2,#24c6aa);animation:tb-flow-merge var(--tb-flow-cycle) linear infinite!important}
        .tb-flow-output i{animation:tb-flow-output var(--tb-flow-cycle) linear infinite!important}
        .tb-product-stream:hover{transform:translateY(-7px)}
        .tb-product-stream:hover .tb-stream-no{background:transparent;color:#167d83;box-shadow:none}
        @keyframes tb-flow-input{0%,1%{opacity:0;transform:translateY(-115%)}2%{opacity:1}10%{opacity:1;transform:translateY(320%)}11%,100%{opacity:0;transform:translateY(320%)}}
        @keyframes tb-flow-core{0%,14%{opacity:0;transform:translateY(-115%)}15%{opacity:1}24%{opacity:1;transform:translateY(320%)}25%,100%{opacity:0;transform:translateY(320%)}}
        @keyframes tb-flow-split{0%,29%{opacity:0;transform:translateY(-105%)}30%{opacity:1}41%{opacity:1;transform:translateY(310%)}42%,100%{opacity:0;transform:translateY(310%)}}
        @keyframes tb-flow-merge{0%,60%{opacity:0;transform:translateY(-105%)}61%{opacity:1}72%{opacity:1;transform:translateY(310%)}73%,100%{opacity:0;transform:translateY(310%)}}
        @keyframes tb-flow-output{0%,80%{opacity:0;transform:translateY(-115%)}81%{opacity:1}91%{opacity:1;transform:translateY(320%)}92%,100%{opacity:0;transform:translateY(320%)}}
        .tb-pitch-map:has(.tb-product-stream:hover){--tb-flow-cycle:9.4s}
        .tb-pitch-map:has(.tb-product-stream:hover) .tb-pitch-split i:before,.tb-pitch-map:has(.tb-product-stream:hover) .tb-pitch-merge i:before{animation:none!important;opacity:0!important}
        .tb-pitch-map:has(.tb-product-stream:nth-child(1):hover) .tb-pitch-split i:nth-child(1):before,.tb-pitch-map:has(.tb-product-stream:nth-child(1):hover) .tb-pitch-merge i:nth-child(1):before{animation:tb-flow-split var(--tb-flow-cycle) linear infinite!important;opacity:1!important}
        .tb-pitch-map:has(.tb-product-stream:nth-child(1):hover) .tb-pitch-merge i:nth-child(1):before{animation-name:tb-flow-merge!important}
        .tb-pitch-map:has(.tb-product-stream:nth-child(2):hover) .tb-pitch-split i:nth-child(2):before,.tb-pitch-map:has(.tb-product-stream:nth-child(2):hover) .tb-pitch-merge i:nth-child(2):before{animation:tb-flow-split var(--tb-flow-cycle) linear infinite!important;opacity:1!important}
        .tb-pitch-map:has(.tb-product-stream:nth-child(2):hover) .tb-pitch-merge i:nth-child(2):before{animation-name:tb-flow-merge!important}
        .tb-pitch-map:has(.tb-product-stream:nth-child(3):hover) .tb-pitch-split i:nth-child(3):before,.tb-pitch-map:has(.tb-product-stream:nth-child(3):hover) .tb-pitch-merge i:nth-child(3):before{animation:tb-flow-split var(--tb-flow-cycle) linear infinite!important;opacity:1!important}
        .tb-pitch-map:has(.tb-product-stream:nth-child(3):hover) .tb-pitch-merge i:nth-child(3):before{animation-name:tb-flow-merge!important}
        @media(prefers-reduced-motion:reduce){.tb-pitch-line i,.tb-pitch-split i:before,.tb-pitch-merge i:before{animation:none!important;opacity:0!important}}
    </style>
@endsection

@push('scripts')
    <script>
        (function(){if(!('IntersectionObserver' in window)||window.matchMedia('(prefers-reduced-motion: reduce)').matches)return;document.documentElement.classList.add('tb-motion-ready');var o=new IntersectionObserver(function(e){e.forEach(function(x){if(x.isIntersecting){x.target.classList.add('tb-visible');o.unobserve(x.target)}})},{threshold:.15});document.querySelectorAll('.tb-pitch-reveal').forEach(function(x){o.observe(x)})})();
    </script>
@endpush
