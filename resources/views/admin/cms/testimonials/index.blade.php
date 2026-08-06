@extends('layouts.admin')
@section('title', 'Testimoni')

@section('content')
    <div class="card card-grid">
        <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.cms.testimonials.create') }}" class="btn btn-sm btn-brand"><i class="fa-solid fa-plus me-1"></i>Tambah Testimoni</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th>Nama</th><th>Layanan</th><th>Rating</th><th>Konten</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse ($testimonials as $t)
                    <tr>
                        <td class="fw-semibold">{{ $t->customer_name }}</td>
                        <td>{{ $t->service_type ?? '-' }}</td>
                        <td>
                            @for ($i=1;$i<=5;$i++)
                                <i class="fa-solid fa-star {{ $i <= $t->rating ? 'text-warning' : 'text-secondary' }}"></i>
                            @endfor
                        </td>
                        <td class="text-truncate" style="max-width:300px">{{ $t->content }}</td>
                        <td><span class="badge bg-{{ $t->is_active ? 'success' : 'secondary' }}">{{ $t->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td>
                            <a href="{{ route('admin.cms.testimonials.edit', $t) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.cms.testimonials.destroy', $t) }}" method="post" class="d-inline delete-form">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada testimoni.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection