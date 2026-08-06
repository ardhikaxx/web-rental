@extends('layouts.admin')
@section('title', 'Laporan Driver')

@section('content')
<div class="card card-grid">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Laporan Driver</h6>
        <a href="{{ route('admin.reports.export-pdf', ['type'=>'driver']) }}" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-file-pdf"></i> PDF</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>No.</th><th>Nama</th><th>No HP</th><th>SIM</th><th>Rating</th><th>Perjalanan</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse ($drivers as $i=>$d)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $d->name }}</td>
                        <td>{{ $d->phone }}</td>
                        <td>{{ $d->license_number }}</td>
                        <td>{{ $d->rating }}</td>
                        <td>{{ $d->total_trips }}</td>
                        <td><span class="badge bg-secondary">{{ $d->status }}</span></td>
                    </tr>
                    @empty <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data.</td></tr> @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection