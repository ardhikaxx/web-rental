@extends('layouts.admin')
@section('title', $faq->exists ? 'Edit FAQ' : 'Tambah FAQ')

@section('content')
<form method="post" action="{{ $faq->exists ? route('admin.cms.faqs.update', $faq) : route('admin.cms.faqs.store') }}">
    @csrf
    @if($faq->exists) @method('put') @endif
    <div class="card card-grid" style="max-width:640px">
        <div class="card-header bg-white fw-bold">Detail FAQ</div>
        <div class="card-body row g-3">
            <div class="col-md-4"><label class="form-label">Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order', $faq->sort_order) }}" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Aktif</label><select name="is_active" class="form-select"><option value="1" @selected($faq->is_active)>Ya</option><option value="0" @selected(!$faq->is_active)>Tidak</option></select></div>
            <div class="col-12"><label class="form-label">Pertanyaan</label><input type="text" name="question" value="{{ old('question', $faq->question) }}" class="form-control" required></div>
            <div class="col-12"><label class="form-label">Jawaban</label><textarea name="answer" class="form-control" rows="4">{{ old('answer', $faq->answer) }}</textarea></div>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-brand"><i class="fa-solid fa-save me-2"></i>Simpan</button>
        <a href="{{ route('admin.cms.faqs') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection