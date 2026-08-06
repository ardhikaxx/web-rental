@extends('layouts.admin')
@section('title', $gallery->exists ? 'Edit Foto Galeri' : 'Tambah Foto Galeri')

@section('content')
<form method="post" action="{{ $gallery->exists ? route('admin.cms.galleries.update', $gallery) : route('admin.cms.galleries.store') }}" enctype="multipart/form-data">
    @csrf
    @if($gallery->exists) @method('put') @endif
    <div class="card card-grid" style="max-width:640px">
        <div class="card-header bg-white fw-bold">Detail Galeri</div>
        <div class="card-body row g-3">
            <div class="col-md-8"><label class="form-label">Judul</label><input type="text" name="title" value="{{ old('title', $gallery->title) }}" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Kategori</label><input type="text" name="category" value="{{ old('category', $gallery->category) }}" class="form-control"></div>
            <div class="col-12"><label class="form-label">Gambar</label>
                @if($gallery->image)<img src="{{ asset('storage/' . $gallery->image) }}" class="d-block mb-2 rounded-3" style="max-height:140px" alt="">@endif
                <input type="file" name="image" accept="image/*" class="form-control" {{ $gallery->exists ? '' : 'required' }}>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-brand"><i class="fa-solid fa-save me-2"></i>Simpan</button>
        <a href="{{ route('admin.cms.galleries') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection