<!-- BREADCRUMBS SECTION START -->
<section class="ul-breadcrumb ul-section-spacing">
    <div class="ul-container">
        <h2 class="ul-breadcrumb-title">{{ $title ?? '' }}</h2>
        <ul class="ul-breadcrumb-nav">
            @isset($items)
                @foreach($items as $index => $item)
                    @if(isset($item['url']))
                        <li><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                    @else
                        <li>{{ $item['label'] }}</li>
                    @endif
                    @if($index < count($items) - 1)
                        <li><span class="separator"><i class="flaticon-right"></i></span></li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
</section>
<!-- BREADCRUMBS SECTION END -->