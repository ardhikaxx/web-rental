@extends('layouts.public')
@section('title', 'Sewa Mobil, Rental Tour & Travel Terpercaya')
@section('meta_description', $site['description'] ?? '')

@section('hero')
<section class="hero">
    <div class="container position-relative py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="chip text-white mb-3" style="background:rgba(0,245,212,.15);color:#00f5d4"><i class="fa-solid fa-star me-1"></i> Rental & Transportasi Terpercaya #1 di Bondowoso</span>
                <h1>{{ $banners->first()->subtitle ?? 'Armada Premium Untuk Perjalanan Anda' }}</h1>
                <h1 class="text-brand" style="color:#00f5d4!important">{{ $banners[0]->title ?? '' }}</h1>
                <p class="lead">{{ $banners->first()->subtitle ?? 'Pilih armada terbaik untuk keluarga, bisnis & wisata ke seluruh Jawa Timur dan Bali.' }}</p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="{{ route('booking') }}" class="btn btn-brand"><i class="fa-solid fa-car-side me-2"></i>Booking Sekarang</a>
                    <a href="https://wa.me/{{ $site['whatsapp'] ?? '' }}" target="_blank" class="btn btn-wa"><i class="fa-brands fa-whatsapp me-2"></i>Chat WhatsApp</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="row g-3">
                    @foreach ([
                        ['label' => 'Armada Siap Pakai', 'value' => $stats['fleet'], 'icon' => 'fa-car-side'],
                        ['label' => 'Pelanggan Setia', 'value' => $stats['customer'], 'icon' => 'fa-users'],
                        ['label' => 'Perjalanan Selesai', 'value' => $stats['trip'], 'icon' => 'fa-route'],
                        ['label' => 'Destinasi Wisata', 'value' => $stats['destination'], 'icon' => 'fa-map-location-dot'],
                    ] as $s)
                    <div class="col-6">
                        <div class="stat-card p-3 h-100">
                            <i class="fa-solid {{ $s['icon'] }}" style="color:#00f5d4"></i>
                            <div class="fs-3 fw-bold">{{ $s['value'] }}+</div>
                            <div class="small">{{ $s['label'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')

<section class="section" id="layanan">
    <div class="container">
        <div class="text-center mb-5">
            <span class="chip d-inline-block">Layanan Kami</span>
            <h2 class="section-title mt-3">Solusi Transportasi Lengkap</h2>
            <p class="text-muted">Satu pintu untuk semua kebutuhan perjalanan Anda.</p>
        </div>
        <div class="row g-4">
            @foreach ($services as $service)
            <div class="col-md-6 col-lg-4">
                <div class="card card-rc h-100 p-4">
                    <div class="icon-circle bg-brand mb-3"><i class="fa-solid {{ $service->icon ?: 'fa-car' }}"></i></div>
                    <h5 class="fw-bold">{{ $service->name }}</h5>
                    <p class="text-muted small mb-3">{{ $service->description }}</p>
                    <a href="{{ route('services.show', $service) }}" class="text-brand small fw-semibold text-decoration-none">Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section" style="background:#f6f8ff" id="armada">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
            <div>
                <span class="chip d-inline-block">Armada Kami</span>
                <h2 class="section-title mt-3">Pilih Armada Terbaik</h2>
            </div>
            <a href="{{ route('fleet.index') }}" class="btn btn-outline-primary rounded-pill">Lihat Semua</a>
        </div>
        <div class="row g-4">
            @foreach ($fleets as $fleet)
            <div class="col-md-6 col-lg-4">
                <div class="card card-rc h-100">
                    <div style="height:210px;overflow:hidden"><img src="{{ $fleet->main_image }}" class="w-100 h-100 object-fit-cover" alt="{{ $fleet->display_name }}"></div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">{{ $fleet->display_name }}</h5>
                            <span class="chip">{{ $fleet->category?->name }}</span>
                        </div>
                        <div class="d-flex gap-3 small text-muted my-3">
                            <span><i class="fa-solid fa-user me-1"></i>{{ $fleet->capacity }}</span>
                            <span><i class="fa-solid fa-gear me-1"></i>{{ $fleet->transmission }}</span>
                            <span><i class="fa-solid fa-gas-pump me-1"></i>{{ $fleet->fuel }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div><small class="text-muted">Mulai</small><div class="price-tag fs-5">@rupiah($fleet->daily_price)<small class="text-muted fw-normal">/hari</small></div></div>
                            <a href="{{ route('fleet.show', $fleet) }}" class="btn btn-brand btn-sm">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section" id="wisata">
    <div class="container">
        <div class="text-center mb-5">
            <span class="chip d-inline-block">Paket Wisata</span>
            <h2 class="section-title mt-3">Destinasi & Paket Seru</h2>
            <p class="text-muted">Trip wisata Ijen, Baluran, Bromo dan lainnya dengan tour leader profesional.</p>
        </div>
        <div class="row g-4">
            @foreach ($tours as $tour)
            <div class="col-md-6 col-lg-4">
                <div class="card card-rc h-100">
                    <div style="height:200px;overflow:hidden"><img src="{{ $tour->thumb }}" class="w-100 h-100 object-fit-cover" alt="{{ $tour->name }}"></div>
                    <div class="card-body">
                        <h5 class="fw-bold">{{ $tour->name }}</h5>
                        <p class="small text-muted"><i class="fa-solid fa-location-dot me-1"></i>{{ $tour->destination }} · {{ $tour->duration_days }}D{{ $tour->duration_nights }}N</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div><small>Mulai</small><div class="price-tag">@rupiah($tour->price_per_person)<small class="text-muted fw-normal">/org</small></div></div>
                            <a href="{{ route('tours.show', $tour) }}" class="btn btn-brand btn-sm">Lihat</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4"><a href="{{ route('tours.index') }}" class="btn btn-outline-primary rounded-pill">Semua Paket Wisata</a></div>
    </div>
</section>

<section class="section" style="background:#f6f8ff" id="travel">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
            <div>
                <span class="chip d-inline-block">Travel Antar Kota</span>
                <h2 class="section-title mt-3">Rute Akhir Pekan & Bisnis</h2>
            </div>
            <a href="{{ route('travel') }}" class="btn btn-outline-brand rounded-pill">Semua Rute</a>
        </div>
        <div class="row g-3">
            @foreach ($travels as $travel)
            <div class="col-md-6 col-lg-3">
                <div class="card card-rc h-100 p-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa-solid fa-location-dot text-brand"></i><span class="fw-bold">{{ $travel->route_origin }}</span>
                        <i class="fa-solid fa-arrow-right text-muted small"></i>
                        <span class="fw-bold">{{ $travel->route_destination }}</span>
                    </div>
                    <div class="small text-muted"><i class="fa-solid fa-clock me-1"></i>{{ $travel->travel_time_hours }} jam · Berangkat {{ $travel->departure_time }}</div>
                    <div class="price-tag mt-2">@rupiah($travel->price)<small class="text-muted fw-normal">/seat</small></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section" id="testimoni">
    <div class="container">
        <div class="text-center mb-5">
            <span class="chip d-inline-block">Testimoni</span>
            <h2 class="section-title mt-3">Apa Kata Pelanggan</h2>
        </div>
        <div class="row g-4">
            @foreach ($testimonials as $t)
            <div class="col-md-6 col-lg-4">
                <div class="card card-rc h-100 p-4">
                    <div class="text-warning mb-2">@for($i=0;$i<$t->rating;$i++)<i class="fa-solid fa-star"></i>@endfor</div>
                    <p class="small text-muted">{{ $t->content }}</p>
                    <div class="d-flex align-items-center gap-2 mt-2">
                        <img src="{{ $t->photo_url }}" width="40" height="40" class="rounded-circle object-fit-cover" alt="">
                        <div><div class="fw-bold small">{{ $t->customer_name }}</div><small class="text-muted">{{ $t->company ?? $t->service_type }}</small></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section" style="background:#f6f8ff" id="blog">
    <div class="container">
        <div class="text-center mb-5">
            <span class="chip d-inline-block">Artikel</span>
            <h2 class="section-title mt-3">Tips & Berita Terkini</h2>
        </div>
        <div class="row g-4">
            @foreach ($blogs as $blog)
            <div class="col-md-6 col-lg-4">
                <div class="card card-rc h-100">
                    <div style="height:180px;overflow:hidden"><img src="{{ $blog->image }}" class="w-100 h-100 object-fit-cover" alt="{{ $blog->title }}"></div>
                    <div class="card-body">
                        <span class="chip mb-2 d-inline-block">{{ $blog->category }}</span>
                        <h5 class="fw-bold">{{ \Illuminate\Support\Str::limit($blog->title, 60) }}</h5>
                        <p class="small text-muted">{{ \Carbon\Carbon::parse($blog->published_at)->translatedFormat('d F Y') }}</p>
                        <a href="{{ route('blog.show', $blog) }}" class="text-brand small fw-semibold">Baca <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="card card-rc p-5 text-center" style="background:linear-gradient(120deg,#0b1224,#1750ae);color:#fff;border:none">
            <h2 class="fw-bold">Siap Berpergian Hari Ini?</h2>
            <p>Booking armada atau paket wisata Anda sekarang, tim kami siap standby 24 jam.</p>
            <div class="d-flex justify-content-center gap-3 mt-3">
                <a href="{{ route('booking') }}" class="btn btn-brand">Booking Sekarang</a>
                <a href="https://wa.me/{{ $site['whatsapp'] ?? '' }}" target="_blank" class="btn btn-wa"><i class="fa-brands fa-whatsapp me-2"></i>WhatsApp</a>
            </div>
        </div>
    </div>
</section>
@endsection