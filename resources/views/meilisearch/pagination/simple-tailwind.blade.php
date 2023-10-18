@if ($total)
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
        {{-- Previous Page Link --}}
        @if ($page === 1)
            <span class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 cursor-default">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <button wire:click="$set('page', {{ $previous }})" rel="prev" class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 text-white border transition duration-150 ease-in-out hover:text-gray-200 focus:ring focus:outline-none active:text-white bg-secondary-700 border-secondary-300 ring-secondary focus:border-secondary-300 active:bg-secondary-800">
                {!! __('pagination.previous') !!}
            </button>
        @endif

        <div class="flex items-center">
            <span class="inline-flex relative items-center py-2 px-1 text-sm font-medium leading-5 text-gray-500 bg-white cursor-default">
                Page
            </span>
            <span class="inline-flex relative items-center py-2 text-sm font-medium leading-5 text-gray-500 bg-white cursor-default">
                {{ $page }}
            </span>
            <span class="inline-flex relative items-center py-2 px-1 text-sm font-medium leading-5 text-gray-500 bg-white cursor-default">
                of
            </span>
            <span class="inline-flex relative items-center py-2 text-sm font-medium leading-5 text-gray-500 bg-white cursor-default">
                {{ number_format($totalPages, 0, '.', ',') }}
            </span>
        </div>


        {{-- Next Page Link --}}
        @if ($page < $last)
            <button wire:click="$set('page', {{ $next }})" rel="next" class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 text-white border transition duration-150 ease-in-out hover:text-gray-200 focus:ring focus:outline-none active:text-white bg-secondary-700 border-secondary-300 ring-secondary focus:border-secondary-300 active:bg-secondary-800">
                {!! __('pagination.next') !!}
            </button>
        @else
            <span class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 cursor-default">
                {!! __('pagination.next') !!}
            </span>
        @endif
    </nav>
@endif
