@extends('layouts.admin')
@section('title', 'Laporan Pengeluaran')

@section('content')
<div class="card card-grid">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Pengeluaran Maintenance</h6>
        <a href="{{ route('admin.reports.export-pdf', array_merge(['type'=>'maintenance'], request()->query())) }}" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-file-pdf"></i> PDF</a>
    </div>
    <div class="card-body">
        <form class="row g-2 mb-3" method="get">
            <div class="col-auto"><input type="date" name="from" value="{{ $from }}" class="form-control form-control-sm"></div>
            <div class="col-auto"><input type="date" name="to" value="{{ $to }}" class="form-control form-control-sm"></div>
            <div class="col-auto"><button class="btn btn-sm btn-outline-primary">Terapkan</button></div>
        </form>
        <div class="alert alert-light border-2">Total Pengeluaran: <strong>@rupiah($total)</strong></div>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>No.</th><th>Kode</th><th>Armada</th><th>Jenis</th><th>Tanggal</th><th>Biaya</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse ($maintenances as $i=>$m)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $m->code }}</td>
                        <td>{{ $m->fleet?->license_plate }}</td>
                        <td>{{ $m->type }}</td>
                        <td>@dateid($m->date)</td>
                        <td>@rupiah($m->cost)</td>
                        <td><span class="badge bg-secondary">{{ $m->status }}</span></td>
                    </tr>
                    @empty <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data.</td></tr> @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection