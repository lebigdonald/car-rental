<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'brand',
        'make_year',
        'passenger_capacity',
        'kilometers_per_liter',
        'fuel_type',
        'transmission_type',
        'daily_rate',
        'image_url',
        // 'available' is deprecated, availability is calculated dynamically
    ];

    public function secondaryImages()
    {
        return $this->hasMany(Image::class);
    }

    public function rents()
    {
        return $this->hasMany(Rent::class);
    }

    public function scopeAvailable($query)
    {
        return $query->whereDoesntHave('rents', function ($q) {
            $q->where('start_date', '<=', now())
              ->where('end_date', '>=', now());
        });
    }
}
