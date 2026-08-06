@extends('layouts.admin')
@section('title', $service->exists ? 'Edit Layanan' : 'Tambah Layanan')

@section('content')
<form method="post" action="{{ $service->exists ? route('admin.cms.services.update', $service) : route('admin.cms.services.store') }}" enctype="multipart/form-data">
    @csrf
    @if($service->exists) @method('put') @endif
    <div class="card card-grid">
        <div class="card-header bg-white fw-bold">Detail Layanan</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><label class="form-label">Nama</label><input type="text" name="name" value="{{ old('name', $service->name) }}" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label">Ikon (FontAwesome)</label><input type="text" name="icon" value="{{ old('icon', $service->icon) }}" class="form-control" placeholder="fa-car"></div>
            <div class="col-md-3"><label class="form-label">Aktif</label><select name="is_active" class="form-select"><option value="1" @selected($service->is_active)>Ya</option><option value="0" @selected(!$service->is_active)>Tidak</option></select></div>
            <div class="col-12"><label class="form-label">Ringkasan</label><textarea name="description" class="form-control" rows="2">{{ old('description', $service->description) }}</textarea></div>
            <div class="col-12"><label class="form-label">Konten</label><textarea name="content" class="form-control" rows="5">{{ old('content', $service->content) }}</textarea></div>
            <div class="col-12"><label class="form-label">Gambar Utama</label>
                @if($service->featured_image)<img src="{{ asset('storage/' . $service->featured_image) }}" class="d-block mb-2 rounded-3" style="max-height:120px" alt="">@endif
                <input type="file" name="featured_image" accept="image/*" class="form-control">
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-brand"><i class="fa-solid fa-save me-2"></i>Simpan</button>
        <a href="{{ route('admin.cms.services') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection