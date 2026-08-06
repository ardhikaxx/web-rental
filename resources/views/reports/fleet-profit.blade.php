@extends('layouts.admin')
@section('title', 'Laba per Unit Armada')

@section('content')
<div class="card card-grid">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Laba / Rugi per Armada</h6>
        <a href="{{ route('admin.reports.export-pdf', array_merge(['type'=>'fleet-profit'], request()->query())) }}" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-file-pdf"></i> PDF</a>
    </div>
    <div class="card-body">
        <form class="row g-2 mb-3" method="get">
            <div class="col-auto"><input type="date" name="from" value="{{ $from }}" class="form-control form-control-sm"></div>
            <div class="col-auto"><input type="date" name="to" value="{{ $to }}" class="form-control form-control-sm"></div>
            <div class="col-auto"><button class="btn btn-sm btn-outline-primary">Terapkan</button></div>
        </form>

        <div class="row g-2 mb-4">
            <div class="col-md-3"><div class="border rounded-3 p-3"><small class="text-muted">Total Pendapatan</small><div class="fs-5 fw-bold text-success">@rupiah($totals['revenue'])</div></div></div>
            <div class="col-md-3"><div class="border rounded-3 p-3"><small class="text-muted">Total Biaya Maintenance</small><div class="fs-5 fw-bold text-danger">@rupiah($totals['maintenance_cost'])</div></div></div>
            <div class="col-md-3"><div class="border rounded-3 p-3"><small class="text-muted">Total Laba Bersih</small><div class="fs-5 fw-bold {{ $totals['net']<0?'text-danger':'text-success' }}">@rupiah($totals['net'])</div></div></div>
            <div class="col-md-3"><div class="border rounded-3 p-3"><small class="text-muted">Trip / Maintenance</small><div class="fs-5 fw-bold">{{ $totals['trips'] }} <span class="fs-6 text-muted">/ {{ $totals['maintenance_count'] }}</span></div></div></div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>No.</th><th>Kode</th><th>Armada</th><th>Plat</th><th>Trip</th><th>Pendapatan</th><th>Biaya Maint.</th><th>Laba</th></tr></thead>
                <tbody>
                    @forelse ($fleets as $i=>$f)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $f->code }}</td>
                        <td>{{ $f->display_name }}</td>
                        <td>{{ $f->license_plate }}</td>
                        <td>{{ $f->trips }}</td>
                        <td>@rupiah($f->revenue)</td>
                        <td>@rupiah($f->maintenance_cost)</td>
                        <td class="fw-bold {{ $f->net<0?'text-danger':'text-success' }}">@rupiah($f->net)</td>
                    </tr>
                    @empty <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data.</td></tr> @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection