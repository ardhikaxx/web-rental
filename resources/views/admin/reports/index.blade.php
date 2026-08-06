@extends('layouts.admin')
@section('title', 'Center Laporan')

@section('content')
<div class="row g-3">
    <div class="col-md-3"><div class="card card-grid"><div class="card-body"><div class="fs-4 fw-bold">@rupiah($totalRevenue)</div><small class="text-muted">Total Pendapatan (Booking)</small></div></div></div>
    <div class="col-md-3"><div class="card card-grid"><div class="card-body"><div class="fs-4 fw-bold">@rupiah($totalExpense)</div><small class="text-muted">Total Pengeluaran (Maintenance)</small></div></div></div>
    <div class="col-md-3"><div class="card card-grid"><div class="card-body"><div class="fs-4 fw-bold">{{ $totalBooking }}</div><small class="text-muted">Total Booking</small></div></div></div>
    <div class="col-md-3"><div class="card card-grid"><div class="card-body"><div class="fs-4 fw-bold">{{ $totalFleet }}</div><small class="text-muted">Total Armada</small></div></div></div>
</div>

<div class="row g-3 mt-1">
    @php
    $menus = [
        ['admin.reports.booking', 'fa-calendar-check', 'Laporan Booking', 'Rincian seluruh transaksi booking', 'primary'],
        ['admin.reports.revenue', 'fa-money-bill-trend-up', 'Laporan Pendapatan', 'Pemasukan dari pembayaran terverifikasi', 'success'],
        ['admin.reports.expense', 'fa-sack-dollar', 'Laporan Pengeluaran', 'Biaya maintenance armada', 'danger'],
        ['admin.reports.profit-loss', 'fa-scale-balanced', 'Laba Rugi', 'Perbandingan pendapatan & pengeluaran', 'info'],
        ['admin.reports.fleet', 'fa-car', 'Laporan Armada', 'Status & performa armada', 'warning'],
        ['admin.reports.driver', 'fa-user-tie', 'Laporan Driver', 'Kinerja & rating driver', 'dark'],
        ['admin.reports.customer', 'fa-users', 'Laporan Pelanggan', 'Total belanja per pelanggan', 'info'],
    ];
    @endphp
    @foreach ($menus as $m)
    <div class="col-md-4">
        <a href="{{ route($m[0]) }}" class="text-decoration-none">
            <div class="card card-grid card-rc h-100"><div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#eef2ff;color:#4361ee"><i class="fa-solid {{ $m[1] }}"></i></div>
                <div><h6 class="fw-bold mb-1">{{ $m[2] }}</h6><small class="text-muted">{{ $m[3] }}</small></div>
                <i class="fa-solid fa-chevron-right ms-auto text-muted"></i>
            </div></div>
        </a>
    </div>
    @endforeach
</div>
@endsection