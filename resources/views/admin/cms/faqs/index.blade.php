@extends('layouts.admin')
@section('title', 'FAQ')

@section('content')
    <div class="card card-grid">
        <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.cms.faqs.create') }}" class="btn btn-sm btn-brand"><i class="fa-solid fa-plus me-1"></i>Tambah FAQ</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th>Urutan</th><th>Pertanyaan</th><th>Jawaban</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse ($faqs as $faq)
                    <tr>
                        <td>{{ $faq->sort_order }}</td>
                        <td class="fw-semibold">{{ $faq->question }}</td>
                        <td class="text-truncate" style="max-width:360px">{{ $faq->answer }}</td>
                        <td><span class="badge bg-{{ $faq->is_active ? 'success' : 'secondary' }}">{{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td>
                            <a href="{{ route('admin.cms.faqs.edit', $faq) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.cms.faqs.destroy', $faq) }}" method="post" class="d-inline delete-form">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada FAQ.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection