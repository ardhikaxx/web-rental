@extends('layouts.admin')
@section('title', $banner->exists ? 'Edit Banner' : 'Tambah Banner')

@section('content')
<form method="post" action="{{ $banner->exists ? route('admin.cms.banners.update', $banner) : route('admin.cms.banners.store') }}" enctype="multipart/form-data">
    @csrf
    @if($banner->exists) @method('put') @endif
    <div class="card card-grid" style="max-width:640px">
        <div class="card-header bg-white fw-bold">Detail Banner</div>
        <div class="card-body row g-3">
            <div class="col-12"><label class="form-label">Judul</label><input type="text" name="title" value="{{ old('title', $banner->title) }}" class="form-control" required></div>
            <div class="col-12"><label class="form-label">Subjudul</label><textarea name="subtitle" class="form-control" rows="2">{{ old('subtitle', $banner->subtitle) }}</textarea></div>
            <div class="col-md-6"><label class="form-label">Teks Tombol</label><input type="text" name="button_text" value="{{ old('button_text', $banner->button_text) }}" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Tautan Tombol</label><input type="text" name="button_link" value="{{ old('button_link', $banner->button_link) }}" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Posisi</label><select name="position" class="form-select">
                @foreach (['hero','top','middle','bottom'] as $p)<option value="{{ $p }}" @selected($banner->position==$p)>{{ ucfirst($p) }}</option>@endforeach
            </select></div>
            <div class="col-md-6"><label class="form-label">Aktif</label><select name="is_active" class="form-select"><option value="1" @selected($banner->is_active)>Ya</option><option value="0" @selected(!$banner->is_active)>Tidak</option></select></div>
            <div class="col-12"><label class="form-label">Gambar</label>
                @if($banner->image)<img src="{{ asset('storage/' . $banner->image) }}" class="d-block mb-2 rounded-3" style="max-height:120px" alt="">@endif
                <input type="file" name="image" accept="image/*" class="form-control">
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-brand"><i class="fa-solid fa-save me-2"></i>Simpan</button>
        <a href="{{ route('admin.cms.banners') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection