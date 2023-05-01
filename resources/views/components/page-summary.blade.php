<li class="grid grid-cols-7 py-4">
    <div class="col-span-1 px-2">
        <a class="col-span-1 my-2 mx-auto w-20 h-auto" href="{{ route('pages.show', ['item' => $page->item, 'page' => $page]) }}">
            <img src="{{ $page->getFirstMedia()?->getUrl('thumb') }}"
                 alt=""
                 loading="lazy"
            >
        </a>
    </div>
    <div class="col-span-6 py-2 px-4">
        <p class="pb-1 text-lg font-medium capitalize text-secondary">
            <a href="{{ route('pages.show', ['item' => $page->parent, 'page' => $page]) }}">Page {{ $page->order }}</a>
        </p>
        <div class="flex gap-x-3 ml-2 text-base font-medium">
            <div>
                <span class="text-gray-600">Part of </span>
                <span class="text-secondary">
                    <a href="{{ route('documents.show', ['item' => $page->parent]) }}">{{ \Illuminate\Support\Str::of($page->parent?->name)->replaceMatches('/\[.*?\]/', '')->trim() }}</a>
                </span>
            </div>
            <div>
                @auth()
                    @hasanyrole('CFM Researcher')
                        <div>
                            @if($page->parent?->enabled)
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
            @php
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
            @endif

            {{--{!! Str::of( strip_tags( $page->text() ) )->words(50) !!}--}}
            @if($page->dates->count() > 0)
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
            @endif
        </div>
        @hasanyrole('Editor|Admin|Super Admin')
            <div class="ml-3">
                <p class="text-sm text-gray-900">Real name: {{ $page->name }}</p>
                <p class="text-sm text-gray-900">Item: {{ $page->item->name }}</p>
                @if($page->quotes_count > 0)
                    <p class="text-sm text-gray-900">Quotes: {{ $page->quotes_count }}</p>
                @endif
            </div>
        @endhasanyrole
    </div>
</li>
