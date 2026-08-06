<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\FAQ;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Support\Str;

class CMSSeeder extends Seeder
{
    public function run(): void
    {
        // Services
        $services = [
            ['name' => 'Rental Mobil', 'slug' => 'rental-mobil', 'icon' => 'fa-car', 'desc' => 'Sewa mobil harian, mingguan & bulanan dengan pilihan armada premium.'],
            ['name' => 'Paket Wisata', 'slug' => 'paket-wisata', 'icon' => 'fa-plane', 'desc' => 'Trip wisata Ijen, Baluran, Bromo & destinasi Jawa Timur lainnya.'],
            ['name' => 'Travel Antar Kota', 'slug' => 'travel-antar-kota', 'icon' => 'fa-bus', 'desc' => 'Layanan travel antar kota Jawa Timur, Bali & sekitarnya.'],
            ['name' => 'Wedding Car', 'slug' => 'wedding-car', 'icon' => 'fa-heart', 'desc' => 'Mobil pengantin dengan dekorasi cantik untuk hari bahagia Anda.'],
            ['name' => 'Antar Jemput Bandara', 'slug' => 'antar-jemput-bandara', 'icon' => 'fa-plane-departure', 'desc' => 'Layanan jemput & antar ke bandara untuk perjalanan nyaman.'],
            ['name' => 'Sewaan Doc & Niot', 'slug' => 'sewaan-doc-niot', 'icon' => 'fa-user-tie', 'desc' => 'Sewa dengan supir berpengalaman & tour leader profesional.'],
        ];
        foreach ($services as $s) {
            Service::firstOrCreate(['slug' => $s['slug']], [
                'name' => $s['name'],
                'icon' => $s['icon'],
                'description' => $s['desc'],
                'content' => '<p>' . $s['desc'] . '</p>',
                'is_active' => true,
            ]);
        }

        // Banners
        Banner::create(['title' => 'Sewa Mobil Premium di Bondowoso', 'subtitle' => 'Armada terbaik untuk perjalanan keluarga, dinas & wisata ke seluruh Jawa Timur dan Bali.', 'button_text' => 'Booking Sekarang', 'button_link' => '/booking', 'position' => 'home', 'is_active' => true]);

        // Galleries
        foreach (['Armada MPV', 'Armada SUV', 'Armada Premium', 'Wisata Ijen', 'Wedding Car', 'Travel Antar Kota'] as $g) {
            Gallery::create(['title' => $g, 'image' => 'https://placehold.co/800x600?text=' . urlencode($g), 'category' => $g]);
        }

        // FAQs
        $faqs = [
            ['q' => 'Bagaimana cara booking mobil?', 'a' => 'Anda bisa booking langsung melalui website halaman Booking, atau menghubungi Call Center kami di 0812-3456-7890.'],
            ['q' => 'Apakah sudah termasuk bensin & supir?', 'a' => 'Harga paket sudah termasuk mobil, supir berpengalaman dan bensin untuk 8 jam pemakaian. Kelebihan jam dikenakan biaya tambahan.'],
            ['q' => 'Berapa DP yang harus dibayar?', 'a' => 'Pembayaran DP minimal 50% dari total biaya untuk mengamankan armada.'],
            ['q' => 'Apakah bisa sewa lepas kunci?', 'a' => 'Ya, tersedia opsi sewa lepas kunci untuk pelanggan yang memiliki SIM.'],
            ['q' => 'Bagaimana jika mobil lemas di tengah perjalanan?', 'a' => 'Tim kami siap standby 24 jam dan menyediakan armada pengganti bila diperlukan.'],
            ['q' => 'Apakah bisa ke Bali / antar kota?', 'a' => 'Bisa. Kami melayani rute Jawa Timur, Bali, dan Jawa Tengah dengan biaya sesuai jarak.'],
        ];
        foreach ($faqs as $i => $f) {
            FAQ::create(['question' => $f['q'], 'answer' => $f['a'], 'sort_order' => $i, 'is_active' => true]);
        }

        // Blogs 50
        $titles = [
            'Tips Traveling ke Kawah Ijen', '7 Alasan Sewa Mobil di RC Trans', 'Panduan Wisata Baluran',
            'Syarat Penyewaan Mobil', 'Sewa Mobil untuk Acara Nikah', 'Liburan Hemat ke Bromu',
            'Rute Travel Bondowoso Surabaya', 'Cara Booking via WhatsApp', 'Jenis Mobil RMV Terbaik',
            'Wisata Bali 3 Hari', 'Tips MBSR', 'Paket Liburan keluarga', 'Keunggulan Sewa Mingguan',
            'Armada Premium Alphard', 'Wisata Ijen Blue Fire', 'Sewa Bus Rombongan', 'Driver Profesional',
            'Prosedur Pembayaran DP', 'Pengalaman Travel Antarkota', 'Wisata Pantai Merah', 'Paket Bulan Madu',
            'Tips Safety Driving', 'Restoran dekat Ijen', 'Sewa Mobil Moana', 'Promo Akhir Tahun',
            'Kelebihan MPV vs SUV', 'Wisata Raung', 'Travel Bali Murah', 'Panduan Pelunasan', 'Liburan Sekolah',
            'Hotel dekat Kawah Ijen', 'Paket Arung Jeram', 'Wisata Pantai Banyuwangi', 'Sopir Antarmuka',
            'Rent Mobile Corporate', 'Armada Baru 2026', 'Paket Wedding Budget', 'Wisata Pulau Merah',
            'Biaya Sewa Bulanan', 'Rute Jember Surabaya', 'Wisata Sukamade', 'Tips Pakai Mobil Baru',
            'Paket Reuni', 'Highlight Albapard', 'Kelebihan Travel Surabaya', 'Wisata Pantai Pulau',
            'Keamanan Perjalanan', 'Paket Jogging', 'Rute Jang', 'CV Frais Tour',
        ];
        $authors = ['Admin RC Trans', 'Dimas Andika', 'Ratna Anjani', 'Bambang Susilo', 'Siti Nurhaliza', 'Rahmad Hidayat', 'Dewi Lestari', 'Yusuf Maulana'];
        foreach ($titles as $i => $t) {
            Blog::create([
                'title' => $t,
                'slug' => Str::slug($t) . '-' . ($i + 1),
                'content' => "<h2>{$t}</h2><p>RC Trans Bondowoso memberikan layanan terbaik untuk kebutuhan transportasi Anda. Lorem ipsum dolor sit amet consectetur adipiscing elit.</p><p>Temukan promo menarik dan armada terbaik untuk perjalanan Anda bersama kami.</p>",
                'excerpt' => Str::limit($t, 60),
                'category' => ['Tips', 'Travel', 'Promo', 'Armada', 'Wisata'][array_rand(['Tips', 'Travel', 'Promo', 'Armada', 'Wisata'])],
                'author' => $authors[array_rand($authors)],
                'status' => 'published',
                'published_at' => now()->subDays(rand(0, 120))->subHours(rand(1, 23)),
                'meta_title' => $t,
                'meta_description' => Str::limit($t, 120),
            ]);
        }

        // Testimonials 30
        $firsts = ['Budi', 'Rina', 'Bagus', 'Citra', 'Doni', 'Sari', 'Teguh', 'Putri', 'Hendra', 'Lina', 'Bayu', 'Siti', 'Eko', 'Wati', 'Agus', 'Maya', 'Rudi', 'Intan', 'Joko', 'Umar', 'Nia', 'Fajar', 'Ratna', 'Dian', 'Puji', 'Rahmayanti', 'Sinta', 'Dewi', 'Yuni', 'Hariyanto'];
        $surnames = ['Pratama', 'Santoso', 'Wijaya', 'Kurniawan', 'Hidayat', 'Susanto', 'Nugroho', 'Saputra', 'Hariati', 'Setiawan', 'Ramadhan', 'Hartono', 'Cahyono', 'Maulana', 'Rahmawati', 'Fatmawati', 'Ulfa', 'Muktia', 'Pramesti', 'Susiloningsih'];
        $companies = ['CV Sumber Makmur', 'CV Duta Jaya', 'PT Borneo Sejahtera', 'PT Maju Lancar', 'Koperasi Rakyat', 'PT Aneka Niaga', 'CV Karya Utama', 'PT Sinar Abadi', 'Kantor Dinas Pariwisata', 'PT Garuda Wisata'];
        $testimonials = [
            ['Puas dengan pelayanan RC Trans, mobil bersih dan sopir ramah', 5], ['Armada bersih & sopir ramah', 5], ['Perjalanan ke Ijen lancar & menyenangkan', 5],
            ['Harga terjangkau, supir berpengalaman', 4], ['Booking mudah lewat website', 5], ['Mobil baru dan terawat dengan sangat baik', 5],
            ['Tim sigap bantu ganti armada saat diperlukan', 4], ['Wisata Bali kece sekali, recommended', 5], ['Sopir standby 24 jam', 4],
            ['Pelayanan sopan dan profesional', 5], ['Harga bisa nego, pelayanan koperasi', 4], ['Libur tahun baru puas banget pakai RC Trans', 5],
        ];
        foreach ($testimonials as $x) {
            $name = $firsts[array_rand($firsts)] . ' ' . $surnames[array_rand($surnames)];
            Testimonial::create([
                'customer_name' => $name,
                'company' => rand(0, 1) ? null : $companies[array_rand($companies)],
                'service_type' => ['rental', 'tour', 'wedding', 'travel'][array_rand(['rental', 'tour', 'wedding', 'travel'])],
                'rating' => $x[1],
                'content' => $x[0],
                'is_active' => true,
            ]);
        }
    }
}