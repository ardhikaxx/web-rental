@extends('layouts.admin')
@section('title', 'Manajemen Paket Wisata')
@section('styles')
<style>.tour-thumb{width:72px;height:50px;object-fit:cover;border-radius:8px}</style>
@endsection

@section('content')
<div class="card card-grid">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <form class="d-flex gap-2" method="get" action="">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari paket">
                <button class="btn btn-sm btn-outline-primary">Filter</button>
            </form>
            <a href="{{ route('admin.tours.create') }}" class="btn btn-sm btn-brand"><i class="fa-solid fa-plus me-1"></i>Tambah Paket</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th></th><th>Paket</th><th>Tujuan</th><th>Durasi</th><th>Per Orang</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach ($tours as $tour)
                    <tr>
                        <td>@if($tour->thumbnail)<img src="{{ asset('storage/' . $tour->thumbnail) }}" class="tour-thumb" alt="">@else<i class="fa-solid fa-image text-muted"></i>@endif</td>
                        <td class="fw-semibold">{{ $tour->name }}</td>
                        <td>{{ $tour->destination }}</td>
                        <td>{{ $tour->duration_days }}D {{ $tour->duration_nights }}N</td>
                        <td>@rupiah($tour->price_per_person)</td>
                        <td><span class="badge bg-{{ $tour->status=='aktif'?'success':'secondary' }}">{{ $tour->status }}</span></td>
                        <td>
                            <a href="{{ route('admin.tours.edit', $tour) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.tours.destroy', $tour) }}" method="post" class="d-inline delete-form">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $tours->links() }}
    </div>
</div>
@endsection