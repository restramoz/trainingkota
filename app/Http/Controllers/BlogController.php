<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $query = Article::published();

        if ($category) {
            $query->forCategory($category);
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

        return view('blog-index', compact('articles', 'categories', 'category', 'search', 'title', 'meta_description'));
    }
}
