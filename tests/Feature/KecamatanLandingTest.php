<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\City;
use App\Models\Kecamatan;
use App\Models\Service;

class KecamatanLandingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_all_published_services_for_a_kecamatan()
    {
        // Create a city
        $city = City::create([
            'name' => 'Test City',
            'slug' => 'test-city',
            'status' => 'active',
        ]);

        // Create a Kecamatan
        $kecamatan = Kecamatan::create([
            'city_id' => $city->id,
            'name' => 'Test Kecamatan',
            'slug' => 'test-kecamatan',
            'status' => 'active',
        ]);

        // Create a published service
        $publishedService = Service::create([
            'category' => 'pelatihan',
            'name' => 'Published Test Service',
            'slug' => 'published-test-service',
            'badge' => 'Test Badge',
            'duration' => '2 Hari',
            'description' => 'A test service description.',
            'status' => 'published',
        ]);

        // Create an unpublished (draft) service
        $draftService = Service::create([
            'category' => 'pelatihan',
            'name' => 'Draft Test Service',
            'slug' => 'draft-test-service',
            'badge' => 'Draft Badge',
            'duration' => '2 Hari',
            'description' => 'A draft service description.',
            'status' => 'draft',
        ]);

        // Hit the Kecamatan landing page for the given category
        $response = $this->get('/pelatihan/kecamatan-' . $kecamatan->slug);
        $response->assertStatus(200);
        $response->assertSee($publishedService->name);
        $response->assertDontSee($draftService->name);
        // Ensure the service link points to the correct city service landing route
        $response->assertSee(route('city.service.landing', [
            'category' => $publishedService->category,
            'serviceSlug' => $publishedService->slug,
            'citySlug' => $city->slug,
        ]), false);
    }

    /** @test */
    public function it_returns_404_for_invalid_kecamatan_slug()
    {
        $response = $this->get('/pelatihan/kecamatan-nonexistent');
        $response->assertStatus(404);
    }
}
