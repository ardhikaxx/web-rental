@extends('layouts.admin')
@section('title', $tour->exists ? 'Edit Paket Wisata' : 'Tambah Paket Wisata')

@section('content')
<form method="post" action="{{ $tour->exists ? route('admin.tours.update', $tour) : route('admin.tours.store') }}" enctype="multipart/form-data">
    @csrf
    @if($tour->exists) @method('put') @endif
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card card-grid">
                <div class="card-header bg-white fw-bold">Detail Paket</div>
                <div class="card-body row g-3">
                    <div class="col-md-6"><label class="form-label">Nama Paket</label><input type="text" name="name" value="{{ old('name', $tour->name) }}" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Tujuan</label><input type="text" name="destination" value="{{ old('destination', $tour->destination) }}" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">Hari</label><input type="number" name="duration_days" value="{{ old('duration_days', $tour->duration_days) }}" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Malam</label><input type="number" name="duration_nights" value="{{ old('duration_nights', $tour->duration_nights) }}" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">Harga / Orang</label><input type="number" step="0.01" name="price_per_person" value="{{ old('price_per_person', $tour->price_per_person) }}" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Harga / Grup</label><input type="number" step="0.01" name="price_per_group" value="{{ old('price_per_group', $tour->price_per_group) }}" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">Min Grup</label><input type="number" name="min_group" value="{{ old('min_group', $tour->min_group) }}" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">Max Grup</label><input type="number" name="max_group" value="{{ old('max_group', $tour->max_group) }}" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            @foreach (['aktif','draft','nonaktif'] as $s)<option value="{{ $s }}" @selected($tour->status==$s)>{{ ucfirst($s) }}</option>@endforeach
                        </select>
                    </div>
                    <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3">{{ old('description', $tour->description) }}</textarea></div>
                    <div class="col-12"><label class="form-label">Itinerary (setiap baris)</label><textarea name="itinerary" class="form-control" rows="4">{{ old('itinerary', $tour->itinerary) }}</textarea></div>
                    <div class="col-12"><label class="form-label">Fasilitas (setiap baris)</label><textarea name="facilities" class="form-control" rows="3">{{ old('facilities', $tour->facilities) }}</textarea></div>
                    <div class="col-12"><label class="form-label">Syarat & Ketentuan (setiap baris)</label><textarea name="terms" class="form-control" rows="3">{{ old('terms', $tour->terms) }}</textarea></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-grid">
                <div class="card-header bg-white fw-bold">Thumbnail</div>
                <div class="card-body">
                    @if($tour->thumbnail)<img src="{{ asset('storage/' . $tour->thumbnail) }}" class="w-100 rounded-3 mb-2" style="max-height:180px;object-fit:cover" alt="">@endif
                    <input type="file" name="thumbnail" accept="image/*" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-brand"><i class="fa-solid fa-save me-2"></i>Simpan</button>
        <a href="{{ route('admin.tours.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection