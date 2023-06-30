@if ($total)
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
        {{-- Previous Page Link --}}
        @if ($page === 1)
            <span class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 text-gray-500 bg-white rounded-md border border-gray-300 cursor-default">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <button wire:click="$set('page', {{ $previous }})" rel="prev" class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 text-gray-700 bg-white rounded-md border border-gray-300 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-500 focus:border-blue-300 focus:ring focus:outline-none active:text-gray-700 active:bg-gray-100">
                {!! __('pagination.previous') !!}
            </button>
        @endif

        <span class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 text-gray-500 bg-white cursor-default">
            Page {{ $page }}
        </span>

        {{-- Next Page Link --}}
        @if ($page < $last)
            <button wire:click="$set('page', {{ $next }})" rel="next" class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 text-gray-700 bg-white rounded-md border border-gray-300 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-500 focus:border-blue-300 focus:ring focus:outline-none active:text-gray-700 active:bg-gray-100">
                {!! __('pagination.next') !!}
            </button>
        @else
            <span class="inline-flex relative items-center py-2 px-4 text-sm font-medium leading-5 text-gray-500 bg-white rounded-md border border-gray-300 cursor-default">
                {!! __('pagination.next') !!}
            </span>
        @endif
    </nav>
@endif
