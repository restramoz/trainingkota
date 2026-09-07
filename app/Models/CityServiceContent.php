<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityServiceContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'service_id',
        'category',
        'seo_title',
        'meta_description',
        'custom_heading',
        'custom_content',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
