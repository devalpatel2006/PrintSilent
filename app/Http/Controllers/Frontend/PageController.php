<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\SeoService;

/**
 * Serves all public-facing static pages with per-page SEO metadata.
 *
 * Each method configures the SeoService singleton before returning the view,
 * ensuring correct title, description, Open Graph, structured data, and
 * breadcrumbs for every page.
 */
class PageController extends Controller
{
    public function __construct(
        private SeoService $seo
    ) {
    }

    /**
     * Home page — primary landing page.
     */
    public function home()
    {
        $this->seo
            ->setTitle('')  // Empty = uses default "PrintSilently — Silent Printing for Modern Businesses"
            ->setDescription('PrintSilently connects cloud apps to local printers with secure silent background printing. The best QZ Tray alternative for thermal labels, ZPL, ESC/POS, and browser-based printing.')
            ->setKeywords(['silent printing', 'QZ Tray alternative', 'browser printing', 'thermal label printing', 'cloud printing'])
            ->setBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
            ]);

        // Add Organization + WebSite + SoftwareApplication schemas
        $this->seo->addSchema($this->seo->getOrganizationSchema());
        $this->seo->addSchema($this->seo->getWebSiteSchema());
        $this->seo->addSchema($this->seo->getSoftwareApplicationSchema());

        // FAQ schema for homepage FAQ section
        $this->seo->addSchema($this->seo->getFaqSchema($this->getHomeFaqs()));

        return view('frontend.index');
    }

    /**
     * Features page.
     */
    public function features()
    {
        $this->seo
            ->setTitle('Features — Silent Printing, Thermal Labels & Browser Print API')
            ->setDescription('Explore PrintSilently features: silent background printing, thermal label support, Zebra ZPL & ESC/POS printing, browser print API, cloud-to-local printer bridge, and enterprise security.')
            ->setKeywords(['silent printing features', 'thermal label printing', 'ZPL printing', 'ESC/POS printing', 'browser print API', 'Zebra printer support'])
            ->setBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Features'],
            ]);

        $this->seo->addSchema($this->seo->getOrganizationSchema());
        $this->seo->addSchema($this->seo->getSoftwareApplicationSchema());

        return view('frontend.features');
    }

    /**
     * Pricing page.
     */
    public function pricing()
    {
        $this->seo
            ->setTitle('Pricing — Free Silent Printing & Enterprise Plans')
            ->setDescription('PrintSilently offers a free-forever plan with unlimited print jobs. Compare our Free, White Label, and Enterprise plans. No credit card required to get started.')
            ->setKeywords(['silent printing pricing', 'free printing software', 'cloud printing plans', 'enterprise printing pricing'])
            ->setBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Pricing'],
            ]);

        $this->seo->addSchema($this->seo->getOrganizationSchema());

        // Product offers schema
        $this->seo->addSchema([
            '@context' => 'https://schema.org',
            '@type'    => 'Product',
            'name'     => 'PrintSilently',
            'description' => 'Enterprise-grade silent printing platform — free forever plan available.',
            'brand'    => [
                '@type' => 'Brand',
                'name'  => 'PrintSilently',
            ],
            'offers'   => [
                [
                    '@type'         => 'Offer',
                    'name'          => 'Free',
                    'price'         => '0',
                    'priceCurrency' => 'USD',
                    'description'   => 'Unlimited print jobs, silent printing, shipping labels & invoices.',
                    'availability'  => 'https://schema.org/InStock',
                ],
                [
                    '@type'         => 'Offer',
                    'name'          => 'White Label',
                    'price'         => '0',
                    'priceCurrency' => 'USD',
                    'description'   => 'Custom branding, dedicated API, custom desktop app.',
                    'availability'  => 'https://schema.org/InStock',
                    'priceSpecification' => [
                        '@type'       => 'PriceSpecification',
                        'description' => 'Custom pricing — contact sales.',
                    ],
                ],
                [
                    '@type'         => 'Offer',
                    'name'          => 'Enterprise',
                    'price'         => '0',
                    'priceCurrency' => 'USD',
                    'description'   => 'SSO, dedicated infrastructure, custom SLA, account manager.',
                    'availability'  => 'https://schema.org/InStock',
                    'priceSpecification' => [
                        '@type'       => 'PriceSpecification',
                        'description' => 'Custom pricing — contact sales.',
                    ],
                ],
            ],
        ]);

        return view('frontend.pricing');
    }

    /**
     * Download page.
     */
    public function download()
    {
        $this->seo
            ->setTitle('Download PrintSilently — Silent Print Agent for Mac & Windows')
            ->setDescription('Download the PrintSilently desktop agent for macOS and Windows. Install in 2 minutes, connect your printers, and start silent printing from any web application.')
            ->setKeywords(['download silent printing software', 'print agent download', 'QZ Tray alternative download', 'silent print app'])
            ->setBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Download'],
            ]);

        $this->seo->addSchema($this->seo->getSoftwareApplicationSchema());

        // HowTo schema for installation
        $this->seo->addSchema([
            '@context' => 'https://schema.org',
            '@type'    => 'HowTo',
            'name'     => 'How to Install PrintSilently',
            'description' => 'Step-by-step guide to install and configure the PrintSilently desktop agent.',
            'step'     => [
                [
                    '@type' => 'HowToStep',
                    'name'  => 'Download the Agent',
                    'text'  => 'Download the PrintSilently desktop agent for your operating system (macOS or Windows).',
                ],
                [
                    '@type' => 'HowToStep',
                    'name'  => 'Install & Launch',
                    'text'  => 'Run the installer and launch PrintSilently. The agent runs in your system tray.',
                ],
                [
                    '@type' => 'HowToStep',
                    'name'  => 'Connect Your Account',
                    'text'  => 'Sign in with your PrintSilently account to pair the agent with your API key.',
                ],
                [
                    '@type' => 'HowToStep',
                    'name'  => 'Start Printing',
                    'text'  => 'Send print jobs from your web application — they print silently with no dialogs.',
                ],
            ],
        ]);

        return view('frontend.download');
    }

    /**
     * API Documentation page.
     */
    public function apiDocs()
    {
        $this->seo
            ->setTitle('API Documentation — Browser Print API & REST Endpoints')
            ->setDescription('PrintSilently REST API documentation. Print PDFs, ZPL labels, ESC/POS receipts, and raw data from any web application. Simple JSON API with code examples.')
            ->setOgType('article')
            ->setKeywords(['browser print API', 'silent print REST API', 'ZPL printing API', 'ESC/POS API', 'print API documentation'])
            ->setBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'API Documentation'],
            ]);

        $this->seo->addSchema([
            '@context' => 'https://schema.org',
            '@type'    => 'TechArticle',
            'headline' => 'PrintSilently API Documentation',
            'description' => 'Complete REST API reference for browser-based silent printing.',
            'author'   => [
                '@type' => 'Organization',
                'name'  => 'PrintSilently',
            ],
        ]);

        return view('frontend.api-documentation');
    }

    /**
     * FAQ page.
     */
    public function faq()
    {
        $faqs = $this->getAllFaqs();

        $this->seo
            ->setTitle('FAQ — Silent Printing Questions & Answers')
            ->setDescription('Frequently asked questions about PrintSilently: setup, supported printers, security, integrations, thermal labels, ZPL, ESC/POS, and troubleshooting.')
            ->setKeywords(['silent printing FAQ', 'thermal printer setup', 'browser printing help', 'ZPL printing questions'])
            ->setBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'FAQ'],
            ]);

        $this->seo->addSchema($this->seo->getFaqSchema($faqs));

        return view('frontend.faq', compact('faqs'));
    }

    /**
     * Contact page.
     */
    public function contact()
    {
        $this->seo
            ->setTitle('Contact Us — PrintSilently Support & Sales')
            ->setDescription('Get in touch with the PrintSilently team. Contact us for support, enterprise pricing, white-label partnerships, or custom integration help.')
            ->setKeywords(['contact PrintSilently', 'printing software support', 'enterprise printing contact'])
            ->setBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Contact'],
            ]);

        $this->seo->addSchema($this->seo->getOrganizationSchema());

        return view('frontend.contact');
    }

    /**
     * Privacy Policy page.
     */
    public function privacyPolicy()
    {
        $this->seo
            ->setTitle('Privacy Policy')
            ->setDescription('PrintSilently privacy policy. Learn how we collect, use, and protect your data when you use our silent printing platform.')
            ->setBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Privacy Policy'],
            ]);

        $this->seo->addSchema($this->seo->getWebPageSchema());

        return view('frontend.privacy-policy');
    }

    /**
     * Terms of Service page.
     */
    public function terms()
    {
        $this->seo
            ->setTitle('Terms of Service')
            ->setDescription('PrintSilently terms of service. Read our terms and conditions for using the silent printing platform, desktop agent, and API.')
            ->setBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Terms of Service'],
            ]);

        $this->seo->addSchema($this->seo->getWebPageSchema());

        return view('frontend.terms');
    }

    /**
     * About page.
     */
    public function about()
    {
        $this->seo
            ->setTitle('About PrintSilently — The Modern QZ Tray Alternative')
            ->setDescription('PrintSilently is an enterprise-grade silent printing platform built for modern businesses. Learn about our mission to replace print dialogs with seamless automation.')
            ->setOgType('article')
            ->setKeywords(['about PrintSilently', 'silent printing company', 'QZ Tray alternative', 'printing platform'])
            ->setBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'About'],
            ]);

        $this->seo->addSchema($this->seo->getOrganizationSchema());

        return view('frontend.about');
    }

    /**
     * FAQs shown on the homepage.
     */
    private function getHomeFaqs(): array
    {
        return [
            [
                'question' => 'How does Print Silently stay silent?',
                'answer'   => 'Our desktop bridge runs locally and delivers print jobs directly to the OS print spooler. The browser never opens a print dialog.',
            ],
            [
                'question' => 'Which printers are supported?',
                'answer'   => 'PDF, thermal, label, ESC/POS, raw, network, and USB printers are supported via the local device agent.',
            ],
            [
                'question' => 'Can I use it with ERP, POS, and warehouse systems?',
                'answer'   => 'Yes. The platform is designed for integrations with ERP, POS, logistics, hospital systems, and custom SaaS workflows.',
            ],
            [
                'question' => 'Is it secure for enterprise environments?',
                'answer'   => 'Yes. We offer end-to-end encrypted print payloads, signed print jobs, device authentication, audit logs, IP whitelisting, and SSO support.',
            ],
        ];
    }

    /**
     * Complete FAQ list for the dedicated FAQ page.
     */
    private function getAllFaqs(): array
    {
        return array_merge($this->getHomeFaqs(), [
            [
                'question' => 'What is PrintSilently?',
                'answer'   => 'PrintSilently is a SaaS platform for browser-based silent printing. It connects your cloud web applications to local printers through a secure desktop agent — no print dialogs, no user intervention.',
            ],
            [
                'question' => 'How is PrintSilently different from QZ Tray?',
                'answer'   => 'PrintSilently offers a modern cloud-first architecture with a REST API, real-time WebSocket communication, enterprise security features (SSO, audit logs, IP whitelisting), and a free-forever plan. Unlike QZ Tray, no Java is required.',
            ],
            [
                'question' => 'Does it support Zebra ZPL printers?',
                'answer'   => 'Yes. PrintSilently supports sending raw ZPL commands directly to Zebra label printers for barcode labels, shipping labels, and thermal printing.',
            ],
            [
                'question' => 'Does it support ESC/POS receipt printers?',
                'answer'   => 'Yes. You can send ESC/POS commands to thermal receipt printers for POS systems, restaurants, and retail environments.',
            ],
            [
                'question' => 'Can I print shipping labels from Shopify or WooCommerce?',
                'answer'   => 'Yes. PrintSilently integrates with e-commerce platforms. When an order arrives, labels and invoices can be printed automatically without any clicks.',
            ],
            [
                'question' => 'Is there a free plan?',
                'answer'   => 'Yes. Our free plan includes unlimited print jobs, multiple store connections, silent background printing, and email support. No credit card required.',
            ],
            [
                'question' => 'What operating systems are supported?',
                'answer'   => 'The PrintSilently desktop agent is available for macOS and Windows. The web API works from any browser or server environment.',
            ],
            [
                'question' => 'How do I install the desktop agent?',
                'answer'   => 'Download the agent from our Download page, run the installer, sign in with your account, and your printers are automatically detected. Setup takes under 2 minutes.',
            ],
        ]);
    }
}
