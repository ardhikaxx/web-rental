<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TourPackage;
use App\Models\TourSchedule;
use Illuminate\Support\Str;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            ['name' => 'Trip Wisata Ijen Blue Fire', 'destination' => 'Kawah Ijen, Banyuwangi', 'days' => 2, 'pax' => 350000, 'grp' => 3500000, 'maxg' => 15],
            ['name' => 'Wonderland Baluran Safari', 'destination' => 'Taman Nasional Baluran, Situbondo', 'days' => 2, 'pax' => 250000, 'grp' => 2500000, 'maxg' => 20],
            ['name' => 'Baluran + Ijen Combo', 'destination' => 'Banyuwangi & Situbondo', 'days' => 3, 'pax' => 500000, 'grp' => 4800000, 'maxg' => 15],
            ['name' => 'Rafting B29 Sukamade', 'destination' => 'Arung Jeram B29, Sukamade', 'days' => 2, 'pax' => 400000, 'grp' => 3800000, 'maxg' => 12],
            ['name' => 'Pulau Merah Beach Trip', 'destination' => 'Pantai Pulau Merah, Banyuwangi', 'days' => 2, 'pax' => 220000, 'grp' => 2200000, 'maxg' => 15],
            ['name' => 'Bukit Cinta & Ranu Klakah', 'destination' => 'Bukit Cinta, Klakah', 'days' => 1, 'pax' => 120000, 'grp' => 1200000, 'maxg' => 15],
            ['name' => 'Gunung Raung Expedition', 'destination' => 'Gunung Raung, Bondowoso', 'days' => 2, 'pax' => 450000, 'grp' => 4300000, 'maxg' => 12],
            ['name' => 'Teluk Ijo & Sukamade', 'destination' => 'Teluk Ijo, Meru Betiri', 'days' => 2, 'pax' => 300000, 'grp' => 2900000, 'maxg' => 15],
            ['name' => 'Kawah Wurung', 'destination' => 'Kawah Wurung, Situbondo', 'days' => 1, 'pax' => 100000, 'grp' => 1000000, 'maxg' => 20],
            ['name' => 'Taman Nasional Meru Betiri', 'destination' => 'Meru Betiri, Jember', 'days' => 2, 'pax' => 350000, 'grp' => 3400000, 'maxg' => 15],
            ['name' => 'Rasuna Beach Tour', 'destination' => 'Pantai Rasuna, Banyuwangi', 'days' => 1, 'pax' => 150000, 'grp' => 1400000, 'maxg' => 20],
            ['name' => 'Sukamade Turtle Watching', 'destination' => 'Sukamade, Meru Betiri', 'days' => 2, 'pax' => 600000, 'grp' => 5500000, 'maxg' => 10],
            ['name' => 'Bromo Gunung Bromo', 'destination' => 'Gunung Bromo', 'days' => 2, 'pax' => 400000, 'grp' => 3800000, 'maxg' => 15],
            ['name' => 'batu & Musang Coffee', 'destination' => 'Batu, Kawah Ijen', 'days' => 2, 'pax' => 380000, 'grp' => 3600000, 'maxg' => 12],
            ['name' => 'Ken Puri & Sukorambi', 'destination' => 'Ken Puri, Sukorambi', 'days' => 1, 'pax' => 130000, 'grp' => 1200000, 'maxg' => 20],
            ['name' => 'Wedding Sunset Tour', 'destination' => 'Pantai Paseban, Jember', 'days' => 2, 'pax' => 280000, 'grp' => 2700000, 'maxg' => 15],
            ['name' => 'Olina Blue Fire', 'destination' => 'Kawah Ijen & Homestay Olina', 'days' => 2, 'pax' => 320000, 'grp' => 3000000, 'maxg' => 12],
            ['name' => 'Sukade Family Tour', 'destination' => 'Sukamade & Pulau Merah', 'days' => 3, 'pax' => 700000, 'grp' => 6500000, 'maxg' => 15],
            ['name' => 'Camping Pantai Mustika', 'destination' => 'Pantai Mustika, Banyuwangi', 'days' => 2, 'pax' => 180000, 'grp' => 1700000, 'maxg' => 20],
            ['name' => 'Java South Sea', 'destination' => 'Pantai Selatan Jawa', 'days' => 3, 'pax' => 800000, 'grp' => 7500000, 'maxg' => 15],
        ];

        foreach ($packages as $p) {
            $package = TourPackage::create([
                'name' => $p['name'],
                'slug' => Str::slug($p['name']) . '-' . rand(10, 99),
                'destination' => $p['destination'],
                'duration_days' => $p['days'],
                'duration_nights' => max(0, $p['days'] - 1),
                'price_per_person' => $p['pax'],
                'price_per_group' => $p['grp'],
                'min_group' => 4,
                'max_group' => $p['maxg'],
                'description' => 'Nikmati liburan seru bersama ' . $p['name'] . ' bersama RC Trans. Transportasi armada premium, sopir berpengalaman, dan tour leader profesional siap menemani.',
                'itinerary' => "Hari 1: Penjemputan & tour destination.\nHari 2: Wisata & kembali ke Bondowoso.",
                'facilities' => "Mobil full AC\nSopir berpengalaman\nBensin (8 jam)\nTour Leader\nDokumentasi\nAir mineral\nMister",
                'terms' => "DP 50% untuk konfirmasi pemesanan.\nPelunasan maksimal H-1 keberangkatan.\nTidak termasuk tiket masuk destinasi.\nPembatalan 72 jam sebelum keberangkatan dikenakan biaya 50%.",
                'status' => 'aktif',
                'is_active' => true,
                'meta_title' => $p['name'],
                'meta_description' => 'Paket wisata ' . $p['name'] . ' dari RC Trans Bondowoso.',
            ]);

            // schedules for next 3 months
            for ($s = 0; $s < 6; $s++) {
                TourSchedule::create([
                    'tour_package_id' => $package->id,
                    'departure_date' => now()->addDays(rand(3, 90)),
                    'quota' => $p['maxg'] + 5,
                    'booked' => rand(0, $p['maxg']),
                    'status' => 'buka',
                ]);
            }
        }
    }
}