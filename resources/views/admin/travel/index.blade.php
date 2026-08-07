@extends('layouts.admin')
@section('title', 'Manajemen Travel')

@section('content')
<div class="card card-grid">
    <x-table-toolbar title="Rute Travel" :searchable="false" addUrl="{{ route('admin.travel.create') }}" addLabel="Tambah Rute" addTitle="Tambah Rute Baru"></x-table-toolbar>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th>Rute</th><th>Waktu Tempuh</th><th>Jam Berangkat</th><th>Kuota</th><th>Harga</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach ($travels as $tr)
                    <tr>
                        <td class="fw-semibold">{{ $tr->route_origin }} &rarr; {{ $tr->route_destination }}</td>
                        <td>{{ $tr->travel_time_hours }} jam</td>
                        <td>{{ $tr->departure_time ?? '-' }}</td>
                        <td>{{ $tr->quota }}</td>
                        <td>@rupiah($tr->price)</td>
                        <td>
                            <a href="{{ route('admin.travel.edit', $tr) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.travel.destroy', $tr) }}" method="post" class="d-inline delete-form">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $travels->links() }}
    </div>
</div>
@endsection