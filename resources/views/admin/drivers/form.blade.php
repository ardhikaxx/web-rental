@extends('layouts.admin')
@section('title', $driver->exists ? 'Edit Driver' : 'Tambah Driver')

@section('content')
<form method="post" action="{{ $driver->exists ? route('admin.drivers.update', $driver) : route('admin.drivers.store') }}" enctype="multipart/form-data">
    @csrf
    @if($driver->exists) @method('put') @endif
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card card-grid">
                <div class="card-header bg-white fw-bold">Data Driver</div>
                <div class="card-body row g-3">
                    <div class="col-md-6"><label class="form-label">Nama</label><input type="text" name="name" value="{{ old('name', $driver->name) }}" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">No. HP</label><input type="text" name="phone" value="{{ old('phone', $driver->phone) }}" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email', $driver->email) }}" class="form-control"></div>
                    <div class="col-12"><label class="form-label">Alamat</label><textarea name="address" class="form-control" rows="2">{{ old('address', $driver->address) }}</textarea></div>
                    <div class="col-md-4"><label class="form-label">No. SIM</label><input type="text" name="license_number" value="{{ old('license_number', $driver->license_number) }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Masa Berlaku SIM</label><input type="date" name="license_expired_at" value="{{ old('license_expired_at', optional($driver->license_expired_at)->format('Y-m-d')) }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Jenis SIM</label><select name="license_type" class="form-select">
                        <option value="">--</option>
                        @foreach (['A','B1','B2','C'] as $t)<option value="{{ $t }}" @selected($driver->license_type==$t)>{{ $t }}</option>@endforeach
                    </select></div>
                    <div class="col-md-4"><label class="form-label">Status</label><input type="text" name="status" value="{{ old('status', $driver->status ?? 'aktif') }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Rating</label><input type="number" step="0.1" min="0" max="5" name="rating" value="{{ old('rating', $driver->rating) }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Pengalaman</label><input type="text" name="experience" value="{{ old('experience', $driver->experience) }}" class="form-control"></div>
                    <div class="col-12"><label class="form-label">Catatan</label><textarea name="notes" class="form-control" rows="2">{{ old('notes', $driver->notes) }}</textarea></div>
                    <div class="col-md-4"><label class="form-label">Aktif</label><select name="is_active" class="form-select"><option value="1" @selected($driver->is_active)>Ya</option><option value="0" @selected(!$driver->is_active)>Tidak</option></select></div>
                    <div class="col-md-8"><label class="form-label">Foto</label><input type="file" name="photo" accept="image/*" class="form-control"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-brand"><i class="fa-solid fa-save me-2"></i>Simpan</button>
        <a href="{{ route('admin.drivers.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection