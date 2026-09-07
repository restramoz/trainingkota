<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\City;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($category)
    {
        $validCategories = ['pelatihan', 'kajian', 'jasa'];
        if (!in_array($category, $validCategories)) {
            abort(404);
        }

        $services = Service::where('category', $category)->orderBy('id')->get();
        $hubCities = City::where('is_hub', true)->get();
        $allCities = City::orderBy('name')->get();

        $titles = [
            'pelatihan' => 'Katalog Program Pelatihan & Sertifikasi K3',
            'kajian' => 'Kajian Teknis & Studi Kelayakan K3 Industri',
            'jasa' => 'Jasa Teknis, SLF & Perizinan Industri K3',
        ];

        $subtitles = [
            'pelatihan' => 'Sertifikasi resmi Kemnaker RI dan BNSP untuk peningkatan kompetensi ahli keselamatan kerja seluruh Indonesia.',
            'kajian' => 'Analisis komprehensif keselamatan, manajemen risiko kebakaran, dan evaluasi kepatuhan operasional fasilitas.',
            'jasa' => 'Pengurusan legalitas perizinan, sertifikat laik fungsi (SLF), SLO, serta riksa uji peralatan keteknikan.',
        ];

        $categoryTitle = $titles[$category] ?? ucfirst($category);
        $categorySubtitle = $subtitles[$category] ?? '';

        $viewName = view()->exists("services.{$category}") ? "services.{$category}" : 'category';

        return view($viewName, compact(
            'category',
            'categoryTitle',
            'categorySubtitle',
            'services',
            'hubCities',
            'allCities'
        ));
    }
}
