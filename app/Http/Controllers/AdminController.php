<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\City;
use App\Models\CityServiceContent;
use App\Models\Article;
use App\Models\Faq;
use App\Models\TrainingSchedule;
use App\Models\Kecamatan;
use App\Models\Location;
use App\Services\OllamaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function manageServices(Request $request)
    {
        return redirect()->route('admin.dashboard', ['tab' => 'services']);
    }

    public function manageLocations(Request $request)
    {
        return redirect()->route('admin.dashboard', ['tab' => 'locations']);
    }

    public function manageGraphics(Request $request)
    {
        return redirect()->route('admin.dashboard', ['tab' => 'graphics']);
    }

    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'services');
        $data = $this->getDashboardData($request);

        return view('admin.dashboard', array_merge($data, [
            'activeTab' => $activeTab,
            'coverageStats' => $coverageStats,
        ]));
    }

    protected function getDashboardData(Request $request)
    {
        // 1. Stats Overview
        $stats = [
            'total_services'     => Service::count(),
            'total_pelatihan'    => Service::where('category', 'pelatihan')->count(),
            'total_kajian'       => Service::where('category', 'kajian')->count(),
            'total_jasa'         => Service::where('category', 'jasa')->count(),
            'total_cities'       => City::count(),
            'total_hubs'         => City::where('is_hub', true)->count(),
            'total_articles'     => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'draft_articles'     => Article::where('status', 'draft')->count(),
            'total_faqs'         => Faq::count(),
            'total_schedules'    => TrainingSchedule::count(),
            'total_locations'     => Location::count(),
        ];

        // 2. Coverage Analysis (New)
        $coverageStats = City::withCount(['articles as published_articles' => function($q) {
            $q->where('status', 'published');
        }])
        ->withCount(['locations'])
        ->get()
        ->map(function ($city) {
            return [
                'city_name' => $city->name,
                'city_slug' => $city->slug,
                'article_count' => $city->published_articles,
                'location_count' => $city->locations_count,
                'coverage_rate' => ($city->published_articles > 0 || $city->locations_count > 0) ? 100 : 0,
            ];
        });


        // 2. Services Query
        $serviceCategoryFilter = $request->query('service_category') ?? $request->query('category') ?? $request->query('filter_category');
        $serviceSearch = $request->query('service_q') ?? $request->query('q') ?? $request->query('search_service');

        $servicesQuery = Service::query();
        if ($serviceCategoryFilter) {
            $servicesQuery->where('category', $serviceCategoryFilter);
        }
        if ($serviceSearch) {
            $servicesQuery->where(function ($q) use ($serviceSearch) {
                $q->where('name', 'like', "%{$serviceSearch}%")
                  ->orWhere('badge', 'like', "%{$serviceSearch}%")
                  ->orWhere('slug', 'like', "%{$serviceSearch}%");
            });
        }
        $services = $servicesQuery->orderBy('category')->orderBy('name')->paginate(15, ['*'], 'services_page')->withQueryString();

        // 3. Cities Query
        $citySearch = $request->query('city_q') ?? $request->query('search_city');
        $islandFilter = $request->query('island') ?? $request->query('filter_island');

        $citiesQuery = City::query();
        if ($islandFilter) {
            $citiesQuery->where('island', $islandFilter);
        }
        if ($citySearch) {
            $citiesQuery->where(function ($q) use ($citySearch) {
                $q->where('name', 'like', "%{$citySearch}%")
                  ->orWhere('sentra_praktik', 'like', "%{$citySearch}%")
                  ->orWhere('address', 'like', "%{$citySearch}%");
            });
        }
        $cities = $citiesQuery->orderBy('name')->paginate(15, ['*'], 'cities_page')->withQueryString();

        // 4. CityServiceContent (Overrides) Query
        $overrideCityFilter = $request->query('override_city');
        $overridesQuery = CityServiceContent::with(['city', 'service']);
        if ($overrideCityFilter) {
            $overridesQuery->where('city_id', $overrideCityFilter);
        }
        $overrides = $overridesQuery->paginate(15, ['*'], 'overrides_page')->withQueryString();


        // 5. Articles Query
        $articleSearch = $request->query('article_q');
        $articleCategoryFilter = $request->query('article_category');
        $articleServiceFilter = $request->query('article_service');
        $articleCityFilter = $request->query('article_city');

        $articlesQuery = Article::with(['city', 'service'])->latest();
        if ($articleCategoryFilter) {
            $articlesQuery->where('category', $articleCategoryFilter);
        }
        if ($articleServiceFilter) {
            $articlesQuery->where('service_id', $articleServiceFilter);
        }
        if ($articleCityFilter) {
            $articlesQuery->where('city_id', $articleCityFilter);
        }
        if ($articleSearch) {
            $articlesQuery->where(function ($q) use ($articleSearch) {
                $q->where('title', 'like', "%{$articleSearch}%")
                  ->orWhere('slug', 'like', "%{$articleSearch}%")
                  ->orWhere('focus_keywords', 'like', "%{$articleSearch}%");
            });
        }
        $articles = $articlesQuery->paginate(15, ['*'], 'articles_page')->withQueryString();

        // 6. Form Dropdowns (Global Lists)
        $allServices = Service::select('id', 'name', 'category', 'slug')->get();
        $allCities   = City::select('id', 'name', 'slug', 'province')->get();
        $kecamatans   = Kecamatan::select('id', 'name', 'city_id')->get();

        return array_merge([
            'stats'         => $stats,
            'services'      => $services,
            'cities'        => $cities,
            'overrides'     => $overrides,
            'articles'     => $articles,
            'allServices'   => $allServices,
            'allCities'     => $allCities,
            'kecamatans'    => $kecamatans,
        ], $stats);
    }


    // ── CRUD LAYANAN ─────────────────────────────────────────────────────────

    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'category'       => 'required|in:pelatihan,kajian,jasa',
            'slug'           => 'nullable|string|unique:services,slug|max:255',
            'badge'          => 'nullable|string|max:100',
            'duration'       => 'nullable|string|max:100',
            'price_estimate' => 'nullable|string|max:100',
            'description'    => 'nullable|string',
            'status'         => 'required|in:published,draft',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        Service::create($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'services'])
            ->with('success', "Layanan '{$validated['name']}' berhasil ditambahkan ke katalog nasional.");
    }

    public function updateService(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'category'       => 'required|in:pelatihan,kajian,jasa',
            'slug'           => 'required|string|max:255|unique:services,slug,' . $service->id,
            'badge'          => 'nullable|string|max:100',
            'duration'       => 'nullable|string|max:100',
            'price_estimate' => 'nullable|string|max:100',
            'description'    => 'nullable|string',
            'status'         => 'required|in:published,draft',
        ]);

        $service->update($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'services'])
            ->with('success', "Layanan '{$service->name}' berhasil diperbarui.");
    }

    public function deleteService($id)
    {
        $service = Service::findOrFail($id);
        $name = $service->name;
        $service->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'services'])
            ->with('success', "Layanan '{$name}' telah dihapus dari sistem.");
    }

    // ── CRUD KOTA ────────────────────────────────────────────────────────────

    public function updateCity(Request $request, $id)
    {
        $city = City::findOrFail($id);

        $validated = $request->validate([
            'sentra_praktik' => 'nullable|string|max:255',
            'address'        => 'nullable|string|max:255',
            'province'       => 'nullable|string|max:100',
            'lat'            => 'nullable|numeric',
            'lng'            => 'nullable|numeric',
            'maps_embed_url' => 'nullable|string',
            'is_hub'         => 'nullable|boolean',
        ]);

        $validated['is_hub'] = $request->has('is_hub');

        $city->update($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'cities'])
            ->with('success', "Data kota '{$city->name}' berhasil diperbarui.");
    }

    // ── CRUD OVERRIDES KONTEN / SEO ──────────────────────────────────────────

    public function storeCityContent(Request $request)
    {
        $validated = $request->validate([
            'city_id'          => 'required|exists:cities,id',
            'service_id'       => 'nullable|exists:services,id',
            'category'         => 'nullable|in:pelatihan,kajian,jasa',
            'seo_title'        => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'custom_heading'   => 'nullable|string|max:255',
            'custom_content'   => 'nullable|string',
        ]);

        CityServiceContent::updateOrCreate(
            [
                'city_id'    => $validated['city_id'],
                'service_id' => $validated['service_id'] ?? null,
                'category'   => $validated['category'] ?? null,
            ],
            $validated
        );

        return redirect()->route('admin.dashboard', ['tab' => 'overrides'])
            ->with('success', "Kustomisasi SEO & konten regional berhasil diperbarui.");
    }

    public function deleteCityContent($id)
    {
        $content = CityServiceContent::findOrFail($id);
        $content->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'overrides'])
            ->with('success', "Override konten wilayah berhasil dihapus.");
    }

    // ── CRUD ARTIKEL / BLOG ──────────────────────────────────────────────────

    public function storeArticle(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:articles,slug',
            'category'         => 'nullable|in:pelatihan,kajian,jasa',
            'service_id'       => 'nullable|exists:services,id',
            'city_id'          => 'nullable|exists:cities,id',
            'kecamatan_id'     => 'nullable|exists:kecamatans,id',
            'excerpt'          => 'nullable|string',
            'content'          => 'required|string',
            'reading_time'     => 'nullable|integer|min:1',
            'seo_title'        => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'focus_keywords'   => 'nullable|string|max:255',
            'status'           => 'required|in:draft,published',
            'internal_links'   => 'nullable|array',
        ]);

        if (empty($validated['slug'])) {
            $base = Str::slug($validated['title']);
            $validated['slug'] = $base;
            $counter = 1;
            while (Article::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $base . '-' . $counter++;
            }
        }

        if (empty($validated['reading_time'])) {
            $wordCount = str_word_count(strip_tags($validated['content']));
            $validated['reading_time'] = max(1, (int) ceil($wordCount / 200));
        }

        if (empty($validated['excerpt'])) {
            $validated['excerpt'] = Str::limit(strip_tags($validated['content']), 200);
        }

        $article = Article::create($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'articles'])
            ->with('success', "Artikel '{$article->title}' berhasil disimpan.");
    }

    public function updateArticle(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:articles,slug,' . $article->id,
            'category'         => 'nullable|in:pelatihan,kajian,jasa',
            'service_id'       => 'nullable|exists:services,id',
            'city_id'          => 'nullable|exists:cities,id',
            'kecamatan_id'     => 'nullable|exists:kecamatans,id',
            'excerpt'          => 'nullable|string',
            'content'          => 'required|string',
            'reading_time'     => 'nullable|integer|min:1',
            'seo_title'        => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'focus_keywords'   => 'nullable|string|max:255',
            'status'           => 'required|in:draft,published',
            'internal_links'   => 'nullable|array',
        ]);

        if (empty($validated['reading_time'])) {
            $wordCount = str_word_count(strip_tags($validated['content']));
            $validated['reading_time'] = max(1, (int) ceil($wordCount / 200));
        }

        $article->update($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'articles'])
            ->with('success', "Artikel '{$article->title}' berhasil diperbarui.");
    }

    public function deleteArticle($id)
    {
        $article = Article::findOrFail($id);
        $title = $article->title;
        $article->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'articles'])
            ->with('success', "Artikel '{$title}' berhasil dihapus.");
    }

    public function toggleArticleStatus($id)
    {
        $article = Article::findOrFail($id);
        $article->status = ($article->status === 'published') ? 'draft' : 'published';
        $article->save();

        $label = $article->status === 'published' ? 'dipublish' : 'dijadikan draft';

        return redirect()->route('admin.dashboard', ['tab' => 'articles'])
            ->with('success', "Artikel '{$article->title}' berhasil {$label}.");
    }

    // ── AI ARTICLE GENERATOR ─────────────────────────────────────────────────

    public function aiGenerateArticle(Request $request)
    {
        $validated = $request->validate([
            'service_id'              => 'nullable|exists:services,id',
            'city_id'                 => 'nullable|exists:cities,id',
            'kecamatan_id'            => 'nullable|exists:kecamatans,id',
            'category'                => 'nullable|in:pelatihan,kajian,jasa',
            'topic'                   => 'nullable|string|max:255',
            'target_keyword'          => 'nullable|string|max:255',
            'word_count'              => 'nullable|integer|min:500|max:5000',
            'tone'                    => 'nullable|string|max:100',
            'additional_instructions' => 'nullable|string|max:1000',
            'save_as_draft'           => 'nullable|boolean',
        ]);

        $service = isset($validated['service_id']) ? Service::find($validated['service_id']) : null;
        $city    = isset($validated['city_id']) ? City::find($validated['city_id']) : null;
        $kecamatan = isset($validated['kecamatan_id']) ? Kecamatan::find($validated['kecamatan_id']) : null;

        // Fetch SEO Override context if available for Service + City
        $seoOverride = null;
        if ($service && $city) {
            $seoOverride = CityServiceContent::where('service_id', $service->id)
                ->where('city_id', $city->id)
                ->first();
        }

        $params = [
            'service_name'            => $service?->name ?? 'Layanan K3',
            'category'                => $validated['category'] ?? $service?->category ?? 'pelatihan',
            'city_name'               => $city?->name ?? 'Nasional',
            'kecamatan_name'          => $kecamatan?->name ?? null,
            'topic'                   => $validated['topic'] ?? null,
            'target_keyword'          => $validated['target_keyword'] ?? null,
            'word_count'              => $validated['word_count'] ?? 1500,
            'tone'                    => $validated['tone'] ?? 'Professional B2B',
            'additional_instructions' => $validated['additional_instructions'] ?? '',
            'seo_override'            => $seoOverride ? [
                'seo_title'        => $seoOverride->seo_title,
                'meta_description' => $seoOverride->meta_description,
                'custom_heading'   => $seoOverride->custom_heading,
                'custom_content'   => $seoOverride->custom_content,
            ] : null,
        ];

        $ollama = new OllamaService();
        $result = $ollama->generateArticle($params);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'error'   => $result['error'] ?? 'Gagal generate artikel dari AI.',
            ], 500);
        }

        // If save_as_draft is NOT provided, we return the result for preview without saving.
        if (!empty($validated['save_as_draft'])) {
            $slug = Str::slug($result['slug'] ?? $result['title']);
            $counter = 1;
            $originalSlug = $slug;
            while (Article::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }

            $wordCount = str_word_count(strip_tags($result['content'] ?? ''));
            $readingTime = max(1, (int) ceil($wordCount / 200));

            $article = Article::create([
                'title'            => $result['title'],
                'slug'             => $slug,
                'category'         => $validated['category'] ?? $service?->category,
                'service_id'       => $validated['service_id'] ?? null,
                'city_id'          => $validated['city_id'] ?? null,
                'kecamatan_id'     => $validated['kecamatan_id'] ?? null,
                'excerpt'          => $result['excerpt'] ?? Str::limit(strip_tags($result['content'] ?? ''), 200),
                'content'          => $result['content'] ?? '',
                'seo_title'        => $result['seo_title'] ?? null,
                'meta_description' => $result['meta_description'] ?? null,
                'focus_keywords'   => $params['target_keyword'] ?? null,
                'faq_items'        => $result['suggested_faqs'] ?? null,
                'internal_links'   => $result['suggested_internal_links'] ?? null,
                'reading_time'     => $readingTime,
                'status'           => 'draft',
            ]);

            $result['saved_article_id'] = $article->id;
            $result['saved_slug']       = $article->slug;
        }

        return response()->json(array_merge($result, ['success' => true]));
    }

    public function previewAiArticle(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string',
            'category' => 'nullable|string',
            'service_id' => 'nullable|integer',
            'city_id' => 'nullable|integer',
            'kecamatan_id' => 'nullable|integer',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'seo_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'focus_keywords' => 'nullable|string',
            'faq_items' => 'nullable|array',
        ]);

        return view('admin.ai-preview', compact('data'));
    }

    // ── CRUD FAQ / Q&A ───────────────────────────────────────────────────────

    public function storeFaq(Request $request)
    {
        $validated = $request->validate([
            'service_id'   => 'nullable|exists:services,id',
            'city_id'      => 'nullable|exists:cities,id',
            'kecamatan_id' => 'nullable|exists:kecamatans,id',
            'question'     => 'required|string',
            'answer'       => 'required|string',
            'order'        => 'nullable|integer|min:0',
            'status'       => 'required|in:published,draft',
        ]);

        Faq::create($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'faqs'])
            ->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function updateFaq(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $validated = $request->validate([
            'service_id'   => 'nullable|exists:services,id',
            'city_id'      => 'nullable|exists:cities,id',
            'kecamatan_id' => 'nullable|exists:kecamatans,id',
            'question'     => 'required|string',
            'answer'       => 'required|string',
            'order'        => 'nullable|integer|min:0',
            'status'       => 'required|in:published,draft',
        ]);

        $faq->update($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'faqs'])
            ->with('success', 'FAQ berhasil diperbarui.');
    }

    public function deleteFaq($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'faqs'])
            ->with('success', 'FAQ berhasil dihapus.');
    }

    // ── CRUD JADWAL PELATIHAN ─────────────────────────────────────────────────

    public function storeSchedule(Request $request)
    {
        $validated = $request->validate([
            'service_id'      => 'required|exists:services,id',
            'city_id'         => 'required|exists:cities,id',
            'date'            => 'required|date',
            'start_time'      => 'nullable|string|max:10',
            'end_time'        => 'nullable|string|max:10',
            'location'        => 'required|string|max:255',
            'available_slots' => 'nullable|integer|min:0',
            'status'          => 'required|in:open,closed,full,completed',
            'notes'           => 'nullable|string',
        ]);

        TrainingSchedule::create($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'schedules'])
            ->with('success', 'Jadwal pelatihan berhasil ditambahkan.');
    }

    public function updateSchedule(Request $request, $id)
    {
        $schedule = TrainingSchedule::findOrFail($id);

        $validated = $request->validate([
            'service_id'      => 'required|exists:services,id',
            'city_id'         => 'required|exists:cities,id',
            'date'            => 'required|date',
            'start_time'      => 'nullable|string|max:10',
            'end_time'        => 'nullable|string|max:10',
            'location'        => 'required|string|max:255',
            'available_slots' => 'nullable|integer|min:0',
            'status'          => 'required|in:open,closed,full,completed',
            'notes'           => 'nullable|string',
        ]);

        $schedule->update($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'schedules'])
            ->with('success', 'Jadwal pelatihan berhasil diperbarui.');
    }

    public function deleteSchedule($id)
    {
        $schedule = TrainingSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'schedules'])
            ->with('success', 'Jadwal pelatihan berhasil dihapus.');
    }

    // ── CRUD KECAMATAN ───────────────────────────────────────────────────────

    public function storeKecamatan(Request $request)
    {
        $validated = $request->validate([
            'city_id'          => 'required|exists:cities,id',
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255',
            'address'          => 'nullable|string|max:255',
            'lat'              => 'nullable|numeric',
            'lng'              => 'nullable|numeric',
            'google_maps_url'  => 'nullable|string',
            'seo_title'        => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status'           => 'required|in:active,inactive',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Pastikan slug unik dalam kota yang sama
        $base = $validated['slug'];
        $counter = 1;
        while (Kecamatan::where('city_id', $validated['city_id'])->where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $base . '-' . $counter++;
        }

        Kecamatan::create($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'kecamatans'])
            ->with('success', "Kecamatan '{$validated['name']}' berhasil ditambahkan.");
    }

    public function updateKecamatan(Request $request, $id)
    {
        $kecamatan = Kecamatan::findOrFail($id);

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255',
            'address'          => 'nullable|string|max:255',
            'lat'              => 'nullable|numeric',
            'lng'              => 'nullable|numeric',
            'google_maps_url'  => 'nullable|string',
            'seo_title'        => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status'           => 'required|in:active,inactive',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $kecamatan->update($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'kecamatans'])
            ->with('success', "Kecamatan '{$kecamatan->name}' berhasil diperbarui.");
    }

    public function deleteKecamatan($id)
    {
        $kecamatan = Kecamatan::findOrFail($id);
        $name = $kecamatan->name;
        $kecamatan->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'kecamatans'])
            ->with('success', "Kecamatan '{$name}' berhasil dihapus.");
    }

    // ── CRUD LOCATION / TITIK PETA ───────────────────────────────────────────

    public function storeLocation(Request $request)
    {
        $validated = $request->validate([
            'city_id'         => 'required|exists:cities,id',
            'kecamatan_id'    => 'nullable|exists:kecamatans,id',
            'location_name'   => 'required|string|max:255',
            'address'         => 'nullable|string|max:255',
            'lat'             => 'nullable|numeric',
            'lng'             => 'nullable|numeric',
            'google_maps_url' => 'nullable|string',
            'status'          => 'required|in:active,inactive',
        ]);

        Location::create($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'locations'])
            ->with('success', "Lokasi '{$validated['location_name']}' berhasil ditambahkan.");
    }

    public function updateLocation(Request $request, $id)
    {
        $location = Location::findOrFail($id);

        $validated = $request->validate([
            'city_id'         => 'required|exists:cities,id',
            'kecamatan_id'    => 'nullable|exists:kecamatans,id',
            'location_name'   => 'required|string|max:255',
            'address'         => 'nullable|string|max:255',
            'lat'             => 'nullable|numeric',
            'lng'             => 'nullable|numeric',
            'google_maps_url' => 'nullable|string',
            'status'          => 'required|in:active,inactive',
        ]);

        $location->update($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'locations'])
            ->with('success', "Lokasi '{$location->location_name}' berhasil diperbarui.");
    }

    public function deleteLocation($id)
    {
        $location = Location::findOrFail($id);
        $name = $location->location_name;
        $location->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'locations'])
            ->with('success', "Lokasi '{$name}' berhasil dihapus.");
    }

    public function contentMatrix(Request $request)
    {
        // Get baseline dashboard data to avoid "Undefined variable" errors in admin.dashboard view
        $data = $this->getDashboardData($request);

        // Filters for the matrix itself
        $serviceFilter = $request->query('matrix_service');
        $categoryFilter = $request->query('matrix_category');
        $cityFilter = $request->query('matrix_city');
        $kecamatanFilter = $request->query('matrix_kecamatan');

        $servicesQuery = Service::query();
        if ($serviceFilter) $servicesQuery->where('id', $serviceFilter);
        if ($categoryFilter) $servicesQuery->where('category', $categoryFilter);
        $matrixServices = $servicesQuery->orderBy('category')->orderBy('name')->get();

        $citiesQuery = City::query();
        if ($cityFilter) $citiesQuery->where('id', $cityFilter);
        $matrixCities = $citiesQuery->orderBy('name')->get();

        // Matrix Data construction
        $coverageMatrix = [];
        foreach ($matrixServices as $service) {
            foreach ($matrixCities as $city) {
                $coverageMatrix[$service->id][$city->id] = $this->calculateCoverage($service->id, $city->id);
            }
        }

        return view('admin.dashboard', array_merge($data, [
            'coverageMatrix' => $coverageMatrix,
            'matrixServices' => $matrixServices,
            'matrixCities'   => $matrixCities,
            'activeTab'       => 'matrix'
        ]));
    }

    private function calculateCoverage($serviceId, $cityId, $kecId = null)
    {
        $article = Article::where('service_id', $serviceId)
            ->where('city_id', $cityId)
            ->when($kecId, fn($q) => $q->where('kecamatan_id', $kecId))
            ->first();

        $hasFaq = Faq::where('service_id', $serviceId)
            ->where('city_id', $cityId)
            ->when($kecId, fn($q) => $q->where('kecamatan_id', $kecId))
            ->exists();

        $hasSeo = false;
        if (!$kecId) {
            $hasSeo = \App\Models\CityServiceContent::where('service_id', $serviceId)
                ->where('city_id', $cityId)
                ->exists();
        }

        $hasLocation = Location::where('city_id', $cityId)
            ->when($kecId, fn($q) => $q->where('kecamatan_id', $kecId))
            ->exists();

        $score = 0;
        if ($article) $score++;
        if ($hasFaq) $score++;
        if ($hasSeo) $score++;

        $status = 'MISSING';
        if ($score === 3) $status = 'COMPLETE';
        elseif ($score > 0) $status = 'PARTIAL';

        return [
            'status' => $status,
            'article' => $article ? ['id' => $article->id, 'slug' => $article->slug] : false,
            'faq' => $hasFaq,
            'seo' => $hasSeo,
            'location' => $hasLocation,
        ];
    }
}
