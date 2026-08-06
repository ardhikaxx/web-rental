@extends('layouts.public')
@section('title', $service->name)
@section('meta_description', $service->meta_description ?? $service->description)

@section('content')
@include('components.page-header', ['title' => $service->name])
<div class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="card card-rc p-4 h-100">
                    <h4 class="fw-bold"><i class="fa-solid {{ $service->icon ?: 'fa-car' }} text-brand me-2"></i>{{ $service->name }}</h4>
                    <p class="text-muted">{{ $service->description }}</p>
                    <div>{!! $service->content ?? '' !!}</div>
                    <a href="{{ route('booking') }}" class="btn btn-brand mt-3 align-self-start"><i class="fa-solid fa-car-side me-2"></i>Booking Sekarang</a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-rc p-4 mb-4">
                    <h6 class="fw-bold">Layanan Lainnya</h6>
                    <div class="list-group list-group-flush">
                        @foreach (\App\Models\Service::where('is_active', true)->where('id', '!=', $service->id)->get() as $s)
                        <a href="{{ route('services.show', $s) }}" class="list-group-item text-decoration-none small">{{ $s->name }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="card card-rc p-4">
                    <h6 class="fw-bold">Butuh Bantuan?</h6>
                    <p class="small text-muted">Hubungi tim kami melalui WhatsApp untuk pertanyaan cepat.</p>
                    <a href="https://wa.me/{{ $site['whatsapp'] ?? '' }}" target="_blank" class="btn btn-wa btn-sm w-100"><i class="fa-brands fa-whatsapp me-2"></i>Chat</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection