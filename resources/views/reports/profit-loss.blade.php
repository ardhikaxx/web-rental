@extends('layouts.admin')
@section('title', 'Laporan Laba Rugi')

@section('content')
<div class="card card-grid">
    <div class="card-header bg-white"><h6 class="fw-bold mb-0">Laba Rugi</h6></div>
    <div class="card-body">
        <form class="row g-2 mb-3" method="get">
            <div class="col-auto"><input type="date" name="from" value="{{ $from }}" class="form-control form-control-sm"></div>
            <div class="col-auto"><input type="date" name="to" value="{{ $to }}" class="form-control form-control-sm"></div>
            <div class="col-auto"><button class="btn btn-sm btn-outline-primary">Terapkan</button></div>
        </form>

        <div class="table-responsive mb-4">
            <table class="table table-borderless w-50">
                <tbody>
                    <tr><td class="fw-semibold">Pendapatan (verified)</td><td class="text-end text-success">@rupiah($income)</td></tr>
                    <tr><td class="fw-semibold">Diskon Promo</td><td class="text-end text-warning">- @rupiah($discounts)</td></tr>
                    <tr><td class="fw-semibold">Pengeluaran (maintenance)</td><td class="text-end text-danger">- @rupiah($expense)</td></tr>
                    <tr class="border-top"><td class="fw-bold">Laba Bersih</td><td class="text-end fw-bold @if($net<0) text-danger @else text-success @endif">@rupiah($net)</td></tr>
                </tbody>
            </table>
        </div>

        <h6 class="fw-bold">Tren Bulanan Tahun {{ now()->year }}</h6>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead><tr><th>Bulan</th><th>Pendapatan</th><th>Pengeluaran</th><th>Selisih</th></tr></thead>
                <tbody>
                    @foreach ($months as $mo)
                    <tr>
                        <td>{{ $mo['month']->translatedFormat('F Y') }}</td>
                        <td>@rupiah($mo['income'])</td>
                        <td>@rupiah($mo['expense'])</td>
                        <td class="@php echo $mo['income']-$mo['expense'] < 0 ? 'text-danger':'text-success'; @endphp">@rupiah($mo['income'] - $mo['expense'])</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection