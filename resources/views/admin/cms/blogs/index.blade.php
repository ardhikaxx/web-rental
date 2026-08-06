@extends('layouts.admin')
@section('title', 'Artikel Blog')
@section('styles')
<style>.blog-img{width:90px;height:56px;object-fit:cover;border-radius:8px}</style>
@endsection

@section('content')
    <div class="card card-grid">
        <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.cms.blogs.create') }}" class="btn btn-sm btn-brand"><i class="fa-solid fa-plus me-1"></i>Tulis Artikel</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th></th><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse ($blogs as $blog)
                    <tr>
                        <td>@if($blog->featured_image)<img src="{{ asset('storage/' . $blog->featured_image) }}" class="blog-img" alt="">@else<span class="text-muted">-</span>@endif</td>
                        <td class="fw-semibold">{{ $blog->title }}</td>
                        <td>{{ $blog->category ?? '-' }}</td>
                        <td>{{ $blog->author }}</td>
                        <td><span class="badge bg-{{ $blog->status=='published' ? 'success' : 'secondary' }}">{{ $blog->status }}</span></td>
                        <td>
                            <a href="{{ route('admin.cms.blogs.edit', $blog) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.cms.blogs.destroy', $blog) }}" method="post" class="d-inline delete-form">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada artikel.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection