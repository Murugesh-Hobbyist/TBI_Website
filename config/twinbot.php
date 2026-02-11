<?php

return [
    'site' => [
        'name' => env('TWINBOT_SITE_NAME', 'TwinBot Innovations'),
        'domain' => env('TWINBOT_SITE_DOMAIN', 'twinbot.in'),
        'tagline' => env('TWINBOT_SITE_TAGLINE', 'Embedded Control Systems for modern industrial automation.'),
    ],

    'contact' => [
        'phone_display' => env('TWINBOT_PHONE_DISPLAY', '+91 6383931536'),
        'phone_tel' => env('TWINBOT_PHONE_TEL', '+916383931536'),
        'email_primary' => env('TWINBOT_EMAIL_PRIMARY', 'support@twinbot.in'),
        'email_sales' => env('TWINBOT_EMAIL_SALES', 'murugesh@twinbot.in'),
        'whatsapp_url' => env('TWINBOT_WHATSAPP_URL', 'https://api.whatsapp.com/send?phone=6383931536'),
        'location' => env('TWINBOT_LOCATION', 'Chennai, India'),
    ],

    'assets' => [
        'logo' => 'twinbot/brand/logo.png',
        'og_image' => 'twinbot/brand/eye.png',
        'favicon_32' => 'twinbot/icons/favicon-32x32.png',
        'favicon_192' => 'twinbot/icons/favicon-192x192.png',
        'apple_touch_icon' => 'twinbot/icons/apple-touch-icon.png',
        'ms_tile' => 'twinbot/icons/ms-tile-270x270.png',
        'hero_image' => 'twinbot/hero/automation.jpg',
        'about_team_image' => 'twinbot/about/team.png',
        'trusted_logos' => [
            'twinbot/brands/logo-das.png',
            'twinbot/brands/astroven.png',
            'twinbot/brands/wee.png',
            'twinbot/brands/brand-1000173653.png',
            'twinbot/brands/brand-29_06_17_120929.png',
            'twinbot/brands/brand-306078965.png',
            'twinbot/brands/brand-screenshot-08_23_46.png',
            'twinbot/brands/brand-screenshot-08_26_08.png',
            'twinbot/brands/brand-screenshot-16_26_53.png',
        ],
    ],

    // Fallback catalog used when DB is not configured (or unavailable).
    'products' => [
        [
            'slug' => 'digidial-console-8ch',
            'title' => 'DigiDial Console - 8CH',
            'series' => 'DigiDial Console Series',
            'summary' => 'Automated dimensional inspection system built around Mitutoyo Digimatic Dials. Captures measurements, compares tolerances, outputs OK/Fail, logs results, and simplifies operator effort.',
            'body' => "DigiDial Console is a purpose-built automated inspection system designed to measure casted or machined part dimensions using up to 8 Mitutoyo Digimatic Dials with 2-digit precision.\n\nIt captures real-time readings, compares them against predefined tolerance limits, and automatically determines Pass or Fail. It reduces manual error, ensures consistency, and stores every detail for inspection analysis.\n\nOptional IoTLink module outputs data via RS485 Modbus RTU for IoT integration.",
            'image' => 'twinbot/products/digidial-console-8ch.png',
        ],
        [
            'slug' => 'digidial-console-12ch',
            'title' => 'DigiDial Console - 12CH',
            'series' => 'DigiDial Console Series',
            'summary' => 'Automated dimensional inspection system built around Mitutoyo Digimatic Dials. Captures measurements, compares tolerances, outputs OK/Fail, logs results, and simplifies operator effort.',
            'body' => "DigiDial Console is a purpose-built automated inspection system designed to measure casted or machined part dimensions using up to 12 Mitutoyo Digimatic Dials with 2-digit precision.\n\nEquipped with a 10-inch capacitive touch display, it captures real-time readings, compares them against tolerance limits, and determines Pass/Fail automatically.\n\nOptional IoTLink module outputs data via RS485 Modbus RTU for IoT integration.",
            'image' => 'twinbot/products/digidial-console-12ch.png',
        ],
        [
            'slug' => 'digidial-console-16ch',
            'title' => 'DigiDial Console - 16CH',
            'series' => 'DigiDial Console Series',
            'summary' => 'Automated dimensional inspection system built around Mitutoyo Digimatic Dials. Captures measurements, compares tolerances, outputs OK/Fail, logs results, and simplifies operator effort.',
            'body' => "DigiDial Console is a purpose-built automated inspection system designed to measure casted or machined part dimensions using up to 16 Mitutoyo Digimatic Dials with 2-digit precision.\n\nEquipped with a 15-inch capacitive touch display, it captures real-time readings, compares them against tolerance limits, and determines Pass/Fail automatically.\n\nOptional IoTLink module outputs data via RS485 Modbus RTU for IoT integration.",
            'image' => 'twinbot/products/digidial-console-16ch.png',
        ],
        [
            'slug' => 'mitutoyo-digimatic-cable',
            'title' => 'Mitutoyo Digimatic Cable',
            'series' => 'Accessories',
            'summary' => '2-meter flat straight cable to connect Mitutoyo Digimatic measuring devices to PCs or data interfaces for flexible data transfer.',
            'body' => "The Mitutoyo Digimatic Cable (Flat Straight Type) is designed to connect Mitutoyo measuring devices with data output to a PC.\n\nThe cable supports both direct connections via USB (with USB Input Tool Direct Cables) and indirect connections through standard Digimatic cables paired with interface boxes, or wireless transmitters.\n\nNote: For each specific Digimatic instrument, refer to the official Mitutoyo documentation to select the appropriate cable.",
            'image' => 'twinbot/products/mitutoyo-digimatic-cable.png',
        ],
        [
            'slug' => 'fitsense-lite',
            'title' => 'FitSense Lite',
            'series' => 'FitSense Series',
            'summary' => 'Precision displacement measurement tool for essential industrial applications. Single probe, clear 4-digit display, compact and user-friendly design.',
            'body' => "FitSense Lite is a high-precision displacement measurement tool for essential industrial applications where simplicity and accuracy matter.\n\nKey Features:\n- Single probe measurement for accurate displacement readings\n- Clear 4-digit 7-segment display\n- Compact, lightweight, portable design\n- User-friendly interface (minimal training)\n- Durable for regular industrial use\n\nApplications:\n- Basic precision measurement tasks in manufacturing\n- Quality checks for displacement and tolerances\n- Entry-level solution for straightforward measurement workflows",
            'image' => 'twinbot/products/fitsense-lite.jpeg',
        ],
        [
            'slug' => 'fitsense-pro',
            'title' => 'FitSense Pro',
            'series' => 'FitSense Series',
            'summary' => 'Precision displacement measurement tool with 2-probe measurement and a 4.3-inch LCD display for clear visualization and reliable operation.',
            'body' => "FitSense Pro is a high-precision displacement measurement tool for industrial applications where simplicity and accuracy are paramount.\n\nKey Features:\n- 2 probe measurement for accurate displacement readings\n- 4.3-inch LCD display for clear visualization\n- Compact, lightweight, portable design\n- User-friendly interface (minimal training)\n- Durable for regular industrial use\n\nApplications:\n- Basic precision measurement tasks in manufacturing\n- Quality checks for displacement and tolerances\n- Entry-level solution for straightforward measurement workflows",
            'image' => 'twinbot/products/fitsense-pro.jpeg',
        ],
        [
            'slug' => 'fitsense-ultra',
            'title' => 'FitSense Ultra',
            'series' => 'FitSense Series',
            'summary' => 'Precision displacement measurement tool with 4-probe measurement and a 7-inch LCD display for clearer visualization and faster workflows.',
            'body' => "FitSense Ultra is a high-precision displacement measurement tool for industrial applications where simplicity and accuracy are paramount.\n\nKey Features:\n- 4 probe measurement for accurate displacement readings\n- 7-inch LCD display for clear visualization\n- Compact, lightweight, portable design\n- User-friendly interface (minimal training)\n- Durable for regular industrial use\n\nApplications:\n- Basic precision measurement tasks in manufacturing\n- Quality checks for displacement and tolerances\n- Entry-level solution for straightforward measurement workflows",
            'image' => 'twinbot/products/fitsense-ultra.jpeg',
        ],
    ],

    'product_groups' => [
        [
            'title' => 'DigiDial Console Series',
            'slugs' => [
                'digidial-console-8ch',
                'digidial-console-12ch',
                'digidial-console-16ch',
            ],
        ],
        [
            'title' => 'Accessories',
            'slugs' => [
                'mitutoyo-digimatic-cable',
            ],
        ],
        [
            'title' => 'FitSense Series',
            'slugs' => [
                'fitsense-lite',
                'fitsense-pro',
                'fitsense-ultra',
            ],
        ],
    ],

    'home' => [
        'plc_vs_ecs' => [
            [
                'aspect' => 'Cost & Maintenance',
                'plc' => 'Expensive, especially for complex setups with proprietary hardware; requires vendor-specific support and expensive spare parts.',
                'ecs' => 'Affordable, tailored for specific needs without industrial-grade costs; easier maintenance with relatively low-cost spare parts.',
            ],
            [
                'aspect' => 'Programming',
                'plc' => 'Primarily uses ladder logic, limiting functionality and flexibility.',
                'ecs' => 'Supports versatile programming (C, C++, Python), enabling advanced control logic.',
            ],
            [
                'aspect' => 'Size & Space',
                'plc' => 'Bulkier, requiring more control panel space.',
                'ecs' => 'Compact, with space-efficient designs perfect for tight environments.',
            ],
            [
                'aspect' => 'Reliability',
                'plc' => 'Proven reliability in harsh industrial environments.',
                'ecs' => 'Equally reliable with ruggedized designs for industrial applications.',
            ],
            [
                'aspect' => 'Scalability',
                'plc' => 'Scaling up can be costly and may require additional modules.',
                'ecs' => 'Easily scalable and flexible, adapting to growing needs.',
            ],
            [
                'aspect' => 'System Complexity',
                'plc' => 'Increased complexity with additional modules for custom setups.',
                'ecs' => 'Simpler architectures with consolidated functionality.',
            ],
            [
                'aspect' => 'Customization',
                'plc' => 'Limited flexibility, designed for standard industrial processes.',
                'ecs' => 'Fully customizable for specific applications and unique requirements.',
            ],
            [
                'aspect' => 'Integration',
                'plc' => 'Requires extra hardware for IoT, AI, or modern sensor integration.',
                'ecs' => 'Seamless integration with IoT, AI, and advanced technologies from the start.',
            ],
            [
                'aspect' => 'Environmental Impact',
                'plc' => 'High energy consumption due to fixed industrial-grade components.',
                'ecs' => 'Energy-efficient specified designs reduce operational costs and environmental impact.',
            ],
        ],
    ],

    'faqs' => [
        [
            'q' => 'What services does TwinBot Innovations offer?',
            'a' => 'We specialize in industrial automation, robotics, embedded control systems, and custom solutions tailored to your needs.',
        ],
        [
            'q' => 'How can I get a quote for a project?',
            'a' => 'To receive a personalized quote, please email us with the details of your project.',
        ],
        [
            'q' => 'What industries do you serve?',
            'a' => 'We serve a variety of industries, including manufacturing, logistics, and technology, providing innovative automation solutions tailored to each sector.',
        ],
        [
            'q' => 'Do you offer support after purchase?',
            'a' => 'Yes, we provide comprehensive support and maintenance for our products. Our team is always here to assist you with any questions or issues.',
        ],
        [
            'q' => 'Can you customize solutions for my specific needs?',
            'a' => 'Absolutely. We build user-specific embedded motherboards and automation solutions to meet unique requirements.',
        ],
        [
            'q' => 'How long does the development process take?',
            'a' => 'Timelines depend on complexity. We provide an estimate once we understand your requirements.',
        ],
        [
            'q' => 'What is your return policy?',
            'a' => 'If you encounter any issues, contact us within 30 days of purchase to discuss your concerns.',
        ],
        [
            'q' => 'How do I stay updated on your latest products and innovations?',
            'a' => 'Follow our social channels to receive the latest updates and news from TwinBot Innovations.',
        ],
        [
            'q' => 'Where are you located?',
            'a' => 'We are based in Chennai, and we serve clients in India.',
        ],
        [
            'q' => 'How can I contact you?',
            'a' => 'Email support@twinbot.in or call +91 6383931536.',
        ],
    ],
];

