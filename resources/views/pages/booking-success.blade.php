@extends('layouts.public')
@section('title', 'Booking Berhasil')
@section('meta_description', 'Pemesanan Anda berhasil dibuat.')

@section('content')
<div class="section">
    <div class="container" style="max-width:760px">
        <div class="card card-rc p-5 text-center">
            <div class="fa-solid fa-circle-check fs-1 text-success mb-3"></div>
            <h2 class="fw-bold">Pemesanan Berhasil!</h2>
            <p class="text-muted">Terima kasih {{ $booking->customer_name }}. Pesanan Anda telah dibuat dan menunggu konfirmasi admin.</p>
            <hr>
            <div class="row text-start g-3">
                <div class="col-md-6"><label class="small text-muted">Kode Booking</label><div class="fs-4 fw-bold text-brand">{{ $booking->booking_code }}</div></div>
                <div class="col-md-6"><label class="small text-muted">No. Invoice</label><div class="fs-4 fw-bold">{{ $booking->invoice_number }}</div></div>
                <div class="col-md-4"><label class="small text-muted">Armada</label><div class="fw-bold">{{ $booking->fleet?->display_name }}</div></div>
                <div class="col-md-4"><label class="small text-muted">Periode Sewa</label><div class="fw-bold">{{ format_indo_date($booking->start_date) }}</div></div>
                <div class="col-md-4"><label class="small text-muted">Total</label><div class="fw-bold">@rupiah($booking->total_price)</div></div>
                <div class="col-md-4"><label class="small text-muted">DP (min 50%)</label><div class="fw-bold text-danger">@rupiah($booking->dp_amount)</div></div>
                <div class="col-md-8"><label class="small text-muted">Tanggal Kembali</label><div class="fw-bold">{{ format_indo_date($booking->end_date) }}</div></div>
            </div>
            <div class="mt-4 d-grid gap-2">
                <a href="{{ route('tracking') }}" class="btn btn-outline-primary">Lacak Status Booking</a>
                @auth
                    <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-brand">Lihat di Portal</a>
                @endauth
                <a href="https://wa.me/{{ $site['whatsapp'] ?? '' }}?text={{ urlencode('Halo, saya ingin konfirmasi booking '.$booking->booking_code) }}" target="_blank" class="btn btn-wa"><i class="fa-brands fa-whatsapp me-2"></i>Konfirmasi via WhatsApp</a>
            </div>
        </div>
    </div>
</div>
@endsection