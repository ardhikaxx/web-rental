<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\Fleet;
use Illuminate\Http\Request;

class BookingAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['fleet', 'driver', 'user']);
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if ($request->filled('q')) {
            $query->where(fn ($q) => $q->where('booking_code', 'like', "%{$request->q}%")
                ->orWhere('customer_name', 'like', "%{$request->q}%")
                ->orWhere('customer_phone', 'like', "%{$request->q}%"));
        }
        if ($request->filled('date_from')) {
            $query->whereDate('start_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('start_date', '<=', $request->date_to);
        }
        return view('admin.bookings.index', [
            'bookings' => $query->latest()->paginate(15)->withQueryString(),
            'statuses' => Booking::statuses(),
        ]);
    }

    public function create()
    {
        return view('admin.bookings.form', [
            'booking' => new Booking(),
            'fleets' => Fleet::where('is_active', true)->get(),
            'drivers' => Driver::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required'],
            'customer_phone' => ['required'],
            'customer_email' => ['required', 'email'],
            'fleet_id' => ['required', 'exists:fleets,id'],
            'driver_id' => ['nullable', 'exists:drivers,id'],
            'with_driver' => ['sometimes', 'boolean'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'pickup_location' => ['nullable'],
            'dropoff_location' => ['nullable'],
            'total_price' => ['required', 'numeric'],
            'status' => ['required'],
        ]);

        $booking = Booking::create(array_merge($data, [
            'booking_code' => 'RCB' . now()->format('ymd') . '-' . strtoupper(substr(str_shuffle('ABCDEFGH123456789'), 0, 6)),
            'invoice_number' => 'INV-' . now()->format('Y') . '-' . str_pad((string) (Booking::withTrashed()->count() + 1000), 6, '0', STR_PAD_LEFT),
            'created_by' => auth()->id(),
        ]));
        $this->log('create', 'booking', 'Booking ' . $booking->booking_code . ' dibuat oleh admin.', $booking);
        return redirect()->route('admin.bookings.show', $booking)->with('success', 'Booking berhasil dibuat.');
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', [
            'booking' => $booking->load('fleet', 'driver', 'user', 'payments'),
            'statuses' => Booking::statuses(),
        ]);
    }

    public function edit(Booking $booking)
    {
        return view('admin.bookings.form', [
            'booking' => $booking,
            'fleets' => Fleet::all(),
            'drivers' => Driver::all(),
        ]);
    }

    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'customer_name' => ['required'],
            'customer_phone' => ['required'],
            'fleet_id' => ['required', 'exists:fleets,id'],
            'driver_id' => ['nullable', 'exists:drivers,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ]);
        $booking->update(array_merge($data, ['updated_by' => auth()->id()]));
        $this->log('update', 'booking', 'Booking ' . $booking->booking_code . ' diperbarui.', $booking);
        return back()->with('success', 'Booking diperbarui.');
    }

    public function destroy(Booking $booking)
    {
        $this->log('delete', 'booking', 'Booking ' . $booking->booking_code . ' dihapus.', $booking);
        $booking->delete();
        return back()->with('success', 'Booking dihapus.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate(['status' => ['required', 'in:' . implode(',', array_keys(Booking::statuses()))]]);

        $booking->update(['status' => $request->status, 'updated_by' => auth()->id()]);

        if ($request->status === 'berjalan') {
            $booking->fleet?->update(['status' => 'berjalan']);
        } elseif (in_array($request->status, ['selesai', 'arsip'])) {
            $booking->fleet?->update(['status' => 'tersedia']);
            if ($booking->driver) {
                $booking->driver->increment('experience_trips');
            }
        } elseif (in_array($request->status, ['dijadwalkan', 'pembayaran_diterima'])) {
            $booking->fleet?->update(['status' => 'dipesan']);
        }

        $this->log('status_change', 'booking', 'Status booking ' . $booking->booking_code . ' diubah menjadi ' . $request->status, $booking);

        return back()->with('success', 'Status booking diperbarui menjadi: ' . Booking::statuses()[$request->status]);
    }
}