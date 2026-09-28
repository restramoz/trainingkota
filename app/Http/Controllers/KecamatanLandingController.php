<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Kecamatan;
use App\Models\Service;
use App\Models\Location;
use App\Models\Article;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

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
        if (!$city) {
            abort(404);
        }

        // Services in this category
        // Services in this category (all published services)
        $services = Service::where('category', $category)
            ->where('status', 'published')
            ->orderBy('id')
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

        // Related Articles for this Kecamatan/City context
        // Priority:
        // 1. Kecamatan-specific articles (kecamatan_id = this kecamatan)
        // 2. City-level articles (city_id = this city, kecamatan_id = NULL)
        // 3. Global articles (city_id = NULL, kecamatan_id = NULL) - for all cities & kecamatans
        if (Schema::hasTable('articles')) {
            $relatedArticles = Article::published()
                ->where(function ($q) use ($kecamatan, $city) {
                    // Kecamatan-specific
                    $q->where(function ($qKec) use ($kecamatan) {
                        $qKec->where('kecamatan_id', $kecamatan->id);
                    })
                    // City-level (no specific kecamatan)
                    ->orWhere(function ($qCity) use ($city) {
                        $qCity->where('city_id', $city->id)->whereNull('kecamatan_id');
                    })
                    // Global articles (no city, no kecamatan) - available everywhere
                    ->orWhere(function ($qGlobal) {
                        $qGlobal->whereNull('city_id')->whereNull('kecamatan_id');
                    });
                })
                ->orderByRaw('kecamatan_id IS NULL')
                ->orderByRaw('city_id IS NULL')
                ->latest()
                ->take(6)
                ->get();
        } else {
            $relatedArticles = collect();
        }

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
            'relatedArticles',
            'faqs'
        ));
    }
}
