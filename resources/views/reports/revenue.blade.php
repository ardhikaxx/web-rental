@extends('layouts.admin')
@section('title', 'Laporan Pendapatan')

@section('content')
<div class="card card-grid">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Pendapatan Terverifikasi</h6>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reports.export-pdf', array_merge(['type'=>'payment'], request()->query())) }}" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-file-pdf"></i> PDF</a>
        </div>
    </div>
    <div class="card-body">
        <form class="row g-2 mb-3" method="get">
            <div class="col-auto"><input type="date" name="from" value="{{ $from }}" class="form-control form-control-sm"></div>
            <div class="col-auto"><input type="date" name="to" value="{{ $to }}" class="form-control form-control-sm"></div>
            <div class="col-auto"><button class="btn btn-sm btn-outline-primary">Terapkan</button></div>
        </form>
        <div class="alert alert-light border"><strong>Total Pendapatan:</strong> @rupiah($total)</div>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>No.</th><th>No. Bayar</th><th>Kode Booking</th><th>Jumlah</th><th>Metode</th><th>Diverifikasi</th></tr></thead>
                <tbody>
                    @forelse ($payments as $i=>$p)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $p->payment_number }}</td>
                        <td>{{ $p->booking?->booking_code ?? '-' }}</td>
                        <td>@rupiah($p->amount)</td>
                        <td>{{ $p->payment_method }}</td>
                        <td>@dateid($p->verified_at)</td>
                    </tr>
                    @empty <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data.</td></tr> @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection