<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fleet;
use App\Models\WeddingCar;
use Illuminate\Support\Str;

class WeddingCarSeeder extends Seeder
{
    public function run(): void
    {
        $fleets = Fleet::whereIn('category_id', Fleet::whereHas('category',
            fn ($q) => $q->whereIn('slug', ['premium', 'sedan', 'mpv', 'suv']))->pluck('category_id'))->get();

        $packages = [
            ['name' => 'Alphard Wedding Package', 'area' => 'Bondowoso & sekitarnya', 'hours' => 6],
            ['name' => 'Vellfire Royal Wedding', 'area' => 'Bondowoso & sekitarnya', 'hours' => 8],
            ['name' => 'Innova Zenix Wedding', 'area' => 'Bondowoso & sekitarnya', 'hours' => 6],
            ['name' => 'Fortuner Prestige', 'area' => 'Bondowoso & sekitarnya', 'hours' => 6],
            ['name' => 'Camry Mewah', 'area' => 'se-Jawa Timur', 'hours' => 8],
            ['name' => 'Hiace Vintage Wedding', 'area' => 'se-Jawa Timur', 'hours' => 8],
        ];

        foreach ($packages as $i => $p) {
            $fleet = $fleets->random();
            $rental = $fleet->daily_price ?? 1500000;
            $decoration = 750000;
            $driverFee = 300000;
            WeddingCar::create([
                'name' => $p['name'],
                'slug' => Str::slug($p['name']) . '-' . mt_rand(10, 99),
                'fleet_id' => $fleet->id,
                'area' => $p['area'],
                'rental_price' => $rental,
                'decoration_price' => $decoration,
                'driver_price' => $driverFee,
                'total_price' => $rental + $decoration + $driverFee,
                'duration_hours' => $p['hours'],
                'decoration_details' => "Dekorasi bunga segar\nRibbon door\nBonquet pengantin\nBoneka pengantin\nBellow & belian",
                'status' => 'aktif',
                'is_active' => true,
            ]);
        }
    }
}