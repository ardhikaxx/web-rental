@extends('layouts.admin')
@section('title', 'Galeri')
@section('styles')
<style>.gallery-img{width:120px;height:80px;object-fit:cover;border-radius:8px}</style>
@endsection

@section('content')
    <div class="card card-grid">
        <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.cms.galleries.create') }}" class="btn btn-sm btn-brand"><i class="fa-solid fa-plus me-1"></i>Tambah Foto</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th></th><th>Judul</th><th>Kategori</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse ($galleries as $gallery)
                    <tr>
                        <td><img src="{{ asset('storage/' . $gallery->image) }}" class="gallery-img" alt=""></td>
                        <td class="fw-semibold">{{ $gallery->title }}</td>
                        <td>{{ $gallery->category }}</td>
                        <td>
                            <a href="{{ route('admin.cms.galleries.edit', $gallery) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.cms.galleries.destroy', $gallery) }}" method="post" class="d-inline delete-form">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada foto.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection