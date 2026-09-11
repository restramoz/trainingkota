<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CityLandingController;
use App\Http\Controllers\CityServiceLandingController;
use App\Http\Controllers\KecamatanLandingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BlogController;

use App\Http\Controllers\SitemapController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ArticleAdminController;
use App\Http\Controllers\Admin\ScheduleAdminController;


/*
|--------------------------------------------------------------------------
| Web Routes - TRAININGKOTA.MY.ID (Local Environment)
|--------------------------------------------------------------------------
*/

// 0. Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 1. Dynamic Sitemap.xml
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// 2. Homepage: 3 Pilar Layanan & Widget 212 Kota
Route::get('/', [HomeController::class, 'index'])->name('home');

// 3. CMS Admin Dashboard & CRUD (Protected by admin.auth)
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // CRUD Layanan
    Route::get('/services/manage', [AdminController::class, 'manageServices'])->name('services.manage');
    Route::post('/services', [AdminController::class, 'storeService'])->name('services.store');
    Route::put('/services/{id}', [AdminController::class, 'updateService'])->name('services.update');
    Route::delete('/services/{id}', [AdminController::class, 'deleteService'])->name('services.delete');

    // CRUD Kota
    Route::get('/locations', [AdminController::class, 'manageLocations'])->name('locations.manage');
    Route::put('/cities/{id}', [AdminController::class, 'updateCity'])->name('cities.update');

    // CRUD Overrides Konten / SEO per Kota
    Route::post('/city-service-contents', [AdminController::class, 'storeCityContent'])->name('city-contents.store');
    Route::delete('/city-service-contents/{id}', [AdminController::class, 'deleteCityContent'])->name('city-contents.delete');
    Route::get('/content-matrix', [AdminController::class, 'contentMatrix'])->name('content-matrix');

    // CRUD Artikel / Blog
    // Coverage matrix for articles
    Route::get('/articles/coverage', [ArticleAdminController::class, 'coverage'])->name('articles.coverage');

    Route::resource('articles', ArticleAdminController::class)->names([
        'index' => 'articles.index',
        'create' => 'articles.create',
        'store' => 'articles.store',
        'show' => 'articles.show',
        'edit' => 'articles.edit',
        'update' => 'articles.update',
        'destroy' => 'articles.destroy',
    ]);
    Route::post('/articles/{id}/toggle-status', [ArticleAdminController::class, 'toggleStatus'])->name('articles.toggle-status');
    Route::get('/kecamatans/get', [ArticleAdminController::class, 'getKecamatansByCity']);



    // AI Article Generator - returns an unsaved draft to the Article form.
    Route::post('/articles/ai-generate', [AdminController::class, 'aiGenerateArticle'])->name('articles.ai-generate');
    Route::get('/articles/ai-preview', [AdminController::class, 'previewAiArticle'])->name('articles.ai-preview');

    // CRUD FAQ / Q&A
    Route::post('/faqs', [AdminController::class, 'storeFaq'])->name('faqs.store');
    Route::put('/faqs/{id}', [AdminController::class, 'updateFaq'])->name('faqs.update');
    Route::delete('/faqs/{id}', [AdminController::class, 'deleteFaq'])->name('faqs.delete');

    // CRUD Jadwal Pelatihan
    Route::resource('schedules', ScheduleAdminController::class)->names([
        'index' => 'schedules.index',
        'create' => 'schedules.create',
        'store' => 'schedules.store',
        'show' => 'schedules.show',
        'edit' => 'schedules.edit',
        'update' => 'schedules.update',
        'destroy' => 'schedules.destroy',
    ]);

    // CRUD Kecamatan
    Route::post('/kecamatans', [AdminController::class, 'storeKecamatan'])->name('kecamatans.store');
    Route::put('/kecamatans/{id}', [AdminController::class, 'updateKecamatan'])->name('kecamatans.update');
    Route::delete('/kecamatans/{id}', [AdminController::class, 'deleteKecamatan'])->name('kecamatans.delete');

    // CRUD Location / Titik Peta
    Route::post('/locations', [AdminController::class, 'storeLocation'])->name('locations.store');
    Route::put('/locations/{id}', [AdminController::class, 'updateLocation'])->name('locations.update');
    Route::delete('/locations/{id}', [AdminController::class, 'deleteLocation'])->name('locations.delete');

    // CRUD Graphics
    Route::get('/graphics', [AdminController::class, 'manageGraphics'])->name('graphics.manage');
});


// 4a. Blog Portal
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');


// 4. Artikel SEO: /artikel/{slug}
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('article.show');

// 5. Hyper-Specific City Service Landing: /{category}/{service-slug}/kota-{city-slug}
Route::get('/{category}/{serviceSlug}/kota-{citySlug}', [CityServiceLandingController::class, 'show'])
    ->where('category', 'pelatihan|kajian|jasa')
    ->name('city.service.landing');

// 6. Dynamic City Landing Page: /{category}/kota-{city-slug}
Route::get('/{category}/kota-{citySlug}', [CityLandingController::class, 'show'])
    ->where('category', 'pelatihan|kajian|jasa')
    ->name('city.landing');

Route::get('/{category}/kecamatan-{kecamatanSlug}', [KecamatanLandingController::class, 'show'])
    ->where('category', 'pelatihan|kajian|jasa')
    ->name('kecamatan.landing');

// 7. Detail Layanan Master: /{category}/{service-slug}
Route::get('/{category}/{serviceSlug}', [ServiceController::class, 'show'])
    ->where('category', 'pelatihan|kajian|jasa')
    ->name('service.detail');

// 8. Kategori Master: /{category} (pelatihan / kajian / jasa)
Route::get('/{category}', [CategoryController::class, 'show'])
    ->where('category', 'pelatihan|kajian|jasa')
    ->name('category.show');
