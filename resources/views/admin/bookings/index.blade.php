@extends('layouts.admin')
@section('title', 'Manajemen Booking')

@section('content')
<div class="card card-grid">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <form class="d-flex gap-2 flex-wrap" method="get" action="">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Kode / nama / no HP">
                <select name="status" class="form-select form-select-sm">
                    <option value="all">Semua Status</option>
                    @foreach ($statuses as $k=>$v)
                        <option value="{{ $k }}" @selected(request('status', 'all')==$k)>{{ $v }}</option>
                    @endforeach
                </select>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control form-control-sm">
                <span class="align-self-center">s.d.</span>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control form-control-sm">
                <button class="btn btn-sm btn-outline-primary">Filter</button>
            </form>
            <a href="{{ route('admin.bookings.create') }}" class="btn btn-sm btn-brand"><i class="fa-solid fa-plus me-1"></i>Buat Booking</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th>Kode</th><th>Pelanggan</th><th>No HP</th><th>Armada</th><th>Tanggal Mulai</th><th>Total</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach ($bookings as $b)
                    <tr>
                        <td><a href="{{ route('admin.bookings.show', $b) }}" class="fw-semibold text-decoration-none">{{ $b->booking_code }}</a></td>
                        <td>{{ $b->customer_name }}</td>
                        <td>{{ $b->customer_phone }}</td>
                        <td>{{ $b->fleet->license_plate ?? '-' }}</td>
                        <td>{{ format_indo_date($b->start_date) }}</td>
                        <td>@rupiah($b->total_price)</td>
                        <td><span class="badge bg-{{ $b->status=='selesai'?'success':($b->status=='dibatalkan'||$b->status=='refund'?'danger':($b->status=='berjalan'?'info':'secondary')) }}">{{ $statuses[$b->status] ?? $b->status }}</span></td>
                        <td><a href="{{ route('admin.bookings.show', $b) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $bookings->links() }}
    </div>
</div>
@endsection