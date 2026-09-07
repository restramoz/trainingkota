<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\City;
use Illuminate\Http\Request;

class CityLandingController extends Controller
{
    public function show($category, $citySlug)
    {
        $validCategories = ['pelatihan', 'kajian', 'jasa'];
        if (!in_array($category, $validCategories)) {
            abort(404);
        }

        $city = City::where('slug', $citySlug)->firstOrFail();
        $services = Service::where('category', $category)->orderBy('id')->get();
        $featuredServices = $services->take(8);
        $otherCitiesInIsland = City::where('island', $city->island)
            ->where('id', '!=', $city->id)
            ->take(12)
            ->get();

        $categoryNames = [
            'pelatihan' => 'Pelatihan K3 & Sertifikasi Kemnaker RI',
            'kajian' => 'Kajian Teknis & Studi Kelayakan K3',
            'jasa' => 'Jasa Teknis, SLF & Riksa Uji Industri',
        ];

        $categoryName = $categoryNames[$category] ?? ucfirst($category);

        return view('city-landing', compact(
            'category',
            'categoryName',
            'city',
            'services',
            'featuredServices',
            'otherCitiesInIsland'
        ));
    }
}
