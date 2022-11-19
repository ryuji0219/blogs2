<!--もしPageがあったら。-->
@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">
    {{-- First Page View --}} 
            <li class="page-item {{ $paginator->onFirstPage() ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->url(1) }}">&laquo;</a>
            </li>

        {{-- Previous Page Link --}}
<!--ペジネータが最初のページを扱っているか判定 -->
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span aria-hidden="true">&lsaquo;</span>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}

<!--複数ページへアイテムを分割できる数があるか判定 -->
        @if ($paginator->hasMorePages())
            <li>
<!--次ページのURL取得 -->
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
            </li>
        @else
            <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span aria-hidden="true">&rsaquo;</span>
            </li>
        @endif
        <li class="page-item {{ $paginator->currentPage() == $paginator->lastPage() ? ' disabled' : '' }}">
        <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">&raquo;</a>
        </li>
    </ul>
@endif