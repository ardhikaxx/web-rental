@extends('layouts.admin')
@section('title', 'Laporan Booking')

@section('content')
<div class="card card-grid">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Laporan Booking</h6>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reports.export-pdf', array_merge(['type'=>'booking'], request()->query())) }}" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-file-pdf"></i> PDF</a>
            <a href="{{ route('admin.reports.export-excel', array_merge(['type'=>'booking'], request()->query())) }}" class="btn btn-sm btn-outline-success"><i class="fa-solid fa-file-excel"></i> Excel</a>
        </div>
    </div>
    <div class="card-body">
        <form class="row g-2 mb-3" method="get">
            <div class="col-auto"><input type="date" name="from" value="{{ request('from') }}" class="form-control form-control-sm"></div>
            <div class="col-auto"><input type="date" name="to" value="{{ request('to') }}" class="form-control form-control-sm"></div>
            <div class="col-auto">
                <select name="status" class="form-select form-select-sm">
                    <option value="all">Semua Status</option>
                    @foreach ($statuses as $k=>$v)<option value="{{ $k }}" @selected(request('status','all')==$k)>{{ $v }}</option>@endforeach
                </select>
            </div>
            <div class="col-auto"><button class="btn btn-sm btn-outline-primary">Filter</button></div>
            <div class="col-auto"><a href="{{ route('admin.reports.booking') }}" class="btn btn-sm btn-outline-secondary">Reset</a></div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>No.</th><th>Kode</th><th>Pelanggan</th><th>Armada</th><th>Durasi</th><th>Mulai</th><th>Selesai</th><th>Total</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse ($bookings as $i=>$b)
                    <tr>
                        <td>{{ $i + $bookings->firstItem() }}</td>
                        <td><a href="{{ route('admin.bookings.show', $b) }}" class="text-decoration-none">{{ $b->booking_code }}</a></td>
                        <td>{{ $b->customer_name }}</td>
                        <td>{{ $b->fleet?->license_plate }}</td>
                        <td>{{ $b->duration_days }} hari</td>
                        <td>@dateid($b->start_date)</td>
                        <td>@dateid($b->end_date)</td>
                        <td>@rupiah($b->total_price)</td>
                        <td><span class="badge bg-secondary">{{ $statuses[$b->status] ?? $b->status }}</span></td>
                    </tr>
                    @empty <tr><td colspan="9" class="text-center text-muted py-4">Belum ada data.</td></tr> @endforelse
                </tbody>
            </table>
        </div>
        {{ $bookings->links() }}
    </div>
</div>
@endsection