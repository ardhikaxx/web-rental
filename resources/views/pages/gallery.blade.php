@extends('layouts.public')
@section('title', 'Galeri')
@section('meta_description', 'Galeri foto armada, wisata dan momen perjalanan pelanggan.')

@section('content')
@include('components.page-header', ['title' => 'Galeri'])
<div class="section">
    <div class="container">
        <div class="row g-3">
            @forelse ($galleries as $g)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ $g->image_url }}" data-fancybox="gallery" data-caption="{{ $g->title }}">
                    <img src="{{ $g->image_url }}" class="rounded-3 w-100" style="height:180px;object-fit:cover" alt="{{ $g->title }}">
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">Belum ada galeri.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>Fancybox.bind('[data-fancybox="gallery"]', {});</script>
@endsection