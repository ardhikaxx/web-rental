@extends('layouts.admin')
@section('title', 'Layanan')

@section('content')
    <div class="card card-grid">
        <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.cms.services.create') }}" class="btn btn-sm btn-brand"><i class="fa-solid fa-plus me-1"></i>Tambah Layanan</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th>Ikon</th><th>Nama</th><th>Deskripsi</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse ($services as $service)
                    <tr>
                        <td><i class="fa-solid {{ $service->icon }}"></i></td>
                        <td class="fw-semibold">{{ $service->name }}</td>
                        <td class="text-truncate" style="max-width:320px">{{ $service->description }}</td>
                        <td><span class="badge bg-{{ $service->is_active ? 'success' : 'secondary' }}">{{ $service->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td>
                            <a href="{{ route('admin.cms.services.edit', $service) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.cms.services.destroy', $service) }}" method="post" class="d-inline delete-form">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada layanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection