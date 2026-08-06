@extends('layouts.admin')
@section('title', $travel->exists ? 'Edit Rute Travel' : 'Tambah Rute Travel')

@section('content')
<form method="post" action="{{ $travel->exists ? route('admin.travel.update', $travel) : route('admin.travel.store') }}">
    @csrf
    @if($travel->exists) @method('put') @endif
    <div class="card card-grid">
        <div class="card-header bg-white fw-bold">Rute Travel</div>
        <div class="card-body row g-3">
            <div class="col-md-4"><label class="form-label">Asal</label>
                <select name="route_origin" class="form-select" required>
                    <option value="">--</option>
                    @foreach ($routes as $k=>$v)<option value="{{ $k }}" @selected($travel->route_origin==$k)>{{ $v }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">Tujuan</label>
                <select name="route_destination" class="form-select" required>
                    <option value="">--</option>
                    @foreach ($routes as $k=>$v)<option value="{{ $k }}" @selected($travel->route_destination==$k)>{{ $v }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">Harga (Rp)</label><input type="number" step="0.01" name="price" value="{{ old('price', $travel->price) }}" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Waktu Tempuh (jam)</label><input type="number" step="0.1" name="travel_time_hours" value="{{ old('travel_time_hours', $travel->travel_time_hours) }}" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Jam Berangkat</label><input type="time" name="departure_time" value="{{ old('departure_time', $travel->departure_time) }}" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Kuota</label><input type="number" name="quota" value="{{ old('quota', $travel->quota) }}" class="form-control" required></div>
            <div class="col-12"><label class="form-label">Titik Penjemputan (setiap baris)</label><textarea name="pickup_points" class="form-control" rows="2">{{ old('pickup_points', $travel->pickup_points) }}</textarea></div>
            <div class="col-12"><label class="form-label">Titik Penurunan (setiap baris)</label><textarea name="dropoff_points" class="form-control" rows="2">{{ old('dropoff_points', $travel->dropoff_points) }}</textarea></div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-brand"><i class="fa-solid fa-save me-2"></i>Simpan</button>
        <a href="{{ route('admin.travel.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection