@extends('layouts.admin')
@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="card card-grid">
    <div class="card-body">
        <form class="d-flex gap-2 mb-3" method="get" action="" style="max-width:420px">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari no. bayar / kode booking">
            <select name="status" class="form-select form-select-sm">
                <option value="all">Semua Status</option>
                @foreach ($statuses as $k=>$v)
                    <option value="{{ $k }}" @selected(request('status', 'all')==$k)>{{ $v }}</option>
                @endforeach
            </select>
            <button class="btn btn-sm btn-outline-primary">Filter</button>
        </form>
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th>No.</th><th>No. Bayar</th><th>Kode Booking</th><th>Tipe</th><th>Jumlah</th><th>Metode</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach ($payments as $i=>$p)
                    <tr>
                        <td>{{ $i + $payments->firstItem() }}</td>
                        <td>{{ $p->payment_number }}</td>
                        <td><a href="{{ route('admin.bookings.show', $p->booking) }}" class="text-decoration-none">{{ $p->booking?->booking_code ?? '-' }}</a></td>
                        <td>{{ strtoupper($p->type) }}</td>
                        <td>@rupiah($p->amount)</td>
                        <td>{{ $p->payment_method }}</td>
                        <td><span class="badge bg-{{ $p->status=='verified'?'success':($p->status=='rejected'?'danger':'secondary') }}">{{ $statuses[$p->status] ?? $p->status }}</span></td>
                        <td>
                            <a href="{{ route('admin.payments.show', $p) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></a>
                            @if($p->status=='menunggu_verifikasi')
                            <form action="{{ route('admin.payments.verify', $p) }}" method="post" class="d-inline">@csrf<button class="btn btn-sm btn-outline-success"><i class="fa-solid fa-check"></i></button></form>
                            <form action="{{ route('admin.payments.reject', $p) }}" method="post" class="d-inline">@csrf<input type="hidden" name="note" value="Ditolak"><button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-xmark"></i></button></form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $payments->links() }}
    </div>
</div>
@endsection