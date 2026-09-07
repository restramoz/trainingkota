<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\City;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $pelatihanServices = Service::where('category', 'pelatihan')->take(6)->get();
        $kajianServices = Service::where('category', 'kajian')->get();
        $jasaServices = Service::where('category', 'jasa')->get();

        $stats = [
            'total_services' => Service::count(),
            'total_pelatihan' => Service::where('category', 'pelatihan')->count(),
            'total_kajian' => Service::where('category', 'kajian')->count(),
            'total_jasa' => Service::where('category', 'jasa')->count(),
            'total_cities' => City::count(),
        ];

        // All 212 cities grouped by island for the interactive widget
        $citiesGrouped = City::orderBy('name')->get()->groupBy('island');
        $hubCities = City::where('is_hub', true)->get();

        return view('landing.home', compact(
            'pelatihanServices',
            'kajianServices',
            'jasaServices',
            'stats',
            'citiesGrouped',
            'hubCities'
        ));
    }
}
