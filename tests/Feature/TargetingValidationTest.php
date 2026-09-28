<?php

namespace Tests\Feature;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
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

    #[Test]
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

    #[Test]
    public function article_global_targeting_is_enforced(): void
    {
        $city = City::where('slug', 'malang')->first();
        $payload = [
            'title'   => 'Test Global Article',
            'category'=> 'pelatihan',
            'city_id' => $city->id, // Should be ignored/forced to null
            'content' => 'Content',
            'status'  => 'draft',
        ];
        $response = $this->withSession($this->adminSession)->post('/admin/articles', $payload);
        $response->assertRedirect();
        // New behavior: city_id and kecamatan_id are forced to NULL (global targeting)
        $this->assertDatabaseHas('articles', ['title' => 'Test Global Article', 'city_id' => null, 'kecamatan_id' => null]);
    }

    #[Test]
    public function article_kecamatan_validation_skipped_for_global(): void
    {
        [$city, $kec] = $this->getCityAndKecamatan();
        // Use a mismatched kecamatan from a different city
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
        // New behavior: no validation error because city_id/kecamatan_id are forced to NULL
        $response->assertRedirect();
        $this->assertDatabaseHas('articles', ['title' => 'Invalid Article', 'city_id' => null, 'kecamatan_id' => null]);
    }

    #[Test]
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

    #[Test]
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
