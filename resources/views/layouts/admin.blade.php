<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - {{ $site['company_name'] ?? 'RC Trans' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <style>
        :root { --brand:#4d5bf9; --side:#0f1226; --side-hover:#171c3a; --side-active:rgba(77,91,249,.16); --side-text:#9aa3bf; --side-line:#23294a; }
        body { font-family:'Segoe UI',system-ui; background:#f2f5fb; }
        .sidebar{position:fixed;top:0;left:0;bottom:0;width:252px;background:var(--side);color:#cdd5e8;overflow-y:auto;transition:transform .3s ease;z-index:1040;scrollbar-width:thin;scrollbar-color:#2a2f4e transparent}
        .sidebar::-webkit-scrollbar{width:6px}.sidebar::-webkit-scrollbar-thumb{background:#2a2f4e;border-radius:4px}
        .sidebar .brand{display:flex;align-items:center;gap:12px;padding:20px 20px 18px;border-bottom:1px solid var(--side-line);font-weight:700;color:#fff;font-size:1.02rem;letter-spacing:.2px}
        .sidebar .brand .logo{width:38px;height:38px;border-radius:11px;display:grid;place-items:center;flex-shrink:0;background:linear-gradient(135deg,#4d63f9,#7a5cf5);color:#fff;font-size:1.05rem;box-shadow:0 4px 12px rgba(77,91,249,.4)}
        .sidebar .group{display:flex;align-items:center;gap:6px;padding:18px 20px 7px;font-size:.66rem;text-transform:uppercase;letter-spacing:1.4px;color:#58617f;font-weight:600}
        .sidebar .group::before{content:'';width:7px;height:7px;border-radius:50%;background:var(--brand);opacity:.85}
        .sidebar a.menu{position:relative;display:flex;align-items:center;gap:11px;margin:2px 10px;padding:9px 12px;border-radius:9px;color:var(--side-text);text-decoration:none;font-size:.875rem;font-weight:500;transition:.15s}
        .sidebar a.menu i{width:20px;text-align:center;font-size:.95rem;flex-shrink:0}
        .sidebar a.menu:hover{background:var(--side-hover);color:#fff}
        .sidebar a.menu.active{background:var(--side-active);color:#fff;font-weight:600}
        .sidebar a.menu.active::before{content:'';position:absolute;left:-20px;top:50%;transform:translateY(-50%);height:60%;width:3px;border-radius:0 3px 3px 0;background:var(--brand)}
        .sidebar a.menu.active i{color:var(--brand)}
        .sidebar a.menu .fa-bell-wrap{position:relative}
        .admin-footer-sub{margin-top:10px;padding:14px 20px;border-top:1px solid var(--side-line)}
        .main{margin-left:252px;padding:22px;min-height:100vh}
        .topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;gap:10px}
        .card-grid{border:none;border-radius:16px;box-shadow:0 3px 12px rgba(0,0,0,.05)}
        .stat-icon{width:52px;height:52px;border-radius:14px;display:grid;place-items:center;font-size:1.3rem}
        .table{vertical-align:middle}
        .pagination{justify-content:center}
        .badge{font-weight:500}
        @media(max-width:992px){.sidebar{transform:translateX(-100%)}.sidebar.open{transform:none}.main{margin-left:0}}
    </style>
    @yield('styles')
    @stack('styles')
</head>
<body>
<aside class="sidebar" id="sidebar">
    <div class="brand">
        <span class="logo"><i class="fa-solid fa-car-side"></i></span>
        <span>@yield('brand', 'RC Admin')</span>
    </div>

    <div class="group">Utama</div>
    <a class="menu {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge-high"></i>Dashboard</a>
    <a class="menu {{ request()->is('admin/notifications*') ? 'active' : '' }}" href="{{ route('admin.notifications') }}"><i class="fa-solid fa-bell"></i>Notifikasi</a>

    <div class="group">Operasional</div>
    <a class="menu {{ request()->is('admin/bookings*') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}"><i class="fa-solid fa-calendar-check"></i>Bookings</a>
    <a class="menu {{ request()->is('admin/payments*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}"><i class="fa-solid fa-money-bill-wave"></i>Pembayaran</a>
    <a class="menu {{ request()->is('admin/fleets*') || request()->is('admin/fleet-categories*') ? 'active' : '' }}" href="{{ route('admin.fleets.index') }}"><i class="fa-solid fa-car"></i>Armada</a>
    <a class="menu {{ request()->is('admin/drivers*') ? 'active' : '' }}" href="{{ route('admin.drivers.index') }}"><i class="fa-solid fa-user-tie"></i>Driver</a>
    <a class="menu {{ request()->is('admin/maintenances*') ? 'active' : '' }}" href="{{ route('admin.maintenances.index') }}"><i class="fa-solid fa-wrench"></i>Maintenance</a>

    <div class="group">Penjualan</div>
    <a class="menu {{ request()->is('admin/tours*') ? 'active' : '' }}" href="{{ route('admin.tours.index') }}"><i class="fa-solid fa-map-location-dot"></i>Paket Wisata</a>
    <a class="menu {{ request()->is('admin/travel*') ? 'active' : '' }}" href="{{ route('admin.travel.index') }}"><i class="fa-solid fa-bus"></i>Travel</a>
    <a class="menu {{ request()->is('admin/weddings*') ? 'active' : '' }}" href="{{ route('admin.weddings.index') }}"><i class="fa-solid fa-heart"></i>Wedding Car</a>
    <a class="menu {{ request()->is('admin/promos*') ? 'active' : '' }}" href="{{ route('admin.promos.index') }}"><i class="fa-solid fa-tags"></i>Promo & Voucher</a>
    <a class="menu {{ request()->is('admin/customers*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}"><i class="fa-solid fa-users"></i>Pelanggan</a>

    <div class="group">CMS & Website</div>
    <a class="menu {{ request()->is('admin/cms/banners*') ? 'active' : '' }}" href="{{ route('admin.cms.banners') }}"><i class="fa-solid fa-image"></i>Banners</a>
    <a class="menu {{ request()->is('admin/cms/services*') ? 'active' : '' }}" href="{{ route('admin.cms.services') }}"><i class="fa-solid fa-layer-group"></i>Layanan</a>
    <a class="menu {{ request()->is('admin/cms/blogs*') ? 'active' : '' }}" href="{{ route('admin.cms.blogs') }}"><i class="fa-solid fa-newspaper"></i>Artikel Blog</a>
    <a class="menu {{ request()->is('admin/cms/faqs*') ? 'active' : '' }}" href="{{ route('admin.cms.faqs') }}"><i class="fa-solid fa-circle-question"></i>FAQ</a>
    <a class="menu {{ request()->is('admin/cms/testimonials*') ? 'active' : '' }}" href="{{ route('admin.cms.testimonials') }}"><i class="fa-solid fa-comment"></i>Testimoni</a>
    <a class="menu {{ request()->is('admin/cms/galleries*') ? 'active' : '' }}" href="{{ route('admin.cms.galleries') }}"><i class="fa-solid fa-images"></i>Galeri</a>

    <div class="group">Laporan</div>
    <a class="menu {{ request()->is('admin/reports*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}"><i class="fa-solid fa-chart-line"></i>Center Laporan</a>
    <a class="menu {{ request()->is('admin/activity-logs*') ? 'active' : '' }}" href="{{ route('admin.logs.index') }}"><i class="fa-solid fa-clock-rotate-left"></i>Activity Log</a>

    <div class="group">Sistem</div>
    @can('users.manage')
        <a class="menu {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="fa-solid fa-user-gear"></i>Manajemen User</a>
    @endcan
    @can('settings.manage')
        <a class="menu {{ request()->is('admin/settings*') ? 'active' : '' }}" href="{{ route('admin.settings') }}"><i class="fa-solid fa-gear"></i>Pengaturan</a>
    @endcan

    <div class="admin-footer-sub">
        <a class="menu" href="{{ route('home') }}" target="_blank"><i class="fa-solid fa-globe"></i>Lihat Website</a>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('open')"><i class="fa-solid fa-bars"></i></button>
            <h5 class="fw-bold mb-0">@yield('title', 'Dashboard')</h5>
        </div>
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                <img src="{{ auth()->user()->avatar }}" width="30" height="30" class="rounded-circle" alt="">
                <span class="small fw-semibold">{{ auth()->user()->name }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li class="dropdown-header text-capitalize">{{ auth()->user()->getRoleNameAttribute() }}</li>
                <li><a class="dropdown-item" href="{{ route('home') }}" target="_blank"><i class="fa-solid fa-globe me-2"></i>Website</a></li>
                @if(auth()->user()->hasRole('customer'))
                    <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}"><i class="fa-solid fa-user me-2"></i>Portal</a></li>
                @endif
                <li><form method="post" action="{{ route('logout') }}">@csrf<button class="dropdown-item"><i class="fa-solid fa-right-from-bracket me-2"></i>Keluar</button></form></li>
            </ul>
        </div>
    </div>
    @include('components.flash')
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // confirm delete with sweetalert
    $(document).on('submit', 'form.delete-form', function (e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: 'Hapus data ini?',
            text: 'Tindakan ini tidak dapat dibatalkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((r) => { if (r.isConfirmed) form.submit(); });
    });
</script>
@yield('scripts')
@stack('scripts')
</body>
</html>