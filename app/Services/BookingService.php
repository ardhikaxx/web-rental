<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Fleet;
use App\Models\Promo;
use Carbon\Carbon;

class BookingService
{
    public const TAX_RATE = 0.11;

    public function isFleetAvailable(int $fleetId, $start, $end, ?int $ignoreBookingId = null): bool
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);

        $conflicts = Booking::where('fleet_id', $fleetId)
            ->whereIn('status', ['menunggu_konfirmasi', 'menunggu_pembayaran', 'pembayaran_diterima', 'dijadwalkan', 'berjalan'])
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2->where('start_date', '<=', $start)->where('end_date', '>=', $end);
                    });
            });

        if ($ignoreBookingId) {
            $conflicts->where('id', '!=', $ignoreBookingId);
        }

        return $conflicts->count() === 0;
    }

    public function calculate(
        Fleet $fleet,
        $start,
        $end,
        bool $withDriver,
        float $extraCost = 0,
        ?string $voucherCode = null,
        ?Promo $promo = null,
        bool $applyTax = true
    ): array {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);
        $hours = max(1, $start->diffInHours($end));
        $days = max(1, (int) ceil($hours / 24));

        $basePrice = $fleet->daily_price * $days;

        $driverFee = 0;
        if ($withDriver) {
            $driverFee = ($fleet->driver_fee ?: 150000) * $days;
        }

        $subtotal = $basePrice + $driverFee + $extraCost;

        $discount = 0;
        if ($promo) {
            $discount = $promo->calculateDiscount($subtotal);
        }

        $tax = $applyTax ? round(($subtotal - $discount) * self::TAX_RATE) : 0;
        $total = max(0, $subtotal - $discount + $tax);

        return [
            'duration_days' => $days,
            'base_price' => round($basePrice, 2),
            'driver_fee' => round($driverFee, 2),
            'extra_cost' => round($extraCost, 2),
            'discount' => round($discount, 2),
            'tax' => round($tax, 2),
            'total_price' => round($total, 2),
        ];
    }

    public function generateBookingCode(): string
    {
        do {
            $code = 'RCB' . now()->format('ymd') . '-' . strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPRSTUVWXYZ23456789'), 0, 6));
        } while (Booking::where('booking_code', $code)->exists());

        return $code;
    }

    public function generateInvoiceNumber(): string
    {
        $num = Booking::withTrashed()->count() + now()->year;
        return 'INV-' . now()->format('Y') . '-' . str_pad((string) ($num + 1000), 6, '0', STR_PAD_LEFT);
    }
}