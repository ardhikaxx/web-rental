@extends('layouts.admin')
@section('title', $testimonial->exists ? 'Edit Testimoni' : 'Tambah Testimoni')

@section('content')
<form method="post" action="{{ $testimonial->exists ? route('admin.cms.testimonials.update', $testimonial) : route('admin.cms.testimonials.store') }}" enctype="multipart/form-data">
    @csrf
    @if($testimonial->exists) @method('put') @endif
    <div class="card card-grid">
        <div class="card-header bg-white fw-bold">Detail Testimoni</div>
        <div class="card-body row g-3">
            <div class="col-md-4"><label class="form-label">Nama</label><input type="text" name="customer_name" value="{{ old('customer_name', $testimonial->customer_name) }}" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Perusahaan</label><input type="text" name="company" value="{{ old('company', $testimonial->company) }}" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Tipe Layanan</label><input type="text" name="service_type" value="{{ old('service_type', $testimonial->service_type) }}" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Rating</label>
                <select name="rating" class="form-select">
                    @for ($i=1;$i<=5;$i++)<option value="{{ $i }}" @selected($testimonial->rating==$i)>{{ $i }} bintang</option>@endfor
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">Aktif</label><select name="is_active" class="form-select"><option value="1" @selected($testimonial->is_active)>Ya</option><option value="0" @selected(!$testimonial->is_active)>Tidak</option></select></div>
            <div class="col-12"><label class="form-label">Konten</label><textarea name="content" class="form-control" rows="4">{{ old('content', $testimonial->content) }}</textarea></div>
            <div class="col-12"><label class="form-label">Foto</label>
                @if($testimonial->photo)<img src="{{ asset('storage/' . $testimonial->photo) }}" class="d-block mb-2 rounded-circle" style="width:70px;height:70px;object-fit:cover" alt="">@endif
                <input type="file" name="photo" accept="image/*" class="form-control">
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-brand"><i class="fa-solid fa-save me-2"></i>Simpan</button>
        <a href="{{ route('admin.cms.testimonials') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection