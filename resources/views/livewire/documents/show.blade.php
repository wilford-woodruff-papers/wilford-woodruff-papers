<div>
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
                                    {{ $item->type->name }}
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
                            @foreach($item->items->sortBy('order') as $section)
                                <div class="value">
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
                                           placeholder="Search">
                                </div>
                            </div>
                        </form>
                    </div>

                    <ul class="divide-y divide-gray-200">

                        @foreach($pages as $page)

                            <x-page-summary :page="$page" />

                        @endforeach

                    </ul>
                    <div class="my-4 px-8">
                        {!! $pages->links() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
