@if ($paginator->hasPages())
    <nav role="navigation" class="w-100 d-flex justify-content-end align-items-center" aria-label="Pagination Navigation">
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        {{$page}}
                    @endif
                @endforeach
            @endif
        @endforeach
        <ul class="pagination m-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="paginatorElement disabled" aria-disabled="true" style="filter: grayscale(100%);">
                    <img style="width:30px; height:30px;" src="{{ asset('media/ico/left.ico') }}" alt="prevButton">
                </li>
            @else
                <li class="paginatorElement">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <img style="width:30px; height:30px;" src="{{ asset('media/ico/left.ico') }}" alt="prevButton">
                    </a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="paginatorElement">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <img style="width:30px; height:30px;" src="{{ asset('media/ico/right.ico') }}" alt="nextButton">
                    </a>
                </li>
            @else
                <li class="paginatorElement disabled" aria-disabled="true" style="filter: grayscale(100%);">
                    <img style="width:30px; height:30px;" src="{{ asset('media/ico/right.ico') }}" alt="nextButton">
                </li>
            @endif
        </ul>
    </nav>
@endif
