@extends('layouts.admin')
@section('title', $fleet->exists ? 'Edit Armada' : 'Tambah Armada')

@section('content')
<form method="post" action="{{ $fleet->exists ? route('admin.fleets.update', $fleet) : route('admin.fleets.store') }}" enctype="multipart/form-data">
    @csrf
    @if($fleet->exists) @method('put') @endif
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card card-grid">
                <div class="card-header bg-white fw-bold">Info Kendaraan</div>
                <div class="card-body row g-3">
                    <div class="col-md-4"><label class="form-label">Merk</label><input type="text" name="brand" value="{{ old('brand', $fleet->brand) }}" class="form-control" required></div>
                    <div class="col-md-4"><label class="form-label">Model</label><input type="text" name="model" value="{{ old('model', $fleet->model) }}" class="form-control" required></div>
                    <div class="col-md-4"><label class="form-label">Kategori</label>
                        <select name="category_id" class="form-select">
                            <option value="">--</option>
                            @foreach ($categories as $c)<option value="{{ $c->id }}" @selected($fleet->category_id==$c->id)>{{ $c->name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="col-md-3"><label class="form-label">Tahun</label><input type="text" name="year" value="{{ old('year', $fleet->year) }}" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">No. Polisi</label><input type="text" name="license_plate" value="{{ old('license_plate', $fleet->license_plate) }}" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Warna</label><input type="text" name="color" value="{{ old('color', $fleet->color) }}" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">Jenis BBM</label><input type="text" name="fuel" value="{{ old('fuel', $fleet->fuel) }}" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">Transmisi</label><input type="text" name="transmission" value="{{ old('transmission', $fleet->transmission) }}" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">Kapasitas</label><input type="number" name="capacity" value="{{ old('capacity', $fleet->capacity) }}" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">No. Rangka</label><input type="text" name="frame_number" value="{{ old('frame_number', $fleet->frame_number) }}" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">No. Mesin</label><input type="text" name="engine_number" value="{{ old('engine_number', $fleet->engine_number) }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Lokasi</label><input type="text" name="location" value="{{ old('location', $fleet->location) }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            @foreach (['tersedia','dipesan','berjalan','maintenance','nonaktif'] as $s)<option value="{{ $s }}" @selected($fleet->status==$s)>{{ ucfirst($s) }}</option>@endforeach
                        </select>
                    </div>
                    <div class="col-md-4"><label class="form-label">Aktif</label><select name="is_active" class="form-select"><option value="1" @selected($fleet->is_active) >Ya</option><option value="0" @selected(!$fleet->is_active)>Tidak</option></select></div>
                    <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="2">{{ old('description', $fleet->description) }}</textarea></div>
                    <div class="col-12"><label class="form-label">Fasilitas (setiap baris)</label><textarea name="facilities" class="form-control" rows="3">{{ old('facilities', $fleet->facilities) }}</textarea></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-grid">
                <div class="card-header bg-white fw-bold">Harga Sewa</div>
                <div class="card-body row g-3">
                    <div class="col-12"><label class="form-label">Harian (Rp)</label><input type="number" step="any" name="daily_price" value="{{ old('daily_price', $fleet->daily_price) }}" class="form-control" required></div>
                    <div class="col-6"><label class="form-label">Mingguan</label><input type="number" step="any" name="weekly_price" value="{{ old('weekly_price', $fleet->weekly_price) }}" class="form-control"></div>
                    <div class="col-6"><label class="form-label">Bulanan</label><input type="number" step="any" name="monthly_price" value="{{ old('monthly_price', $fleet->monthly_price) }}" class="form-control"></div>
                    <div class="col-12"><label class="form-label">Dengan Sopir</label><input type="number" step="any" name="price_with_driver" value="{{ old('price_with_driver', $fleet->price_with_driver) }}" class="form-control"></div>
                    <div class="col-12"><label class="form-label">Lepas Kunci</label><input type="number" step="any" name="price_without_driver" value="{{ old('price_without_driver', $fleet->price_without_driver) }}" class="form-control"></div>
                </div>
            </div>
            <div class="card card-grid mt-3">
                <div class="card-header bg-white fw-bold">Foto Kendaraan</div>
                <div class="card-body"><input type="file" name="images[]" multiple accept="image/*" class="form-control"></div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-brand"><i class="fa-solid fa-save me-2"></i>Simpan</button>
        <a href="{{ route('admin.fleets.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection