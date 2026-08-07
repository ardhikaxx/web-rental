@extends('layouts.admin')
@section('title', 'Manajemen Wedding Car')

@section('content')
<div class="card card-grid">
    <x-table-toolbar title="Wedding Car" :searchable="false" addUrl="{{ route('admin.weddings.create') }}" addLabel="Tambah Paket" addTitle="Tambah Paket Wedding"></x-table-toolbar>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th>Paket</th><th>Armada</th><th>Area</th><th>Durasi</th><th>Total Harga</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach ($weddings as $w)
                    <tr>
                        <td class="fw-semibold">{{ $w->name }}</td>
                        <td>{{ $w->fleet?->display_name ?? '-' }}</td>
                        <td>{{ $w->area ?? '-' }}</td>
                        <td>{{ $w->duration_hours }} jam</td>
                        <td>@rupiah($w->total_price)</td>
                        <td>
                            <a href="{{ route('admin.weddings.edit', $w) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.weddings.destroy', $w) }}" method="post" class="d-inline delete-form">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $weddings->links() }}
    </div>
</div>
@endsection