<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CityLandingController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes - TRAININGKOTA.MY.ID (Local Environment)
|--------------------------------------------------------------------------
*/

// 1. Homepage: 3 Pilar Layanan & Widget 212 Kota
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. CMS Admin Dashboard: Manajemen Katalog & Kota
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

// 3. Dynamic City Landing Page: /{category}/kota-{city-slug}
Route::get('/{category}/kota-{citySlug}', [CityLandingController::class, 'show'])
    ->where('category', 'pelatihan|kajian|jasa')
    ->name('city.landing');

// 4. Detail Layanan Master: /{category}/{service-slug}
Route::get('/{category}/{serviceSlug}', [ServiceController::class, 'show'])
    ->where('category', 'pelatihan|kajian|jasa')
    ->name('service.detail');

// 5. Kategori Master: /{category} (pelatihan / kajian / jasa)
Route::get('/{category}', [CategoryController::class, 'show'])
    ->where('category', 'pelatihan|kajian|jasa')
    ->name('category.show');
