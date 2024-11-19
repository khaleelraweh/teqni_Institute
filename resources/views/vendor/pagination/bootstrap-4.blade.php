@if ($paginator->hasPages())
    <!-- Pagination Start -->
    <div class="pagination-main hidden-xs hiddens-sm">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!-- Previous Page Link -->
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <a class="page-link" href="#">
                            <i class="fa fa-angle-right"></i> {{ __('transf.previous') }}
                        </a>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                            <i class="fa fa-angle-right"></i> {{ __('transf.previous') }}
                        </a>
                    </li>
                @endif

                <!-- Pagination Elements -->
                @foreach ($elements as $element)
                    <!-- "Three Dots" Separator -->
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span
                                class="page-link">{{ $element }}</span></li>
                    @endif

                    <!-- Array Of Links -->
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span
                                        class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link"
                                        href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                <!-- Next Page Link -->
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                            {{ __('transf.next') }} <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <a class="page-link" href="#">
                            {{ __('transf.next') }} <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    <!-- Pagination End -->
@endif
