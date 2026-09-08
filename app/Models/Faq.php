<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'city_id',
        'kecamatan_id',
        'question',
        'answer',
        'order',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('id');
    }

    public static function forContext(?int $serviceId = null, ?int $cityId = null, ?int $kecamatanId = null)
    {
        return static::published()
            ->where(function ($q) use ($serviceId, $cityId, $kecamatanId) {
                if ($kecamatanId) {
                    $q->where('kecamatan_id', $kecamatanId);
                }
                if ($cityId) {
                    $q->orWhere('city_id', $cityId);
                }
                if ($serviceId) {
                    $q->orWhere('service_id', $serviceId);
                }
            })
            ->ordered()
            ->get();
    }
}
