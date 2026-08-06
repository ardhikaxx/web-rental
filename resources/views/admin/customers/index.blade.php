@extends('layouts.admin')
@section('title', 'Manajemen Pelanggan')

@section('content')
<div class="card card-grid">
    <div class="card-body">
        <form class="d-flex gap-2 mb-3" method="get" action="" style="max-width:360px">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari nama / email / no HP">
            <button class="btn btn-sm btn-outline-primary">Filter</button>
        </form>
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