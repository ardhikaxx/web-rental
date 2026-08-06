@extends('layouts.public')
@section('title', $tour->name)
@section('meta_description', $tour->meta_description ?? $tour->description)

@section('content')
@include('components.page-header', ['title' => $tour->name, 'parent' => ['label' => 'Paket Wisata', 'href' => route('tours.index')]])
<div class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="card card-rc overflow-hidden">
                    <img src="{{ $tour->thumb }}" class="w-100" style="height:400px;object-fit:cover" alt="{{ $tour->name }}">
                </div>
                <div class="card card-rc p-4 mt-4">
                    <h5 class="fw-bold">Deskripsi</h5>
                    <p class="text-muted">{!! nl2br(e($tour->description)) !!}</p>
                </div>
                @if($tour->itinerary)
                <div class="card card-rc p-4 mt-3">
                    <h5 class="fw-bold"><i class="fa-solid fa-route me-2 text-brand"></i>Itinerary</h5>
                    <div class="small">{!! nl2br(e($tour->itinerary)) !!}</div>
                </div>
                @endif
                @if($tour->facilities)
                <div class="card card-rc p-4 mt-3">
                    <h5 class="fw-bold"><i class="fa-solid fa-check me-2 text-brand"></i>Fasilitas</h5>
                    <ul class="list-check row g-2">
                        @foreach (explode("\n", $tour->facilities) as $f) @if(trim($f))<li class="col-md-6 small">{{ $f }}</li>@endif @endforeach
                    </ul>
                </div>
                @endif
                @if($tour->terms)
                <div class="card card-rc p-4 mt-3">
                    <h5 class="fw-bold"><i class="fa-solid fa-file-contract me-2 text-brand"></i>Syarat & Ketentuan</h5>
                    <div class="small text-muted">{!! nl2br(e($tour->terms)) !!}</div>
                </div>
                @endif
            </div>
            <div class="col-lg-5">
                <div class="card card-rc p-4 sticky-top" style="top:80px">
                    <h5 class="fw-bold">{{ $tour->name }}</h5>
                    <div class="chip mb-3"><i class="fa-solid fa-calendar me-1"></i>{{ $tour->duration_days }} Hari / {{ $tour->duration_nights }} Malam</div>
                    <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted">Per Orang</span><span class="fw-bold price-tag">@rupiah($tour->price_per_person)</span></div>
                    <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted">Paket Group (min 4)</span><span class="fw-bold">@rupiah($tour->price_per_group)</span></div>
                    <div class="d-flex justify-content-between py-2"><span class="text-muted">Kapasitas Max</span><span class="fw-bold">{{ $tour->max_group }} orang</span></div>

                    <div class="mt-3">
                        <h6 class="fw-bold">Jadwal Keberangkatan</h6>
                        @forelse ($schedules as $sc)
                        <div class="d-flex justify-content-between align-items-center border rounded-3 p-2 mb-2 small">
                            <div><i class="fa-solid fa-calendar-day me-1 text-brand"></i>{{ \Carbon\Carbon::parse($sc->departure_date)->translatedFormat('d M Y') }}</div>
                            <span class="chip">Sisa {{ $sc->remaining_quota }} kursi</span>
                        </div>
                        @empty
                        <p class="small text-muted">Jadwal segera hadir.</p>
                        @endforelse
                    </div>

                    <a href="https://wa.me/{{ $site['whatsapp'] ?? '' }}?text={{ urlencode('Halo, saya mau booking paket '.$tour->name) }}" target="_blank" class="btn btn-wa w-100 mt-3"><i class="fa-brands fa-whatsapp me-2"></i>Booking via WhatsApp</a>
                    <a href="{{ route('booking') }}" class="btn btn-brand w-100 mt-2"><i class="fa-solid fa-car-side me-2"></i>Booking Online</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection