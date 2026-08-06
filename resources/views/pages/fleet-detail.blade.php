@extends('layouts.public')
@section('title', $fleet->display_name)
@section('meta_description', 'Sewa ' . $fleet->display_name .' ' . $fleet->year . '. Nyaman, aman dan terawat.')

@section('content')
@include('components.page-header', ['title' => $fleet->display_name, 'parent' => ['label' => 'Armada', 'href' => route('fleet.index')]])
<div class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="card card-rc overflow-hidden">
                    <img src="{{ $fleet->main_image }}" class="w-100" style="height:380px;object-fit:cover" alt="{{ $fleet->display_name }}">
                </div>
                @if($fleet->photos->count())
                <div class="row g-2 mt-2">
                    @foreach ($fleet->photos as $photo)
                    <div class="col-3"><img src="{{ $photo->url }}" class="rounded-3 w-100" style="height:90px;object-fit:cover" alt=""></div>
                    @endforeach
                </div>
                @endif
                <div class="card card-rc p-4 mt-4">
                    <h5 class="fw-bold mb-3">Fasilitas</h5>
                    <ul class="list-check row g-2">
                        @foreach (explode("\n", $fleet->facilities ?? '') as $f)
                            @if(trim($f))<li class="col-md-6">{{ $f }}</li>@endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card card-rc p-4 sticky-top" style="top:80px">
                    <h5 class="fw-bold">{{ $fleet->display_name }}</h5>
                    <div class="d-flex gap-3 small text-muted mb-3 flex-wrap">
                        <span><i class="fa-solid fa-user me-1"></i>{{ $fleet->capacity }} Kursi</span>
                        <span><i class="fa-solid fa-gear me-1"></i>{{ $fleet->transmission }}</span>
                        <span><i class="fa-solid fa-gas-pump me-1"></i>{{ $fleet->fuel }}</span>
                        <span><i class="fa-solid fa-calendar me-1"></i>{{ $fleet->year }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="chip"><i class="fa-solid fa-circle me-1"></i>{{ $fleet->status == 'tersedia' ? 'Tersedia' : ucfirst($fleet->status) }}</span>
                    </div>
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between py-1"><span class="text-muted small">Harga Harian</span><span class="fw-bold">@rupiah($fleet->daily_price)</span></div>
                        <div class="d-flex justify-content-between py-1"><span class="text-muted small">Harga Mingguan</span><span class="fw-bold">@rupiah($fleet->weekly_price)</span></div>
                        <div class="d-flex justify-content-between py-1"><span class="text-muted small">Harga Bulanan</span><span class="fw-bold">@rupiah($fleet->monthly_price)</span></div>
                        <div class="d-flex justify-content-between py-1"><span class="text-muted small">Dengan Sopir</span><span class="fw-bold">@rupiah($fleet->price_with_driver)</span></div>
                        <div class="d-flex justify-content-between py-1 border-bottom pb-2"><span class="text-muted small">Lepas Kunci</span><span class="fw-bold">@rupiah($fleet->price_without_driver)</span></div>
                    </div>
                    <a href="{{ route('booking', ['fleet' => $fleet->id]) }}" class="btn btn-brand w-100 mt-3"><i class="fa-solid fa-car-side me-2"></i>Booking Sekarang</a>
                    <a href="https://wa.me/{{ $site['whatsapp'] ?? '' }}?text={{ urlencode('Halo, saya mau tanya harga '.$fleet->display_name) }}" target="_blank" class="btn btn-wa w-100 mt-2"><i class="fa-brands fa-whatsapp me-2"></i>Ask WhatsApp</a>
                    <p class="small text-muted mt-3 mb-0"><i class="fa-solid fa-location-dot me-1"></i>{{ $fleet->location }} · <i class="fa-solid fa-circle-info me-1"></i>{{ $fleet->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection