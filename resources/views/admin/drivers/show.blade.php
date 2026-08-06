@extends('layouts.admin')
@section('title', 'Detail Driver ' . $driver->name)

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card card-grid">
            <div class="card-body text-center">
                <img src="{{ $driver->photo_url }}" class="rounded-circle mb-3" style="width:110px;height:110px;object-fit:cover" alt="">
                <h5 class="fw-bold mb-0">{{ $driver->name }}</h5>
                <span class="badge bg-{{ $driver->is_active ? 'success' : 'secondary' }}">{{ $driver->status ?? ($driver->is_active ? 'aktif' : 'nonaktif') }}</span>
                <hr>
                <div class="text-start small">
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">No. HP</span><span>{{ $driver->phone }}</span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">Email</span><span>{{ $driver->email ?? '-' }}</span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">No. SIM</span><span>{{ $driver->license_number ?? '-' }}</span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">SIM Berlaku</span><span>{{ $driver->license_expired_at ? format_indo_date($driver->license_expired_at) : '-' }}</span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">Rating</span><span>{{ $driver->rating ? number_format($driver->rating, 1) : '-' }}</span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">Total Trip</span><span>{{ $driver->experience_trips }}x</span></div>
                    <div class="py-1"><span class="text-muted d-block">Alamat</span>{{ $driver->address ?? '-' }}</div>
                </div>
            </div>
        </div>
        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('admin.drivers.edit', $driver) }}" class="btn btn-outline-primary w-100"><i class="fa-solid fa-pen"></i> Edit</a>
            <a href="{{ route('admin.drivers.index') }}" class="btn btn-outline-secondary w-100">Kembali</a>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card card-grid">
            <div class="card-header bg-white fw-bold">Riwayat Booking</div>
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead><tr><th>Kode</th><th>Pelanggan</th><th>Armada</th><th>Tanggal</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse ($driver->bookings as $b)
                        <tr>
                            <td><a href="{{ route('admin.bookings.show', $b) }}" class="text-decoration-none">{{ $b->booking_code }}</a></td>
                            <td>{{ $b->customer_name }}</td>
                            <td>{{ $b->fleet->license_plate ?? '-' }}</td>
                            <td>{{ format_indo_date($b->start_date) }}</td>
                            <td><span class="badge bg-secondary">{{ $b->status }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-muted text-center py-4">Belum ada booking.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection