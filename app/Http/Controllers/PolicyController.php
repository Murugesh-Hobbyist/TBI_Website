<?php

namespace App\Http\Controllers;

class PolicyController extends Controller
{
    public function terms()
    {
        return $this->render('terms');
    }

    public function privacy()
    {
        return $this->render('privacy');
    }

    public function refunds()
    {
        return $this->render('refunds');
    }

    public function shipping()
    {
        return $this->render('shipping');
    }

    public function warranty()
    {
        return $this->render('warranty');
    }

    public function vendingPayments()
    {
        return $this->render('vending-payments');
    }

    public function grievance()
    {
        return $this->render('grievance');
    }

    private function render(string $policy)
    {
        $contact = config('twinbot.contact');
        $policies = $this->definitions($contact);
        abort_unless(isset($policies[$policy]), 404);

        return view('site.policy', $policies[$policy] + [
            'lastUpdated' => '27 August 2026',
            'contact' => $contact,
        ]);
    }

    private function definitions(array $contact): array
    {
        $support = (string) ($contact['email_primary'] ?? 'support@twinbot.in');
        $phone = (string) ($contact['phone_display'] ?? '');

        return [
            'terms' => [
                'title' => 'Terms and Conditions',
                'meta' => 'Terms governing use of the TwinBot Innovations website, enquiries, products, software, and engineering services.',
                'intro' => 'These terms govern use of twinbot.in and enquiries made to TwinBot Innovations. An accepted quotation, work order, licence, or service agreement may contain additional terms and will govern the applicable order if there is a conflict.',
                'sections' => [
                    ['title' => 'Business scope', 'paragraphs' => ['TwinBot develops embedded automation hardware, firmware, application software, IoT services, and engineering support. For vending solutions, TwinBot may supply the automation layer while an independent OEM or integrator supplies the enclosure, mechanical system, and final assembly.']],
                    ['title' => 'Enquiries and quotations', 'paragraphs' => ['Submitting an enquiry does not create a contract. Scope, compatibility, taxes, freight, installation, third-party services, delivery commitments, and recurring fees are confirmed in the applicable written quotation or order.']],
                    ['title' => 'Customer and operator responsibilities', 'paragraphs' => ['Customers must provide accurate requirements and approve relevant specifications. Vending operators remain responsible for lawful product sourcing, prices, taxes, stock, expiry control, licences, consumer support, and refunds for products sold through their machines.']],
                    ['title' => 'Payment services', 'paragraphs' => ['Payment functionality may use an approved third-party payment service provider. Merchant approval, transaction processing, settlements, refunds, disputes, fees, and availability remain subject to the provider and the operator merchant agreement. TwinBot does not ordinarily hold vending-sale proceeds.']],
                    ['title' => 'Software, acceptable use, and third parties', 'paragraphs' => ['TwinBot retains its pre-existing software, firmware, designs, documentation, trademarks, and know-how. Users must not misuse platform access, payment states, credentials, machine identifiers, or security controls. Connectivity, cloud, payment, and messaging services may be governed by third-party terms.']],
                    ['title' => 'Contact', 'paragraphs' => ["Questions about these terms can be sent to {$support}".($phone !== '' ? " or {$phone}." : '.')]],
                ],
            ],
            'privacy' => [
                'title' => 'Privacy Policy',
                'meta' => 'How TwinBot Innovations handles information submitted through its website, enquiries, support, and connected automation services.',
                'intro' => 'This policy explains how TwinBot Innovations handles information received through its website, business enquiries, support interactions, and authorised connected services.',
                'sections' => [
                    ['title' => 'Information we may collect', 'items' => ['Contact and company details submitted in an enquiry', 'Project, quotation, order, and support information', 'Machine identifiers, operational events, and fault records for authorised connected deployments', 'Basic security, browser, and website-usage information']],
                    ['title' => 'How information is used', 'items' => ['Respond to enquiries and prepare quotations', 'Supply, configure, and support products', 'Operate authorised platform accounts and investigate machine events', 'Maintain security, audit records, and legal or accounting records']],
                    ['title' => 'Payment and identity data', 'paragraphs' => ['Payments and merchant verification are handled through approved payment-service workflows. Do not submit a UPI PIN, card PIN, OTP, password, complete card details, bank credentials, PAN, Aadhaar, or KYC documents through ordinary website forms.']],
                    ['title' => 'Sharing, retention, and security', 'paragraphs' => ['Relevant information may be shared with the responsible operator, OEM, payment provider, hosting or support vendor, professional adviser, or authority when reasonably required. TwinBot uses access controls, encrypted transport, logging, and other reasonable safeguards, and retains records only as required for business, security, contractual, or legal purposes.']],
                    ['title' => 'Privacy requests', 'paragraphs' => ["For access, correction, deletion, consent, or privacy concerns, contact {$support}".($phone !== '' ? " or {$phone}." : '.')]],
                ],
            ],
            'refunds' => [
                'title' => 'Refund and Cancellation Policy',
                'meta' => 'Refund and cancellation principles for TwinBot products, engineering services, subscriptions, and vending-machine transactions.',
                'intro' => 'Refund and cancellation eligibility depends on the accepted quotation, order, completed work, product condition, and applicable law. This page does not replace order-specific written terms.',
                'sections' => [
                    ['title' => 'Orders and custom work', 'paragraphs' => ['Unaccepted quotations may be cancelled without charge. After acceptance, completed engineering, customisation, procurement, activated licences, consumed support, and non-recoverable third-party costs may affect cancellation or refund eligibility. Custom-built hardware may not be cancellable after approval or production begins.']],
                    ['title' => 'Defective or incorrect supply', 'paragraphs' => ['Report damage, incorrect items, or functional concerns promptly with the invoice, serial number, photographs, and fault description. TwinBot may troubleshoot, repair, replace, or refund according to the accepted order, warranty, and applicable law.']],
                    ['title' => 'Vending-machine purchases', 'paragraphs' => ['Products sold through a vending machine are sold by the operator identified on that machine. Failed-dispense, product-quality, replacement, and retail-refund requests must first be raised with that operator. TwinBot may provide technical records to the operator but cannot independently refund funds it did not receive.']],
                    ['title' => 'Contact', 'paragraphs' => ["Send order-related requests to {$support} with the relevant order or invoice details."]],
                ],
            ],
            'shipping' => [
                'title' => 'Shipping and Delivery Policy',
                'meta' => 'Shipping, delivery, inspection, installation, and commissioning information for TwinBot products and projects.',
                'intro' => 'Delivery locations, dispatch estimates, packing, freight, taxes, insurance, installation, and commissioning are defined in the applicable quotation or order acknowledgement.',
                'sections' => [
                    ['title' => 'Delivery scope and schedule', 'paragraphs' => ['Custom automation schedules begin after the agreed advance, confirmed requirements, and necessary customer approvals. Changes to inputs, site readiness, enclosure design, or third-party component availability may revise the schedule.']],
                    ['title' => 'Charges and receipt inspection', 'paragraphs' => ['Packing, freight, insurance, installation, duties, and taxes are included only when stated in writing. Recipients should inspect shipments promptly and report visible damage or shortage with photographs and shipment details.']],
                    ['title' => 'Installation and commissioning', 'paragraphs' => ['Delivery does not include installation unless specified. The customer or OEM must provide safe access, suitable power, network connectivity, mechanical readiness, and authorised personnel.']],
                    ['title' => 'Contact', 'paragraphs' => ["For delivery questions, contact {$support}".($phone !== '' ? " or {$phone}." : '.')]],
                ],
            ],
            'warranty' => [
                'title' => 'Warranty and Support Policy',
                'meta' => 'Warranty coverage, exclusions, support, and service information for TwinBot products and automation projects.',
                'intro' => 'The warranty period and included support are stated in the accepted quotation or order. Custom projects may include separate acceptance, maintenance, software, and field-service terms.',
                'sections' => [
                    ['title' => 'Covered support', 'paragraphs' => ['Subject to the applicable order, support may include remote diagnosis, configuration assistance, firmware correction, or repair or replacement of covered TwinBot-supplied components.']],
                    ['title' => 'Typical exclusions', 'items' => ['Incorrect wiring, voltage, earthing, or installation', 'Mechanical overload or unsuitable dispensing design', 'Environmental exposure outside stated ratings', 'Accident, misuse, vandalism, unauthorised repair, or modification', 'Third-party cabinet, refrigeration, motor, network, telecom, or payment-provider failure', 'Normal wear, consumables, and operation outside documented limits']],
                    ['title' => 'Support process', 'paragraphs' => ['Provide the invoice, serial or machine ID, fault description, logs, and photographs where available. Remote diagnosis may be required before a return or site visit is authorised. On-site service and travel are chargeable unless included in the order.']],
                    ['title' => 'Contact', 'paragraphs' => ["Request support at {$support}".($phone !== '' ? " or {$phone}." : '.')]],
                ],
            ],
            'vending-payments' => [
                'title' => 'Vending Payment and Failed-Dispense Policy',
                'meta' => 'Payment verification, merchant responsibility, failed-dispense handling, and operator onboarding for TwinBot-enabled vending systems.',
                'intro' => 'This page explains the standard technical and responsibility model for TwinBot-enabled vending systems. The operator displayed on a machine is the seller and merchant of record for products purchased from that machine.',
                'sections' => [
                    ['title' => 'Payment verification', 'paragraphs' => ['A product is authorised for dispensing only after authenticated backend confirmation of a successful transaction. A QR scan, screenshot, or customer success screen alone is not machine authorisation. One paid order must not intentionally generate repeated dispense authorisations.']],
                    ['title' => 'Settlement and merchant responsibility', 'paragraphs' => ['Subject to payment-provider approval, eligible funds are settled by the provider directly to the final operator\'s verified bank account. TwinBot supplies automation and integration technology and does not ordinarily receive or hold vending-sale proceeds. Each operator is responsible for merchant verification, products, pricing, taxes, consumer support, and refunds.']],
                    ['title' => 'Payment succeeds but no product is delivered', 'items' => ['Record the machine ID, transaction reference, amount, date, and time', 'Do not share a UPI PIN, card PIN, OTP, password, or complete bank credentials', 'Contact the operator using the details displayed on the machine', 'The operator verifies payment and machine records and initiates the applicable refund or resolution']],
                    ['title' => 'Merchant onboarding and security', 'paragraphs' => ['The payment provider controls KYC, approval, fees, settlement, suspension, and termination. Operators must provide accurate information, protect dashboard access, notify TwinBot before machine reassignment, and must not use the platform for prohibited products, transaction laundering, or fraudulent activity. TwinBot cannot guarantee provider approval.']],
                    ['title' => 'Escalation', 'paragraphs' => ["If the responsible operator cannot be reached, contact {$support} with the machine ID and transaction reference. TwinBot will assist with technical identification but cannot independently refund funds it did not receive."]],
                ],
            ],
            'grievance' => [
                'title' => 'Grievance Redressal',
                'meta' => 'How to raise business, privacy, technical, and vending-machine concerns with TwinBot Innovations.',
                'intro' => 'TwinBot aims to identify the responsible party and provide a practical response or escalation path for business, privacy, and technical concerns.',
                'sections' => [
                    ['title' => 'Contact TwinBot support', 'paragraphs' => ["Email: {$support}".($phone !== '' ? "\nPhone: {$phone}" : '')."\nLocation: ".($contact['location'] ?? 'Chennai, India')]],
                    ['title' => 'Information to include', 'items' => ['Your name and contact details', 'Machine ID, product serial number, or TwinBot order number', 'Transaction reference, date, time, and amount where applicable', 'A clear description and relevant non-sensitive photographs or documents']],
                    ['title' => 'Resolution approach', 'paragraphs' => ['TwinBot will review whether the concern relates to TwinBot, the vending operator, an OEM, or a payment provider and may request additional evidence. Product quality and retail-refund complaints remain primarily the responsibility of the operator that stocked and sold the product. TwinBot will support technical investigation for TwinBot-enabled systems.']],
                    ['title' => 'Protect your information', 'paragraphs' => ['Never send a UPI PIN, card PIN, OTP, password, complete card details, or complete bank credentials in a grievance request.']],
                ],
            ],
        ];
    }
}
