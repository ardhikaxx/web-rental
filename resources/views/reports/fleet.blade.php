@extends('layouts.admin')
@section('title', 'Laporan Armada')

@section('content')
<div class="card card-grid">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Laporan Armada</h6>
        <form class="d-flex gap-2" method="get">
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="all">Semua Status</option>
                @foreach (['tersedia','dipesan','berjalan','maintenance','nonaktif'] as $s)
                    <option value="{{ $s }}" @selected(request('status','all')==$s)>{{ $s }}</option>
                @endforeach
            </select>
            <a href="{{ route('admin.reports.export-pdf', array_merge(['type'=>'fleet'], request()->query())) }}" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-file-pdf"></i> PDF</a>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>Kode</th><th>Armada</th><th>Plat</th><th>Kapasitas</th><th>Harga Harian</th><th>Status</th><th>Total Booking</th><th>Pendapatan</th></tr></thead>
                <tbody>
                    @forelse ($fleets as $f)
                    <tr>
                        <td>{{ $f->code }}</td>
                        <td>{{ $f->display_name }}</td>
                        <td>{{ $f->license_plate }}</td>
                        <td>{{ $f->capacity }}</td>
                        <td>@rupiah($f->daily_price)</td>
                        <td><span class="badge bg-secondary">{{ $f->status }}</span></td>
                        <td>{{ $f->total_bookings }}</td>
                        <td>@rupiah($f->total_revenue)</td>
                    </tr>
                    @empty <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data.</td></tr> @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection