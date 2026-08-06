@extends('layouts.public')
@section('title', 'Tracking Booking')
@section('meta_description', 'Lacak status pemesanan & perjalanan Anda secara real-time.')

@section('content')
@include('components.page-header', ['title' => 'Tracking Booking'])
<div class="section">
    <div class="container" style="max-width:820px">
        <div class="card card-rc p-4 mb-4">
            <form method="post" action="{{ route('tracking.search') }}" class="row g-2">
                @csrf
                <div class="col-md-9">
                    <input type="text" name="code" value="{{ old('code') }}" class="form-control form-control-lg" placeholder="Masukkan kode booking / no. invoice" required>
                </div>
                <div class="col-md-3"><button type="submit" class="btn btn-brand w-100 btn-lg"><i class="fa-solid fa-magnifying-glass me-1"></i>Lacak</button></div>
            </form>
        </div>

        @if($booking)
        @php
            $steps = ['menunggu_konfirmasi','menunggu_pembayaran','pembayaran_diterima','dijadwalkan','berjalan','selesai'];
            $labels = ['Menunggu Konfirmasi','Menunggu Pembayaran','Pembayaran Diterima','Dijadwalkan','Perjalanan Berlangsung','Selesai'];
            $idx = array_search($booking->status, $steps);
        @endphp
        <div class="card card-rc p-4">
            <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="fw-bold mb-0">{{ $booking->booking_code }}</h5>
                    <small class="text-muted">{{ $booking->customer_name }}</small>
                </div>
                <span class="badge" style="background:#4361ee;color:#fff">{{ $labels[$idx] ?? $booking->status }}</span>
            </div>
            <div class="row g-3 small">
                <div class="col-md-4"><strong>Armada:</strong> {{ $booking->fleet?->display_name }} ({{ $booking->fleet?->license_plate }})</div>
                <div class="col-md-4"><strong>Sewa:</strong> {{ format_indo_date($booking->start_date) }}</div>
                <div class="col-md-4"><strong>Kembali:</strong> {{ format_indo_date($booking->end_date) }}</div>
                <div class="col-md-4"><strong>Sopir:</strong> {{ $booking->driver?->name ?? '-' }}</div>
                <div class="col-md-4"><strong>Total:</strong> @rupiah($booking->total_price)</div>
                <div class="col-md-4"><strong>Status Pembayaran:</strong> {{ $booking->paid_amount > 0 ? 'Sudah bayar' : 'Belum bayar' }} ({{ $booking->paid_percent }}%)</div>
            </div>
            <hr>
            <h6 class="fw-bold mb-3">Status Perjalanan</h6>
            <div class="d-flex justify-content-between">
                @foreach ($steps as $i => $step)
                    @php $done = ($idx !== false && $i <= $idx); @endphp
                    <div class="text-center px-1">
                        <div class="rounded-circle d-grid mx-auto mb-2" style="width:38px;height:38px;place-items:center;background:{{ $done ? '#4361ee' : '#e9ecef' }};color:{{ $done ? '#fff' : '#adb5bd' }}">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <small class="text-muted" style="font-size:11px">{{ $labels[$i] }}</small>
                    </div>
                @endforeach
            </div>
        </div>
        @elseif(session('error'))
        <div class="card card-rc p-4 text-center">
            <i class="fa-solid fa-circle-info text-warning fa-2x mb-2"></i>
            <p class="mb-0">{{ session('error') }}</p>
        </div>
        @endif
    </div>
</div>
@endsection