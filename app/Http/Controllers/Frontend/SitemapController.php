<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML sitemap.
     */
    public function index()
    {
        $baseUrl = config('app.url');
        $now = now()->toAtomString();

        $urls = [
            ['loc' => $baseUrl . '/', 'lastmod' => $now, 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['loc' => $baseUrl . '/features', 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => $baseUrl . '/pricing', 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => $baseUrl . '/download', 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.9'],
            ['loc' => $baseUrl . '/api-documentation', 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => $baseUrl . '/faq', 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => $baseUrl . '/about', 'lastmod' => $now, 'changefreq' => 'yearly', 'priority' => '0.7'],
            ['loc' => $baseUrl . '/contact', 'lastmod' => $now, 'changefreq' => 'yearly', 'priority' => '0.7'],
            ['loc' => $baseUrl . '/privacy-policy', 'lastmod' => $now, 'changefreq' => 'yearly', 'priority' => '0.5'],
            ['loc' => $baseUrl . '/terms-of-service', 'lastmod' => $now, 'changefreq' => 'yearly', 'priority' => '0.5'],
        ];

        $content = view('frontend.sitemap', compact('urls'))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
