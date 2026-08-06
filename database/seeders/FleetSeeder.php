<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fleet;
use App\Models\FleetCategory;

class FleetSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'City Car', 'slug' => 'city-car', 'description' => 'Mobil kota untuk kebutuhan harian'],
            ['name' => 'Sedan', 'slug' => 'sedan', 'description' => 'Mobil sedan nyaman untuk perjalanan dinas'],
            ['name' => 'MPV', 'slug' => 'mpv', 'description' => 'Multi Purpose Vehicle untuk keluarga'],
            ['name' => 'SUV', 'slug' => 'suv', 'description' => 'Sport Utility Vehicle tangguh di segala medan'],
            ['name' => 'Hatchback', 'slug' => 'hatchback', 'description' => 'Mobil kompak & irit'],
            ['name' => 'Premium', 'slug' => 'premium', 'description' => 'Armada premium untuk wedding & VIP'],
            ['name' => 'Wagon / Van', 'slug' => 'wagon-van', 'description' => 'Van penumpang & barang'],
        ];

        foreach ($categories as $c) {
            FleetCategory::firstOrCreate(['slug' => $c['slug']], $c);
        }
        $catIds = FleetCategory::pluck('id', 'slug');

        $models = [
            ['brand' => 'Toyota', 'model' => 'Avanza 1.3', 'category' => 'city-car', 'capacity' => 7, 'price' => 350000, 'type' => 'Bensin'],
            ['brand' => 'Toyota', 'model' => 'Rush', 'category' => 'suv', 'capacity' => 7, 'price' => 450000, 'type' => 'Bensin'],
            ['brand' => 'Toyota', 'model' => 'Innova Zenix', 'category' => 'mpv', 'capacity' => 7, 'price' => 750000, 'type' => 'Bensin'],
            ['brand' => 'Toyota', 'model' => 'Alphard', 'category' => 'premium', 'capacity' => 7, 'price' => 3000000, 'type' => 'Bensin'],
            ['brand' => 'Toyota', 'model' => 'Vellfire', 'category' => 'premium', 'capacity' => 7, 'price' => 3200000, 'type' => 'Bensin'],
            ['brand' => 'Toyota', 'model' => 'Camry', 'category' => 'sedan', 'capacity' => 5, 'price' => 1100000, 'type' => 'Bensin'],
            ['brand' => 'Toyota', 'model' => 'Hiace', 'category' => 'wagon-van', 'capacity' => 14, 'price' => 1500000, 'type' => 'Diesel'],
            ['brand' => 'Toyota', 'model' => 'Fortuner', 'category' => 'suv', 'capacity' => 7, 'price' => 1600000, 'type' => 'Diesel'],
            ['brand' => 'Daihatsu', 'model' => 'Xenia', 'category' => 'city-car', 'capacity' => 7, 'price' => 380000, 'type' => 'Bensin'],
            ['brand' => 'Daihatsu', 'model' => 'Terios', 'category' => 'suv', 'capacity' => 7, 'price' => 480000, 'type' => 'Bensin'],
            ['brand' => 'Daihatsu', 'model' => 'Grand Max', 'category' => 'wagon-van', 'capacity' => 6, 'price' => 420000, 'type' => 'Diesel'],
            ['brand' => 'Daihatsu', 'model' => 'Luxio', 'category' => 'mpv', 'capacity' => 7, 'price' => 400000, 'type' => 'Bensin'],
            ['brand' => 'Honda', 'model' => 'Brio', 'category' => 'hatchback', 'capacity' => 5, 'price' => 300000, 'type' => 'Bensin'],
            ['brand' => 'Honda', 'model' => 'Jazz', 'category' => 'hatchback', 'capacity' => 5, 'price' => 400000, 'type' => 'Bensin'],
            ['brand' => 'Honda', 'model' => 'Civic', 'category' => 'sedan', 'capacity' => 5, 'price' => 700000, 'type' => 'Bensin'],
            ['brand' => 'Honda', 'model' => 'HR-V', 'category' => 'suv', 'capacity' => 5, 'price' => 650000, 'type' => 'Bensin'],
            ['brand' => 'Honda', 'model' => 'CR-V', 'category' => 'suv', 'capacity' => 5, 'price' => 800000, 'type' => 'Bensin'],
            ['brand' => 'Mitsubishi', 'model' => 'Xpander', 'category' => 'mpv', 'capacity' => 7, 'price' => 550000, 'type' => 'Bensin'],
            ['brand' => 'Mitsubishi', 'model' => 'Pajero Sport', 'category' => 'suv', 'capacity' => 7, 'price' => 1800000, 'type' => 'Diesel'],
            ['brand' => 'Mitsubishi', 'model' => 'L300', 'category' => 'wagon-van', 'capacity' => 8, 'price' => 600000, 'type' => 'Diesel'],
            ['brand' => 'Suzuki', 'model' => 'Ertiga', 'category' => 'mpv', 'capacity' => 7, 'price' => 500000, 'type' => 'Bensin'],
            ['brand' => 'Suzuki', 'model' => 'XL7', 'category' => 'suv', 'capacity' => 7, 'price' => 550000, 'type' => 'Bensin'],
            ['brand' => 'Suzuki', 'model' => 'APV', 'category' => 'wagon-van', 'capacity' => 7, 'price' => 420000, 'type' => 'Bensin'],
            ['brand' => 'Nissan', 'model' => 'Grand Livina', 'category' => 'mpv', 'capacity' => 7, 'price' => 520000, 'type' => 'Bensin'],
            ['brand' => 'Hyundai', 'model' => 'Stargazer', 'category' => 'mpv', 'capacity' => 7, 'price' => 600000, 'type' => 'Bensin'],
            ['brand' => 'Wuling', 'model' => 'Aimera', 'category' => 'mpv', 'capacity' => 7, 'price' => 550000, 'type' => 'Bensin'],
            ['brand' => 'Kia', 'model' => 'Carens', 'category' => 'mpv', 'capacity' => 7, 'price' => 700000, 'type' => 'Bensin'],
            ['brand' => 'Mercedes', 'model' => 'Sprinter', 'category' => 'bus', 'capacity' => 20, 'price' => 4000000, 'type' => 'Diesel'],
            ['brand' => 'Hino', 'model' => 'Bus Medium', 'category' => 'bus', 'capacity' => 28, 'price' => 4500000, 'type' => 'Diesel'],
            ['brand' => 'Isuzu', 'model' => 'ELF', 'category' => 'bus', 'capacity' => 16, 'price' => 2000000, 'type' => 'Diesel'],
        ];

        $locations = ['Bondowoso', 'Jember', 'Situbondo', 'Banyuwangi'];
        $colors = ['Hitam', 'Putih', 'Silver', 'Abu-abu', 'Biru', 'Merah', 'Hitam Moka'];
        $years = [2018, 2019, 2020, 2021, 2022, 2023, 2024];
        $trans = ['Manual', 'Automatic'];

        $plateLetters = ['N', 'P', 'B', 'L', 'AG'];
        $statuses = ['tersedia', 'tersedia', 'tersedia', 'dipesan', 'tersedia'];

        for ($i = 1; $i <= 50; $i++) {
            $tmpl = $models[array_rand($models)];
            $letter = $plateLetters[array_rand($plateLetters)];
            $number = rand(100, 9999);
            $plate = sprintf('%s %s %s', $letter, $number, $plateLetters[array_rand($plateLetters)]);
            $year = $years[array_rand($years)];

            $daily = $tmpl['price'];

            $catId = $catIds[$tmpl['category']] ?? null;
            $fleet = Fleet::create([
                'code' => 'F' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                'category_id' => $catId,
                'brand' => $tmpl['brand'],
                'model' => $tmpl['model'],
                'type' => $tmpl['type'],
                'year' => (string) $year,
                'license_plate' => $plate,
                'frame_number' => 'MHFFE' . rand(10000000, 99999999) . 'AA' . $i,
                'engine_number' => 'ENG' . rand(100000, 999999),
                'color' => $colors[array_rand($colors)],
                'capacity' => $tmpl['capacity'],
                'transmission' => $trans[array_rand($trans)],
                'fuel' => $tmpl['type'],
                'daily_price' => $daily,
                'weekly_price' => $daily * 6,
                'monthly_price' => $daily * 22,
                'price_with_driver' => $daily + 150000,
                'price_without_driver' => $daily,
                'location' => $locations[array_rand($locations)],
                'facilities' => 'AC, Audio System, Bensin Full (8 jam), Supir Berpengalaman, Asuransi',
                'description' => $tmpl['brand'] . ' ' . $tmpl['model'] . ' tahun ' . $year . ' kondisi prima, interior bersih, cocok untuk perjalanan keluarga maupun dinas.',
                'status' => $statuses[array_rand($statuses)],
                'is_active' => true,
            ]);
        }
    }
}