@extends('layouts.public')
@section('title', 'Booking Online')
@section('meta_description', 'Sewa mobil & booking wisata secara online dengan mudah.')

@section('content')
@include('components.page-header', ['title' => 'Booking Online'])
<div class="section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card card-rc p-4">
                    <h5 class="fw-bold mb-4"><i class="fa-solid fa-calendar-check me-2 text-brand"></i>Form Pemesanan</h5>
                    <form method="post" action="{{ route('booking.store') }}" id="bookingForm">
                        @csrf
                        <input type="hidden" name="service_type" value="rental">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small">Nama Lengkap</label>
                                <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name ?? '') }}" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">No. HP/WhatsApp</label>
                                <input type="text" name="customer_phone" value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Email</label>
                                <input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()->email ?? '') }}" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small">Alamat</label>
                                <input type="text" name="address" value="{{ old('address', auth()->user()->address ?? '') }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Pilih Armada</label>
                                <select name="fleet_id" id="fleet_id" class="form-select" required>
                                    <option value="">-- Pilih Armada --</option>
                                    @foreach ($fleets as $fleet)
                                        <option value="{{ $fleet->id }}" data-price="{{ $fleet->daily_price }}" @selected($selectedFleet?->id == $fleet->id)>{{ $fleet->display_name }} ({{ $fleet->license_plate }} {{ $fleet->category?->name }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Layanan</label>
                                <select name="with_driver" class="form-select" id="with_driver">
                                    <option value="1">Dengan Sopir</option>
                                    <option value="0">Lepas Kunci</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Tanggal Sewa</label>
                                <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Tanggal Kembali</label>
                                <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Jemput</label>
                                <input type="text" name="pickup_location" value="{{ old('pickup_location') }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Tujuan Kembali</label>
                                <input type="text" name="dropoff_location" value="{{ old('dropoff_location') }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Kode Voucher (opsional)</label>
                                <input type="text" name="voucher_code" id="voucher_code" value="{{ old('voucher_code') }}" class="form-control" placeholder="mis: WELCOME10">
                            </div>
                            <div class="col-12">
                                <label class="form-label small">Catatan Khusus</label>
                                <textarea name="special_notes" class="form-control" rows="2">{{ old('special_notes') }}</textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="agree" value="1" required id="agree">
                                    <label class="form-check-label small" for="agree">Saya setuju dengan syarat & ketentuan sewa yang berlaku.</label>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light p-3 mt-4">
                            <div class="text-center">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="btnCheck"><i class="fa-solid fa-calculator me-1"></i>Hitung Estimasi Harga</button>
                            </div>
                            <div id="priceResult" class="mt-3 d-none">
                                <table class="table table-sm mb-0 small">
                                    <tr><td>Durasi Sewa</td><td class="text-end fw-bold" id="r_durasi">-</td></tr>
                                    <tr><td>Biaya Sewa (Base)</td><td class="text-end" id="r_base">-</td></tr>
                                    <tr><td>Biaya Sopir</td><td class="text-end" id="r_driver">-</td></tr>
                                    <tr><td>Biaya Tambahan</td><td class="text-end" id="r_extra">-</td></tr>
                                    <tr><td>Diskon Promo</td><td class="text-end text-success" id="r_discount">-</td></tr>
                                    <tr><td>Pajak (11%)</td><td class="text-end" id="r_tax">-</td></tr>
                                    <tr class="table-primary"><td class="fw-bold">Total</td><td class="text-end fw-bold fs-5" id="r_total">-</td></tr>
                                </table>
                            </div>
                        </div>

                        <button class="btn btn-brand w-100 mt-3 btn-lg"><i class="fa-solid fa-paper-plane me-2"></i>Kirim Pemesanan</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-rc p-4">
                    <h6 class="fw-bold">Keunggulan</h6>
                    <ul class="list-check small">
                        <li>Pengecekan ketersediaan otomatis</li>
                        <li>Kode booking unik & mudah dilacak</li>
                        <li>Pembayaran DP minimal 50%</li>
                        <li>Invoice & kuitansi PDF</li>
                        <li>Support 24 jam</li>
                    </ul>
                </div>
                <div class="card card-rc p-4 mt-3">
                    <h6 class="fw-bold">Butuh bantuan?</h6>
                    <a href="https://wa.me/{{ $site['whatsapp'] ?? '' }}" target="_blank" class="btn btn-wa w-100"><i class="fa-brands fa-whatsapp me-2"></i>Chat WhatsApp</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#btnCheck').on('click', function () {
        const data = {
            fleet_id: $('#fleet_id').val(),
            start_date: $('#start_date').val(),
            end_date: $('#end_date').val(),
            with_driver: $('#with_driver').val(),
            extra_cost: 0,
            voucher_code: $('#voucher_code').val(),
            _token: $('input[name="_token"]').val(),
        };
        if (!data.fleet_id || !data.start_date || !data.end_date) {
            alert('Pilih armada dan tanggal terlebih dahulu.');
            return;
        }
        $.post('{{ route('booking.check') }}', data, function (res) {
            const p = res.prices;
            $('#priceResult').removeClass('d-none');
            $('#r_durasi').text(p.duration_days + ' hari');
            $('#r_base').text(rupify(p.base_price));
            $('#r_driver').text(rupify(p.driver_fee));
            $('#r_extra').text(rupify(p.extra_cost));
            $('#r_discount').text(rupify(p.discount));
            $('#r_tax').text(rupify(p.tax));
            $('#r_total').text(rupify(p.total_price));
        }).fail(function (xhr) {
            alert(xhr.responseJSON?.message || 'Harga tidak dapat dihitung.');
        });
    });
    function rupify(v){ return 'Rp ' + Number(v).toLocaleString('id-ID'); }
</script>
@endsection