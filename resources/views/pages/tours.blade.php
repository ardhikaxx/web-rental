@extends('layouts.public')
@section('title', 'Paket Wisata')
@section('meta_description', 'Kumpulan paket wisata seru: Ijen Blue Fire, Baluran, Bromo, Sukamade dan destinasi lainnya bersama RC Pengikut.')

@section('content')
@include('components.page-header', ['title' => 'Paket Wisata'])
<section class="section">
    <div class="container">
        <div class="row g-4">
            @forelse ($tours as $tour)
            <div class="col-md-6 col-lg-4">
                <div class="card card-rc h-100">
                    <div style="height:210px;overflow:hidden;position:relative">
                        <img src="{{ $tour->thumb }}" class="w-100 h-100 object-fit-cover" alt="{{ $tour->name }}">
                        <span class="position-absolute top-0 end-0 m-2 chip bg-white">{{ $tour->duration_days }}D{{ $tour->duration_nights }}N</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold">{{ $tour->name }}</h5>
                        <p class="small text-muted mb-2"><i class="fa-solid fa-location-dot me-1"></i>{{ $tour->destination }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <div><small class="text-muted">Mulai</small><div class="price-tag">@rupiah($tour->price_per_person)<small class="text-muted fw-normal">/org</small></div></div>
                            <a href="{{ route('tours.show', $tour) }}" class="btn btn-brand btn-sm">Lihat Paket</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">Belum ada paket wisata.</div>
            @endforelse
        </div>
        <div class="mt-4 d-flex justify-content-center">{{ $tours->links() }}</div>
    </div>
</section>
@endsection