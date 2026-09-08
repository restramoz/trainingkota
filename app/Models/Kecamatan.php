<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'name',
        'slug',
        'address',
        'lat',
        'lng',
        'google_maps_url',
        'seo_title',
        'meta_description',
        'status',
    ];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function hasGeo(): bool
    {
        return !is_null($this->lat) && !is_null($this->lng);
    }

    public function mapsEmbedUrl(): string
    {
        if (!empty($this->google_maps_url)) {
            return $this->google_maps_url;
        }

        if ($this->hasGeo()) {
            return "https://maps.google.com/maps?q={$this->lat},{$this->lng}&z=14&output=embed";
        }

        $cityName = $this->city ? $this->city->name : '';
        $query = urlencode("Kecamatan {$this->name}, {$cityName}, Indonesia");
        return "https://maps.google.com/maps?q={$query}&z=13&output=embed";
    }
}
