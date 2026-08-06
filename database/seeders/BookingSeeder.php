<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\Fleet;
use App\Models\Payment;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereHas('roles', fn ($q) => $q->where('name', 'customer'))->get();
        $drivers = Driver::where('status', '!=', 'nonaktif')->get();
        $fleets = Fleet::all();
        $promos = Promo::where('is_active', true)->get();

        $pickups = ['Bandara Blimbingsari', 'Stasiun Tanggul', 'Terminal Bondowoso', 'Kantor RC Trans', 'Jl. P. B. Sudirman Bondowoso', 'Hotel Bondowoso'];
        $areas = ['Bondowoso', 'Jember', 'Situbondo', 'Banyuwangi', 'Surabaya', 'Malang', 'Denpasar Bali', 'Jogjakarta'];
        $notes = ['Butuh mobil bersih untuk keluarga.', 'Berangkat pagi hari.', 'Lebih diutamakan sopir ramah.', 'Ada bayi, siapkan car seat.'];

        // distribution over 200 bookings across last 12 months
        for ($i = 1; $i <= 200; $i++) {
            $customer = $users->random();
            $fleet = $fleets->random();
            $withDriver = (bool) rand(0, 1);
            $driver = $withDriver ? $drivers->random() : null;

            $status = $this->pickStatus();
            $days = rand(1, 7);

            if (in_array($status, ['menunggu_konfirmasi', 'menunggu_pembayaran', 'pembayaran_diterima', 'dijadwalkan', 'berjalan'])) {
                $start = now()->subDays(rand(1, 20))->addDays(rand(-2, 10));
                $created = now()->subDays(rand(2, 15));
            } else {
                $start = now()->subMonths(rand(0, 11))->subDays(rand(0, 28));
                $created = $start->copy()->subDays(rand(1, 7));
            }

            $base = $fleet->daily_price * $days;
            $driverFee = $withDriver ? ($fleet->driver_fee ?: 150000) * $days : 0;
            $extra = (rand(0, 1)) ? rand(0, 3) * 50000 : 0;
            $promoDiscount = 0;
            $promoId = null;
            $promoCode = null;
            if (rand(1, 6) === 1 && $promos->count()) {
                $promo = $promos->random();
                $promoDiscount = $this->calculateDiscountValue($promo, $base + $driverFee);
                $promoId = $promo->id;
                $promoCode = $promo->code;
            }
            $tax = round(($base + $driverFee + $extra - $promoDiscount) * 0.11);
            $total = max(0, $base + $driverFee + $extra - $promoDiscount + $tax);

            $booking = Booking::create([
                'booking_code' => 'RCB' . now()->format('ymd') . '-' . str_pad((string) (1000 + $i), 6, '0', STR_PAD_LEFT),
                'invoice_number' => 'INV-' . date('Y') . '-' . str_pad((string) $i, 5, '0', STR_PAD_LEFT),
                'user_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_phone' => $customer->phone,
                'customer_email' => $customer->email,
                'address' => $customer->address,
                'service_type' => 'rental',
                'fleet_id' => $fleet->id,
                'driver_id' => $driver->id ?? null,
                'with_driver' => $withDriver,
                'start_date' => $start,
                'end_date' => $start->copy()->addDays($days),
                'pickup_location' => $pickups[array_rand($pickups)],
                'dropoff_location' => $areas[array_rand($areas)],
                'special_notes' => rand(0, 3) === 0 ? $notes[array_rand($notes)] : null,
                'duration_days' => $days,
                'base_price' => $base,
                'driver_fee' => $driverFee,
                'extra_cost' => $extra,
                'discount' => 0,
                'promo_code_discount' => $promoDiscount,
                'tax' => $tax,
                'total_price' => $total,
                'dp_amount' => round($total * 0.5, 2),
                'dp_percent' => 50,
                'promo_id' => $promoId,
                'voucher_code' => $promoCode,
                'status' => $status,
                'created_by' => $customer->id,
                'pickup_status' => in_array($status, ['berjalan', 'selesai']) ? 'done' : 'pending',
                'return_status' => $status === 'selesai' ? 'done' : 'pending',
                'created_at' => $created,
                'updated_at' => $created,
            ]);

            $this->createPayments($booking, $status);
        }
    }

    private function createPayments(Booking $booking, string $status): void
    {
        $amount = (float) $booking->total_price;
        if (in_array($status, ['dibatalkan', 'refund'])) {
            return;
        }
        if ($status === 'menunggu_konfirmasi') {
            return; // no payment yet
        }
        // DP payment (50%) for most
        $dp = $amount * 0.5;
        $paidAt = $booking->created_at->addHours(rand(3, 30));

        $dpPayment = $this->makePayment($booking, 'dp', round($dp, 2), $paidAt, true);
        if (in_array($status, ['selesai', 'arsip'])) {
            $this->makePayment($booking, 'pelunasan', round($amount - $dp, 2), $paidAt->copy()->addDays(rand(1, $booking->duration_days)), true);
        } else {
            // remaining pending/lunas status: mark lunas only if finished-ish
        }
    }

    private function makePayment(Booking $booking, string $type, float $amount, $paidAt, bool $verified): Payment
    {
        static $seq = 0;
        $seq++;
        $methods = ['transfer', 'transfer', 'cash', 'qris'];
        $banks = ['BCA', 'Mandiri', 'BRI', 'BNI'];
        $payment = Payment::create([
            'payment_number' => 'PAY-' . date('Ymd') . '-' . str_pad((string) $seq, 5, '0', STR_PAD_LEFT),
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'type' => $type,
            'amount' => $amount,
            'payment_method' => $methods[array_rand($methods)],
            'bank_name' => $banks[array_rand($banks)],
            'account_name' => $booking->customer_name,
            'status' => $verified ? 'verified' : 'menunggu_verifikasi',
            'paid_at' => $paidAt,
            'verified_at' => $verified ? $paidAt->copy()->addHours(rand(1, 20)) : null,
            'verified_by' => rand(1, 8),
            'created_at' => $paidAt,
            'updated_at' => $paidAt,
        ]);
        return $payment;
    }

    private function pickStatus(): string
    {
        $pool = [
            'selesai' => 120, 'arsip' => 20, 'menunggu_konfirmasi' => 12,
            'menunggu_pembayaran' => 14, 'pembayaran_diterima' => 16,
            'dijadwalkan' => 12, 'berjalan' => 6,
        ];
        $total = array_sum($pool);
        $roll = rand(1, $total);
        $cum = 0;
        foreach ($pool as $status => $weight) {
            $cum += $weight;
            if ($roll <= $cum) {
                return $status;
            }
        }
        return 'selesai';
    }

    private function calculateDiscountValue($promo, float $subtotal): float
    {
        if ($promo->type === 'persen') {
            $d = $subtotal * $promo->value / 100;
        } else {
            $d = $promo->value;
        }
        if ($promo->max_discount > 0) {
            $d = min($d, $promo->max_discount);
        }
        return min($d, $subtotal);
    }
}