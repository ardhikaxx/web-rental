@extends('layouts.admin')
@section('title', 'Manajemen Promo & Voucher')

@section('content')
<div class="card card-grid">
    <x-table-toolbar title="Promo & Voucher" :searchable="false" addUrl="{{ route('admin.promos.create') }}" addLabel="Tambah Promo" addTitle="Tambah Promo / Voucher"></x-table-toolbar>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th>Kode</th><th>Nama</th><th>Tipe</th><th>Nilai</th><th>Berlaku</th><th>Pakai</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach ($promos as $promo)
                    <tr>
                        <td class="fw-bold">{{ $promo->code }}</td>
                        <td>{{ $promo->name }}</td>
                        <td>{{ $types[$promo->type] ?? $promo->type }}</td>
                        <td>{{ $promo->type=='persen' ? $promo->value . '%' : 'Rp ' . number_format($promo->value, 0, ',', '.') }}</td>
                        <td>{{ $promo->valid_from ? format_indo_date($promo->valid_from) : '-' }} s/d {{ $promo->valid_until ? format_indo_date($promo->valid_until) : '-' }}</td>
                        <td>{{ $promo->used_count }} / {{ $promo->usage_limit ?? '&infin;' }}</td>
                        <td><span class="badge bg-{{ $promo->is_valid ? 'success' : 'secondary' }}">{{ $promo->status }}</span></td>
                        <td>
                            <a href="{{ route('admin.promos.edit', $promo) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.promos.destroy', $promo) }}" method="post" class="d-inline delete-form">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $promos->links() }}
    </div>
</div>
@endsection