<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('pages.tracking', ['booking' => null]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        $booking = Booking::where('booking_code', $request->code)
            ->orWhere('invoice_number', $request->code)
            ->with(['fleet', 'driver'])
            ->first();

        if (! $booking) {
            return back()->withInput()->with('error', 'Kode booking tidak ditemukan. Silakan periksa kembali.');
        }

        return view('pages.tracking', ['booking' => $booking]);
    }
}