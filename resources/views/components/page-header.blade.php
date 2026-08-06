<section class="page-header py-5">
    <div class="container">
        <h1 class="fw-bold mb-1">{{ $title }}</h1>
        <nav aria-label="breadcrumb" class="small">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                @if(isset($parent) && $parent['link'])
                    <li class="breadcrumb-item"><a href="{{ $parent['link'] }}" class="text-white-50 text-decoration-none">{{ $parent['label'] }}</a></li>
                @endif
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
</section>