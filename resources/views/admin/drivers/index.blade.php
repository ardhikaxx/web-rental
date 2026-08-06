@extends('layouts.admin')
@section('title', 'Manajemen Driver')
@section('styles')
<style>.driver-img{width:46px;height:46px;border-radius:50%;object-fit:cover}</style>
@endsection

@section('content')
<div class="card card-grid">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <form class="d-flex gap-2" method="get" action="">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari nama / no HP">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    @foreach (['aktif','libur','bertugas','nonaktif'] as $s)
                        <option value="{{ $s }}" @selected(request('status')==$s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button class="btn btn-sm btn-outline-primary">Filter</button>
            </form>
            <a href="{{ route('admin.drivers.create') }}" class="btn btn-sm btn-brand"><i class="fa-solid fa-plus me-1"></i>Tambah Driver</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th></th><th>Nama</th><th>No HP</th><th>No. SIM</th><th>Rating</th><th>Trip</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach ($drivers as $driver)
                    <tr>
                        <td><img src="{{ $driver->photo_url }}" class="driver-img" alt=""></td>
                        <td><a href="{{ route('admin.drivers.show', $driver) }}" class="fw-semibold text-decoration-none">{{ $driver->name }}</a></td>
                        <td>{{ $driver->phone }}</td>
                        <td>{{ $driver->license_number ?? '-' }}</td>
                        <td>{{ $driver->rating ? number_format($driver->rating, 1) : '-' }}</td>
                        <td>{{ $driver->experience_trips }}x</td>
                        <td>
                            <span class="badge bg-{{ $driver->is_active ? 'success' : 'secondary' }}">
                                {{ $driver->status ?? ($driver->is_active ? 'aktif' : 'nonaktif') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.drivers.edit', $driver) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.drivers.destroy', $driver) }}" method="post" class="d-inline delete-form">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $drivers->links() }}
    </div>
</div>
@endsection