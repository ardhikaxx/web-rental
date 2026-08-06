@extends('layouts.admin')
@section('title', 'Detail Pembayaran ' . $payment->payment_number)

@section('content')
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card card-grid">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="fw-bold mb-0">{{ $payment->payment_number }}</h5>
                    <span class="badge bg-{{ $payment->status=='verified'?'success':($payment->status=='rejected'?'danger':'secondary') }}">{{ \App\Models\Payment::statuses()[$payment->status] ?? $payment->status }}</span>
                </div>
                <hr>
                <div class="row g-2">
                    <div class="col-md-6"><strong>Booking:</strong> <a href="{{ route('admin.bookings.show', $payment->booking) }}">{{ $payment->booking?->booking_code ?? '-' }}</a></div>
                    <div class="col-md-6"><strong>Pelanggan:</strong> {{ $payment->booking?->customer_name ?? $payment->account_name }}</div>
                    <div class="col-md-6"><strong>Tipe:</strong> {{ strtoupper($payment->type) }}</div>
                    <div class="col-md-6"><strong>Jumlah:</strong> @rupiah($payment->amount)</div>
                    <div class="col-md-6"><strong>Metode:</strong> {{ $payment->payment_method }} {{ $payment->bank_name ? '(' . $payment->bank_name . ')' : '' }}</div>
                    <div class="col-md-6"><strong>Waktu:</strong> {{ $payment->paid_at ? format_indo_date($payment->paid_at) : '-' }}</div>
                </div>
                <div class="mt-3"><strong>Bukti Transfer</strong></div>
                @if($payment->proof_url)
                    <img src="{{ $payment->proof_url }}" class="img-fluid rounded-3 mt-2" style="max-height:380px" alt="Bukti">
                @else
                    <p class="text-muted">Tidak ada bukti upload (dicatat manual).</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-grid">
            <div class="card-header bg-white fw-bold">Aksi Verifikasi</div>
            <div class="card-body">
                @if($payment->status == 'menunggu_verifikasi')
                <form method="post" action="{{ route('admin.payments.verify', $payment) }}">
                    @csrf
                    <button class="btn btn-success w-100"><i class="fa-solid fa-check me-1"></i>Verifikasi</button>
                </form>
                <hr>
                <form method="post" action="{{ route('admin.payments.reject', $payment) }}">
                    @csrf
                    <label class="form-label">Alasan Penolakan</label>
                    <textarea name="note" class="form-control mb-2" rows="2" placeholder="Catatan penolakan"></textarea>
                    <button class="btn btn-danger w-100"><i class="fa-solid fa-xmark me-1"></i>Tolak</button>
                </form>
                @else
                    <p class="small text-muted mb-0">
                        Status sudah <strong>{{ $payment->status }}</strong>.
                    </p>
                @endif
            </div>
        </div>
        <div class="card card-grid mt-3">
            <div class="card-body">
                <h6 class="fw-bold">Unduh Dokumen</h6>
                <a href="{{ route('admin.payments.invoice', $payment) }}" class="d-block btn btn-outline-primary btn-sm mb-2"><i class="fa-solid fa-file-invoice me-1"></i>Invoice</a>
                <a href="{{ route('admin.payments.kuitansi', $payment) }}" class="d-block btn btn-outline-secondary btn-sm"><i class="fa-solid fa-receipt me-1"></i>Kuitansi</a>
            </div>
        </div>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary w-100 mt-3">Kembali</a>
    </div>
</div>
@endsection