<div class="mt-8 w-full">
    <div class="grid grid-cols-4 gap-x-2">
        <div class="col-span-1">
            <div>
                <div class="flex flex-col gap-y-5 bg-white border-r border-gray-200 grow">
                    @include('search.filters', ['location' => 'left'])
                </div>
            </div>
        </div>
        <div class="col-span-3 py-4">
            <div class="flex gap-x-4">
                <div class="flex-1 min-w-0">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input wire:model.live.debounce.400="q"
                               type="search"
                               name="search"
                               id="search"
                               class="block py-1.5 pl-10 w-full border-0 ring-1 ring-inset ring-gray-300 sm:text-lg sm:leading-10 focus:ring-2 focus:ring-inset placeholder:text-gray-400 focus:ring-secondary"
                               placeholder="Search" />
                    </div>
                </div>
            </div>
            <div>
                @if(count($hits) > 0)
                    <ul wire:loading.remove
                        class="divide-y divide-gray-200">

                        @foreach ($hits as $hit)
                            <a class="col-span-1 my-2 mx-auto w-20 h-auto group"
                               href="{{ data_get($hit, '_formatted.url') }}"
                               target="{{ (str(data_get($hit, '_formatted.url'))->contains(config('app.url')) ? '_self' : '_blank') }}"
                            >
                                <li class="grid grid-cols-7 py-4 group-focus:bg-gray-100 hover:bg-gray-100">

                                    <div class="col-span-3 px-2 sm:col-span-1">
                                        <div class="col-span-1 my-2 mx-auto w-20 h-auto">
                                            @if(! empty(data_get($hit, '_formatted.thumbnail')))
                                                <img src="{{ data_get($hit, '_formatted.thumbnail') }}"
                                                     alt=""
                                                     loading="lazy"
                                                >
                                            @else
                                                <div class="flex justify-center items-center w-full text-white bg-gray-400 aspect-[16/9]">
                                                    @if(in_array(data_get($hit, 'resource_type'), ['Media']))
                                                        @includeFirst(['search.'.str(data_get($hit, 'type'))->snake(), 'search.generic'])
                                                    @else
                                                        @includeFirst(['search.'.str(data_get($hit, 'resource_type'))->snake(), 'search.generic'])
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-span-4 py-2 px-4 sm:col-span-6">
                                        <div class="flex gap-x-3 text-base font-medium">
                                            <div class="pb-2">
                                                @auth()
                                                    @hasanyrole('CFM Researcher')
                                                    <div>
                                                        @if(data_get($hit, '_formatted.is_published'))
                                                            <span class="inline-flex items-center py-0.5 px-2.5 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                                                    {{ __('Published') }}
                                                </span>
                                                        @else
                                                            <span class="inline-flex items-center py-0.5 px-2.5 text-xs font-medium text-red-800 bg-red-100 rounded-full">
                                                    {{ __('Not Published') }}
                                                </span>
                                                        @endif
                                                    </div>
                                                    @endhasanyrole
                                                @endauth
                                            </div>
                                        </div>
                                        <div class="flex gap-x-2 items-center pb-1">
                                            @if(in_array(data_get($hit, 'resource_type'), ['Media']))
                                                @includeFirst(['search.'.str(data_get($hit, 'type'))->snake(), 'search.generic'])
                                            @else
                                                @includeFirst(['search.'.str(data_get($hit, 'resource_type'))->snake(), 'search.generic'])
                                            @endif
                                            <span class="text-lg font-medium capitalize text-secondary">
                                            {!! str(data_get($hit, '_formatted.name'))->remove('[[')->remove(']]') !!}
                                        </span>
                                        </div>

                                        {{--@if($page->item->type)
                                            <p class="ml-2 text-base text-primary">{{ $page->item->type->name }}</p>
                                        @endif--}}
                                        @if(! empty($author = data_get($hit, 'author')))
                                            <div class="mt-1 -mb-3 text-sm font-semibold leading-6 text-gray-600">
                                                Quote by {!! $author !!}:
                                            </div>
                                        @endif
                                        <div class="py-2 px-4 font-serif text-sm text-gray-500">
                                            {{--@php
                                                $description = '';
                                                if(! empty( request('q')) && request('q') != '*'){
                                                    preg_match_all('~(?:[\p{L}\p{N}\']+[^\p{L}\p{N}\']+){0,10}'.request('q').'(?:[^\p{L}\p{N}\']+[\p{L}\p{N}\']+){0,10}~ui', str_replace(['[[', ']]'], '', strip_tags( $page->transcript ) ),$matches);
                                                    foreach ($matches[0] as $match) {
                                                        $description .= '<div>...' . str_highlight($match, request('q'), STR_HIGHLIGHT_SIMPLE, '<span class="bg-yellow-100">\1</span>') . '...</div>';
                                                    }

                                                }else {
                                                    $description = (strlen($page->text()) > 0) ? get_snippet($page->text(), 100) . ((get_word_count($page->text()) > 100)?' ...':'') : '';
                                                    $description = str_replace(['[[', ']]'], '', strip_tags( $description ) );
                                                }
                                            @endphp

                                            @if(! empty($description))
                                                <div class="mb-1 font-bold">
                                                    Excerpt:
                                                </div>
                                                {!! $description !!}
                                            @endif--}}

                                            <div class="line-clamp-3">
                                                {!! str(data_get($hit, '_formatted.description'))->remove('[[')->remove(']]') !!}
                                            </div>



                                            {{--{!! Str::of( strip_tags( $page->text() ) )->words(50) !!}--}}
                                            {{--@if($page->dates->count() > 0)
                                                <div class="grid grid-cols-12 mt-3">
                                                    <div class="col-span-1 font-bold">
                                                        Dates:
                                                    </div>
                                                    <div class="col-span-11">
                                                        <div class="grid grid-cols-4 gap-1">
                                                            {!! $page->dates->sortBy('date')->map(function($date){
                                                                return '<span class="inline-flex items-center py-0.5 px-2 text-xs font-medium text-gray-800 bg-gray-100 rounded">'
                                                                            . $date->date->format('F j, Y')
                                                                        . '</span>';
                                                            })->join(" ") !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif--}}
                                        </div>
                                    </div>
                                    @hasanyrole('Admin|Super Admin')
                                    @if(! empty($q))
                                        <div class="col-span-7 px-4 mt-5 text-sm leading-6 text-gray-600 line-clamp-3">
                                            Ranking Score: {{ number_format(data_get($hit, '_rankingScore'), 2) }}
                                        </div>
                                    @endif
                                    @endhasanyrole
                                </li>
                            </a>
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
                        @include('meilisearch.pagination.simple-tailwind', ['location' => 'bottom'])
                    </div>
                @endif
            </div>
        </div>
    </div>
    @push('styles')
        <style>
            em {
                background-color: #fff59d;
            }
        </style>
    @endpush
</div>
