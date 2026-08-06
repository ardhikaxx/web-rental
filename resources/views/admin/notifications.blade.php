@extends('layouts.admin')
@section('title', 'Notifikasi')

@section('content')
<div class="card card-grid">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0">Notifikasi Anda</h6>
            <form method="post" action="{{ route('admin.notifications.read') }}">@csrf
                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-check-double me-1"></i>Tandai Semua</button>
            </form>
        </div>
        <div class="list-group" style="max-height:70vh;overflow-y:auto">
            @forelse ($notifications as $n)
            <div class="list-group-item d-flex justify-content-between align-items-start {{ $n->read_at ? '' : 'list-group-item-light' }}">
                <div class="me-3">
                    <div class="fw-semibold">{{ $n->data['title'] ?? 'Notifikasi' }}</div>
                    <small class="text-muted d-block">{{ $n->data['message'] ?? '' }}</small>
                    <small class="text-muted">{{ $n->created_at->format('d M Y H:i') }}</small>
                </div>
                @if(!$n->read_at)
                <form method="post" action="{{ route('admin.notifications.read-one', $n->id) }}">@csrf
                    <button class="btn btn-sm btn-outline-success"><i class="fa-solid fa-check"></i></button>
                </form>
                @endif
            </div>
            @empty
            <p class="text-muted text-center py-4 mb-0">Tidak ada notifikasi.</p>
            @endforelse
        </div>
        <div class="mt-3">{{ $notifications->links() }}</div>
    </div>
</div>
@endsection