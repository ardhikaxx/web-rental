@extends('layouts.admin')
@section('title', 'Manajemen Armada')
@section('styles')
<style>.fleet-image{width:70px;height:50px;object-fit:cover;border-radius:8px}</style>
@endsection

@section('content')
<div class="card card-grid">
    <x-table-toolbar title="Armada" placeholder="Cari armada / plat…" addUrl="{{ route('admin.fleets.create') }}" addLabel="Tambah Armada" addTitle="Tambah Armada" filter="filter">
        <select name="status" class="form-select form-select-sm" style="width:auto">
            <option value="">Semua Status</option>
            @foreach (['tersedia','dipesan','berjalan','maintenance','nonaktif'] as $s)
                <option value="{{ $s }}" @selected(request('status')==$s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </x-table-toolbar>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th></th><th>Armada</th><th>Plat</th><th>Kategori</th><th>Tahun</th><th>Harga/Hari</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach ($fleets as $fleet)
                    <tr>
                        <td><img src="{{ $fleet->main_image }}" class="fleet-image" alt=""></td>
                        <td><a href="{{ route('admin.fleets.show', $fleet) }}" class="fw-semibold text-decoration-none">{{ $fleet->display_name }}</a></td>
                        <td>{{ $fleet->license_plate }}</td>
                        <td>{{ $fleet->category?->name ?? '-' }}</td>
                        <td>{{ $fleet->year }}</td>
                        <td>@rupiah($fleet->daily_price)</td>
                        <td><span class="badge bg-{{ $fleet->status=='tersedia'?'success':($fleet->status=='maintenance'?'danger':($fleet->status=='berjalan'?'info':'secondary')) }}">{{ ucfirst($fleet->status) }}</span></td>
                        <td>
                            <a href="{{ route('admin.fleets.edit', $fleet) }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.fleets.destroy', $fleet) }}" method="post" class="d-inline delete-form">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $fleets->links() }}
    </div>
</div>
@endsection