<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\City;
use App\Models\Service;
use App\Models\Kecamatan;
use App\Models\CityServiceContent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ArticleAdminController extends Controller
{
    /** List articles with filters */
    public function index(Request $request)
    {
        $search = $request->query('q');
        $category = $request->query('category');
        $serviceId = $request->query('service_id');
        $cityId = $request->query('city_id');
        $status = $request->query('status');

        $query = Article::with(['city', 'service', 'kecamatan'])->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        if ($category) {
            $query->where('category', $category);
        }
        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }
        if ($cityId) {
            $query->where('city_id', $cityId);
        }
        if ($status) {
            $query->where('status', $status);
        }

        $articles = $query->paginate(20)->withQueryString();
        $services = Service::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $categories = ['pelatihan', 'kajian', 'jasa'];

        return view('admin.articles.index', compact('articles', 'services', 'cities', 'categories'));
    }

    /** Show creation form */
    public function create()
    {
        $services = Service::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $categories = ['pelatihan', 'kajian', 'jasa'];
        return view('admin.articles.create', compact('services', 'cities', 'categories'));
    }

    /** Store new article */
    public function store(Request $request)
    {
        $validated = $this->validateArticle($request);
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Duplicate protection
        $dup = Article::where('service_id', $validated['service_id'] ?? null)
            ->where('city_id', $validated['city_id'] ?? null);
        if (!empty($validated['kecamatan_id'])) {
            $dup->where('kecamatan_id', $validated['kecamatan_id']);
        } else {
            $dup->whereNull('kecamatan_id');
        }
        if ($dup->exists()) {
            return redirect()->back()->withInput()->withErrors([
                'city_id' => 'Artikel untuk kombinasi layanan dan wilayah ini sudah ada.',
            ]);
        }

        $article = Article::create($validated);
        if ($validated['status'] === 'published') {
            $this->ensureCatalogCoverage($article);
        }
        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dibuat.');
    }

    /** Show edit form */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $services = Service::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $categories = ['pelatihan', 'kajian', 'jasa'];
        return view('admin.articles.edit', compact('article', 'services', 'cities', 'categories'));
    }

    /** Update existing article */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $validated = $this->validateArticle($request);
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        // Duplicate protection excluding current article
        $dup = Article::where('service_id', $validated['service_id'] ?? null)
            ->where('city_id', $validated['city_id'] ?? null);
        if (!empty($validated['kecamatan_id'])) {
            $dup->where('kecamatan_id', $validated['kecamatan_id']);
        } else {
            $dup->whereNull('kecamatan_id');
        }
        $dup->where('id', '!=', $article->id);
        if ($dup->exists()) {
            return redirect()->back()->withInput()->withErrors([
                'city_id' => 'Artikel untuk kombinasi layanan dan wilayah ini sudah ada.',
            ]);
        }
        $article->update($validated);
        if ($validated['status'] === 'published') {
            $this->ensureCatalogCoverage($article);
        }
        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    /** Delete */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    /** Toggle published status */
    public function toggleStatus($id)
    {
        $article = Article::findOrFail($id);
        $article->status = ($article->status === 'published') ? 'draft' : 'published';
        $article->save();
        if ($article->status === 'published') {
            $this->ensureCatalogCoverage($article);
        }
        return redirect()->back()
            ->with('success', 'Status artikel berhasil diubah ke ' . $article->status);
    }

    /** Coverage matrix view */
    public function coverage(Request $request)
    {
        $serviceId = $request->query('service_id');
        $service = $serviceId ? Service::find($serviceId) : null;
        $services = Service::orderBy('name')->get();
        $cities = City::orderBy('name')->paginate(20)->withQueryString();
        $articleMap = [];
        if ($service) {
            $cityIds = $cities->pluck('id')->toArray();
            $articles = Article::where('service_id', $service->id)
                ->whereIn('city_id', $cityIds)
                ->get();
            foreach ($articles as $a) {
                $key = $a->city_id;
                if (!isset($articleMap[$key]) || $a->status === 'published') {
                    $articleMap[$key] = $a->status;
                }
            }
        }
        return view('admin.articles.coverage', compact('service', 'services', 'cities', 'articleMap'));
    }

    /** Validation helper */
    protected function validateArticle(Request $request)
    {
        return Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category' => 'required|in:pelatihan,kajian,jasa',
            'service_id' => 'nullable|exists:services,id',
            'city_id' => 'nullable|exists:cities,id',
            'kecamatan_id' => [
                'nullable',
                'exists:kecamatans,id',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && $request->city_id) {
                        $exists = Kecamatan::where('id', $value)
                            ->where('city_id', $request->city_id)
                            ->exists();
                        if (! $exists) {
                            $fail('Kecamatan yang dipilih tidak sesuai dengan Kota.');
                        }
                    }
                },
            ],
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'seo_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'focus_keywords' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ])->validate();
    }

    /** Ajax helper for kecamatans */
    public function getKecamatansByCity(Request $request)
    {
        $request->validate(['city_id' => 'required|exists:cities,id']);
        $kecamatans = Kecamatan::where('city_id', $request->city_id)
            ->orderBy('name')
            ->get(['id', 'name']);
        return response()->json($kecamatans);
    }

    /** Show a single article (admin view) */
    public function show($id)
    {
        $article = Article::with(['city', 'service', 'kecamatan'])->findOrFail($id);
        return view('admin.articles.show', compact('article'));
    }

    /** Ensure catalog coverage exists for a published article */
    protected function ensureCatalogCoverage(Article $article)
    {
        if (! $article->service_id || ! $article->city_id) {
            return;
        }
        $exists = CityServiceContent::where('service_id', $article->service_id)
            ->where('city_id', $article->city_id)
            ->exists();
        if (! $exists) {
            CityServiceContent::create([
                'service_id' => $article->service_id,
                'city_id'    => $article->city_id,
                'category'   => $article->category ?? null,
                'seo_title'  => $article->seo_title ?? null,
                'meta_description' => $article->meta_description ?? null,
            ]);
        }
    }
}
