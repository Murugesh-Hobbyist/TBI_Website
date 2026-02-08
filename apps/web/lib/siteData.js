// Centralized content used across pages.
// Keep it static so the site can be exported and hosted without a Node runtime.

export const SITE = {
  brand: {
    name: 'TwinBot Innovations',
    shortName: 'TwinBot',
    domain: 'twinbot.in',
    tagline: 'Embedded Control Systems (ECS) and product-grade automation for modern manufacturing.'
  },
  contact: {
    email: 'support@twinbot.in',
    phoneDisplay: '+91 63839 31536',
    phoneE164: '+916383931536',
    whatsappUrl: 'https://api.whatsapp.com/send?phone=6383931536',
    location: 'Chennai, India'
  },
  hero: {
    eyebrow: 'Industrial Automation',
    headline: 'Say Goodbye to PLCs. Step into the Future with ECS.',
    subhead:
      'Replace high-cost PLC stacks with purpose-built Embedded Control Systems (ECS) and Sail OS dashboards that make automation simpler, faster, and easier to maintain.',
    ctas: [
      { href: '/products', label: 'Explore Products' },
      { href: '/quote-request', label: 'Request a Quote', variant: 'outline' }
    ]
  },
  highlights: {
    intro:
      'Programmable Logic Controllers (PLCs) have powered industry for decades, but they can be costly, rigid, and over-complex for many modern use cases. ECS offers a compact, flexible, and integration-ready path forward.',
    plcVsEcs: [
      {
        aspect: 'Cost and Maintenance',
        plc:
          'Higher cost with proprietary hardware; vendor-specific support and expensive spare parts.',
        ecs:
          'Lower fixed cost for the same outcome; easier maintenance and more affordable spare parts.'
      },
      {
        aspect: 'Programming',
        plc: 'Commonly ladder-logic focused; limits advanced workflows.',
        ecs: 'Supports modern stacks (C/C++/Python) for richer logic and integrations.'
      },
      {
        aspect: 'Size and Space',
        plc: 'Bulkier, needs larger control panel footprint.',
        ecs: 'Compact designs fit tight panels and edge enclosures.'
      },
      {
        aspect: 'Reliability',
        plc: 'Proven for harsh industrial environments.',
        ecs: 'Industrial-grade designs can match reliability with ruggedized hardware.'
      },
      {
        aspect: 'Scalability',
        plc: 'Scaling can be costly and requires extra modules.',
        ecs: 'Flexible scaling with simpler expansion paths.'
      },
      {
        aspect: 'System Complexity',
        plc: 'Custom setups often add modules and complexity.',
        ecs: 'Consolidated architectures keep systems simpler.'
      },
      {
        aspect: 'Customization',
        plc: 'Designed for standard processes; less tailor-fit.',
        ecs: 'Fully customizable for your exact process and workflow.'
      },
      {
        aspect: 'Integration',
        plc: 'Often needs add-on hardware for IoT/AI and modern sensors.',
        ecs: 'Integration-ready for IoT, analytics, and modern connectivity.'
      },
      {
        aspect: 'Environmental Impact',
        plc: 'Higher energy draw with fixed industrial-grade components.',
        ecs: 'Energy-efficient designs reduce operating cost and footprint.'
      }
    ],
    keyFeatures: [
      {
        title: 'Seamless Integration',
        desc:
          'Designed to slot into real production environments with clean wiring, clear UI, and stable protocols.'
      },
      {
        title: 'Easy to Use',
        desc:
          'Operator-first workflows that reduce judgement calls and make outcomes consistent.'
      },
      {
        title: 'Cross Compatibility',
        desc:
          'Built for retrofit and coexistence with existing sensors, tooling, and shop-floor constraints.'
      },
      {
        title: 'Scalable',
        desc:
          'Start small and expand without redesigning the whole control architecture.'
      },
      {
        title: 'Secure',
        desc:
          'Lock down settings and protect sensitive parameters with role-based access and guarded screens.'
      },
      {
        title: 'Robust and Cost-Effective',
        desc:
          'Durable hardware and practical packaging to deliver dependable automation without overpaying.'
      }
    ],
    process: [
      {
        step: 'Connect',
        desc:
          'Share your requirements and desired features. We design a solution tailored to your workflow.'
      },
      {
        step: 'Integrate',
        desc:
          'We propose a timeline and deliver a personalized control panel after you approve the plan.'
      },
      {
        step: 'Streamline',
        desc:
          'We install, automate, and integrate into live production with stable results and minimal downtime.'
      }
    ]
  },
  sailOs: {
    title: 'Sail OS: Clarity for Industrial Automation',
    intro:
      'Sail OS is a custom-built operating system for industrial automation. It converts complex factory signals into dashboards, insights, and actions your team can understand quickly.',
    screenshotUrl: 'https://twinbot.in/wp-content/uploads/2025/07/Screenshot-13-07-2025-07_13_05.png',
    features: [
      {
        title: 'Customizable and Intuitive Interface',
        desc:
          'Tailor control panels for your factory. Simple UI works for technical and non-technical teams.'
      },
      {
        title: 'Immersive HDMI Support',
        desc:
          'High-resolution views on external displays for clear monitoring on the shop floor.'
      },
      {
        title: 'Real-Time Visualizations and Troubleshooting',
        desc:
          'Dashboards show what changed and where to look so downtime stays low.'
      },
      {
        title: 'Data Logging and Advanced Reporting',
        desc:
          'Track, store, and analyze process data for audits, optimization, and future planning.'
      },
      {
        title: 'Seamless Device Integration',
        desc:
          'Connect and control sensors and devices as one cohesive system.'
      },
      {
        title: 'Scalable and Energy-Efficient',
        desc:
          'Scale to new lines while reducing power use and operating cost where possible.'
      }
    ]
  },
  solutions: {
    headline: 'Solutions That Replace PLC Complexity',
    intro:
      'We build embedded control systems and measurement workstations that eliminate bulky PLC stacks while improving traceability and decision speed.',
    areas: [
      {
        title: 'Embedded Control Panels (ECS)',
        desc:
          'Compact control systems that reduce panel size, wiring, and long-term maintenance while keeping industrial-grade reliability.'
      },
      {
        title: 'Automated Gauging and Inspection',
        desc:
          'Multi-channel measurement consoles with tolerance checks, OK/Fail actions, and secure logging.'
      },
      {
        title: 'Sail OS Dashboards',
        desc:
          'Shop-floor dashboards that translate sensor data into operator-friendly views and actionable alerts.'
      },
      {
        title: 'Retrofit and Integration',
        desc:
          'Integrate ECS with existing sensors, jigs, and lines to modernize without a full replacement.'
      }
    ],
    sampleProjects: [
      {
        title: '4-in-1 Multi Gauge ECS',
        desc:
          'A single ECS workstation that inspects multiple dimensions, logs every cycle, and guides operators with visual cues.'
      },
      {
        title: 'DigiDial Console Line',
        desc:
          'Multi-channel Digimatic inspection consoles for fast cycle verification and traceable results.'
      },
      {
        title: 'FitSense Station',
        desc:
          'Compact displacement measurement stations optimized for quick operator decisions.'
      }
    ]
  },
  about: {
    headline: 'Who We Are',
    missionShort:
      'To replace high-cost PLC systems with advanced Embedded Control Systems (ECS) that are cost-effective and reliable, making modern automation accessible and sustainable.',
    team: [
      { name: 'Murugesh', role: 'Founder and CEO' },
      { name: 'Lingappan', role: 'Co-Founder' },
      { name: 'Karthikeyan', role: 'Seed Investor' }
    ],
    values: [
      {
        title: 'Integrity',
        desc:
          'Transparency and honesty in how we design, deliver, and support systems that factories depend on.'
      },
      {
        title: 'Safety',
        desc:
          'Safety-first engineering so solutions stay secure for people, equipment, and the environment.'
      },
      {
        title: 'Customer Support',
        desc:
          'We stay close after delivery with clear documentation, fast issue resolution, and practical guidance.'
      },
      {
        title: 'Innovation',
        desc:
          'We push for authentic, cutting-edge solutions that solve real constraints on the floor.'
      }
    ],
    quote:
      'Innovation is not just about technology; it is about daring to dream and crafting tomorrow\'s solutions today.'
  },
  pricing: {
    intro:
      'Pricing is designed to deliver strong value without compromising reliability. Most automation needs are unique, so we offer configurable packages that align to your requirements.',
    points: [
      'Competitive pricing compared to traditional auto-solution providers.',
      'Cost savings by replacing costly PLC stacks with ECS.',
      'Customizable packages based on features and integration scope.'
    ],
    includedFeatures: [
      { title: 'Support', desc: 'Prompt help and guidance to keep systems running smoothly.' },
      { title: 'Durable Solutions', desc: 'Reliable hardware built for industrial environments.' },
      { title: 'Scalable', desc: 'Expand capabilities without compromising performance.' },
      { title: 'Enclosure', desc: 'Secure packaging with practical enclosures for shop-floor use.' },
      { title: 'Protection', desc: 'Options for water and dust protection to extend longevity.' }
    ]
  },
  trust: {
    title: 'Trusted By Teams In Production',
    logos: [
      { src: 'https://twinbot.in/wp-content/uploads/2024/09/306078965_378950131092188_903240023780148328_n-removebg-preview.png', alt: 'Trusted company logo' },
      { src: 'https://twinbot.in/wp-content/uploads/2024/09/Screenshot_-_26-09-2024___16_26_53-removebg-preview.png', alt: 'Trusted company logo' },
      { src: 'https://twinbot.in/wp-content/uploads/2024/11/Screenshot_-_28-11-2024___08_23_46-removebg-preview.png', alt: 'Trusted company logo' },
      { src: 'https://twinbot.in/wp-content/uploads/2024/11/Screenshot_-_28-11-2024___08_26_08-removebg-preview.png', alt: 'Trusted company logo' },
      { src: 'https://twinbot.in/wp-content/uploads/2024/11/29_06_17_120929_Logo-removebg-preview.png', alt: 'Trusted company logo' },
      { src: 'https://twinbot.in/wp-content/uploads/2025/04/1000173653-removebg-preview.png', alt: 'Trusted company logo' },
      { src: 'https://twinbot.in/wp-content/uploads/2025/06/logo-das.png', alt: 'Trusted company logo' },
      { src: 'https://twinbot.in/wp-content/uploads/2025/06/Astroven.png', alt: 'Trusted company logo' },
      { src: 'https://twinbot.in/wp-content/uploads/2025/09/Wee.png', alt: 'Trusted company logo' }
    ]
  },
  media: {
    demoVideos: [
      {
        title: '4-in-1 Multi Gauge (PC ECS) Demo',
        src: 'https://twinbot.in/wp-content/uploads/2025/10/4-in-1-Multi-Gauge-_-PC-ECS-_-TBI1080P_HD.mp4',
        note: 'Approved sample project for reference.'
      }
    ]
  },
  productsFallback: [
    {
      id: 101,
      name: 'DigiDial Console - 8CH',
      price: 0,
      image_url: 'https://twinbot.in/wp-content/uploads/2025/03/6.png',
      description:
        'Automated dimensional inspection console built around Mitutoyo Digimatic dials with tolerance checks, OK/Fail decisions, SD logging, and optional IoTLink (RS485 Modbus).',
      images: [{ url: 'https://twinbot.in/wp-content/uploads/2025/03/6.png', alt_text: 'DigiDial Console - 8CH' }],
      highlights: [
        'Supports 8 Mitutoyo Digimatic dials (2-digit resolution)',
        '10-inch capacitive touch display',
        'Auto pass/fail with optional OK-part punching',
        'High-speed SD logging with timestamps',
        'Optional IoTLink via RS485 Modbus RTU'
      ]
    },
    {
      id: 102,
      name: 'DigiDial Console - 12CH',
      price: 0,
      image_url: 'https://twinbot.in/wp-content/uploads/2025/03/thrhr.png',
      description:
        '12-channel DigiDial Console for automated multi-point inspection using Mitutoyo Digimatic dials with logging and IoTLink-ready outputs.',
      images: [{ url: 'https://twinbot.in/wp-content/uploads/2025/03/thrhr.png', alt_text: 'DigiDial Console - 12CH' }],
      highlights: [
        'Supports 12 Mitutoyo Digimatic dials',
        '10-inch capacitive touch display',
        'Automatic tolerance comparison and OK/Fail decisions',
        'SD card logging for every cycle',
        'Optional RS485 Modbus RTU IoTLink output'
      ]
    },
    {
      id: 103,
      name: 'DigiDial Console - 16CH',
      price: 0,
      image_url: 'https://twinbot.in/wp-content/uploads/2025/03/5.png',
      description:
        '16-channel DigiDial Console with a larger display for high-throughput automated dimensional inspection and traceable inspection logs.',
      images: [{ url: 'https://twinbot.in/wp-content/uploads/2025/03/5.png', alt_text: 'DigiDial Console - 16CH' }],
      highlights: [
        'Supports 16 Mitutoyo Digimatic dials',
        '15-inch capacitive touch display',
        'Automated cycle with tolerance checks',
        'SD logging: values, tolerances, date/time, final result',
        'Optional IoTLink via RS485 Modbus RTU'
      ]
    },
    {
      id: 201,
      name: 'FitSense Lite',
      price: 0,
      image_url: 'https://twinbot.in/wp-content/uploads/2024/11/WhatsApp-Image-2024-11-24-at-16.54.12.jpeg',
      description:
        'Precision displacement measurement tool for essential industrial checks. Single-probe measurement with a clear 4-digit 7-seg display and a compact operator-friendly design.',
      images: [{ url: 'https://twinbot.in/wp-content/uploads/2024/11/WhatsApp-Image-2024-11-24-at-16.54.12.jpeg', alt_text: 'FitSense Lite' }],
      highlights: ['Single probe measurement', '4-digit 7-segment display', 'Compact, user-friendly', '1-year limited warranty']
    },
    {
      id: 202,
      name: 'FitSense Pro',
      price: 0,
      image_url: 'https://twinbot.in/wp-content/uploads/2024/11/WhatsApp-Image-2024-11-24-at-16.54.11-1.jpeg',
      description:
        'Upgraded displacement measurement for shop-floor workflows. Designed for accurate readings with a 4.3-inch display and a durable compact build.',
      images: [{ url: 'https://twinbot.in/wp-content/uploads/2024/11/WhatsApp-Image-2024-11-24-at-16.54.11-1.jpeg', alt_text: 'FitSense Pro' }],
      highlights: ['2 probe measurement', '4.3-inch LCD display', 'Operator-friendly interface', '1-year limited warranty']
    },
    {
      id: 203,
      name: 'FitSense Ultra',
      price: 0,
      image_url: 'https://twinbot.in/wp-content/uploads/2024/11/WhatsApp-Image-2024-11-24-at-16.54.11.jpeg',
      description:
        'High-visibility FitSense variant with a 7-inch display for clearer monitoring and rapid decision-making during measurement tasks.',
      images: [{ url: 'https://twinbot.in/wp-content/uploads/2024/11/WhatsApp-Image-2024-11-24-at-16.54.11.jpeg', alt_text: 'FitSense Ultra' }],
      highlights: ['4 probe measurement', '7-inch LCD display', 'Durable build', '1-year limited warranty']
    },
    {
      id: 301,
      name: 'Mitutoyo Digimatic Cable (2m)',
      price: 0,
      image_url: 'https://twinbot.in/wp-content/uploads/2025/03/1.png',
      description:
        '2-meter flat straight cable for connecting Mitutoyo Digimatic measuring devices to PCs or data interfaces for transfer and logging.',
      images: [{ url: 'https://twinbot.in/wp-content/uploads/2025/03/1.png', alt_text: 'Mitutoyo Digimatic Cable' }],
      highlights: [
        '2-meter flat straight cable',
        'Connects Mitutoyo Digimatic devices to PCs/interfaces',
        'USB direct or via Digimatic/wireless transmitters',
        'Built for precision measurement data collection'
      ]
    }
  ],
  faqs: [
    {
      q: 'What services does TwinBot Innovations offer?',
      a: 'Industrial automation, robotics, embedded control systems, and custom solutions tailored to your needs.'
    },
    {
      q: 'How can I get a quote for a project?',
      a: 'Use the quote request form on this site or email us your requirements. We will respond with a tailored proposal.'
    },
    {
      q: 'What industries do you serve?',
      a: 'Manufacturing, logistics, and technology teams looking to modernize automation and measurement workflows.'
    },
    {
      q: 'Do you offer support after purchase?',
      a: 'Yes. We provide support and maintenance for our products and solutions.'
    },
    {
      q: 'Can you customize solutions for my specific needs?',
      a: 'Yes. We build user-specific embedded boards and automation solutions designed around your constraints.'
    },
    {
      q: 'How long does development take?',
      a: 'Timelines depend on complexity. After understanding your requirements, we provide a clear estimate.'
    },
    {
      q: 'What is your return policy?',
      a: 'If you encounter issues, contact us within 30 days of purchase and we will review options.'
    },
    {
      q: 'Where are you located?',
      a: 'We are based in Chennai and serve clients across India.'
    },
    {
      q: 'How can I contact you?',
      a: 'Email support@twinbot.in or call +91 63839 31536. WhatsApp is also available.'
    }
  ]
};
