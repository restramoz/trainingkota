<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'name',
        'slug',
        'badge',
        'duration',
        'price_estimate',
        'description',
        'syllabus',
        'target_audience',
        'status',
    ];

    protected $casts = [
        'syllabus' => 'array',
    ];

    public function cityServiceContents()
    {
        return $this->hasMany(CityServiceContent::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
