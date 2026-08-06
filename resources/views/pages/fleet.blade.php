@extends('layouts.public')
@section('title', 'Armada Kami')
@section('meta_description', 'Lihat koleksi armada rental mobil premium kami, tersedia MPV, SUV, sedan hingga bus untuk berbagai kebutuhan.')

@section('content')
@include('components.page-header', ['title' => 'Armada Kami'])
<section class="section">
    <div class="container">
        <form method="get" class="row g-3 mb-4 align-items-end">
            <div class="col-md-4"><label class="form-label small">Cari Armada</label><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Merk / tipe"></div>
            <div class="col-md-3">
                <label class="form-label small">Kategori</label>
                <select name="category" class="form-select">
                    <option value="">Semua</option>
                    @foreach (\App\Models\FleetCategory::all() as $c)
                        <option value="{{ $c->slug }}" @selected(request('category') == $c->slug)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2"><button class="btn btn-brand w-100">Filter</button></div>
        </form>

        <div class="row g-4">
            @forelse ($fleets as $fleet)
            <div class="col-md-6 col-lg-4">
                <div class="card card-rc h-100">
                    <div style="height:200px;overflow:hidden"><img src="{{ $fleet->main_image }}" class="w-100 h-100 object-fit-cover" alt="{{ $fleet->display_name }}"></div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between"><h5 class="fw-bold mb-0">{{ $fleet->display_name }}</h5><span class="chip">{{ $fleet->category?->name }}</span></div>
                        <div class="d-flex gap-3 small text-muted my-3">
                            <span><i class="fa-solid fa-user me-1"></i>{{ $fleet->capacity }}</span>
                            <span><i class="fa-solid fa-gear me-1"></i>{{ $fleet->transmission }}</span>
                            <span><i class="fa-solid fa-gas-pump me-1"></i>{{ $fleet->fuel }}</span>
                            <span>{{ $fleet->year }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div><small class="text-muted">Mulai</small><div class="price-tag fs-5">@rupiah($fleet->daily_price)<small class="text-muted fw-normal">/hari</small></div></div>
                            <a href="{{ route('fleet.show', $fleet) }}" class="btn btn-brand btn-sm"><i class="fa-solid fa-eye me-1"></i>Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted"><i class="fa-solid fa-car fa-2x mb-3"></i><p>Tidak ada armada ditemukan.</p></div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">{{ $fleets->links() }}</div>
    </div>
</section>
@endsection