<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show(string $slug)
    {
        $article = Article::published()
            ->where('slug', $slug)
            ->with(['city', 'service'])
            ->firstOrFail();

        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->where(function ($q) use ($article) {
                $q->where('category', $article->category)
                  ->orWhere('city_id', $article->city_id);
            })
            ->limit(3)
            ->get();

        $viewName = view()->exists('articles.show') ? 'articles.show' : 'article-show';

        return view($viewName, compact('article', 'relatedArticles'));
    }
}
