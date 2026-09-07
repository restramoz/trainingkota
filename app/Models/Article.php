<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'service_id',
        'city_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'reading_time',
        'faq_items',
        'seo_title',
        'meta_description',
        'focus_keywords',
        'status',
    ];

    protected $casts = [
        'faq_items' => 'array',
    ];

    /**
     * Relasi ke kota (opsional).
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Relasi ke layanan (opsional).
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Scope: hanya artikel yang published.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope: filter berdasarkan kategori.
     */
    public function scopeForCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
