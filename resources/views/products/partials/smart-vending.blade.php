<div class="mt-6 grid gap-4 sm:grid-cols-2">
    @foreach ([
        ['title' => 'Automation layer', 'desc' => 'Touchscreen application, embedded controller, motor and sensor interfaces, product configuration, and machine-control logic.'],
        ['title' => 'Connected visibility', 'desc' => 'Optional IoT monitoring for machine status, stock, dispense events, faults, configuration, and operational reports.'],
        ['title' => 'OEM-ready integration', 'desc' => 'Clear electrical, mechanical, communication, and acceptance interfaces for cabinet fabricators and system integrators.'],
        ['title' => 'Payment-ready workflow', 'desc' => 'Transaction-specific payment flows that authorise dispensing only after authenticated backend confirmation.'],
    ] as $item)
        <div class="tb-panel-soft p-4">
            <h2 class="font-display text-lg text-[#122E53]">{{ $item['title'] }}</h2>
            <p class="mt-2 text-sm leading-relaxed text-[#4F6890]">{{ $item['desc'] }}</p>
        </div>
    @endforeach
</div>

<div class="mt-6 tb-panel-soft p-5">
    <h2 class="font-display text-xl text-[#122E53]">How a connected vending transaction works</h2>
    <ol class="mt-4 grid gap-2 text-sm leading-relaxed text-[#4F6890]">
        <li><strong>1.</strong> The customer selects an available product.</li>
        <li><strong>2.</strong> The platform creates an amount-specific order and QR.</li>
        <li><strong>3.</strong> The payment provider verifies the transaction.</li>
        <li><strong>4.</strong> The controller receives one paid dispense authorisation.</li>
        <li><strong>5.</strong> The selected mechanism dispenses and supported sensors record the result.</li>
        <li><strong>6.</strong> Stock, transaction, and machine status are updated.</li>
    </ol>
</div>

<div class="mt-6 tb-panel-soft p-5">
    <h2 class="font-display text-xl text-[#122E53]">Clear responsibility model</h2>
    <p class="mt-2 text-sm leading-relaxed text-[#4F6890]">TwinBot supplies automation and integration technology. An OEM or system integrator may build the enclosure and mechanical machine. The final vending operator stocks and prices products, supports consumers, and acts as merchant of record. Subject to provider approval, eligible customer payments are settled by the payment provider directly to the operator's verified bank account.</p>
    <p class="mt-3 text-sm leading-relaxed text-[#4F6890]">TwinBot does not ordinarily receive or hold the operator's vending-sale proceeds and does not claim payment-provider approval until confirmed in writing.</p>
    <a href="{{ route('policies.vending-payments') }}" class="mt-4 inline-flex text-sm font-bold text-[#1F6FD0] hover:text-[#16589F]">Read the vending payment policy</a>
</div>
