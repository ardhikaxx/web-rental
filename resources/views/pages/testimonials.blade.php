@extends('layouts.public')
@section('title', 'Testimoni Pelanggan')
@section('meta_description', 'Apa kata pelanggan tentang layanan kami.')

@section('content')
@include('components.page-header', ['title' => 'Testimoni Pelanggan'])
<div class="section">
    <div class="container">
        <div class="row g-4">
            @foreach ($testimonials as $t)
            <div class="col-md-6 col-lg-4">
                <div class="card card-rc h-100 p-4">
                    <div class="text-warning mb-2">@for($i=0;$i<$t->rating;$i++)<i class="fa-solid fa-star"></i>@endfor<span class="chip text-capitalize">{{ $t->service_type }}</span></div>
                    <p class="small text-muted">"{{ $t->content }}"</p>
                    <div class="d-flex align-items-center gap-2 mt-auto">
                        <img src="{{ $t->photo_url }}" width="44" height="44" class="rounded-circle object-fit-cover" alt="">
                        <div><div class="fw-bold small">{{ $t->customer_name }}</div><small class="text-muted">{{ $t->company }}</small></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection