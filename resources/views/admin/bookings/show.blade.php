@extends('layouts.admin')
@section('title', 'Detail Booking ' . $booking->booking_code)

@section('content')
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card card-grid">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold mb-0">{{ $booking->booking_code }}</h5>
                        <small class="text-muted">{{ $booking->invoice_number }}</small>
                    </div>
                    <span class="badge bg-{{ $booking->status=='selesai'?'success':($booking->status=='dibatalkan'||$booking->status=='refund'?'danger':($booking->status=='berjalan'?'info':'secondary')) }}">{{ $statuses[$booking->status] ?? $booking->status }}</span>
                </div>
                <hr>
                <div class="row g-2">
                    <div class="col-md-4"><strong>Pelanggan:</strong> {{ $booking->customer_name }}</div>
                    <div class="col-md-4"><strong>No HP:</strong> {{ $booking->customer_phone }}</div>
                    <div class="col-md-4"><strong>Email:</strong> {{ $booking->customer_email }}</div>
                    <div class="col-md-4"><strong>Armada:</strong> {{ $booking->fleet?->display_name ?? '-' }}</div>
                    <div class="col-md-4"><strong>Driver:</strong> {{ $booking->driver?->name ?? '-' }}</div>
                    <div class="col-md-4"><strong>Dengan Sopir:</strong> {{ $booking->with_driver ? 'Ya' : 'Tidak' }}</div>
                    <div class="col-md-4"><strong>Mulai:</strong> {{ format_indo_date($booking->start_date) }}</div>
                    <div class="col-md-4"><strong>Selesai:</strong> {{ format_indo_date($booking->end_date) }}</div>
                    <div class="col-md-4"><strong>Durasi:</strong> {{ $booking->duration_days ?? '-' }} hari</div>
                    <div class="col-md-6"><strong>Penjemputan:</strong> {{ $booking->pickup_location ?? '-' }}</div>
                    <div class="col-md-6"><strong>Penurunan:</strong> {{ $booking->dropoff_location ?? '-' }}</div>
                    @if($booking->special_notes)<div class="col-12"><strong>Catatan:</strong> {{ $booking->special_notes }}</div>@endif
                </div>
            </div>
        </div>

        <div class="row g-3 mt-0">
            <div class="col-lg-6">
                <div class="card card-grid">
                    <div class="card-header bg-white fw-bold">Rincian Biaya</div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between py-1"><span>Harga Dasar</span><span>@rupiah($booking->base_price)</span></div>
                        <div class="d-flex justify-content-between py-1"><span>Fee Driver</span><span>@rupiah($booking->driver_fee)</span></div>
                        <div class="d-flex justify-content-between py-1"><span>Biaya Tambahan</span><span>@rupiah($booking->extra_cost)</span></div>
                        <div class="d-flex justify-content-between py-1"><span>Diskon</span><span>-@rupiah($booking->discount)</span></div>
                        <div class="d-flex justify-content-between py-1"><span>Pajak</span><span>@rupiah($booking->tax)</span></div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold py-1"><span>Total</span><span>@rupiah($booking->total_price)</span></div>
                        <div class="d-flex justify-content-between py-1"><span>Dibayar</span><span class="text-success">@rupiah($booking->paid_amount) ({{ $booking->paid_percent }}%)</span></div>
                        <div class="d-flex justify-content-between py-1 text-danger fw-semibold"><span>Sisa</span><span>@rupiah($booking->remaining_amount)</span></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-grid">
                    <div class="card-header bg-white fw-bold">Pembayaran</div>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead><tr><th>No.</th><th>Tipe</th><th>Jumlah</th><th>Status</th></tr></thead>
                            <tbody>
                                @forelse ($booking->payments as $p)
                                <tr>
                                    <td>{{ $p->payment_number }}</td>
                                    <td>{{ $p->type }}</td>
                                    <td>@rupiah($p->amount)</td>
                                    <td><span class="badge bg-{{ $p->status=='verified'?'success':($p->status=='rejected'?'danger':'secondary') }}">{{ $p->status }}</span></td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">Belum ada pembayaran.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card card-grid">
            <div class="card-header bg-white fw-bold">Ubah Status</div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.bookings.status', $booking) }}">
                    @csrf
                    <select name="status" class="form-select mb-3" required>
                        @foreach ($statuses as $k=>$v)
                            <option value="{{ $k }}" @selected($booking->status==$k)>{{ $v }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary w-100"><i class="fa-solid fa-arrows-rotate me-1"></i>Perbarui Status</button>
                </form>
                <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-outline-primary w-100 mt-2"><i class="fa-solid fa-pen"></i> Edit Booking</a>
            </div>
        </div>
        <div class="card card-grid mt-3">
            <div class="card-body">
                <h6 class="fw-bold">Progress Pembayaran</h6>
                <div class="progress mb-2" style="height:8px"><div class="progress-bar bg-success" style="width:{{ $booking->paid_percent }}%"></div></div>
                <small class="text-muted">{{ $booking->paid_percent }}% dibayar dari @rupiah($booking->total_price)</small>
            </div>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary w-100 mt-3">Kembali</a>
    </div>
</div>
@endsection