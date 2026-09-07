<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\City;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function show($category, $serviceSlug)
    {
        $validCategories = ['pelatihan', 'kajian', 'jasa'];
        if (!in_array($category, $validCategories)) {
            abort(404);
        }

        $service = Service::where('category', $category)
            ->where('slug', $serviceSlug)
            ->firstOrFail();

        $relatedServices = Service::where('category', $category)
            ->where('id', '!=', $service->id)
            ->take(4)
            ->get();

        $hubCities = City::where('is_hub', true)->get();

        $viewName = view()->exists('services.show') ? 'services.show' : 'service-detail';

        return view($viewName, compact(
            'category',
            'service',
            'relatedServices',
            'hubCities'
        ));
    }
}
