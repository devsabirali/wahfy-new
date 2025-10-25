{{-- resources/views/partials/pagination.blade.php --}}

@if ($items->count() > 0)
    <ul class="pagination justify-content-end mb-2">
        {{-- Previous Page Link --}}
        @if ($items->onFirstPage())
            <li class="page-item disabled" aria-disabled="true">
                <a class="page-link" href="javascript:void(0);" aria-label="Previous">
                    <i class="mdi mdi-chevron-left"></i> Previous
                </a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $items->previousPageUrl() }}" aria-label="Previous">
                    <i class="mdi mdi-chevron-left"></i> Previous
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($items->links()->elements as $element)
            {{-- Make "Three Dots" --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true">
                    <a class="page-link" href="javascript:void(0);">{{ $element }}</a>
                </li>
            @endif

            {{-- Array of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $items->currentPage())
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="javascript:void(0);">{{ $page }}</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($items->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $items->nextPageUrl() }}" aria-label="Next">
                    Next <i class="mdi mdi-chevron-right"></i>
                </a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true">
                <a class="page-link" href="javascript:void(0);" aria-label="Next">
                    Next <i class="mdi mdi-chevron-right"></i>
                </a>
            </li>
        @endif
    </ul>
@endif
