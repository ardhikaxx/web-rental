<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promo;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $promos = [
            ['name' => 'Diskon 10% Booking Pertama', 'code' => 'WELCOME10', 'type' => 'persen', 'value' => 10, 'min' => 0, 'max' => 200000],
            ['name' => 'Diskon 15% Rental Mingguan', 'code' => 'WEEKEND15', 'type' => 'persen', 'value' => 15, 'min' => 2000000, 'max' => 300000],
            ['name' => 'Potongan Rp100rb', 'code' => 'HEMAT100', 'type' => 'nominal', 'value' => 100000, 'min' => 1000000, 'max' => 0],
            ['name' => 'Voucher Lebaran', 'code' => 'LEBARAN2026', 'type' => 'persen', 'value' => 20, 'min' => 1500000, 'max' => 400000],
            ['name' => 'Promo Wedding Car', 'code' => 'WEDDING', 'type' => 'nominal', 'value' => 250000, 'min' => 2000000, 'max' => 0],
            ['name' => 'Diskon Anniversary', 'code' => 'RC8TH', 'type' => 'persen', 'value' => 15, 'min' => 0, 'max' => 500000],
            ['name' => 'Paket Wisata Hemat', 'code' => 'TRIPH5', 'type' => 'persen', 'value' => 12, 'min' => 2000000, 'max' => 250000],
            ['name' => 'Member Gold', 'code' => 'GOLD', 'type' => 'persen', 'value' => 8, 'min' => 500000, 'max' => 150000],
            ['name' => 'Akhir Pekan Santai', 'code' => 'WEEKEND', 'type' => 'persen', 'value' => 5, 'min' => 300000, 'max' => 50000],
            ['name' => 'Promo Travel Bali', 'code' => 'BALI', 'type' => 'nominal', 'value' => 150000, 'min' => 1200000, 'max' => 0],
            ['name' => 'Diskon Tahun Baru', 'code' => 'NY2026', 'type' => 'persen', 'value' => 25, 'min' => 2000000, 'max' => 750000],
            ['name' => 'Cashback Kilat', 'code' => 'CASHBACK50', 'type' => 'nominal', 'value' => 50000, 'min' => 600000, 'max' => 0],
            ['name' => 'Promo Bisnis', 'code' => 'CORS', 'type' => 'persen', 'value' => 10, 'min' => 3000000, 'max' => 500000],
            ['name' => 'Diskon Medsos', 'code' => 'RCGRAM', 'type' => 'persen', 'value' => 7, 'min' => 0, 'max' => 100000],
            ['name' => 'Kembali Sehat', 'code' => 'SANSE', 'type' => 'nominal', 'value' => 75000, 'min' => 450000, 'max' => 0],
            ['name' => 'Libur Panjang', 'code' => 'LALONG', 'type' => 'persen', 'value' => 18, 'min' => 1000000, 'max' => 350000],
            ['name' => 'Diskon Jumat', 'code' => 'JUMAT', 'type' => 'nominal', 'value' => 50000, 'min' => 500000, 'max' => 0],
            ['name' => 'Voucher Referral', 'code' => 'RAFEL', 'type' => 'nominal', 'value' => 100000, 'min' => 1000000, 'max' => 0],
            ['name' => 'Promo Pulau', 'code' => 'LOMBOK', 'type' => 'persen', 'value' => 20, 'min' => 1800000, 'max' => 400000],
            ['name' => 'Cuci Gudang BL', 'code' => 'BCL', 'type' => 'persen', 'value' => 30, 'min' => 0, 'max' => 1000000],
        ];

        foreach ($promos as $p) {
            $start = now()->subMonths(rand(0, 3));
            Promo::create([
                'name' => $p['name'],
                'code' => $p['code'],
                'type' => $p['type'],
                'value' => $p['value'],
                'min_purchase' => $p['min'],
                'max_discount' => $p['max'] > 0 ? $p['max'] : null,
                'valid_from' => $start,
                'valid_until' => $start->addMonths(rand(1, 6))->addDays(rand(0, 15)),
                'usage_limit' => rand(100, 1000),
                'used_count' => rand(0, 80),
                'status' => 'aktif',
                'is_active' => true,
            ]);
        }
    }
}