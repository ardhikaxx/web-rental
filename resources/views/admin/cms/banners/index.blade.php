@extends('layouts.admin')
@section('title', 'Banners')
@section('styles')
<style>.banner-img{width:120px;height:60px;object-fit:cover;border-radius:8px}</style>
@endsection

@section('content')
<div class="card card-grid">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.cms.banners.create') }}" class="btn btn-sm btn-brand"><i class="fa-solid fa-plus me-1"></i>Tambah Banner</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th></th><th>Judul</th><th>Subjudul</th><th>Posisi</th><th>Tombol</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse ($banners as $banner)
                    <tr>
                        <td>@if($banner->image)<img src="{{ asset('storage/' . $banner->image) }}" class="banner-img" alt="">@else<span class="text-muted">-</span>@endif</td>
                        <td class="fw-semibold">{{ $banner->title }}</td>
                        <td>{{ $banner->subtitle }}</td>
                        <td>{{ $banner->position ?? '-' }}</td>
                        <td>{{ $banner->button_text }} <small class="text-muted d-block">{{ $banner->button_link }}</small></td>
                        <td><span class="badge bg-{{ $banner->is_active ? 'success' : 'secondary' }}">{{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td>
                            <a href="{{ route('admin.cms.banners.edit', $banner) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.cms.banners.destroy', $banner) }}" method="post" class="d-inline delete-form">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada banner.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection