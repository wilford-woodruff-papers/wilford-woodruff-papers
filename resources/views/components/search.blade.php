<div id="search">
    <div>
        <form action="{{ route('advanced-search') }}" id="search-form">
            <div class="flex mt-1 max-w-full shadow-sm">
                <div class="flex relative flex-grow items-stretch focus-within:z-10">
                    <input class="block pl-2 w-full rounded-none border-white sm:text-sm"
                           type="search"
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="Search..."
                           aria-label="Search website">
                    <input type="hidden" name="people" value="1" />
                    @foreach(\App\Models\Type::all() as $type)
                        <input type="hidden"
                               name="types[]"
                               type="checkbox"
                               value="{{ $type->id }}" />
                    @endforeach
                </div>
                <button class="inline-flex relative items-center py-2 px-4 -ml-px space-x-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-100 focus:ring-2 focus:outline-none">
                    <svg class="w-5 h-5 text-secondary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="sr-only">Search website</span>
                </button>
            </div>
        </form>
    </div>
</div>
