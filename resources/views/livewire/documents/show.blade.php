<div>
    <x-slot name="title">
        {{ $item->parent()?->name }} | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">

        <div class="px-4 my-12 mx-auto max-w-7xl lg:px-0">
            <div class="my-4 text-4xl font-semibold border-b-2 border-gray-300 text-primary">
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
                    @hasanyrole('Editor|Admin|Super Admin')
                        <div class="flex gap-x-4 items-center my-4">
                            <button type="button"
                                    title="Copy Short URL"
                                    data-url="{{ route('short-url.item', ['hashid' => $item->hashid()]) }}"
                                    onclick="copyShortUrlToClipboard(this)"
                                    class="inline-flex items-center p-1 border border-transparent shadow-sm text-white bg-secondary hover:bg-secondary-80% focus:outline-none focus:ring-2 focus:ring-offset-2">
                                <!-- Heroicon name: outline/clipboard-copy -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                            </button>
                        </div>
                    @endhasanyrole
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
                    @if(! empty($sourceNotes) || ! empty($sourceLink))
                        <div class="my-4 property">
                            <h4>
                                Document Source
                            </h4>
                            <div class="values">
                                @if(! empty($sourceNotes))
                                    <div>
                                        {!! $sourceNotes->value !!}
                                    </div>
                                @endif
                                @if(! empty($sourceLink))
                                    <div>
                                        <a href="{{ $sourceLink->value }}" target="_blank" class="text-secondary">
                                            {{ str($sourceLink->value)->before('?') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    @hasanyrole('Editor|Admin|Super Admin')
                        @if(! empty($item->count() > 0))
                            <div class="property">
                                <h4>Sections ({{ $item->items->count() }})</h4>
                                @if(! empty($filters['section']))
                                    <div wire:click="$set('filters.section', null)"
                                         class="flex justify-between items-center py-1 px-2 my-2 mr-6 text-black bg-gray-200 cursor-pointer"
                                    >
                                        Clear Section Selection
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </div>
                                @endif
                                @foreach($item->items->sortBy('order') as $section)
                                    <div wire:click="$set('filters.section', {{ $section->id }})"
                                         class="cursor-pointer value text-secondary">
                                        {{ $section->name }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endhasanyrole
                    @if($subjects->count() > 0)
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
                    @if($topics->count() > 0)
                        <div class="property">
                            <h4>
                                Topics
                            </h4>
                            <div class="values">
                                @foreach($topics->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE) as $topic)
                                    <div class="value" lang="">
                                        <a class="text-secondary"
                                           href="{{ route('subjects.show', ['subject' => $topic]) }}">
                                            {{ $topic->name }}
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
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none" aria-hidden="true">
                                        <svg class="mr-3 w-4 h-4 text-gray-400" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.defer="filters.search"
                                           type="search"
                                           name="search"
                                           id="search"
                                           class="block pl-9 w-full border-gray-300 sm:text-sm focus:ring-secondary focus:border-secondary"
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
                        class="px-4 divide-y divide-gray-200">
                        @foreach([1, 2, 3, 4, 5] as $placeholder)
                            <li class="grid grid-cols-7 py-4">
                                <div class="col-span-1 pl-4">
                                    <div data-placeholder class="overflow-hidden relative my-2 mr-2 w-20 h-20 bg-gray-200">

                                    </div>
                                </div>
                                <div class="col-span-6 py-2 pl-4">
                                    <div class="flex flex-col justify-between">
                                        <div data-placeholder class="overflow-hidden relative mb-2 w-40 h-8 bg-gray-200">

                                        </div>
                                        <div data-placeholder class="overflow-hidden relative w-40 h-6 bg-gray-200">

                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div wire:loading.remove
                         class="px-8 my-4">
                        {!! $pages->links() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
