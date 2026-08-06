@extends('layouts.public')
@section('title', 'Layanan Kami')
@section('meta_description', 'Layanan rental mobil, paket wisata, travel antar kota, wedding car dan antar jemput bandara.')

@section('content')
@include('components.page-header', ['title' => 'Layanan Kami'])
<section class="section">
    <div class="container">
        <div class="row g-4">
            @foreach ($services as $service)
            <div class="col-md-6 col-lg-4">
                <div class="card card-rc h-100 p-4">
                    <div class="icon-circle bg-brand mb-3"><i class="fa-solid {{ $service->icon ?: 'fa-car' }}"></i></div>
                    <h5 class="fw-bold">{{ $service->name }}</h5>
                    <p class="text-muted small">{{ $service->description }}</p>
                    <a href="{{ route('services.show', $service) }}" class="mt-auto text-brand fw-semibold text-decoration-none small">Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <span class="chip d-inline-block">Bandingkan Paket</span>
            <h3 class="section-title mt-3">Cara Booking Mudah</h3>
            <div class="row g-4 mt-2">
                @foreach ([
                    ['icon'=>'fa-1','title'=>'Pilih Armada','desc'=>'Tentukan kendaraan sesuai kebutuhan'],
                    ['icon'=>'fa-2','title'=>'Isi Tanggal','desc'=>'Tentukan tanggal sewa & kembali'],
                    ['icon'=>'fa-3','title'=>'Bayar DP','desc'=>'Transfer DP minimal 50% untuk konfirmasi'],
                    ['icon'=>'fa-4','title'=>'Siap Berangkat','desc'=>'Tanpa dijemput, nikmati perjalanan'],
                ] as $i => $step)
                <div class="col-md-3"><div class="card card-rc h-100 p-3"><div class="icon-circle bg-brand mx-auto mb-2"><i class="fa-solid {{ $step['icon'] }}"></i></div><h6 class="fw-bold">{{ $step['title'] }}</h6><small class="text-muted">{{ $step['desc'] }}</small></div></div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection