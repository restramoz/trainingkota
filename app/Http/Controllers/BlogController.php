<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\City;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request, $citySlug = null)
    {
        $category = $request->query('category');
        $search = $request->query('search');
        $city = null;

        $query = Article::published();

        if ($category) {
            $query->forCategory($category);
        }

        if ($citySlug) {
            $city = City::where('slug', $citySlug)->first();
            if ($city) {
                $query->where('city_id', $city->id);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%");
            });
        }

        $articles = $query->latest()
            ->paginate(12)
            ->withQueryString();

        // Get existing categories from published articles for the filter
        $categories = Article::published()
            ->select('category')
            ->distinct()
            ->pluck('category');

        $title = 'Blog & Artikel K3 - TrainingKota';
        $meta_description = 'Kumpulan artikel, panduan, dan wawasan terbaru mengenai K3, pelatihan profesional, dan regulasi industri di Indonesia.';

        if ($city) {
            $title = "Artikel {$city->name} - TrainingKota";
            $meta_description = "Daftar artikel, panduan, dan wawasan K3 seputar wilayah {$city->name} dan sekitarnya.";
        }

        return view('blog-index', compact('articles', 'categories', 'category', 'search', 'title', 'meta_description', 'city'));
    }
}
