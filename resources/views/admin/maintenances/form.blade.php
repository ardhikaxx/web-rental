@extends('layouts.admin')
@section('title', $maintenance->exists ? 'Edit Maintenance' : 'Catat Maintenance')

@section('content')
<form method="post" action="{{ $maintenance->exists ? route('admin.maintenances.update', $maintenance) : route('admin.maintenances.store') }}" enctype="multipart/form-data">
    @csrf
    @if($maintenance->exists) @method('put') @endif
    <div class="card card-grid">
        <div class="card-header bg-white fw-bold">Data Maintenance</div>
        <div class="card-body row g-3">
            <div class="col-md-4"><label class="form-label">Armada</label>
                <select name="fleet_id" class="form-select" required>
                    <option value="">--</option>
                    @foreach ($fleets as $f)<option value="{{ $f->id }}" @selected($maintenance->fleet_id==$f->id)>{{ $f->display_name }} ({{ $f->license_plate }})</option>@endforeach
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">Tipe</label>
                <select name="type" class="form-select" required>
                    @foreach ($types as $k=>$v)<option value="{{ $k }}" @selected($maintenance->type==$k)>{{ $v }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">Tanggal</label><input type="date" name="date" value="{{ old('date', optional($maintenance->date)->format('Y-m-d')) }}" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label">Biaya (Rp)</label><input type="number" step="0.01" min="0" name="cost" value="{{ old('cost', $maintenance->cost) }}" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label">Mileage (km)</label><input type="number" name="mileage" value="{{ old('mileage', $maintenance->mileage) }}" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Workshop</label><input type="text" name="workshop" value="{{ old('workshop', $maintenance->workshop) }}" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Berlaku Hingga</label><input type="date" name="valid_until" value="{{ old('valid_until', optional($maintenance->valid_until)->format('Y-m-d')) }}" class="form-control"></div>
            <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3">{{ old('description', $maintenance->description) }}</textarea></div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-brand"><i class="fa-solid fa-save me-2"></i>Simpan</button>
        <a href="{{ route('admin.maintenances.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection