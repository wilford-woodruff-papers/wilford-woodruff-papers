<div>
    <x-slot name="title">
        {{ $item->parent()?->name }} | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">

        <div class="max-w-7xl mx-auto my-12 px-4 lg:px-0">
            <div class="text-4xl text-primary font-semibold my-4 border-b-2 border-gray-300">
                <h2>
                    <span class="title">
                        {{ \Illuminate\Support\Str::of($item->name)->replaceMatches('/\[.*?\]/', '')->trim() }}
                    </span>
                </h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-12">
                <div class="col-span-1 md:col-span-4">
                    <div class="property">
                        <h4>
                            Title
                        </h4>
                        <div class="values">
                            <div class="value" lang="">
                                {{ \Illuminate\Support\Str::of($item->name)->replaceMatches('/\[.*?\]/', '')->trim() }}
                            </div>
                        </div>
                    </div>
                    @if($item->type)
                        <div class="property">
                            <h4>Document Type</h4>
                            <div class="value">
                                <a href="{{ route('documents', ['type' => $item->type]) }}">
                                    {{ str($item->type->name)->singular() }}
                                </a>
                            </div>
                            <div class="my-8">
                                <x-links.primary
                                    href="{{ route('documents.show.transcript', ['item' => $item->uuid]) }}"
                                    target="_blank"
                                >
                                    View Full Transcript
                                </x-links.primary>
                            </div>
                        </div>
                    @endif
                    @hasanyrole('Editor|Admin|Super Admin')
                        @if(! empty($item->count() > 0))
                            <div class="property">
                                <h4>Sections ({{ $item->items->count() }})</h4>
                                @if(! empty($filters['section']))
                                    <div wire:click="$set('filters.section', null)"
                                         class="bg-gray-200 text-black flex justify-between items-center cursor-pointer px-2 py-1 mr-6 my-2"
                                    >
                                        Clear Section Selection
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </div>
                                @endif
                                @foreach($item->items->sortBy('order') as $section)
                                    <div wire:click="$set('filters.section', {{ $section->id }})"
                                         class="value text-secondary cursor-pointer">
                                        {{ $section->name }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endhasanyrole
                    @if($subjects)
                        <div class="property">
                            <h4>
                                People & Places
                            </h4>
                            <div class="values">
                                @foreach($subjects->sortBy('name') as $subject)
                                    <div class="value" lang="">
                                        <a class="text-secondary"
                                           href="{{ route('subjects.show', ['subject' => $subject]) }}">
                                            {{ $subject->name }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
                <div class="col-span-1 md:col-span-8">
                    <div>
                        <form wire:submit.prevent="submit">
                            <div class="pl-3">
                                <label for="search" class="sr-only">Search term</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none" aria-hidden="true">
                                        <svg class="mr-3 h-4 w-4 text-gray-400" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.defer="filters.search"
                                           type="search"
                                           name="search"
                                           id="search"
                                           class="focus:ring-secondary focus:border-secondary block w-full pl-9 sm:text-sm border-gray-300"
                                           placeholder="Search page content">
                                </div>
                            </div>
                        </form>
                    </div>

                    <ul wire:loading.remove
                        class="divide-y divide-gray-200">

                        @foreach($pages as $page)

                            <x-page-summary :page="$page" />

                        @endforeach

                    </ul>
                    <ul wire:loading
                        class="divide-y divide-gray-200 px-4">
                        @foreach([1, 2, 3, 4, 5] as $placeholder)
                            <li class="py-4 grid grid-cols-7">
                                <div class="col-span-1 pl-4">
                                    <div data-placeholder class="mr-2 my-2 h-20 w-20 overflow-hidden relative bg-gray-200">

                                    </div>
                                </div>
                                <div class="col-span-6 py-2 pl-4">
                                    <div class="flex flex-col justify-between">
                                        <div data-placeholder class="mb-2 h-8 w-40 overflow-hidden relative bg-gray-200">

                                        </div>
                                        <div data-placeholder class="h-6 w-40 overflow-hidden relative bg-gray-200">

                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div wire:loading.remove
                         class="my-4 px-8">
                        {!! $pages->links() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
