<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['name' => 'Super Admin', 'email' => 'superadmin@rctrans.co.id', 'role' => 'super_admin', 'gender' => 'Laki-laki', 'phone' => '081234567801'],
            ['name' => 'Rendi Cahyono (Owner)', 'email' => 'owner@rctrans.co.id', 'role' => 'owner', 'gender' => 'Laki-laki', 'phone' => '081234567802'],
            ['name' => 'Admin Operasional', 'email' => 'admin@rctrans.co.id', 'role' => 'admin_operasional', 'gender' => 'Laki-laki', 'phone' => '081234567803'],
            ['name' => 'Customer Service — Dewi', 'email' => 'cs@rctrans.co.id', 'role' => 'customer_service', 'gender' => 'Perempuan', 'phone' => '081234567804'],
            ['name' => 'Driver — Bambang', 'email' => 'driver@rctrans.co.id', 'role' => 'driver', 'gender' => 'Laki-laki', 'phone' => '081234567805'],
            ['name' => 'Tour Leader — Andi', 'email' => 'tourleader@rctrans.co.id', 'role' => 'tour_leader', 'gender' => 'Laki-laki', 'phone' => '081234567806'],
            ['name' => 'Keuangan — Siti', 'email' => 'keuangan@rctrans.co.id', 'role' => 'keuangan', 'gender' => 'Perempuan', 'phone' => '081234567807'],
            ['name' => 'Marketing — Putri', 'email' => 'marketing@rctrans.co.id', 'role' => 'marketing', 'gender' => 'Perempuan', 'phone' => '081234567808'],
            ['name' => 'Pelanggan Demo', 'email' => 'customer@rctrans.co.id', 'role' => 'customer', 'gender' => 'Laki-laki', 'phone' => '081234567809'],
        ];

        $cities = ['Bondowoso', 'Jember', 'Situbondo', 'Banyuwangi', 'Surabaya', 'Malang', 'Probolinggo', 'Pasuruan'];

        foreach ($accounts as $acc) {
            $user = User::firstOrCreate(
                ['email' => $acc['email']],
                [
                    'name' => $acc['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'phone' => $acc['phone'],
                    'whatsapp' => $acc['phone'],
                    'gender' => $acc['gender'],
                    'city' => $cities[array_rand($cities)],
                    'address' => 'Jl. ' . Str::title(fake()->streetName) . ' No. ' . rand(1, 120),
                    'is_active' => true,
                ]
            );

            $user->assignRole($acc['role']);
        }

        // Create 50 customer accounts
        for ($i = 1; $i <= 50; $i++) {
            $firstName = $this->indonesianName();
            $email = Str::slug($firstName) . $i . '@gmail.com';
            if (User::where('email', $email)->exists()) {
                continue;
            }
            $user = User::create([
                'name' => $firstName,
                'email' => $email,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'phone' => '08' . rand(810000000, 899999999),
                'whatsapp' => '08' . rand(810000000, 899999999),
                'gender' => rand(0, 1) ? 'Laki-laki' : 'Perempuan',
                'birth_date' => now()->subYears(rand(22, 55))->subMonths(rand(0, 11)),
                'address' => 'Jl. ' . Str::title(fake()->streetName) . ' No. ' . rand(1, 150),
                'city' => $cities[array_rand($cities)],
                'identity_number' => (string) rand(1000000000000000, 9999999999999999),
                'is_active' => true,
            ]);
            $user->assignRole('customer');
        }
    }

    private function indonesianName(): string
    {
        $male = ['Budi', 'Slamet', 'Agus', 'Hadi', 'Tono', 'Eko', 'Bambang', 'Rudi', 'Fajar', 'Doni', 'Abdul',
            'Bayu', 'Bagus', 'Hendra', 'Teguh', 'Umar', 'Wahyu', 'Joko', 'Sigit', 'Purwanto', 'Joko', 'Solihin',
            'Rahmad', 'Darmanto', 'Sukoco', 'Yanto', 'Koko', 'Heri', 'Agung', 'Wawan', 'Rizky', 'Afif', 'Raharjo',
            'Widi', 'Galih', 'Diky', 'Hardiyono', 'Suryono', 'Kholis', 'Mukhlis', 'Firdaus', 'Ramdani', 'Syafruddin'];
        $female = ['Rina', 'Yuni', 'Dewi', 'Citra', 'Intan', 'Sari', 'Ratna', 'Nia', 'Vina', 'Maya', 'Putri',
            'Rani', 'Wati', 'Lestari', 'Mulyani', 'Halimah', 'Sri','Sulastri', 'Tuti', 'Yuli', 'Nurjannah', 'Iis',
            'Dian', 'Ani', 'Eva', 'Lila', 'Sofiatun', 'Ainun', 'Nafisah', 'Reyna', 'Zahrah', 'Alifah', 'Wanda',
            'Ummi', 'Rosa', 'Wulan', 'Elmi', 'Kartika', 'Mala', 'Fitri', 'Anggita', 'Septi', 'Rina'];
        $surname = ['Pratama', 'Santoso', 'Wijaya', 'Kurniawan', 'Hidayat', 'Susanto', 'Nugroho', 'Saputra',
            'Kusuma', 'Ramadhan', 'Setiawan', 'Lestari', 'Hartono', 'Gunawan', 'Suryana', 'Mustofa', 'Cahyono',
            'Prabowo', 'Maulana', 'Rahman', 'Firmansyah', 'Aditama', 'Prasetyo', 'Utomo', 'Basuki', 'Widyana',
            'Handoko', 'Sutanto', 'Kurnia', 'Mulyadi', 'Siregar', 'Napitupulu', 'Sihombing', 'Tambunan'];
        $gender = rand(0, 1);
        $first = $gender ? $male[array_rand($male)] : $female[array_rand($female)];
        $last = $surname[array_rand($surname)];
        return $first . ' ' . $last;
    }
}