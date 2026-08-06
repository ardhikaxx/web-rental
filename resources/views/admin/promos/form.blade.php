@extends('layouts.admin')
@section('title', $promo->exists ? 'Edit Promo' : 'Tambah Promo')

@section('content')
<form method="post" action="{{ $promo->exists ? route('admin.promos.update', $promo) : route('admin.promos.store') }}">
    @csrf
    @if($promo->exists) @method('put') @endif
    <div class="card card-grid">
        <div class="card-header bg-white fw-bold">Detail Promo</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><label class="form-label">Nama Promo</label><input type="text" name="name" value="{{ old('name', $promo->name) }}" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Kode</label><input type="text" name="code" value="{{ old('code', $promo->code) }}" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Tipe</label>
                <select name="type" class="form-select" required>
                    @foreach ($types as $k=>$v)<option value="{{ $k }}" @selected($promo->type==$k)>{{ $v }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-3"><label class="form-label">Nilai</label><input type="number" step="0.01" min="0" name="value" value="{{ old('value', $promo->value) }}" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label">Min. Pembelian</label><input type="number" step="0.01" name="min_purchase" value="{{ old('min_purchase', $promo->min_purchase) }}" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Maks. Diskon</label><input type="number" step="0.01" name="max_discount" value="{{ old('max_discount', $promo->max_discount) }}" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Mulai</label><input type="date" name="valid_from" value="{{ old('valid_from', optional($promo->valid_from)->format('Y-m-d')) }}" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Berakhir</label><input type="date" name="valid_until" value="{{ old('valid_until', optional($promo->valid_until)->format('Y-m-d')) }}" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Batas Pakai</label><input type="number" name="usage_limit" value="{{ old('usage_limit', $promo->usage_limit) }}" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @foreach (['aktif','nonaktif'] as $s)<option value="{{ $s }}" @selected($promo->status==$s)>{{ ucfirst($s) }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-6"><label class="form-label">Armada</label>
                <select name="fleet_id" class="form-select">
                    <option value="">-- Semua Armada --</option>
                    @foreach ($fleets as $f)<option value="{{ $f->id }}" @selected($promo->fleet_id==$f->id)>{{ $f->display_name }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-6"><label class="form-label">Paket Wisata</label>
                <select name="tour_package_id" class="form-select">
                    <option value="">-- Semua Paket --</option>
                    @foreach ($tours as $t)<option value="{{ $t->id }}" @selected($promo->tour_package_id==$t->id)>{{ $t->name }}</option>@endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-brand"><i class="fa-solid fa-save me-2"></i>Simpan</button>
        <a href="{{ route('admin.promos.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection