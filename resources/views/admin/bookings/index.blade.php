@extends('layouts.admin')
@section('title', 'Manajemen Booking')

@section('content')
<div class="card card-grid">
    <x-table-toolbar title="Booking" placeholder="Kode / nama / no HP…" addUrl="{{ route('admin.bookings.create') }}" addLabel="Buat Booking" addTitle="Buat Booking Baru" filter="filter">
        <select name="status" class="form-select form-select-sm" style="width:auto">
            <option value="all">Semua Status</option>
            @foreach ($statuses as $k=>$v)
                <option value="{{ $k }}" @selected(request('status', 'all')==$k)>{{ $v }}</option>
            @endforeach
        </select>
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control form-control-sm" style="width:auto" title="Tanggal mulai">
        <span class="text-muted small">s.d.</span>
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control form-control-sm" style="width:auto" title="Tanggal akhir">
    </x-table-toolbar>
    <div class="card-body">
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