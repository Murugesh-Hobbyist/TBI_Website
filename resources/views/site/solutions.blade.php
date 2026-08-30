@extends('layouts.site')

@section('title', 'Solutions | TwinBot Innovations')
@section('meta_description', 'TwinBot delivers retrofit modernization, IoT monitoring, custom electronics, dashboards, data extraction, custom applications, integration, and smart vending automation.')

@section('content')
    <section class="tb-section pt-6 pb-16 md:pt-10">
        <div class="mx-auto max-w-6xl px-4">
            <div class="tb-solutions-flow tb-reveal p-6 md:p-10">
                <header class="mx-auto max-w-3xl text-center">
                    <span class="tb-solutions-kicker">TwinBot Solutions</span>
                    <h1>From operational challenge<br>to a system that works.</h1>
                    <p>Follow the solution tracks we build around real machines, data, and day-to-day work.</p>
                </header>
                <div class="tb-solutions-map mt-10">
                    <div class="tb-solutions-start">YOUR OPERATIONAL CHALLENGE</div>
                    @foreach ([
                        ['Retrofit Modernization', 'Upgrade legacy automation stacks with modern ECS architecture while retaining viable assets.'],
                        ['System Integration & Workflow Automation', 'Connect tools, data, machines, and repeated actions into one dependable flow.'],
                        ['Connected IoT Monitoring', 'Remote machine status, stock visibility, records, alerts, configuration, and reporting.'],
                        ['Custom Electronics', 'Purpose-built boards and interface modules for the electrical and mechanical requirement.'],
                        ['Custom Dashboards', 'Clear operational visibility, reports, and decision-ready metrics.'],
                        ['Screen Scraping & Data Extraction', 'Capture useful data from existing screens, portals, and manual workflows.'],
                        ['Custom Applications', 'Customer-specific software built around the real workflow.'],
                        ['Smart Vending Automation', 'Touchscreen, embedded control, dispensing logic, sensors, and payment-ready workflows.'],
                    ] as $index => $solution)
                        <article class="tb-solution-node">
                            <div class="tb-solution-card">
                                <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <h2>{{ $solution[0] }}</h2>
                                <p>{{ $solution[1] }}</p>
                            </div>
                            <i aria-hidden="true"></i>
                        </article>
                    @endforeach
                    <div class="tb-solutions-finish">RELIABLE AUTOMATION, BUILT FOR REAL WORK</div>
                </div>
            </div>
            <div class="tb-solutions-cta tb-reveal mt-8">
                <span class="tb-solutions-kicker">Bring your toughest automation problem</span>
                <h2>Let’s turn it into a practical system.</h2>
                <p>We combine embedded engineering, measurement expertise, and field reality to deliver systems that perform in production, not just in presentation decks.</p>
                <div class="mt-6 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('contact') }}" class="btn btn-primary">Book a Technical Call</a>
                    <a href="{{ route('projects.index') }}" class="btn btn-ghost">See Published Projects</a>
                </div>
            </div>
        </div>
    </section>
    <style>
        .tb-solutions-flow,.tb-solutions-cta{border:1px solid #c7def3;border-radius:1.7rem;box-shadow:0 22px 48px rgba(24,84,141,.12)}.tb-solutions-flow{position:relative;overflow:hidden;background:radial-gradient(circle at 50% 10%,rgba(38,204,184,.18),transparent 25%),linear-gradient(145deg,#fbfeff,#eaf6ff)}.tb-solutions-flow:before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(33,112,208,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(33,112,208,.055) 1px,transparent 1px);background-size:30px 30px}.tb-solutions-flow>*{position:relative;z-index:1}.tb-solutions-kicker{display:inline-flex;border:1px solid #b7d6f0;border-radius:999px;padding:.45rem .75rem;background:#f4fbff;color:#215788;font-size:.68rem;font-weight:800;letter-spacing:.11em;text-transform:uppercase}.tb-solutions-flow h1{margin-top:1rem;color:#133157;font-family:'Chakra Petch',sans-serif;font-size:clamp(2rem,4vw,3.5rem);line-height:1.08}.tb-solutions-flow header p{margin:1rem auto 0;color:#4b6d91;line-height:1.7}.tb-solutions-map{position:relative;margin-inline:auto;max-width:54rem;padding:0 0 .25rem}.tb-solutions-map:before{content:'';position:absolute;z-index:0;left:50%;top:2.4rem;bottom:2.4rem;width:2px;background:#bdd8ee}.tb-solutions-map:after{content:'';position:absolute;z-index:1;left:calc(50% - 3px);top:2.4rem;width:6px;height:1rem;border-radius:999px;background:linear-gradient(#2171d0,#26c5aa);box-shadow:0 0 12px rgba(33,113,208,.65),0 0 18px rgba(38,197,170,.55);animation:tb-solutions-pulse 7s linear infinite}.tb-solutions-start,.tb-solutions-finish{position:relative;z-index:2;margin-inline:auto;width:max-content;max-width:90%;border-radius:999px;padding:.7rem 1rem;background:#e8fbf6;color:#137c80;font-size:.68rem;font-weight:900;letter-spacing:.1em;text-align:center}.tb-solutions-finish{margin-top:.8rem;background:#eaf4ff;color:#215788}.tb-solution-node{position:relative;z-index:2;display:grid;grid-template-columns:1fr 4rem 1fr;align-items:center;min-height:7.1rem}.tb-solution-node i{grid-column:2;grid-row:1;justify-self:center;width:.8rem;height:.8rem;border:3px solid #effbff;border-radius:50%;background:#1fbba8;box-shadow:0 0 0 2px #7cdad0}.tb-solution-card{grid-column:1;grid-row:1;position:relative;max-width:22rem;padding:.75rem .95rem;transition:transform .3s ease,filter .3s ease}.tb-solution-card:after{content:'';position:absolute;top:50%;right:-2rem;width:2rem;height:1px;background:#bdd8ee}.tb-solution-node:nth-child(odd) .tb-solution-card{grid-column:3}.tb-solution-node:nth-child(odd) .tb-solution-card:after{right:auto;left:-2rem}.tb-solution-card span{color:#1aa5a5;font-family:'Chakra Petch',sans-serif;font-size:.72rem;font-weight:900;letter-spacing:.08em}.tb-solution-card h2{margin-top:.18rem;color:#15375f;font-family:'Chakra Petch',sans-serif;font-size:1.25rem;line-height:1.15}.tb-solution-card p{margin-top:.3rem;color:#587898;font-size:.8rem;line-height:1.5}.tb-solution-node:hover .tb-solution-card{transform:translateY(-7px) scale(1.025);filter:drop-shadow(0 12px 14px rgba(22,103,174,.15))}.tb-solution-node:hover i{animation:tb-solutions-node 1s ease-in-out infinite}.tb-solutions-cta{padding:2rem;text-align:center;background:linear-gradient(135deg,#fff,#f1fbff)}.tb-solutions-cta h2{margin-top:.8rem;color:#133157;font-family:'Chakra Petch',sans-serif;font-size:clamp(1.6rem,3vw,2.2rem)}.tb-solutions-cta p{margin:.8rem auto 0;max-width:45rem;color:#537595;line-height:1.7}@keyframes tb-solutions-pulse{from{top:2.4rem}to{top:calc(100% - 2.4rem)}}@keyframes tb-solutions-node{50%{box-shadow:0 0 0 8px rgba(31,187,168,.14)}}@media(max-width:767px){.tb-solutions-map:before,.tb-solutions-map:after{left:1rem}.tb-solution-node{grid-template-columns:2rem 1fr;min-height:auto;padding:1rem 0}.tb-solution-node i{grid-column:1}.tb-solution-card,.tb-solution-node:nth-child(odd) .tb-solution-card{grid-column:2}.tb-solution-card:after,.tb-solution-node:nth-child(odd) .tb-solution-card:after{display:none}.tb-solutions-map:after{animation-duration:9s}}@media(prefers-reduced-motion:reduce){.tb-solutions-map:after,.tb-solution-node:hover i{animation:none}}
    </style>
@endsection
