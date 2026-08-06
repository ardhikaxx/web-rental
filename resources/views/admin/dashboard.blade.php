@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="row g-3">
    <div class="col-md-3"><div class="card card-grid card-rc"><div class="card-body d-flex align-items-center gap-3"><div class="stat-card" style="background:#eef2ff;color:#4361ee"><i class="fa-solid fa-money-bill-wave"></i></div><div><div class="fs-5 fw-bold">@rupiah($stats['month_revenue'])</div><small class="text-muted">Pendapatan Bulan Ini</small></div></div></div></div>
    <div class="col-md-3"><div class="card card-grid card-rc"><div class="card-body d-flex align-items-center gap-3"><div class="stat-card" style="background:#fff5e6;color:#f59f00"><i class="fa-solid fa-calendar-check"></i></div><div><div class="fs-5 fw-bold">{{ $stats['total_bookings'] }}</div><small class="text-muted">Total Booking</small></div></div></div></div>
    <div class="col-md-3"><div class="card card-grid card-rc"><div class="card-body d-flex align-items-center gap-3"><div class="stat-card" style="background:#ffe8e8;color:#fa5252"><i class="fa-solid fa-hourglass-half"></i></div><div><div class="fs-5 fw-bold">{{ $stats['pending_bookings'] }}</div><small class="text-muted">Menunggu Konfirmasi</small></div></div></div></div>
    <div class="col-md-3"><div class="card card-grid card-rc"><div class="card-body d-flex align-items-center gap-3"><div class="stat-card" style="background:#e6f9f0;color:#2f9e44"><i class="fa-solid fa-car-side"></i></div><div><div class="fs-5 fw-bold">{{ $stats['fleet_available'] }}<span class="text-muted fs-6">/{{ $stats['fleet_count'] }}</span></div><small class="text-muted">Armada Tersedia</small></div></div></div></div>
</div>

<div class="row g-3 mt-1">
    <div class="col-lg-8">
        <div class="card card-grid">
            <div class="card-body">
                <div class="d-flex justify-content-between"><h6 class="fw-bold">Pendapatan Bulanan</h6><span class="chip small">{{ $stats['month_revenue'] ? 'OKR'.now()->format('Y') : '' }}</span></div>
                <canvas id="revenueChart" height="110"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-grid h-100">
            <div class="card-body">
                <h6 class="fw-bold">Distribusi Status Booking</h6>
                <canvas id="statusChart" height="230"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-lg-7">
        <div class="card card-grid">
            <div class="card-header bg-white"><a href="{{ route('admin.bookings.index') }}" class="fw-bold text-decoration-none">Booking Terbaru <i class="fa-solid fa-arrow-right"></i></a></div>
            <div class="card-body p-0">
                <table class="table table-hover">
                    <thead><tr><th>Kode</th><th>Pelanggan</th><th>Armada</th><th>Total</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach ($recentBookings as $b)
                        <tr>
                            <td><a href="{{ route('admin.bookings.show', $b) }}">{{ $b->booking_code }}</a></td>
                            <td>{{ $b->customer_name }}</td>
                            <td>{{ $b->fleet?->license_plate }}</td>
                            <td>@rupiah($b->total_price)</td>
                            <td><span class="badge bg-info text-dark">{{ $b->status }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card card-grid">
            <div class="card-body">
                <h6 class="fw-bold">Armada Terlaris</h6>
                @foreach ($topFleets as $f)
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>{{ $f->display_name }}</span>
                    <span class="fw-bold d-inline p-1">{{ $f->booking_count }}x</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
fetch('{{ route('admin.chart-data') }}').then(r=>r.json()).then(d=>{
    new Chart($('#revenueChart'),{type:'bar',data:{labels:d.months,datasets:[{label:'Pendapatan',data:d.monthlyRevenue,backgroundColor:'#4361ee',borderRadius:8}]},options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}});
    const statusCounts = d.status.map(s=>s.jumlah);
    const statusLabels = d.status.map(s=>s.status);
    new Chart($('#statusChart'),{type:'doughnut',data:{labels:statusLabels,datasets:[{data:statusCounts,backgroundColor:['#4361ee','#f59f00','#2f9e44','#339af0','#e03131','#7048e8','#868e96','#f06595']}]},options:{plugins:{legend:{position:'bottom'}}}});
});
</script>
@endsection