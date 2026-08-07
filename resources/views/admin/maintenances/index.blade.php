@extends('layouts.admin')
@section('title', 'Manajemen Maintenance')

@section('content')
<div class="card card-grid">
    <x-table-toolbar title="Maintenance" searchable="false" filter="filter" addUrl="{{ route('admin.maintenances.create') }}" addLabel="Catat Maintenance" addTitle="Catat Maintenance Baru">
        <select name="type" class="form-select form-select-sm" style="width:auto">
            <option value="">Semua Tipe</option>
            @foreach ($types as $k=>$v)
                <option value="{{ $k }}" @selected(request('type')==$k)>{{ $v }}</option>
            @endforeach
        </select>
        <select name="fleet_id" class="form-select form-select-sm" style="width:auto">
            <option value="">Semua Armada</option>
            @foreach ($fleets as $f)<option value="{{ $f->id }}" @selected(request('fleet_id')==$f->id)>{{ $f->display_name }} ({{ $f->license_plate }})</option>@endforeach
        </select>
    </x-table-toolbar>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th>Kode</th><th>Armada</th><th>Tipe</th><th>Tanggal</th><th>Biaya</th><th>Workshop</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach ($maintenances as $m)
                    <tr>
                        <td>{{ $m->code }}</td>
                        <td>{{ $m->fleet?->display_name ?? '-' }}</td>
                        <td>{{ $types[$m->type] ?? $m->type }}</td>
                        <td>{{ format_indo_date($m->date) }}</td>
                        <td>@rupiah($m->cost)</td>
                        <td>{{ $m->workshop ?? '-' }}</td>
                        <td><span class="badge bg-{{ $m->status=='selesai'?'success':'secondary' }}">{{ $m->status ?? 'berjalan' }}</span></td>
                        <td>
                            <a href="{{ route('admin.maintenances.edit', $m) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.maintenances.destroy', $m) }}" method="post" class="d-inline delete-form">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $maintenances->links() }}
    </div>
</div>
@endsection