<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'kecamatan_id',
        'location_name',
        'address',
        'lat',
        'lng',
        'google_maps_url',
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

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
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
            return "https://maps.google.com/maps?q={$this->lat},{$this->lng}&z=15&output=embed";
        }

        $cityName = $this->city ? $this->city->name : '';
        $query = urlencode("{$this->location_name}, {$cityName}, Indonesia");
        return "https://maps.google.com/maps?q={$query}&z=14&output=embed";
    }
}
