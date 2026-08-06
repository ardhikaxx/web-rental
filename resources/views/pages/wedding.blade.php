@extends('layouts.public')
@section('title', 'Wedding Car')
@section('meta_description', 'Rental mobil pengantin dengan dekorasi cantik, sopir profesional dan dokumentasi untuk hari bahagia Anda.')

@section('content')
@include('components.page-header', ['title' => 'Wedding Car'])
<section class="section">
    <div class="container">
        <div class="row g-4">
            @foreach ($weddings as $w)
            <div class="col-md-6 col-lg-4">
                <div class="card card-rc h-100">
                    <div style="height:220px;overflow:hidden"><img src="{{ $w->thumb }}" class="w-100 h-100 object-fit-cover" alt="{{ $w->name }}"></div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold"><i class="fa-solid fa-heart text-danger me-1"></i>{{ $w->name }}</h5>
                        <p class="small text-muted"><i class="fa-solid fa-location-dot me-1"></i>{{ $w->area }} · {{ $w->duration_hours }} jam</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <div class="price-tag">@rupiah($w->total_price)<small class="text-muted fw-normal">/paket</small></div>
                            <a href="https://wa.me/{{ $site['whatsapp'] ?? '' }}?text={{ urlencode('Halo, saya mau booking '.$w->name) }}" target="_blank" class="btn btn-wa btn-sm"><i class="fa-brands fa-whatsapp me-1"></i>Booking</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if($weddings->count())
        <div class="card card-rc p-4 mt-5">
            <h5 class="fw-bold mb-2"><i class="fa-solid fa-gift me-2 text-brand"></i>Paket Dekorasi Termasuk</h5>
            <div class="small">{!! nl2br(e($weddings->first()->decoration_details)) !!}</div>
        </div>
        @endif
    </div>
</section>
@endsection