@extends('layouts.public')
@section('title', $blog->title)
@section('meta_description', $blog->meta_description ?? $blog->excerpt)

@section('content')
@include('components.page-header', ['title' => $blog->category])
<div class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <article class="card card-rc p-4">
                    <h1 class="fw-bold fs-3">{{ $blog->title }}</h1>
                    <div class="small text-muted mb-3"><i class="fa-solid fa-user me-1"></i>{{ $blog->author }} · <i class="fa-solid fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($blog->published_at)->translatedFormat('d F Y') }}</div>
                    <img src="{{ $blog->image }}" class="img-fluid rounded-4 mb-4" alt="{{ $blog->title }}">
                    <div class="content-article">{!! $blog->content !!}</div>
                </article>
            </div>
            <div class="col-lg-4">
                <div class="card card-rc p-4 mb-4">
                    <h6 class="fw-bold">Artikel Lainnya</h6>
                    @foreach ($related as $r)
                    <a class="text-decoration-none text-dark d-block py-2 border-bottom" href="{{ route('blog.show', $r) }}">
                        <div class="fw-semibold small">{{ \Illuminate\Support\Str::limit($r->title, 50) }}</div>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($r->published_at)->translatedFormat('d M Y') }}</small>
                    </a>
                    @endforeach
                </div>
                <div class="card card-rc p-4">
                    <h6 class="fw-bold">Butuh Armada?</h6>
                    <a href="{{ route('booking') }}" class="btn btn-brand w-100">Booking</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection