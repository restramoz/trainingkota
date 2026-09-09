<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Article;
use App\Models\Faq;
use App\Models\Location;
use App\Models\City;
use App\Models\Kecamatan;

/**
 * Tests for the city/kecamatan targeting validation on Article, FAQ and Location.
 */
class TargetingValidationTest extends TestCase
{
    /** @var array */
    protected $adminSession = ['is_admin_authenticated' => true, 'admin_logged_in' => true];

    /** Helper to get a city and a matching kecamatan */
    protected function getCityAndKecamatan(): array
    {
        $city = City::where('slug', 'malang')->first();
        $kecamatan = Kecamatan::where('city_id', $city->id)->first();
        return [$city, $kecamatan];
    }

    /** @test */
    public function article_generic_is_valid(): void
    {
        $payload = [
            'title'   => 'Test Generic Article',
            'category'=> 'pelatihan',
            'content' => 'Content body',
            'status'  => 'draft',
        ];
        $response = $this->withSession($this->adminSession)->post('/admin/articles', $payload);
        $response->assertRedirect();
        $this->assertDatabaseHas('articles', ['title' => 'Test Generic Article', 'city_id' => null, 'kecamatan_id' => null]);
    }

    /** @test */
    public function article_city_without_kecamatan_is_valid(): void
    {
        $city = City::where('slug', 'malang')->first();
        $payload = [
            'title'   => 'Test City Article',
            'category'=> 'pelatihan',
            'city_id' => $city->id,
            'content' => 'Content',
            'status'  => 'draft',
        ];
        $response = $this->withSession($this->adminSession)->post('/admin/articles', $payload);
        $response->assertRedirect();
        $this->assertDatabaseHas('articles', ['title' => 'Test City Article', 'city_id' => $city->id, 'kecamatan_id' => null]);
    }

    /** @test */
    public function article_kecamatan_must_match_city(): void
    {
        [$city, $kec] = $this->getCityAndKecamatan();
        // Use a mismatched kecamatan from a different city (create one quickly)
        $otherCity = City::where('id', '<>', $city->id)->first();
        $otherKec = Kecamatan::create([
            'city_id' => $otherCity->id,
            'name'    => 'TempKec',
            'slug'    => 'tempkec',
        ]);

        $payload = [
            'title'        => 'Invalid Article',
            'category'     => 'pelatihan',
            'city_id'      => $city->id,
            'kecamatan_id' => $otherKec->id,
            'content'      => 'Body',
            'status'       => 'draft',
        ];
        $response = $this->withSession($this->adminSession)->post('/admin/articles', $payload);
        $response->assertSessionHasErrors('kecamatan_id');
    }

    /** @test */
    public function faq_kecamatan_must_match_city(): void
    {
        $city = City::where('slug', 'malang')->first();
        $otherCity = City::where('id', '<>', $city->id)->first();
        $otherKec = Kecamatan::create([
            'city_id' => $otherCity->id,
            'name'    => 'TempKec2',
            'slug'    => 'tempkec2',
        ]);

        $payload = [
            'question'     => 'Test FAQ?',
            'answer'       => 'Answer',
            'city_id'      => $city->id,
            'kecamatan_id' => $otherKec->id,
            'status'       => 'draft',
        ];
        $response = $this->withSession($this->adminSession)->post('/admin/faqs', $payload);
        $response->assertSessionHasErrors('kecamatan_id');
    }

    /** @test */
    public function location_kecamatan_must_match_city(): void
    {
        $city = City::where('slug', 'malang')->first();
        $otherCity = City::where('id', '<>', $city->id)->first();
        $otherKec = Kecamatan::create([
            'city_id' => $otherCity->id,
            'name'    => 'TempKec3',
            'slug'    => 'tempkec3',
        ]);
        $payload = [
            'name'        => 'Test Location',
            'city_id'     => $city->id,
            'kecamatan_id'=> $otherKec->id,
            'address'     => 'Jalan Test',
            'lat'         => -7.0,
            'lng'         => 112.0,
            'status'      => 'active',
        ];
        $response = $this->withSession($this->adminSession)->post('/admin/locations', $payload);
        $response->assertSessionHasErrors('kecamatan_id');
    }
}
