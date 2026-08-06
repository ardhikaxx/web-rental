<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntercityTravel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'route_origin', 'route_destination', 'slug', 'price',
        'travel_time_hours', 'departure_time', 'quota', 'pickup_points',
        'dropoff_points', 'status', 'created_by', 'updated_by',
    ];

    protected $casts = ['price' => 'decimal:2'];

    public static function routes(): array
    {
        return [
            'Bondowoso' => 'Bondowoso',
            'Surabaya' => 'Surabaya',
            'Malang' => 'Malang',
            'Banyuwangi' => 'Banyuwangi',
            'Jember' => 'Jember',
            'Situbondo' => 'Situbondo',
            'Denpasar' => 'Denpasar (Bali)',
            'Jakarta' => 'Jakarta',
            'Jogjakarta' => 'Jogjakarta',
        ];
    }
}