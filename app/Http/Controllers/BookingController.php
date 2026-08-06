<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Driver;
use App\Models\Fleet;
use App\Models\Promo;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private BookingService $service)
    {
    }

    public function create(Request $request)
    {
        $fleets = Fleet::where('is_active', true)->where('status', '!=', 'maintenance')->where('status', '!=', 'nonaktif')->get();

        return view('pages.booking', [
            'fleets' => $fleets,
            'selectedFleet' => $request->integer('fleet') ? Fleet::find($request->integer('fleet')) : null,
            'promos' => Promo::where('is_active', true)->where('status', 'aktif')->where(function ($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
                $q->where(function ($q2) {
                    $q2->whereNull('valid_from')->orWhere('valid_from', '<=', now());
                });
            })->get(),
        ]);
    }

    public function checkPrice(Request $request)
    {
        $data = $request->validate([
            'fleet_id' => ['required', 'exists:fleets,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'with_driver' => ['sometimes', 'boolean'],
            'extra_cost' => ['nullable', 'numeric', 'min:0'],
            'voucher_code' => ['nullable', 'string'],
        ]);

        $fleet = Fleet::findOrFail($data['fleet_id']);
        $promo = null;
        $error = null;

        if (! $this->service->isFleetAvailable($fleet->id, $data['start_date'], $data['end_date'])) {
            return response()->json(['ok' => false, 'message' => 'Armada tidak tersedia pada tanggal tersebut.'], 422);
        }

        if (! empty($data['voucher_code'])) {
            $promo = Promo::where('code', $data['voucher_code'])->first();
            if (! $promo || ! $promo->is_valid) {
                return response()->json(['ok' => false, 'message' => 'Kode voucher tidak valid atau sudah kedaluwarsa.'], 422);
            }
        }

        $prices = $this->service->calculate(
            $fleet,
            $data['start_date'],
            $data['end_date'],
            (bool) ($data['with_driver'] ?? true),
            (float) ($data['extra_cost'] ?? 0),
            $data['voucher_code'] ?? null,
            $promo
        );

        return response()->json(['ok' => true, 'prices' => $prices, 'promo_discount' => $prices['discount']]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_email' => ['required', 'email'],
            'address' => ['nullable', 'string'],
            'service_type' => ['required', 'string'],
            'fleet_id' => ['required', 'integer', 'exists:fleets,id'],
            'with_driver' => ['sometimes', 'boolean'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'pickup_location' => ['nullable', 'string'],
            'dropoff_location' => ['nullable', 'string'],
            'special_notes' => ['nullable', 'string'],
            'extra_cost' => ['nullable', 'numeric', 'min:0'],
            'voucher_code' => ['nullable', 'string'],
            'agree' => ['required'],
        ]);

        $fleet = Fleet::findOrFail($data['fleet_id']);

        if (! $this->service->isFleetAvailable($fleet->id, $data['start_date'], $data['end_date'])) {
            return back()->withInput()->with('error', 'Maaf, armada tersebut tidak tersedia pada tanggal yang Anda pilih.');
        }

        $promo = null;
        if (! empty($data['voucher_code'])) {
            $promo = Promo::where('code', $data['voucher_code'])->first();
            if (! $promo || ! $promo->is_valid) {
                return back()->withInput()->withErrors(['voucher_code' => 'Kode voucher tidak valid atau sudah kedaluwarsa.']);
            }
        }

        $prices = $this->service->calculate(
            $fleet,
            $data['start_date'],
            $data['end_date'],
            (bool) ($data['with_driver'] ?? true),
            (float) ($data['extra_cost'] ?? 0),
            $data['voucher_code'] ?? null,
            $promo
        );

        $booking = Booking::create(array_merge([
            'booking_code' => $this->service->generateBookingCode(),
            'invoice_number' => $this->service->generateInvoiceNumber(),
            'user_id' => auth()->check() ? auth()->id() : null,
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'customer_email' => $data['customer_email'],
            'address' => $data['address'] ?? null,
            'service_type' => $data['service_type'],
            'fleet_id' => $fleet->id,
            'with_driver' => (bool) ($data['with_driver'] ?? true),
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'pickup_location' => $data['pickup_location'] ?? null,
            'dropoff_location' => $data['dropoff_location'] ?? null,
            'special_notes' => $data['special_notes'] ?? null,
            'duration_days' => $prices['duration_days'],
            'base_price' => $prices['base_price'],
            'driver_fee' => $prices['driver_fee'],
            'extra_cost' => $prices['extra_cost'],
            'discount' => $prices['discount'],
            'promo_code_discount' => $prices['discount'],
            'tax' => $prices['tax'],
            'total_price' => $prices['total_price'],
            'dp_amount' => round($prices['total_price'] * 0.5, 2),
            'dp_percent' => 50,
            'promo_id' => $promo->id ?? null,
            'voucher_code' => $data['voucher_code'] ?? null,
            'status' => 'menunggu_konfirmasi',
            'created_by' => auth()->id(),
        ], $prices));

        if ($promo) {
            $promo->increment('used_count');
            \App\Models\PromoUsage::create([
                'promo_id' => $promo->id,
                'booking_id' => $booking->id,
                'user_id' => auth()->id(),
                'discount' => $prices['discount'],
            ]);
        }

        $this->log('create', 'booking', 'Booking baru dibuat: ' . $booking->booking_code . ' oleh ' . $booking->customer_name, $booking);

        return redirect()->route('booking.success', $booking)->with('success', 'Pemesanan berhasil dibuat.');
    }

    public function success(Booking $booking)
    {
        return view('pages.booking-success', compact('booking'));
    }
}