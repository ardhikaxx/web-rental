@extends('layouts.admin')
@section('title', 'Detail Pelanggan ' . $customer->name)

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card card-grid">
            <div class="card-body text-center">
                <img src="{{ $customer->avatar }}" class="rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover" alt="">
                <h5 class="fw-bold mb-1">{{ $customer->name }}</h5>
                <span class="badge bg-{{ $customer->is_active ? 'success' : 'danger' }}">{{ $customer->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                <hr>
                <div class="text-start small">
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">Email</span><span>{{ $customer->email }}</span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">No HP</span><span>{{ $customer->phone ?? '-' }}</span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">Kota</span><span>{{ $customer->city ?? '-' }}</span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">Total Booking</span><span>{{ $customer->bookings->count() }}</span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">Total Belanja</span><span>@rupiah($customer->payments->where('status','verified')->sum('amount'))</span></div>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary w-100 mt-3">Kembali</a>
    </div>
    <div class="col-lg-8">
        <div class="card card-grid">
            <div class="card-header bg-white fw-bold">Riwayat Booking</div>
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead><tr><th>Kode</th><th>Armada</th><th>Total</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse ($customer->bookings as $b)
                        <tr>
                            <td><a href="{{ route('admin.bookings.show', $b) }}" class="text-decoration-none">{{ $b->booking_code }}</a></td>
                            <td>{{ $b->fleet?->display_name ?? '-' }}</td>
                            <td>@rupiah($b->total_price)</td>
                            <td><span class="badge bg-secondary">{{ $b->status }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada booking.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card card-grid mt-3">
            <div class="card-header bg-white fw-bold">Riwayat Pembayaran</div>
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead><tr><th>No. Bayar</th><th>Tipe</th><th>Jumlah</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse ($customer->payments as $p)
                        <tr>
                            <td><a href="{{ route('admin.payments.show', $p) }}" class="text-decoration-none">{{ $p->payment_number }}</a></td>
                            <td>{{ $p->type }}</td>
                            <td>@rupiah($p->amount)</td>
                            <td><span class="badge bg-{{ $p->status=='verified'?'success':($p->status=='rejected'?'danger':'secondary') }}">{{ $p->status }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada pembayaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection