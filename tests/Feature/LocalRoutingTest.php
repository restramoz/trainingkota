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

    public function test_admin_dashboard_is_accessible(): void
    {
        $response = $this->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('CMS MANAGEMENT CONSOLE');
        $response->assertSee('Katalog & Manajemen Lokasi Kota');
    }
}
