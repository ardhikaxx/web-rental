<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            FleetSeeder::class,
            DriverSeeder::class,
            TourSeeder::class,
            PromoSeeder::class,
            BookingSeeder::class,
            TravelSeeder::class,
            WeddingCarSeeder::class,
            CMSSeeder::class,
        ]);
    }
}