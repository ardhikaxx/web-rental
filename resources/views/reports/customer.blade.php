@extends('layouts.admin')
@section('title', 'Laporan Pelanggan')

@section('content')
<div class="card card-grid">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Laporan Pelanggan</h6>
        <a href="{{ route('admin.reports.export-pdf', ['type'=>'customer']) }}" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-file-pdf"></i> PDF</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>No.</th><th>Nama</th><th>Email</th><th>No HP</th><th>Kota</th><th>Total Booking</th><th>Total Belanja</th></tr></thead>
                <tbody>
                    @forelse ($customers as $i=>$c)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->email }}</td>
                        <td>{{ $c->phone }}</td>
                        <td>{{ $c->city }}</td>
                        <td>{{ $c->total_bookings }}</td>
                        <td>@rupiah($c->total_spent)</td>
                    </tr>
                    @empty <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data.</td></tr> @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection