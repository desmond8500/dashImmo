<div class="page-header d-print-none mb-3 mt-0">
    <div class="row g-2 align-items-center">
        <div class="col">
            @if (! empty($subtitle))
                <div class="page-pretitle">{{ $subtitle }}</div>
            @endif
            <h2 class="page-title">{{ $title ?? '' }}</h2>
        </div>
        @if (trim($slot ?? ''))
            <div class="col-12 col-md-auto ms-auto">
                <div class="btn-list">
                    {{ $slot }}
                </div>
            </div>
        @endif
    </div>
</div>
