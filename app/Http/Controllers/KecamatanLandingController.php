<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Kecamatan;
use App\Models\Service;
use App\Models\Location;
use App\Models\Article;
use App\Models\Faq;
use Illuminate\Http\Request;

class KecamatanLandingController extends Controller
{
    public function show($category, $kecamatanSlug)
    {
        $validCategories = ['pelatihan', 'kajian', 'jasa'];
        if (!in_array($category, $validCategories)) {
            abort(404);
        }

        $kecamatan = Kecamatan::with('city')
            ->where('slug', $kecamatanSlug)
            ->where('status', 'active')
            ->firstOrFail();

        $city = $kecamatan->city;

        // Services in this category
        $services = Service::where('category', $category)
            ->where('status', 'published')
            ->orderBy('id')
            ->take(9)
            ->get();

        // Locations in this Kecamatan & City
        $locations = Location::where('city_id', $city->id)
            ->where(function ($q) use ($kecamatan) {
                $q->where('kecamatan_id', $kecamatan->id)
                  ->orWhereNull('kecamatan_id');
            })
            ->where('status', 'active')
            ->take(6)
            ->get();

        // Dynamic Article: Priority: Kecamatan -> City -> Category General
        $article = Article::published()
            ->where(function ($q) use ($kecamatan, $city, $category) {
                $q->where('kecamatan_id', $kecamatan->id)
                  ->orWhere('city_id', $city->id)
                  ->orWhere(function ($q2) use ($category) {
                      $q2->where('category', $category)->whereNull('city_id');
                  });
            })
            ->latest()
            ->first();

        // Dynamic FAQs from database
        $faqs = Faq::published()
            ->where(function ($q) use ($kecamatan, $city) {
                $q->where('kecamatan_id', $kecamatan->id)
                  ->orWhere('city_id', $city->id);
            })
            ->orderBy('order')
            ->get();

        return view('kecamatan-landing', compact(
            'category',
            'kecamatan',
            'city',
            'services',
            'locations',
            'article',
            'faqs'
        ));
    }
}
