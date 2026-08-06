@extends('layouts.public')
@section('title', 'Travel Antar Kota')
@section('meta_description', 'Layanan travel antar kota Bondowoso ke Surabaya, Malang, Bali, Jakarta dan kota lainnya.')

@section('content')
@include('components.page-header', ['title' => 'Travel Antar Kota'])
<section class="section">
    <div class="container">
        <div class="row g-4">
            @foreach ($travels as $travel)
            <div class="col-md-6 col-lg-4">
                <div class="card card-rc h-100 p-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="icon-circle bg-brand" style="width:48px;height:48px;font-size:1.1rem"><i class="fa-solid fa-truck"></i></div>
                        <div>
                            <div class="fw-bold">{{ $travel->route_origin }} <i class="fa-solid fa-arrow-right text-muted small"></i> {{ $travel->route_destination }}</div>
                            <small class="text-muted">{{ $travel->travel_time_hours }} jam · Berangkat {{ $travel->departure_time }}</small>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <div><small class="text-muted">Harga</small><div class="price-tag">@rupiah($travel->price)</div></div>
                        <span class="chip"><i class="fa-solid fa-users me-1"></i>{{ $travel->quota }} seat</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="card card-rc p-4 mt-5">
            <h5 class="fw-bold"><i class="fa-solid fa-location-dot me-2 text-brand"></i>Titik Penjemputan</h5>
            <div class="row g-3">
                @foreach (explode("\n", optional($travels->first())->pickup_points ?? 'Terminal Bondowoso\nKantor RC Trans') as $p) @if(trim($p))<div class="col-md-4 small"><i class="fa-solid fa-circle-check text-brand me-1"></i>{{ $p }}</div>@endif @endforeach
            </div>
        </div>
    </div>
</section>
@endsection