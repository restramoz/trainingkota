<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocalRoutingTest extends TestCase
{
    public function test_homepage_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Pusat Komando K3');
        $response->assertSee('Widget 212 Kota');
    }

    public function test_category_pages_are_accessible(): void
    {
        $categories = ['pelatihan', 'kajian', 'jasa'];
        foreach ($categories as $cat) {
            $response = $this->get("/{$cat}");
            $response->assertStatus(200);
        }
    }

    public function test_service_detail_page_is_accessible(): void
    {
        $response = $this->get('/pelatihan/ahli-k3-umum');
        $response->assertStatus(200);
        $response->assertSee('Ahli K3 Umum');
        $response->assertSee('Silabus');
    }

    public function test_city_landing_page_is_accessible(): void
    {
        $response = $this->get('/pelatihan/kota-malang');
        $response->assertStatus(200);
        $response->assertSee('Malang');
        $response->assertSee('JADWAL KHUSUS REGIONAL');
    }

    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect(route('login'));
    }

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('System Authentication');
        $response->assertSee('Autentikasi Sistem');
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $response = $this->post('/login', [
            'username' => 'wrong_user',
            'password' => 'wrong_pass',
        ]);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors();
        $this->assertFalse(session()->has('is_admin_authenticated'));
    }

    public function test_login_succeeds_with_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'SuksesJaya2026',
        ]);
        $response->assertRedirect('/admin');
        $this->assertTrue(session()->get('is_admin_authenticated'));
    }

    public function test_logout_clears_admin_session(): void
    {
        $response = $this->withSession(['is_admin_authenticated' => true, 'admin_logged_in' => true])
            ->post('/logout');
        $response->assertRedirect(route('login'));
        $this->assertFalse(session()->has('is_admin_authenticated'));
    }

    public function test_admin_dashboard_is_accessible_when_authenticated(): void
    {
        $response = $this->withSession(['is_admin_authenticated' => true, 'admin_logged_in' => true])
            ->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('PORTAL CMS NASIONAL');
        $response->assertSee('Katalog Master Layanan K3');
        $response->assertSee('Live SERP Preview');
    }

    public function test_city_landing_page_includes_seo_article_and_schema(): void
    {
        $response = $this->get('/pelatihan/kota-malang');
        $response->assertStatus(200);
        $response->assertSee('PANDUAN &amp; REGULASI TERKAIT MALANG', false);
        $response->assertSee('DAFTAR ISI ARTIKEL');
        $response->assertSee('schema.org');
        $response->assertSee('FAQPage');
        $response->assertSee('EducationalOrganization');
    }

    public function test_standalone_article_page_is_accessible(): void
    {
        $response = $this->get('/artikel/panduan-sertifikasi-ahli-k3-umum-kemnaker');
        $response->assertStatus(200);
        $response->assertSee('Panduan Lengkap Sertifikasi Ahli K3 Umum');
        $response->assertSee('DAFTAR ISI');
        $response->assertSee('schema.org');
    }

    public function test_sitemap_xml_is_generated_correctly(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee('<urlset', false);
        $response->assertSee('/pelatihan/ahli-k3-umum', false);
        $response->assertSee('/pelatihan/kota-malang', false);
        $response->assertSee('/pelatihan/ahli-k3-umum/kota-malang', false);
    }

    public function test_hyper_specific_city_service_page_is_accessible_with_schemas(): void
    {
        $response = $this->get('/pelatihan/ahli-k3-umum/kota-malang');
        $response->assertStatus(200);
        $response->assertSee('Ahli K3 Umum di Malang');
        $response->assertSee('SENTRA PRAKTIK', false);
        $response->assertSee('LOKASI: MALANG', false);
        $response->assertSee('BreadcrumbList');
        $response->assertSee('EducationalOrganization');
        $response->assertSee('FAQPage');
    }

    public function test_admin_crud_operations_work(): void
    {
        $sessionData = ['is_admin_authenticated' => true, 'admin_logged_in' => true];

        // 1. Create a service
        $postData = [
            'name' => 'Pelatihan Uji Emisi Udara K3',
            'category' => 'pelatihan',
            'slug' => 'pelatihan-uji-emisi-udara-k3',
            'badge' => 'Sertifikasi BNSP',
            'duration' => '3 Hari',
            'price_estimate' => 'Rp 4.500.000',
            'description' => 'Pelatihan teknis monitoring emisi cerobong industri.',
            'status' => 'published',
        ];
        $createResponse = $this->withSession($sessionData)->post('/admin/services', $postData);
        $createResponse->assertRedirect('/admin?tab=services');
        $this->assertDatabaseHas('services', ['slug' => 'pelatihan-uji-emisi-udara-k3']);

        $service = \App\Models\Service::where('slug', 'pelatihan-uji-emisi-udara-k3')->first();
        $this->assertNotNull($service);

        // 2. Update service
        $updateResponse = $this->withSession($sessionData)->put("/admin/services/{$service->id}", array_merge($postData, [
            'name' => 'Pelatihan Uji Emisi Udara K3 Updated',
        ]));
        $updateResponse->assertRedirect('/admin?tab=services');
        $this->assertDatabaseHas('services', ['name' => 'Pelatihan Uji Emisi Udara K3 Updated']);

        // 3. Update city address
        $city = \App\Models\City::where('slug', 'malang')->first();
        $this->assertNotNull($city);
        $cityUpdate = $this->withSession($sessionData)->put("/admin/cities/{$city->id}", [
            'sentra_praktik' => 'Sentra K3 Malang Raya',
            'address' => 'Kawasan Industri Karanglo',
            'province' => $city->province,
            'lat' => -7.9826,
            'lng' => 112.6308,
            'maps_embed_url' => 'https://maps.google.com/embed?q=Malang',
            'is_hub' => '1',
        ]);
        $cityUpdate->assertRedirect('/admin?tab=cities');
        $this->assertDatabaseHas('cities', [
            'id' => $city->id,
            'sentra_praktik' => 'Sentra K3 Malang Raya',
        ]);

        // 4. Create Regional Content Override
        $overrideResponse = $this->withSession($sessionData)->post('/admin/city-service-contents', [
            'city_id' => $city->id,
            'service_id' => $service->id,
            'category' => 'pelatihan',
            'seo_title' => 'Pelatihan Uji Emisi K3 di Malang',
            'meta_description' => 'Info sertifikasi uji emisi Malang.',
            'custom_heading' => 'Pusat Uji Emisi K3 Malang',
            'custom_content' => 'Layanan khusus uji emisi untuk kawasan industri Malang dan sekitarnya.',
        ]);
        $overrideResponse->assertRedirect('/admin?tab=overrides');
        $this->assertDatabaseHas('city_service_contents', [
            'city_id' => $city->id,
            'service_id' => $service->id,
            'custom_heading' => 'Pusat Uji Emisi K3 Malang',
        ]);

        // Clean up created service
        $deleteResponse = $this->withSession($sessionData)->delete("/admin/services/{$service->id}");
        $deleteResponse->assertRedirect('/admin?tab=services');
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }
}
