<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title"> {{ end($breadcrumbs)['label'] ?? '' }}</h1>
    <div>
        <ol class="breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
                <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                    @if (!empty($breadcrumb['url']) && !$loop->last)
                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                    @else
                        {{ $breadcrumb['label'] }}
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</div>
