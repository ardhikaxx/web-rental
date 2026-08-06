@extends('layouts.admin')
@section('title', 'CMS & Konten Website')

@section('content')
<div class="row g-3">
    @php
        $cards = [
            ['route' => 'admin.cms.banners', 'icon' => 'fa-image', 'label' => 'Banners', 'key' => 'banners', 'color' => '#4361ee'],
            ['route' => 'admin.cms.services', 'icon' => 'fa-layer-group', 'label' => 'Layanan', 'key' => 'services', 'color' => '#f72585'],
            ['route' => 'admin.cms.blogs', 'icon' => 'fa-newspaper', 'label' => 'Artikel Blog', 'key' => 'blogs', 'color' => '#06d6a0'],
            ['route' => 'admin.cms.faqs', 'icon' => 'fa-circle-question', 'label' => 'FAQ', 'key' => 'faqs', 'color' => '#fb8500'],
            ['route' => 'admin.cms.testimonials', 'icon' => 'fa-comment', 'label' => 'Testimoni', 'key' => 'testimonials', 'color' => '#7209b7'],
            ['route' => 'admin.cms.galleries', 'icon' => 'fa-images', 'label' => 'Galeri', 'key' => 'galleries', 'color' => '#118ab2'],
        ];
    @endphp
    @foreach ($cards as $c)
    <div class="col-md-4 col-lg-4 col-xl-4">
        <a href="{{ route($c['route']) }}" class="text-decoration-none">
            <div class="card card-grid text-center">
                <div class="card-body py-4">
                    <div class="stat-icon mx-auto mb-3 d-flex align-items-center justify-content-center" style="background:{{ $c['color'] }}1a;color:{{ $c['color'] }}">
                        <i class="fa-solid {{ $c['icon'] }}"></i>
                    </div>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($counts[$c['key']], 0, ',', '.') }}</h3>
                    <div class="text-muted">{{ $c['label'] }}</div>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
@endsection