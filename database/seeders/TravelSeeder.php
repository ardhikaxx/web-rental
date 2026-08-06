<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IntercityTravel;
use Illuminate\Support\Str;

class TravelSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            ['o' => 'Bondowoso', 'd' => 'Surabaya', 'price' => 180000, 'hours' => 5, 'quota' => 4],
            ['o' => 'Bondowoso', 'd' => 'Malang', 'price' => 130000, 'hours' => 4, 'quota' => 4],
            ['o' => 'Bondowoso', 'd' => 'Denpasar', 'price' => 650000, 'hours' => 10, 'quota' => 4],
            ['o' => 'Bondowoso', 'd' => 'Jakarta', 'price' => 900000, 'hours' => 16, 'quota' => 4],
            ['o' => 'Bondowoso', 'd' => 'Banyuwangi', 'price' => 120000, 'hours' => 3, 'quota' => 4],
            ['o' => 'Bondowoso', 'd' => 'Jember', 'price' => 70000, 'hours' => 2, 'quota' => 4],
            ['o' => 'Bondowoso', 'd' => 'Situbondo', 'price' => 65000, 'hours' => 1.5, 'quota' => 4],
            ['o' => 'Bondowoso', 'd' => 'Probolinggo', 'price' => 100000, 'hours' => 3, 'quota' => 4],
            ['o' => 'Bondowoso', 'd' => 'Pasuruan', 'price' => 110000, 'hours' => 3, 'quota' => 4],
            ['o' => 'Bondowoso', 'd' => 'Jogjakarta', 'price' => 850000, 'hours' => 16, 'quota' => 4],
        ];

        foreach ($routes as $r) {
            $slug = Str::slug($r['o'] . ' ke ' . $r['d'] . '-' . mt_rand(10, 99));
            IntercityTravel::create([
                'name' => 'Travel ' . $r['o'] . ' – ' . $r['d'],
                'route_origin' => $r['o'],
                'route_destination' => $r['d'],
                'slug' => $slug,
                'price' => $r['price'],
                'travel_time_hours' => $r['hours'],
                'departure_time' => '06:00',
                'quota' => $r['quota'],
                'pickup_points' => "Terminal Bondowoso\nJl. P.B. Sudirman\nDepan RSUD Bondowoso",
                'dropoff_points' => "Terminal Tipe A\nAlamat tujuan di kota tujuan",
                'status' => 'aktif',
            ]);
        }
    }
}