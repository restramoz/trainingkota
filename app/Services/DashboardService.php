<?php

namespace App\Services;

use App\Models\Service;
use App\Models\City;
use App\Models\Article;
use App\Models\Faq;
use App\Models\TrainingSchedule;
use App\Models\Location;
use App\Models\CityServiceContent;
use Illuminate\Http\Request;

class DashboardService
{
    /**
     * Assemble all data required for the Admin Dashboard.
     */
    public function getDashboardData(Request $request): array
    {
        return [
            'stats' => $this->getStatsOverview(),
            'coverageStats' => $this->getCoverageStats(),
            'services' => $this->getServicesData($request),
            'cities' => $this->getCitiesData($request),
            'articles' => $this->getArticlesData($request),
            'faqs' => $this->getFaqsData($request),
            'schedules' => $this->getSchedulesData($request),
            'locations' => $this->getLocationsData($request),
            // Helper collections used by modals and selectors
            'allServices' => Service::select('id', 'name', 'category', 'slug')->get(),
            'allCities' => City::select('id', 'name', 'slug', 'province')->get(),
            'kecamatans' => \App\Models\Kecamatan::select('id', 'name', 'city_id')->get(),
        ];
    }

    /**
     * Get overall statistics for the dashboard.
     */
    public function getStatsOverview(): array
    {
        return [
            'total_services'     => Service::count(),
            'total_pelatihan'    => Service::where('category', 'pelatihan')->count(),
            'total_kajian'       => Service::where('category', 'kajian')->count(),
            'total_jasa'         => Service::where('category', 'jasa')->count(),
            'total_cities'       => City::count(),
            'total_hubs'         => City::where('is_hub', true)->count(),
            'total_articles'     => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'draft_articles'     => Article::where('status', 'draft')->count(),
            'total_faqs'         => Faq::count(),
            'total_schedules'    => TrainingSchedule::count(),
            'total_locations'     => Location::count(),
        ];
    }

    /**
     * Analyze coverage rate per city.
     */
    public function getCoverageStats()
    {
        return City::withCount(['articles as published_articles' => function($q) {
            $q->where('status', 'published');
        }])
        ->withCount(['locations'])
        ->get()
        ->map(function ($city) {
            return [
                'city_name' => $city->name,
                'city_slug' => $city->slug,
                'article_count' => $city->published_articles,
                'location_count' => $city->locations_count,
                'coverage_rate' => ($city->published_articles > 0 || $city->locations_count > 0) ? 100 : 0,
            ];
        });
    }

    /**
     * Get filtered services for the dashboard.
     */
    public function getServicesData(Request $request)
    {
        $categoryFilter = $request->query('service_category') ?? $request->query('category') ?? $request->query('filter_category');
        $search = $request->query('service_q') ?? $request->query('q') ?? $request->query('search_service');

        $query = Service::query();
        if ($categoryFilter) {
            $query->where('category', $categoryFilter);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('badge', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Fixed incomplete method chaining and added missing withQueryString()
        return $query->orderBy('name')->paginate(15)->withQueryString();
    }

    /**
     * Get filtered FAQs for the dashboard.
     */
    public function getFaqsData(Request $request)
    {
        $search = $request->query('faq_q') ?? $request->query('q') ?? $request->query('search_faq');

        $query = Faq::query()->with(['service', 'city']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%")
                  ->orWhereHas('service', fn($sq) => $sq->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('city', fn($sq) => $sq->where('name', 'like', "%{$search}%"));
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
    }

    /**
     * Get filtered training schedules for the dashboard.
     */
    public function getSchedulesData(Request $request)
    {
        $search = $request->query('schedule_q') ?? $request->query('q') ?? $request->query('search_schedule');

        $query = TrainingSchedule::query()->with(['service', 'city']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('service', fn($sq) => $sq->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('city', fn($sq) => $sq->where('name', 'like', "%{$search}%"));
            });
        }

        return $query->orderBy('date', 'asc')->paginate(15)->withQueryString();
    }

    /**
     * Get filtered locations for the dashboard.
     */
    public function getLocationsData(Request $request)
    {
        $search = $request->query('location_q') ?? $request->query('q') ?? $request->query('search_location');
        $cityFilter = $request->query('location_city');

        $query = Location::query()->with(['city', 'kecamatan']);

        if ($cityFilter) {
            $query->where('city_id', $cityFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('location_name', 'like', "%{$search}%")
                  ->orWhereHas('city', fn($sq) => $sq->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('kecamatan', fn($sq) => $sq->where('name', 'like', "%{$search}%"));
            });
        }

        return $query->orderBy('location_name')->paginate(15)->withQueryString();
    }

    /**
     * Get filtered cities for the dashboard.
     */
    public function getCitiesData(Request $request)
    {
        $search = $request->query('city_q') ?? $request->query('q') ?? $request->query('search_city');

        $query = City::withCount('cityServiceContents');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        return $query->orderBy('name')->paginate(15)->withQueryString();
    }

    /**
     * Get recent articles for the dashboard overview.
     */
    public function getArticlesData(Request $request)
    {
        // Simple recent articles, limited to 5 for the overview card.
        return \App\Models\Article::latest()->take(5)->get();
    }

}