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
        if ($this->hasGeo()) {
            return "https://maps.google.com/maps?q={$this->lat},{$this->lng}&z=14&output=embed";
        }
        // Fallback: search by city name
        $query = urlencode($this->name . ', Indonesia');
        return "https://maps.google.com/maps?q={$query}&z=13&output=embed";
    }
}
