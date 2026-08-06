@extends('layouts.public')
@section('title', 'Blog & Artikel')
@section('meta_description', 'Tips perjalanan, info armada dan berita terbaru dari kami.')

@section('content')
@include('components.page-header', ['title' => 'Blog & Artikel'])
<div class="section">
    <div class="container">
        <div class="row g-4">
            @forelse ($blogs as $blog)
            <div class="col-md-6 col-lg-4">
                <div class="card card-rc h-100">
                    <div style="height:200px;overflow:hidden"><img src="{{ $blog->image }}" class="w-100 h-100 object-fit-cover" alt="{{ $blog->title }}"></div>
                    <div class="card-body d-flex flex-column">
                        <span class="chip mb-2 align-self-start">{{ $blog->category }}</span>
                        <h5 class="fw-bold">{{ $blog->title }}</h5>
                        <p class="small text-muted">{{ \Carbon\Carbon::parse($blog->published_at)->translatedFormat('d F Y') }} · {{ $blog->author }}</p>
                        <a href="{{ route('blog.show', $blog) }}" class="mt-auto text-brand fw-semibold small text-decoration-none">Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 py-5 text-center text-muted">Belum ada artikel.</div>
            @endforelse
        </div>
        <div class="mt-4 d-flex justify-content-center">{{ $blogs->links() }}</div>
    </div>
</div>
@endsection