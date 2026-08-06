@extends('layouts.admin')
@section('title', $wedding->exists ? 'Edit Paket Wedding' : 'Tambah Paket Wedding')

@section('content')
<form method="post" action="{{ $wedding->exists ? route('admin.weddings.update', $wedding) : route('admin.weddings.store') }}">
    @csrf
    @if($wedding->exists) @method('put') @endif
    <div class="card card-grid">
        <div class="card-header bg-white fw-bold">Detail Paket Wedding</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><label class="form-label">Nama Paket</label><input type="text" name="name" value="{{ old('name', $wedding->name) }}" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label">Area</label><input type="text" name="area" value="{{ old('area', $wedding->area) }}" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Durasi (jam)</label><input type="number" name="duration_hours" value="{{ old('duration_hours', $wedding->duration_hours) }}" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Armada</label>
                <select name="fleet_id" class="form-select">
                    <option value="">--</option>
                    @foreach ($fleets as $f)<option value="{{ $f->id }}" @selected($wedding->fleet_id==$f->id)>{{ $f->display_name }} ({{ $f->license_plate }})</option>@endforeach
                </select>
            </div>
            <div class="col-md-3"><label class="form-label">Harga Sewa (Rp)</label><input type="number" step="0.01" name="rental_price" value="{{ old('rental_price', $wedding->rental_price) }}" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label">Hiasan (Rp)</label><input type="number" step="0.01" name="decoration_price" value="{{ old('decoration_price', $wedding->decoration_price) }}" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label">Driver (Rp)</label><input type="number" step="0.01" name="driver_price" value="{{ old('driver_price', $wedding->driver_price) }}" class="form-control" required></div>
            <div class="col-12"><label class="form-label">Detail Dekorasi</label><textarea name="decoration_details" class="form-control" rows="3">{{ old('decoration_details', $wedding->decoration_details) }}</textarea></div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-brand"><i class="fa-solid fa-save me-2"></i>Simpan</button>
        <a href="{{ route('admin.weddings.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection