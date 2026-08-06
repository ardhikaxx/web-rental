<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('meta')
    <title>@yield('title', $site['company_name'] ?? 'RC Trans') - {{ $site['company_name'] ?? 'RC Trans' }}</title>
    <meta name="description" content="@yield('meta_description', $site['description'] ?? '')">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $site['company_name'] ?? 'RC Trans' }}">
    <meta property="og:title" content="@yield('title', $site['company_name'] ?? 'RC Trans')">
    <meta property="og:description" content="@yield('meta_description', $site['description'] ?? '')">
    <meta property="og:image" content="@yield('og_image', url('/img/og-default.jpg'))">
    <meta name="theme-color" content="#4361ee">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.css">
    @yield('head')
    <style>
        :root{--brand:#4361ee;--brand-dark:#3a2f83;--brand-2:#00f5d4;--ink:#0b1b33;}
        body{font-family:'Plus Jakarta Sans',sans-serif;color:#334;background:#fff;}
        .text-brand{color:var(--brand)!important}
        .bg-brand{background:var(--brand)!important}
        .btn-brand{background:var(--brand);color:#fff;border:none;border-radius:12px;padding:.7rem 1.4rem;font-weight:600}
        .btn-brand:hover{background:var(--brand-dark);color:#fff}
        .btn-wa{background:#25d366;color:#fff;border-radius:12px;padding:.7rem 1.4rem;font-weight:600}
        .btn-wa:hover{background:#1eb65c;color:#fff}
        .navbar-rc{background:rgba(255,255,255,.92);backdrop-filter:blur(10px)}
        .navbar-rc .nav-link{color:var(--ink);font-weight:600}
        .navbar-rc .nav-link:hover{color:var(--brand)}
        .hero{background:linear-gradient(135deg,#0f0544 0%,#17559e 60%,#00a8cc 100%);color:#fff;position:relative;overflow:hidden}
        .hero h1{font-weight:800;font-size:clamp(2rem,5vw,3.4rem)}
        .hero::after{content:"";position:absolute;inset:0;background:radial-gradient(circle at 80% 20%,rgba(0,246,212,.18),transparent 40%)}
        .stat-card{background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:16px;backdrop-filter:blur(6px)}
        .section{padding:4.5rem 0}
        .section-title{font-weight:800;font-size:clamp(1.5rem,3.5vw,2.4rem);color:var(--ink)}
        .card-rc{border:none;border-radius:18px;box-shadow:0 6px 30px rgba(16,42,84,.08);transition:.25s}
        .card-rc:hover{transform:translateY(-6px);box-shadow:0 14px 40px rgba(16,42,84,.16)}
        .icon-circle{width:60px;height:60px;border-radius:16px;display:grid;place-items:center;font-size:1.5rem;color:#fff}
        .price-tag{color:var(--brand);font-weight:700}
        .chip{background:#eef2ff;color:var(--brand);border-radius:999px;padding:.25rem .7rem;font-size:.8rem;font-weight:600}
        .footer-rc{background:var(--ink);color:#cfd8e3}
        .footer-rc a{color:#cfd8e3;text-decoration:none}
        .footer-rc a:hover{color:#fff}
        .badge-status{font-size:.72rem;padding:.35em .7em}
        .page-header{background:linear-gradient(120deg,#0b1224,#1750ae);color:#fff}
        .feature-icon{width:44px;height:44px;border-radius:12px;background:#eef2ff;color:var(--brand);display:grid;place-items:center}
        .form-control,.form-select{border-radius:12px}
        .list-check li{list-style:none;padding:.35rem 0}
        .list-check li::before{content:"\f00c";font-family:"Font Awesome 6 Free";font-weight:900;color:#00c853;margin-right:.5rem}
        small.text-small{font-size:.8rem}
        ::selection{background:var(--brand);color:#fff}
    </style>
    @stack('styles')
</head>
<body>

@php
    $current = request()->url();
@endphp
<nav class="navbar navbar-expand-lg navbar-rc sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="fa-solid fa-car-side text-brand me-1"></i> {{ $site['company_short'] ?? 'RC Trans' }}
        </a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMain"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('services') }}">Layanan</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('fleet.index') }}">Armada</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('tours.index') }}">Paket Wisata</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('travel') }}">Travel</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('wedding') }}">Wedding Car</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Lainnya</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('about') }}">Tentang Kami</a></li>
                        <li><a class="dropdown-item" href="{{ route('gallery') }}">Galeri</a></li>
                        <li><a class="dropdown-item" href="{{ route('blog.index') }}">Blog</a></li>
                        <li><a class="dropdown-item" href="{{ route('faq') }}">FAQ</a></li>
                        <li><a class="dropdown-item" href="{{ route('tracking') }}">Tracking Booking</a></li>
                        <li><a class="dropdown-item" href="{{ route('contact') }}">Kontak</a></li>
                    </ul>
                </li>
            </ul>
            <div class="d-flex gap-2 align-items-center">
                @auth
                    @if (auth()->user()->hasAnyRole(['super_admin','owner','admin_operasional','customer_service','driver','tour_leader','keuangan','marketing']))
                        <a class="btn btn-brand btn-sm" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge-high me-1"></i>Dashboard</a>
                    @else
                        <a class="btn btn-brand btn-sm" href="{{ route('customer.dashboard') }}"><i class="fa-solid fa-user me-1"></i>Portal</a>
                    @endif
                @else
                    <a class="btn btn-outline-dark btn-sm" href="{{ route('login') }}">Masuk</a>
                @endauth
                <a class="btn btn-wa btn-sm" href="https://wa.me/{{ $site['whatsapp'] ?? '' }}" target="_blank"><i class="fa-brands fa-whatsapp me-1"></i>WhatsApp</a>
            </div>
        </div>
    </div>
</nav>

@include('components.flash')

@yield('hero')
@yield('content')

<footer class="footer-rc pt-5 pb-4 mt-auto">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5 class="text-white fw-bold"><i class="fa-solid fa-car-side text-brand me-1"></i> {{ $site['company_name'] ?? 'RC Trans' }}</h5>
                <p class="mt-2">{{ $site['description'] ?? '' }}</p>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="text-white fw-bold mb-3">Layanan</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('services') }}">Rental Mobil</a></li>
                    <li class="mb-2"><a href="{{ route('tours.index') }}">Paket Wisata</a></li>
                    <li class="mb-2"><a href="{{ route('travel') }}">Travel Antar Kota</a></li>
                    <li class="mb-2"><a href="{{ route('wedding') }}">Wedding Car</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="text-white fw-bold mb-3">Perusahaan</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('about') }}">Tentang Kami</a></li>
                    <li class="mb-2"><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li class="mb-2"><a href="{{ route('faq') }}">FAQ</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}">Kontak</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h6 class="text-white fw-bold mb-3">Hubungi Kami</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><i class="fa-solid fa-location-dot me-2"></i>{{ $site['address'] ?? '' }}</li>
                    <li class="mb-2"><i class="fa-solid fa-phone me-2"></i>{{ $site['phone'] ?? '' }}</li>
                    <li class="mb-2"><i class="fa-solid fa-envelope me-2"></i>{{ $site['email'] ?? '' }}</li>
                </ul>
                <div class="d-flex gap-2 mt-3">
                    @if(!empty($site['facebook']))<a class="text-white" href="{{ $site['facebook'] }}"><i class="fa-brands fa-facebook fa-lg"></i></a>@endif
                    @if(!empty($site['instagram']))<a class="text-white" href="{{ $site['instagram'] }}"><i class="fa-brands fa-instagram fa-lg"></i></a>@endif
                    @if(!empty($site['tiktok']))<a class="text-white" href="{{ $site['tiktok'] }}"><i class="fa-brands fa-tiktok fa-lg"></i></a>@endif
                    @if(!empty($site['youtube']))<a class="text-white" href="{{ $site['youtube'] }}"><i class="fa-brands fa-youtube fa-lg"></i></a>@endif
                </div>
            </div>
        </div>
        <div class="border-top border-secondary-subtle pt-3 mt-4 small text-center">
            &copy; {{ now()->year }} {{ $site['company_name'] ?? 'RC Trans' }}. All rights reserved.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.umd.js"></script>
@stack('scripts')
</body>
</html>