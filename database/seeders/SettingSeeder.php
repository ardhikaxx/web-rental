<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'company_name' => 'RC Rental & Tour (RC Trans)',
            'company_short' => 'RC Trans',
            'tagline' => 'Sewa Mobil, Rental Tour & Travel Terpercaya di Bondowoso',
            'address' => 'Jl. P. B. Sudirman No. 123, Bondowoso, Jawa Timur 68211',
            'phone' => '0812-3456-7890',
            'whatsapp' => '6281234567890',
            'email' => 'info@rctrans.co.id',
            'slogan' => 'Perjalanan #1 Anda',
            'description' => 'Perusahaan rental mobil, paket wisata dan travel antar kota dengan armada premium dan pelayanan profesional untuk seluruh Jawa Timur & Bali.',
            'facebook' => 'https://facebook.com/rctrans',
            'instagram' => 'https://instagram.com/rctrans',
            'tiktok' => 'https://tiktok.com/@rctrans',
            'youtube' => 'https://youtube.com/@rctrans',
            'twitter' => 'https://twitter.com/rctrans',
            'map_embed' => '',
            'working_hours' => 'Buka 24 Jam',
            'open_time' => 'Pukul 08.00 - 20.00',
            'bank_name' => 'BCA',
            'bank_account' => '1234567890',
            'bank_holder' => 'RC Trans Bondowoso',
            'bank2_name' => 'BRI',
            'bank2_account' => '9876543210',
            'bank2_holder' => 'RC Trans Bondowoso',
            'tdp_number' => 'TDP-2024-002233',
            'nib' => 'NIB-12345',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}