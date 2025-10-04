{{-- resources/views/pagination/admin-simple.blade.php --}}

@if ($paginator->hasPages())
    {{-- MENGHAPUS TAG NAV DAN ATRIBUT YANG BERMASALAH --}}
    <div class="pagination-nav">
        
        <div class="pagination-summary">
            {{ __('Menampilkan') }}
            @if ($paginator->firstItem())
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                {{ __('sampai') }}
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
            @else
                {{ $paginator->count() }}
            @endif
            {{ __('dari') }}
            <span class="font-medium">{{ $paginator->total() }}</span>
            {{ __('hasil') }}
        </div>
        
        <div class="pagination-links">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="pagination-link disabled" aria-disabled="true">
                    &laquo; {{ __('Previous') }}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-link">
                    &laquo; {{ __('Previous') }}
                </a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-link">
                    {{ __('Next') }} &raquo;
                </a>
            @else
                <span class="pagination-link disabled" aria-disabled="true">
                    {{ __('Next') }} &raquo;
                </span>
            @endif
        </div>
    </div>
@endif