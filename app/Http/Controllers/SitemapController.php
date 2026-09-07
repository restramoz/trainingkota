<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\City;
use App\Models\Article;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $baseUrl = config('app.url', 'http://127.0.0.1:8000');
        $now = date('Y-m-d');

        $urls = [];

        // 1. Homepage
        $urls[] = [
            'loc' => $baseUrl . '/',
            'lastmod' => $now,
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        // 2. Master Categories
        $categories = ['pelatihan', 'kajian', 'jasa'];
        foreach ($categories as $cat) {
            $urls[] = [
                'loc' => "{$baseUrl}/{$cat}",
                'lastmod' => $now,
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ];
        }

        // 3. Detail Layanan (All 62 services)
        $services = Service::published()->get();
        foreach ($services as $service) {
            $urls[] = [
                'loc' => "{$baseUrl}/{$service->category}/{$service->slug}",
                'lastmod' => $service->updated_at ? $service->updated_at->format('Y-m-d') : $now,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // 4. Landing Page Kota per Category (212 cities x 3 categories)
        $cities = City::all();
        foreach ($categories as $cat) {
            foreach ($cities as $city) {
                $urls[] = [
                    'loc' => "{$baseUrl}/{$cat}/kota-{$city->slug}",
                    'lastmod' => $now,
                    'changefreq' => 'weekly',
                    'priority' => $city->is_hub ? '0.8' : '0.6',
                ];
            }
        }

        // 5. Hyper-Specific City Service Landing (Hub cities x Top services)
        $hubCities = City::where('is_hub', true)->get();
        $topServices = Service::published()->take(10)->get();
        foreach ($topServices as $ts) {
            foreach ($hubCities as $hc) {
                $urls[] = [
                    'loc' => "{$baseUrl}/{$ts->category}/{$ts->slug}/kota-{$hc->slug}",
                    'lastmod' => $now,
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            }
        }

        // 6. Artikel SEO
        $articles = Article::published()->get();
        foreach ($articles as $art) {
            $urls[] = [
                'loc' => "{$baseUrl}/artikel/{$art->slug}",
                'lastmod' => $art->updated_at ? $art->updated_at->format('Y-m-d') : $now,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // Generate XML string
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($u['loc'], ENT_XML1, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>{$u['lastmod']}</lastmod>\n";
            $xml .= "    <changefreq>{$u['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$u['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
