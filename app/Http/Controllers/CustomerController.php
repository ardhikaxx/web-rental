<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PromoUsage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        return view('customer.dashboard', [
            'bookings' => $user->bookings()->latest()->take(5)->get(),
            'stats' => [
                'total' => $user->bookings()->count(),
                'active' => $user->bookings()->whereIn('status', ['menunggu_konfirmasi', 'menunggu_pembayaran', 'pembayaran_diterima', 'dijadwalkan', 'berjalan'])->count(),
                'completed' => $user->bookings()->where('status', 'selesai')->count(),
                'spent' => $user->bookings()->where('status', '!=', 'dibatalkan')->sum('total_price'),
            ],
        ]);
    }

    public function bookings()
    {
        return view('customer.bookings', ['bookings' => Auth::user()->bookings()->latest()->paginate(10)]);
    }

    public function bookingDetail(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        return view('customer.booking-detail', ['booking' => $booking]);
    }

    public function cancel(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        if (! in_array($booking->status, ['menunggu_konfirmasi', 'menunggu_pembayaran', 'pembayaran_diterima'])) {
            return back()->with('error', 'Booking tidak dapat dibatalkan pada status ini.');
        }
        $booking->update(['status' => 'dibatalkan']);
        $this->log('status_change', 'booking', 'Pelanggan membatalkan booking ' . $booking->booking_code, $booking);
        return back()->with('success', 'Booking ' . $booking->booking_code . ' telah dibatalkan.');
    }

    public function payments()
    {
        return view('customer.payments', ['payments' => Auth::user()->payments()->latest()->paginate(10)]);
    }

    public function paymentDetail(Payment $payment)
    {
        abort_unless($payment->user_id === Auth::id(), 403);
        return view('customer.payment-detail', ['payment' => $payment]);
    }

    public function storePayment(Request $request)
    {
        $data = $request->validate([
            'booking_id' => ['required', 'exists:bookings,id'],
            'type' => ['required', 'in:dp,pelunasan,full'],
            'amount' => ['required', 'numeric', 'min:1'],
            'payment_method' => ['required', 'string'],
            'bank_name' => ['nullable', 'string'],
            'account_number' => ['nullable', 'string'],
            'account_name' => ['nullable', 'string'],
            'proof_image' => ['nullable', 'image', 'max:2048'],
        ]);

        $booking = Booking::findOrFail($data['booking_id']);
        abort_unless($booking->user_id === Auth::id(), 403);

        $proof = null;
        if ($request->hasFile('proof_image')) {
            $proof = $request->file('proof_image')->store('proofs', 'public');
        }

        $payment = Payment::create([
            'payment_number' => 'PAY-' . now()->format('Ymd-His') . Str::upper(Str::random(3)),
            'booking_id' => $booking->id,
            'user_id' => Auth::id(),
            'type' => $data['type'],
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'bank_name' => $data['bank_name'] ?? null,
            'account_number' => $data['account_number'] ?? null,
            'account_name' => $data['account_name'] ?? $booking->customer_name,
            'proof_image' => $proof,
            'status' => 'menunggu_verifikasi',
            'paid_at' => now(),
            'created_by' => $booking->user_id,
        ]);

        $booking->update(['status' => 'menunggu_pembayaran']);
        $this->log('create', 'payment', 'Pembayaran ' . rupiah($payment->amount) . ' diajukan untuk booking ' . $booking->booking_code, $payment);

        return back()->with('success', 'Bukti pembayaran terkirim, menunggu verifikasi tim kami.');
    }

    public function profile()
    {
        return view('customer.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'gender' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'identity_number' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('avatars', 'public');
        }
        $data['whatsapp'] = $data['phone'] ?? $user->whatsapp;
        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function invoice(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        $pdf = Pdf::loadView('pdf.invoice', compact('booking'))
            ->setPaper('a4');
        return $pdf->stream('Invoice-' . $booking->invoice_number . '.pdf');
    }

    public function kuitansi(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        $payments = $booking->payments()->where('status', 'verified')->get();
        $pdf = Pdf::loadView('pdf.kuitansi', compact('booking', 'payments'))->setPaper('a4');
        return $pdf->stream('Kuitansi-' . $booking->booking_code . '.pdf');
    }
}