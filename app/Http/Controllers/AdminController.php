<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\City;
use App\Models\CityServiceContent;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'services');

        // 1. Services Query
        $categoryFilter = $request->query('category');
        $search = $request->query('q');

        $servicesQuery = Service::query();
        if ($categoryFilter) {
            $servicesQuery->where('category', $categoryFilter);
        }
        if ($search) {
            $servicesQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('badge', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }
        $services = $servicesQuery->orderBy('category')->orderBy('name')->paginate(15, ['*'], 'services_page')->withQueryString();

        // 2. Cities Query
        $citySearch = $request->query('city_q');
        $islandFilter = $request->query('island');

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

        // 3. Overrides Query
        $overrides = CityServiceContent::with(['city', 'service'])->latest()->paginate(10, ['*'], 'overrides_page')->withQueryString();

        // 4. Articles Query (NEW — sync dengan homepage)
        $articleSearch = $request->query('article_q');
        $articleCategoryFilter = $request->query('article_category');

        $articlesQuery = Article::with(['city'])->latest();
        if ($articleCategoryFilter) {
            $articlesQuery->where('category', $articleCategoryFilter);
        }
        if ($articleSearch) {
            $articlesQuery->where(function ($q) use ($articleSearch) {
                $q->where('title', 'like', "%{$articleSearch}%")
                  ->orWhere('slug', 'like', "%{$articleSearch}%")
                  ->orWhere('focus_keywords', 'like', "%{$articleSearch}%");
            });
        }
        $articles = $articlesQuery->paginate(10, ['*'], 'articles_page')->withQueryString();

        // Dropdown lists
        $allServices = Service::orderBy('name')->get();
        $allCities = City::orderBy('name')->get();
        $islands = City::select('island')->distinct()->whereNotNull('island')->pluck('island');

        // Stats Overview — semua dari DB real (sync dengan homepage)
        $stats = [
            'total_services'   => Service::count(),
            'total_pelatihan'  => Service::where('category', 'pelatihan')->count(),
            'total_kajian'     => Service::where('category', 'kajian')->count(),
            'total_jasa'       => Service::where('category', 'jasa')->count(),
            'total_cities'     => City::count(),
            'total_hubs'       => City::where('is_hub', true)->count(),
            'total_overrides'  => CityServiceContent::count(),
            'total_articles'   => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'draft_articles'   => Article::where('status', 'draft')->count(),
        ];

        return view('admin.dashboard', compact(
            'activeTab',
            'services',
            'cities',
            'overrides',
            'articles',
            'allServices',
            'allCities',
            'stats',
            'islands',
            'categoryFilter',
            'search',
            'citySearch',
            'islandFilter',
            'articleSearch',
            'articleCategoryFilter'
        ));
    }

    // ── CRUD LAYANAN ────────────────────────────────────────────────────────

    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:pelatihan,kajian,jasa',
            'slug' => 'nullable|string|unique:services,slug|max:255',
            'badge' => 'nullable|string|max:100',
            'duration' => 'nullable|string|max:100',
            'price_estimate' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:published,draft',
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
            'name' => 'required|string|max:255',
            'category' => 'required|in:pelatihan,kajian,jasa',
            'slug' => 'required|string|max:255|unique:services,slug,' . $service->id,
            'badge' => 'nullable|string|max:100',
            'duration' => 'nullable|string|max:100',
            'price_estimate' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:published,draft',
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

    // ── CRUD ALAMAT PERWAKILAN KOTA ──────────────────────────────────────────

    public function updateCity(Request $request, $id)
    {
        $city = City::findOrFail($id);

        $validated = $request->validate([
            'sentra_praktik' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:100',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'maps_embed_url' => 'nullable|string',
            'is_hub' => 'nullable|boolean',
        ]);

        $validated['is_hub'] = $request->has('is_hub');

        $city->update($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'cities'])
            ->with('success', "Data sentra praktik & alamat perwakilan kota '{$city->name}' berhasil disimpan.");
    }

    // ── CRUD OVERRIDES KONTEN / SEO PER KOTA ──────────────────────────────────

    public function storeCityContent(Request $request)
    {
        $validated = $request->validate([
            'city_id' => 'required|exists:cities,id',
            'service_id' => 'nullable|exists:services,id',
            'category' => 'nullable|in:pelatihan,kajian,jasa',
            'seo_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'custom_heading' => 'nullable|string|max:255',
            'custom_content' => 'nullable|string',
        ]);

        CityServiceContent::updateOrCreate(
            [
                'city_id' => $validated['city_id'],
                'service_id' => $validated['service_id'] ?? null,
                'category' => $validated['category'] ?? null,
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
}
