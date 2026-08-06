@extends('layouts.public')
@section('title', 'FAQ')
@section('meta_description', 'Pertanyaan yang sering diajukan tentang layanan rental mobil dan wisata.')

@section('content')
@include('components.page-header', ['title' => 'FAQ'])
<div class="section">
    <div class="container" style="max-width:800px">
        <div class="accordion" id="faqAcc">
            @foreach ($faqs as $i => $f)
            <div class="accordion-item mb-2 border-0 card-rc">
                <h2 class="accordion-header">
                    <button class="accordion-button {{ $i ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#q{{ $i }}">
                        {{ $f->question }}
                    </button>
                </h2>
                <div id="q{{ $i }}" class="accordion-collapse collapse {{ $i===0?'show':'' }}" data-bs-parent="#faqAcc">
                    <div class="accordion-body text-muted small">{{ $f->answer }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection