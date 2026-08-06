@extends('layouts.public')
@section('title', 'Tentang Kami')
@section('meta_description', 'Kenali lebih dekat perusahaan rental mobil, tour & travel terpercaya kami.')

@section('content')
@include('components.page-header', ['title' => 'Tentang Kami'])
<div class="section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <img src="https://placehold.co/800x600?text=RC+Trans" class="img-fluid rounded-4" alt="Tentang Kami">
            </div>
            <div class="col-lg-6">
                <span class="chip d-inline-block mb-2">Tentang Kami</span>
                <h2 class="section-title mb-3">{{ $site['company_name'] ?? 'RC Trans' }}</h2>
                <p>{{ $site['description'] ?? '' }}</p>
                <p>Kami berkomitmen mengutamakan keamanan, kenyamanan dan profesionalisme. Dengan armada terawat, sopir berpengalaman dan tour leader kompeten, kami siap menemani setiap perjalanan Anda baik untuk kebutuhan bisnis maupun rekreasi.</p>
                <div class="row text-center mt-4 g-3">
                    <div class="col-3"><div class="fs-3 fw-bold text-brand">{{ $stats['year'] }}+</div><small class="text-muted">Tahun Melayani</small></div>
                    <div class="col-3"><div class="fs-3 fw-bold text-brand">{{ $stats['fleet'] }}+</div><small class="text-muted">Armada</small></div>
                    <div class="col-3"><div class="fs-3 fw-bold text-brand">{{ $stats['customer'] }}+</div><small class="text-muted">Pelanggan</small></div>
                    <div class="col-3"><div class="fs-3 fw-bold text-brand">{{ $stats['trip'] }}+</div><small class="text-muted">Perjalanan</small></div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-3">
            <div class="col-md-4"><div class="card card-rc h-100 p-4"><h5 class="fw-bold"><i class="fa-solid fa-bullseye text-brand me-2"></i>Visi</h5><p class="small text-muted mb-0">Menjadi penyedia jasa rental mobil dan transportasi terpercaya nomor satu di Jawa Timur.</p></div></div>
            <div class="col-md-4"><div class="card card-rc h-100 p-4"><h5 class="fw-bold"><i class="fa-solid fa-rocket text-brand me-2"></i>Misi</h5><ul class="small text-muted mb-0 ps-3"><li>Armada aman & terawat</li><li>Pelayanan responsif 24 jam</li><li>Prioritas keselamatan & kenyamanan</li></ul></div></div>
            <div class="col-md-4"><div class="card card-rc h-100 p-4"><h5 class="fw-bold"><i class="fa-solid fa-heart text-brand me-2"></i>Nilai Kami</h5><ul class="small text-muted mb-0 ps-3"><li>Integritas & kepercayaan</li><li>Profesionalisme</li><li>Kepuasan pelanggan</li></ul></div></div>
        </div>

        <div class="mt-5">
            <h3 class="section-title text-center">Apa Kata Mereka</h3>
            <div class="row g-4 mt-2">
                @foreach ($testimonials as $t)
                <div class="col-md-6 col-lg-3">
                    <div class="card card-rc h-100 p-3">
                        <div class="text-warning small mb-1">@for($i=0;$i<$t->rating;$i++)<i class="fa-solid fa-star"></i>@endfor</div>
                        <p class="small text-muted">{{ $t->content }}</p>
                        <div class="fw-bold small">{{ $t->customer_name }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection