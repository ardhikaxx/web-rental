@extends('layouts.admin')
@section('title', 'Detail Armada ' . $fleet->license_plate)

@section('content')
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card card-grid">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold">{{ $fleet->display_name }}</h5>
                    <span class="badge bg-{{ $fleet->status=='tersedia'?'success':'secondary' }}">{{ $fleet->status }}</span>
                </div>
                <img src="{{ $fleet->main_image }}" class="w-100 rounded-3 mb-3" style="height:300px;object-fit:cover" alt="">
                <div class="row g-2">
                    @foreach ($fleet->photos as $p)<div class="col-3"><img src="{{ $p->url }}" class="rounded-3 w-100" style="height:80px;object-fit:cover" alt=""></div>@endforeach
                </div>
                <hr>
                <div class="row g-2">
                    <div class="col-md-4"><strong>Plat:</strong> {{ $fleet->license_plate }}</div>
                    <div class="col-md-4"><strong>Kategori:</strong> {{ $fleet->category?->name }}</div>
                    <div class="col-md-4"><strong>Tahun:</strong> {{ $fleet->year }}</div>
                    <div class="col-md-4"><strong>Transmisi:</strong> {{ $fleet->transmission }}</div>
                    <div class="col-md-4"><strong>Kapasitas:</strong> {{ $fleet->capacity }}</div>
                    <div class="col-md-4"><strong>Lokasi:</strong> {{ $fleet->location }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-grid">
            <div class="card-body">
                <h6 class="fw-bold">Riwayat Booking</h6>
                @forelse ($fleet->bookings->take(6) as $b)
                <a href="{{ route('admin.bookings.show', $b) }}" class="d-block py-2 border-bottom text-decoration-none">
                    <div class="fw-semibold small">{{ $b->booking_code }}</div>
                    <small class="text-muted">{{ format_indo_date($b->start_date) }}</small>
                </a>
                @empty <p class="small text-muted mb-0">Belum ada booking.</p> @endforelse
            </div>
        </div>
        <div class="card card-grid mt-3">
            <div class="card-body">
                <h6 class="fw-bold">Maintenance</h6>
                @forelse ($fleet->maintenances->take(5) as $m)
                <div class="d-flex justify-content-between py-2 border-bottom small"><span>{{ $m->type }}</span><span>@rupiah($m->cost)</span></div>
                @empty <p class="small text-muted mb-0">Belum ada maintenance.</p> @endforelse
            </div>
        </div>
        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('admin.fleets.edit', $fleet) }}" class="btn btn-outline-primary w-100"><i class="fa-solid fa-pen"></i> Edit</a>
            <a href="{{ route('admin.fleets.index') }}" class="btn btn-outline-secondary w-100">Kembali</a>
        </div>
    </div>
</div>
@endsection