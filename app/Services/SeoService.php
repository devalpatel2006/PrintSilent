<?php

namespace App\Services;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

/**
 * Centralized SEO metadata management service.
 *
 * Responsible for generating page-level meta tags, Open Graph,
 * Twitter Card data, JSON-LD structured data, and breadcrumbs.
 *
 * Usage in controllers:
 *   app(SeoService::class)
 *       ->setTitle('Features')
 *       ->setDescription('...')
 *       ->setBreadcrumbs([['label' => 'Home', 'url' => '/'], ['label' => 'Features']]);
 */
class SeoService
{
    private string $title = '';
    private string $description = '';
    private string $canonical = '';
    private string $ogImage = '';
    private string $ogType = 'website';
    private string $robots = 'index, follow';
    private array $breadcrumbs = [];
    private array $schemas = [];
    private array $keywords = [];

    /**
     * Set the page title.
     * Automatically appended with " — SiteName" via the title template.
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the meta description (max ~160 chars recommended).
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set the canonical URL. Defaults to current request URL.
     */
    public function setCanonical(string $url): self
    {
        $this->canonical = $url;

        return $this;
    }

    /**
     * Set the Open Graph image path (relative to public/).
     */
    public function setOgImage(string $path): self
    {
        $this->ogImage = $path;

        return $this;
    }

    /**
     * Set the Open Graph type (website, article, product, etc.).
     */
    public function setOgType(string $type): self
    {
        $this->ogType = $type;

        return $this;
    }

    /**
     * Set robots meta directive (e.g., 'noindex, nofollow').
     */
    public function setRobots(string $robots): self
    {
        $this->robots = $robots;

        return $this;
    }

    /**
     * Set page-specific keywords.
     */
    public function setKeywords(array $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Set breadcrumb trail.
     *
     * @param  array  $breadcrumbs  Array of ['label' => string, 'url' => string|null]
     */
    public function setBreadcrumbs(array $breadcrumbs): self
    {
        $this->breadcrumbs = $breadcrumbs;

        return $this;
    }

    /**
     * Add a JSON-LD schema object.
     */
    public function addSchema(array $schema): self
    {
        $this->schemas[] = $schema;

        return $this;
    }

    /**
     * Get the formatted page title with site name suffix.
     */
    public function getTitle(): string
    {
        $siteName = config('seo.site_name', 'PrintSilently');
        $separator = config('seo.title_separator', '—');

        if (empty($this->title)) {
            return $siteName . ' ' . $separator . ' ' . config('seo.default_title');
        }

        return $this->title . ' ' . $separator . ' ' . $siteName;
    }

    /**
     * Get the meta description, falling back to the config default.
     */
    public function getDescription(): string
    {
        return $this->description ?: config('seo.default_description', '');
    }

    /**
     * Get the canonical URL, defaulting to current URL without query strings.
     */
    public function getCanonical(): string
    {
        if (! empty($this->canonical)) {
            return $this->canonical;
        }

        return url()->current();
    }

    /**
     * Get the full Open Graph image URL.
     */
    public function getOgImage(): string
    {
        $path = $this->ogImage ?: config('seo.og_image', '/images/logo.jpg');

        return asset($path);
    }

    /**
     * Get the Open Graph type.
     */
    public function getOgType(): string
    {
        return $this->ogType;
    }

    /**
     * Get the robots meta directive.
     */
    public function getRobots(): string
    {
        return $this->robots;
    }

    /**
     * Get combined keywords (page-specific + global).
     */
    public function getKeywords(): string
    {
        $all = array_merge($this->keywords, config('seo.keywords', []));

        return implode(', ', array_unique($all));
    }

    /**
     * Get breadcrumbs array.
     */
    public function getBreadcrumbs(): array
    {
        return $this->breadcrumbs;
    }

    /**
     * Generate BreadcrumbList JSON-LD schema from breadcrumbs.
     */
    public function getBreadcrumbSchema(): ?array
    {
        if (empty($this->breadcrumbs)) {
            return null;
        }

        $items = [];
        foreach ($this->breadcrumbs as $index => $crumb) {
            $item = [
                '@type'    => 'ListItem',
                'position' => $index + 1,
                'name'     => $crumb['label'],
            ];

            if (! empty($crumb['url'])) {
                $item['item'] = url($crumb['url']);
            }

            $items[] = $item;
        }

        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }

    /**
     * Generate Organization JSON-LD schema.
     */
    public function getOrganizationSchema(): array
    {
        $org = config('seo.organization');

        return [
            '@context'    => 'https://schema.org',
            '@type'       => 'Organization',
            'name'        => $org['name'],
            'legalName'   => $org['legal_name'],
            'url'         => $org['url'],
            'logo'        => asset($org['logo']),
            'email'       => $org['email'],
            'description' => $org['description'],
            'sameAs'      => $org['same_as'],
        ];
    }

    /**
     * Generate WebSite JSON-LD schema with SearchAction.
     */
    public function getWebSiteSchema(): array
    {
        return [
            '@context'      => 'https://schema.org',
            '@type'         => 'WebSite',
            'name'          => config('seo.site_name'),
            'url'           => config('app.url'),
            'description'   => config('seo.default_description'),
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => config('app.url') . '/search?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * Generate WebPage JSON-LD schema for the current page.
     */
    public function getWebPageSchema(): array
    {
        return [
            '@context'    => 'https://schema.org',
            '@type'       => 'WebPage',
            'name'        => $this->getTitle(),
            'description' => $this->getDescription(),
            'url'         => $this->getCanonical(),
            'isPartOf'    => [
                '@type' => 'WebSite',
                'name'  => config('seo.site_name'),
                'url'   => config('app.url'),
            ],
        ];
    }

    /**
     * Generate SoftwareApplication JSON-LD schema.
     */
    public function getSoftwareApplicationSchema(): array
    {
        $sw = config('seo.software');

        return [
            '@context'            => 'https://schema.org',
            '@type'               => 'SoftwareApplication',
            'name'                => $sw['name'],
            'applicationCategory' => $sw['application_category'],
            'operatingSystem'     => $sw['operating_system'],
            'offers'              => [
                '@type'         => 'Offer',
                'price'         => $sw['offers']['price'],
                'priceCurrency' => $sw['offers']['currency'],
            ],
            'description'         => config('seo.organization.description'),
            'url'                 => config('app.url'),
        ];
    }

    /**
     * Generate FAQPage JSON-LD schema.
     *
     * @param  array  $faqs  Array of ['question' => string, 'answer' => string]
     */
    public function getFaqSchema(array $faqs): array
    {
        $entities = array_map(function ($faq) {
            return [
                '@type'          => 'Question',
                'name'           => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => $faq['answer'],
                ],
            ];
        }, $faqs);

        return [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => $entities,
        ];
    }

    /**
     * Get all schemas (custom + auto-generated) as JSON strings for rendering.
     */
    public function getAllSchemas(): array
    {
        $schemas = $this->schemas;

        // Always include breadcrumbs if present
        $breadcrumbSchema = $this->getBreadcrumbSchema();
        if ($breadcrumbSchema) {
            $schemas[] = $breadcrumbSchema;
        }

        return $schemas;
    }

    /**
     * Export all SEO data as an array for view consumption.
     */
    public function toArray(): array
    {
        return [
            'title'       => $this->getTitle(),
            'description' => $this->getDescription(),
            'canonical'   => $this->getCanonical(),
            'og_image'    => $this->getOgImage(),
            'og_type'     => $this->getOgType(),
            'robots'      => $this->getRobots(),
            'keywords'    => $this->getKeywords(),
            'breadcrumbs' => $this->getBreadcrumbs(),
            'schemas'     => $this->getAllSchemas(),
            'site_name'   => config('seo.site_name', 'PrintSilently'),
            'twitter'     => config('seo.twitter_handle', ''),
            'twitter_card' => config('seo.twitter_card_type', 'summary_large_image'),
        ];
    }
}
