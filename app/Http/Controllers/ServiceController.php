<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\City;
use App\Models\TrainingSchedule;
use App\Models\Faq;
use App\Models\Article;
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

        // Dynamic training schedules for Pelatihan
        $schedules = [];
        if ($category === 'pelatihan') {
            $schedules = TrainingSchedule::with('city')
                ->where('service_id', $service->id)
                ->where('status', 'open')
                ->orderBy('date')
                ->take(6)
                ->get();
        }

        // Dynamic FAQs from database
        $faqs = Faq::published()
            ->where('service_id', $service->id)
            ->orderBy('order')
            ->get();

        // Get articles related to this service (for full content display)
        // Priority: 1. Article with this service_id, 2. Article with this category but no service_id
        $article = Article::published()
            ->where(function ($q) use ($service, $category) {
                $q->where('service_id', $service->id)
                  ->orWhere(function ($q2) use ($category) {
                      $q2->where('category', $category)->whereNull('service_id');
                  });
            })
            ->latest()
            ->first();

        // Related articles for sidebar (excluding the main article)
        $relatedArticles = Article::published()
            ->where('id', '!=', $article?->id)
            ->where(function ($q) use ($service, $category) {
                $q->where('service_id', $service->id)
                  ->orWhere(function ($q2) use ($category) {
                      $q2->where('category', $category)->whereNull('service_id');
                  });
            })
            ->latest()
            ->take(5)
            ->get();

        return view('service-detail', compact(
            'category',
            'service',
            'relatedServices',
            'hubCities',
            'schedules',
            'faqs',
            'article',
            'relatedArticles'
        ));
    }
}
