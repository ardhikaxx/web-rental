<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['booking', 'user']);
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if ($request->filled('q')) {
            $query->where(fn ($q) => $q->where('payment_number', 'like', "%{$request->q}%")
                ->orWhereHas('booking', fn ($b) => $b->where('booking_code', 'like', "%{$request->q}%")));
        }
        return view('admin.payments.index', [
            'payments' => $query->latest()->paginate(15)->withQueryString(),
            'statuses' => Payment::statuses(),
        ]);
    }

    public function show(Payment $payment)
    {
        return view('admin.payments.show', ['payment' => $payment->load('booking', 'user')]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'booking_id' => ['required', 'exists:bookings,id'],
            'type' => ['required', 'in:dp,pelunasan,full'],
            'amount' => ['required', 'numeric'],
            'payment_method' => ['required'],
        ]);
        $booking = Booking::findOrFail($data['booking_id']);
        $payment = Payment::create(array_merge($data, [
            'payment_number' => 'PAY-' . now()->format('Ymd') . '-' . str_pad((string) (Payment::count() + 1), 5, '0', STR_PAD_LEFT),
            'user_id' => $booking->user_id,
            'account_name' => $booking->customer_name,
            'status' => 'menunggu_verifikasi',
            'paid_at' => now(),
            'created_by' => auth()->id(),
        ]));
        $this->log('create', 'payment', 'Pembayaran manual ' . rupiah($payment->amount) . ' dicatat.', $payment);
        return back()->with('success', 'Pembayaran dicatat.');
    }

    public function verify(Payment $payment)
    {
        $payment->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);
        $payment->histories()->create(['action' => 'verified', 'note' => 'Pembayaran diverifikasi', 'user_id' => auth()->id()]);

        $booking = $payment->booking;
        if ($booking) {
            $paid = (float) $booking->payments()->where('status', 'verified')->sum('amount');
            if (in_array($booking->status, ['menunggu_konfirmasi', 'menunggu_pembayaran'])) {
                $booking->update(['status' => 'pembayaran_diterima', 'updated_by' => auth()->id()]);
            }
            $booking->fleet?->update(['status' => 'dipesan']);
        }

        $this->log('approve', 'payment', 'Pembayaran ' . $payment->payment_number . ' diverifikasi.', $payment);
        return back()->with('success', 'Bukti pembayaran diverifikasi.');
    }

    public function reject(Request $request, Payment $payment)
    {
        $data = $request->validate(['note' => ['nullable', 'string', 'max:500']]);
        $payment->update(['status' => 'rejected', 'rejection_note' => $data['note'] ?? null, 'updated_by' => auth()->id()]);
        $payment->histories()->create(['action' => 'tolak', 'note' => $data['note'], 'user_id' => auth()->id()]);
        $this->log('reject', 'payment', 'Pembayaran ' . $payment->payment_number . ' ditolak.', $payment);
        return back()->with('success', 'Pembayaran ditolak.');
    }

    public function destroy(Payment $payment)
    {
        $this->log('delete', 'payment', 'Pembayaran ' . $payment->payment_number . ' dihapus.', $payment);
        $payment->delete();
        return back()->with('success', 'Pembayaran dihapus.');
    }

    public function invoice(Payment $payment)
    {
        $pdf = Pdf::loadView('pdf.invoice', ['booking' => $payment->booking])->setPaper('a4');
        return $pdf->stream('Invoice-' . $payment->booking->invoice_number . '.pdf');
    }

    public function kuitansi(Payment $payment)
    {
        $payments = $payment->booking->payments()->where('status', 'verified')->get();
        $pdf = Pdf::loadView('pdf.kuitansi', ['booking' => $payment->booking, 'payments' => $payments])->setPaper('a4');
        return $pdf->stream('Kuitansi-' . $payment->booking->booking_code . '.pdf');
    }
}