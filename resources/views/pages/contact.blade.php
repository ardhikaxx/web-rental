@extends('layouts.public')
@section('title', 'Kontak')
@section('meta_description', 'Hubungi kami untuk info rental mobil, wisata dan travel.')

@section('content')
@include('components.page-header', ['title' => 'Kontak'])
<div class="section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card card-rc p-4 h-100">
                    <h5 class="fw-bold mb-3">Info Kontak</h5>
                    <ul class="list-unstyled">
                        <li class="d-flex gap-3 mb-3"><i class="fa-solid fa-location-dot text-brand"></i><div>{{ $site['address'] ?? '' }}<br><small class="text-muted">{{ $site['working_hours'] ?? '' }}</small></div></li>
                        <li class="d-flex gap-3 mb-3"><i class="fa-solid fa-phone text-brand"></i><div>{{ $site['phone'] ?? '' }}</div></li>
                        <li class="d-flex gap-3 mb-3"><i class="fa-solid fa-envelope text-brand"></i><div>{{ $site['email'] ?? '' }}</div></li>
                        <li class="d-flex gap-3"><i class="fa-brands fa-whatsapp text-brand"></i><div><a href="https://wa.me/{{ $site['whatsapp'] ?? '' }}" target="_blank" class="text-decoration-none text-dark">{{ $site['whatsapp'] ?? '' }}</a></div></li>
                    </ul>
                    <hr>
                    <h6 class="fw-bold">Rekening Pembayaran</h6>
                    <ul class="list-unstyled small text-muted">
                        <li><strong>{{ $site['bank_name'] ?? '' }}</strong> &ndash; {{ $site['bank_account'] ?? '' }} a.n {{ $site['bank_holder'] ?? '' }}</li>
                        @if(!empty($site['bank2_name']))<li class="mt-2"><strong>{{ $site['bank2_name'] }}</strong> &ndash; {{ $site['bank2_account'] }} a.n {{ $site['bank2_holder'] }}</li>@endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card card-rc p-4">
                    <h5 class="fw-bold mb-3">Kirim Pesan</h5>
                    <form method="post" action="{{ route('contact.send') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label small">Nama</label><input type="text" name="name" class="form-control" required></div>
                            <div class="col-md-6"><label class="form-label small">Email</label><input type="email" name="email" class="form-control" required></div>
                            <div class="col-md-6"><label class="form-label small">No HP</label><input type="text" name="phone" class="form-control" required></div>
                            <div class="col-md-6"><label class="form-label small">Subjek</label><input type="text" name="subject" class="form-control" required></div>
                            <div class="col-12"><label class="form-label small">Pesan</label><textarea name="message" rows="4" class="form-control" required></textarea></div>
                            <div class="col-12"><button class="btn btn-brand"><i class="fa-solid fa-paper-plane me-2"></i>Kirim</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
    </div>
</div>
@endsection