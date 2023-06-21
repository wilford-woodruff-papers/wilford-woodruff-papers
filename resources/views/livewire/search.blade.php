<div class="mx-auto max-w-7xl">
    <div>
        <p class="text-sm leading-5 text-gray-700">
            Showing
            <span class="font-medium">{{ $first }}</span>
            to
            <span class="font-medium">{{ $last }}</span>
            of
            <span class="font-medium">{{ $total }}</span>
            results
        </p>
    </div>

    <div>
        <label for="q" class="sr-only"></label>
        <input wire:model.debounce.250="q"
               type="search"
               id="q"
        />
    </div>
    <ul class="divide-y divide-gray-200">
        @foreach ($hits as $hit)
            <li class="grid grid-cols-7 py-4">

                    <div class="col-span-1 px-2">
                        <a class="col-span-1 my-2 mx-auto w-20 h-auto" href="{{ data_get($hit, '_formatted.url') }}">
                            <img src="{{ data_get($hit, '_formatted.thumbnail') }}"
                                 alt=""
                                 loading="lazy"
                            >
                        </a>
                    </div>
                    <div class="col-span-6 py-2 px-4">
                        <p class="pb-1 text-lg font-medium capitalize text-secondary">
                            <a href="{{ data_get($hit, '_formatted.url') }}">{!! data_get($hit, '_formatted.name') !!}</a>
                        </p>
                        <div class="flex gap-x-3 ml-2 text-base font-medium">
                            {{--<div>
                                <span class="text-gray-600">Part of </span>
                                <span class="text-secondary">
                                    <a href="{{ route('documents.show', ['item' => $page->item]) }}">{{ \Illuminate\Support\Str::of($page->item?->name)->replaceMatches('/\[.*?\]/', '')->trim() }}</a>
                                </span>
                            </div>--}}
                            <div>
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
                        {{--@if($page->item->type)
                            <p class="ml-2 text-base text-primary">{{ $page->item->type->name }}</p>
                        @endif--}}
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

                            <div class="mb-1 font-bold">
                                Excerpt:
                            </div>
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

            </li>
        @endforeach
    </ul>
    @push('styles')
        <style>
            em {
                background-color: #fff59d;
            }
        </style>
    @endpush
</div>
