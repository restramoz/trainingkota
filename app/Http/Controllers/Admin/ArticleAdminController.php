<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\City;
use App\Models\Service;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ArticleAdminController extends Controller
{
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

    public function create()
    {
        $services = Service::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $categories = ['pelatihan', 'kajian', 'jasa'];

        return view('admin.articles.create', compact('services', 'cities', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateArticle($request);
        
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $article = Article::create($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dibuat sebagai draft.');
    }

    public function show($id)
    {
        $article = Article::with(['city', 'service', 'kecamatan'])->findOrFail($id);
        return view('admin.articles.show', compact('article'));
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $services = Service::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $kecamatans = $article->city_id ? Kecamatan::where('city_id', $article->city_id)->orderBy('name')->get() : [];
        $categories = ['pelatihan', 'kajian', 'jasa'];

        return view('admin.articles.edit', compact('article', 'services', 'cities', 'kecamatans', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $validated = $this->validateArticle($request);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $article = Article::findOrFail($id);
        $article->status = ($article->status === 'published') ? 'draft' : 'published';
        $article->save();

        return redirect()->back()->with('success', 'Status artikel berhasil diubah ke ' . $article->status);
    }

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
                        $exists = \App\Models\Kecamatan::where('id', $value)
                            ->where('city_id', $request->city_id)
                            ->exists();
                        if (!$exists) {
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

    /**
     * Get kecamatans by city_id for Article targeting.
     */
    public function getKecamatansByCity(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
        ]);

        $kecamatans = Kecamatan::where('city_id', $request->city_id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($kecamatans);
    }
}

