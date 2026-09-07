<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\City;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $categoryFilter = $request->query('category');
        $search = $request->query('q');

        $servicesQuery = Service::query();
        if ($categoryFilter) {
            $servicesQuery->where('category', $categoryFilter);
        }
        if ($search) {
            $servicesQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('badge', 'like', "%{$search}%");
            });
        }
        $services = $servicesQuery->orderBy('category')->orderBy('name')->paginate(15, ['*'], 'services_page')->withQueryString();

        $citySearch = $request->query('city_q');
        $islandFilter = $request->query('island');

        $citiesQuery = City::query();
        if ($islandFilter) {
            $citiesQuery->where('island', $islandFilter);
        }
        if ($citySearch) {
            $citiesQuery->where('name', 'like', "%{$citySearch}%");
        }
        $cities = $citiesQuery->orderBy('name')->paginate(20, ['*'], 'cities_page')->withQueryString();

        $stats = [
            'total_services' => Service::count(),
            'total_pelatihan' => Service::where('category', 'pelatihan')->count(),
            'total_kajian' => Service::where('category', 'kajian')->count(),
            'total_jasa' => Service::where('category', 'jasa')->count(),
            'total_cities' => City::count(),
            'total_hubs' => City::where('is_hub', true)->count(),
        ];

        $islands = City::select('island')->distinct()->whereNotNull('island')->pluck('island');

        return view('admin.dashboard', compact(
            'services',
            'cities',
            'stats',
            'islands',
            'categoryFilter',
            'search',
            'citySearch',
            'islandFilter'
        ));
    }
}
