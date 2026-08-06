<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;
use App\Models\User;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Bambang Susilo', 'Slamet Riyadi', 'Agus Salim', 'Budi Hartono', 'Eko Prasetyo',
            'Hendra Wijaya', 'Fajar Nugroho', 'Teguh Santoso', 'Bayu Pratama', 'Rudi Cahyono',
            'Umar Hadi', 'Wahyu Kurniawan', 'Bagus Prakoso', 'Doni Firmansah', 'Hadi Suryanto',
            'Gunawan Saputra', 'Joko Susanto', 'Purwanto', 'Sigit Purnomo', 'Yusuf Maulana',
        ];

        for ($i = 0; $i < 20; $i++) {
            $name = $names[$i];
            $driver = Driver::create([
                'code' => 'D' . str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT),
                'name' => $name,
                'phone' => '08' . rand(710000000, 799999999),
                'email' => strtolower(str_replace(' ', '', $name)) . '@rctrans.co.id',
                'address' => 'Desa ' . $this->village() . ', Kec. ' . $this->village() . ', Kab. Bondowoso',
                'license_number' => 'SIM-' . rand(7000, 9999) . '-' . now()->format('Y'),
                'license_expired_at' => now()->addYears(rand(1, 4))->addMonths(rand(0, 11)),
                'license_type' => ['SIM A', 'SIM B1', 'SIM B2'][array_rand(['SIM A', 'SIM B1', 'SIM B2'])],
                'status' => ['aktif', 'aktif', 'aktif', 'cuti'][array_rand(['aktif', 'aktif', 'aktif', 'cuti'])],
                'rating' => rand(45, 50) / 10,
                'experience_trips' => rand(50, 600),
                'experience' => (string) rand(2, 15) . ' Tahun',
                'notes' => 'Driver berpengalaman rute Jawa Timur & Bali',
                'is_active' => true,
            ]);
        }
    }

    private function village(): string
    {
        $villages = ['Sumberwringin', 'Curahdami', 'Bondowoso', 'Tlogosari', 'Winongan', 'Klabang', 'Binjean', 'Semenggut'];
        return $villages[array_rand($villages)];
    }
}