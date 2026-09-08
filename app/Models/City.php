<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'island',
        'is_hub',
        'lat',
        'lng',
        'address',
        'province',
        'sentra_praktik',
        'maps_embed_url',
    ];

    protected $casts = [
        'is_hub' => 'boolean',
        'lat'    => 'float',
        'lng'    => 'float',
    ];

    /**
     * Artikel yang dikaitkan dengan kota ini.
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Overrides konten dan SEO khusus kota ini.
     */
    public function cityServiceContents()
    {
        return $this->hasMany(CityServiceContent::class);
    }

    public function kecamatans()
    {
        return $this->hasMany(Kecamatan::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }

    public function trainingSchedules()
    {
        return $this->hasMany(TrainingSchedule::class);
    }

    /**
     * Cek apakah kota punya koordinat untuk Maps embed.
     */
    public function hasGeo(): bool
    {
        return !is_null($this->lat) && !is_null($this->lng);
    }

    /**
     * Generate Google Maps embed URL.
     */
    public function mapsEmbedUrl(): string
    {
        if (!empty($this->maps_embed_url)) {
            return $this->maps_embed_url;
        }

        if ($this->hasGeo()) {
            return "https://maps.google.com/maps?q={$this->lat},{$this->lng}&z=14&output=embed";
        }

        // Fallback: search by sentra / city name
        $search = $this->sentra_praktik ? $this->sentra_praktik . ', ' . $this->name : $this->name . ', Indonesia';
        $query = urlencode($search);
        return "https://maps.google.com/maps?q={$query}&z=13&output=embed";
    }
}
