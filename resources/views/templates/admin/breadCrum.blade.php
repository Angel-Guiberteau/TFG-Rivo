@if(!empty($breadcrumbs) && is_array($breadcrumbs))
    <div class="breadcrumb-wrapper pb-3 margin-custom rounded bg-light d-flex align-items-center small">
        @foreach($breadcrumbs as $index => $breadcrumb)
            @php
                $isLast = $index === count($breadcrumbs) - 1;
            @endphp

            @if($index > 0)
                <span class="breadcrumb-separator mx-2">/</span>
            @endif

            @if(!$isLast && isset($breadcrumb['url']))
                <a href="{{ $breadcrumb['url'] }}" class="breadcrumb-link text-decoration-none text-secondary">
                    {{ $breadcrumb['name'] }}
                </a>
            @else
                <span class="breadcrumb-current active text-decoration-underline text-dark fw-semibold">
                    {{ $breadcrumb['name'] }}
                </span>
            @endif
        @endforeach
    </div>
@endif
