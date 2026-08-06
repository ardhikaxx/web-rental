@extends('layouts.admin')
@section('title', 'Pengaturan')

@section('content')
<form method="post" action="{{ route('admin.settings.update') }}">
    @csrf
    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card card-grid">
                <div class="card-header bg-white fw-bold">Profil Perusahaan</div>
                <div class="card-body row g-3">
                    <div class="col-12"><label class="form-label">Nama Perusahaan</label><input type="text" name="company_name" value="{{ $settings['company_name'] ?? '' }}" class="form-control"></div>
                    <div class="col-12"><label class="form-label">Tagline</label><input type="text" name="tagline" value="{{ $settings['tagline'] ?? '' }}" class="form-control"></div>
                    <div class="col-12"><label class="form-label">Alamat</label><textarea name="address" class="form-control" rows="2">{{ $settings['address'] ?? '' }}</textarea></div>
                    <div class="col-md-4"><label class="form-label">Telepon</label><input type="text" name="phone" value="{{ $settings['phone'] ?? '' }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">WhatsApp</label><input type="text" name="whatsapp" value="{{ $settings['whatsapp'] ?? '' }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Email</label><input type="email" name="email" value="{{ $settings['email'] ?? '' }}" class="form-control"></div>
                    <div class="col-12"><label class="form-label">Jam Operasional</label><input type="text" name="working_hours" value="{{ $settings['working_hours'] ?? '' }}" class="form-control" placeholder="Senin-Minggu 08.00-20.00"></div>
                    <div class="col-6"><label class="form-label">Jam Buka</label><input type="text" name="open_time" value="{{ $settings['open_time'] ?? '' }}" class="form-control"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-grid">
                <div class="card-header bg-white fw-bold">Media Sosial</div>
                <div class="card-body row g-3">
                    <div class="col-md-6"><label class="form-label">Facebook</label><input type="text" name="facebook" value="{{ $settings['facebook'] ?? '' }}" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Instagram</label><input type="text" name="instagram" value="{{ $settings['instagram'] ?? '' }}" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">TikTok</label><input type="text" name="tiktok" value="{{ $settings['tiktok'] ?? '' }}" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">YouTube</label><input type="text" name="youtube" value="{{ $settings['youtube'] ?? '' }}" class="form-control"></div>
                </div>
            </div>
            <div class="card card-grid mt-3">
                <div class="card-header bg-white fw-bold">Rekening Bank 1</div>
                <div class="card-body row g-3">
                    <div class="col-md-4"><label class="form-label">Nama Bank</label><input type="text" name="bank_name" value="{{ $settings['bank_name'] ?? '' }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">No. Rekening</label><input type="text" name="bank_account" value="{{ $settings['bank_account'] ?? '' }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Atas Nama</label><input type="text" name="bank_holder" value="{{ $settings['bank_holder'] ?? '' }}" class="form-control"></div>
                </div>
            </div>
            <div class="card card-grid mt-3">
                <div class="card-header bg-white fw-bold">Rekening Bank 2</div>
                <div class="card-body row g-3">
                    <div class="col-md-4"><label class="form-label">Nama Bank</label><input type="text" name="bank2_name" value="{{ $settings['bank2_name'] ?? '' }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">No. Rekening</label><input type="text" name="bank2_account" value="{{ $settings['bank2_account'] ?? '' }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Atas Nama</label><input type="text" name="bank2_holder" value="{{ $settings['bank2_holder'] ?? '' }}" class="form-control"></div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-grid">
                <div class="card-header bg-white fw-bold">Peta Lokasi (Embed)</div>
                <div class="card-body"><textarea name="map_embed" class="form-control" rows="4" placeholder="Kode embed Google Maps">{{ $settings['map_embed'] ?? '' }}</textarea></div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-brand"><i class="fa-solid fa-save me-2"></i>Simpan Pengaturan</button>
    </div>
</form>
@endsection