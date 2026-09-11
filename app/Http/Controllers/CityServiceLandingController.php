<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\City;
use App\Models\CityServiceContent;
use App\Models\Article;
use Illuminate\Http\Request;

class CityServiceLandingController extends Controller
{
    public function show($category, $serviceSlug, $citySlug)
    {
        $validCategories = ['pelatihan', 'kajian', 'jasa'];
        if (!in_array($category, $validCategories)) {
            abort(404);
        }

        $city = City::where('slug', $citySlug)->firstOrFail();
        $service = Service::where('category', $category)
            ->where('slug', $serviceSlug)
            ->firstOrFail();

        // Check for content/SEO overrides in database
        $override = CityServiceContent::where('city_id', $city->id)
            ->where('service_id', $service->id)
            ->first();

        // Other cities in same island for same service
        $otherCities = City::where('island', $city->island)
            ->where('id', '!=', $city->id)
            ->take(8)
            ->get();

        // Related services in this city
        $relatedServices = Service::where('category', $category)
            ->where('id', '!=', $service->id)
            ->take(4)
            ->get();

        // Related articles - MUST be specific to this service + city
        $relatedArticles = Article::published()
            ->where('city_id', $city->id)
            ->where('service_id', $service->id)
            ->latest()
            ->take(3)
            ->get();

        // FAQ for this service + city, fallback to service-wide FAQ
        $faqs = \App\Models\Faq::published()
            ->where(function($q) use ($city, $service) {
                $q->where('city_id', $city->id)->where('service_id', $service->id)
                  ->orWhere('city_id', null)->where('service_id', $service->id);
            })
            ->orderBy('order')
            ->get();

        return view('city-service-landing', compact(
            'category',
            'service',
            'city',
            'override',
            'otherCities',
            'relatedServices',
            'relatedArticles',
            'faqs'
        ));
    }
}
