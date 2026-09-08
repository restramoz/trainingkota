<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'city_id',
        'date',
        'start_time',
        'end_time',
        'location',
        'available_slots',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'available_slots' => 'integer',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->toDateString())->orderBy('date');
    }
}
