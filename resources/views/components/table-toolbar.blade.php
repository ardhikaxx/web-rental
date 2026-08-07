@props([
    'title' => '',
    'placeholder' => 'Cari…',
    'searchable' => true,
    'filter' => false,
    'addUrl' => null,
    'addLabel' => 'Tambah',
    'addTitle' => 'Tambah Data',
])
<div class="card-header card-toolbar bg-white border-bottom-0 py-3">
    <div class="d-flex flex-wrap align-items-center gap-2">
        @if ($title)
            <h6 class="fw-bold mb-0">{{ $title }}</h6>
        @endif
        <div class="ms-auto d-flex flex-wrap align-items-center gap-2">
            <form method="get" action="" class="d-flex flex-wrap align-items-center gap-2">
                @if ($searchable)
                <div class="input-group input-group-sm" style="width:230px">
                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0" placeholder="{{ $placeholder }}">
                </div>
                @endif
                {{ $slot }}
                @if ($filter)
                <button class="btn btn-sm btn-light border"><i class="fa-solid fa-filter me-1"></i>Filter</button>
                @endif
            </form>
            @if ($addUrl)
            <a href="{{ $addUrl }}" class="btn btn-brand btn-sm" title="{{ $addLabel }}"><i class="fa-solid fa-plus me-1"></i>{{ $addLabel }}</a>
            @endif
        </div>
    </div>
</div>