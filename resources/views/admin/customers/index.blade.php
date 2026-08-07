@extends('layouts.admin')
@section('title', 'Manajemen Pelanggan')

@section('content')
<div class="card card-grid">
    <x-table-toolbar title="Pelanggan" placeholder="Cari nama / email / no HP…" filter="filter"></x-table-toolbar>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th>Nama</th><th>Email</th><th>No HP</th><th>Kota</th><th>Total Booking</th><th>Total Belanja</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach ($customers as $c)
                    <tr>
                        <td><a href="{{ route('admin.customers.show', $c) }}" class="fw-semibold text-decoration-none">{{ $c->name }}</a></td>
                        <td>{{ $c->email }}</td>
                        <td>{{ $c->phone ?? '-' }}</td>
                        <td>{{ $c->city ?? '-' }}</td>
                        <td>{{ $c->total_bookings }}</td>
                        <td>@rupiah($c->total_spent)</td>
                        <td><a href="{{ route('admin.customers.show', $c) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $customers->links() }}
    </div>
</div>
@endsection