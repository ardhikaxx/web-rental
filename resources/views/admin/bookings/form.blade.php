@extends('layouts.admin')
@section('title', $booking->exists ? 'Edit Booking' : 'Buat Booking')

@section('content')
<form method="post" action="{{ $booking->exists ? route('admin.bookings.update', $booking) : route('admin.bookings.store') }}">
    @csrf
    @if($booking->exists) @method('put') @endif
    <div class="card card-grid">
        <div class="card-header bg-white fw-bold">Info Booking</div>
        <div class="card-body row g-3">
            <div class="col-md-4"><label class="form-label">Nama Pelanggan</label><input type="text" name="customer_name" value="{{ old('customer_name', $booking->customer_name) }}" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">No HP</label><input type="text" name="customer_phone" value="{{ old('customer_phone', $booking->customer_phone) }}" class="form-control" required></div>
            @if(!$booking->exists)
            <div class="col-md-4"><label class="form-label">Email</label><input type="email" name="customer_email" value="{{ old('customer_email') }}" class="form-control" required></div>
            @endif
            <div class="col-md-4"><label class="form-label">Armada</label>
                <select name="fleet_id" class="form-select" required>
                    <option value="">--</option>
                    @foreach ($fleets as $f)<option value="{{ $f->id }}" @selected($booking->fleet_id==$f->id)>{{ $f->display_name }} ({{ $f->license_plate }})</option>@endforeach
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">Driver</label>
                <select name="driver_id" class="form-select">
                    <option value="">-- Tanpa Driver --</option>
                    @foreach ($drivers as $d)<option value="{{ $d->id }}" @selected($booking->driver_id==$d->id)>{{ $d->name }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">Tanggal Mulai</label><input type="date" name="start_date" value="{{ old('start_date', optional($booking->start_date)->format('Y-m-d')) }}" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Tanggal Selesai</label><input type="date" name="end_date" value="{{ old('end_date', optional($booking->end_date)->format('Y-m-d')) }}" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Lokasi Penjemputan</label><input type="text" name="pickup_location" value="{{ old('pickup_location', $booking->pickup_location) }}" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Lokasi Tujuan</label><input type="text" name="dropoff_location" value="{{ old('dropoff_location', $booking->dropoff_location) }}" class="form-control"></div>
            @if(!$booking->exists)
            <div class="col-md-4"><label class="form-label">Total Harga (Rp)</label><input type="number" step="0.01" name="total_price" value="{{ old('total_price') }}" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @foreach (\App\Models\Booking::statuses() as $k=>$v)<option value="{{ $k }}" @selected(old('status')==$k)>{{ $v }}</option>@endforeach
                </select>
            </div>
            @endif
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-brand"><i class="fa-solid fa-save me-2"></i>Simpan</button>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection