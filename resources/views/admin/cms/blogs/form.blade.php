@extends('layouts.admin')
@section('title', $blog->exists ? 'Edit Artikel' : 'Tulis Artikel')

@section('content')
<form method="post" action="{{ $blog->exists ? route('admin.cms.blogs.update', $blog) : route('admin.cms.blogs.store') }}" enctype="multipart/form-data">
    @csrf
    @if($blog->exists) @method('put') @endif
    <div class="card card-grid">
        <div class="card-header bg-white fw-bold">Isi Artikel</div>
        <div class="card-body row g-3">
            <div class="col-md-8"><label class="form-label">Judul</label><input type="text" name="title" value="{{ old('title', $blog->title) }}" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @foreach (['draft','published','archived'] as $s)<option value="{{ $s }}" @selected($blog->status==$s)>{{ ucfirst($s) }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">Kategori</label><input type="text" name="category" value="{{ old('category', $blog->category) }}" class="form-control"></div>
            @if($blog->exists)
            <div class="col-md-4"><label class="form-label">Penulis</label><input type="text" name="author" value="{{ old('author', $blog->author) }}" class="form-control"></div>
            @endif
            <div class="col-12"><label class="form-label">Ringkasan</label><textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $blog->excerpt) }}</textarea></div>
            <div class="col-12"><label class="form-label">Konten</label><textarea name="content" class="form-control" rows="8">{{ old('content', $blog->content) }}</textarea></div>
            <div class="col-md-6"><label class="form-label">Meta Title</label><input type="text" name="meta_title" value="{{ old('meta_title', $blog->meta_title) }}" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Meta Description</label><input type="text" name="meta_description" value="{{ old('meta_description', $blog->meta_description) }}" class="form-control"></div>
            <div class="col-12"><label class="form-label">Gambar Utama</label>
                @if($blog->featured_image)<img src="{{ asset('storage/' . $blog->featured_image) }}" class="d-block mb-2 rounded-3" style="max-height:140px" alt="">@endif
                <input type="file" name="featured_image" accept="image/*" class="form-control">
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-brand"><i class="fa-solid fa-save me-2"></i>Simpan</button>
        <a href="{{ route('admin.cms.blogs') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection