<li class="py-4 grid grid-cols-7">
    <div class="col-span-1 px-2">
        <a class="col-span-1 h-auto w-20 my-2 mx-auto" href="{{ route('pages.show', ['item' => $page->item, 'page' => $page]) }}">
            <img src="{{ optional($page->getFirstMedia())->getUrl('thumb') }}" alt="">
        </a>
    </div>
    <div class="col-span-6 py-2 px-4">
        <p class="text-lg font-medium text-secondary pb-1 capitalize">
            <a href="{{ route('pages.show', ['item' => $page->parent, 'page' => $page]) }}">Page {{ $page->order }}</a>
        </p>
        <p class="text-base font-medium ml-2">
            <span class="text-gray-600">Part of </span>
            <span class="text-secondary">
                <a href="{{ route('documents.show', ['item' => $page->parent]) }}">{{ $page->parent->name }}</a>
            </span>
        </p>
        {{--@if($page->item->type)
            <p class="text-base text-primary ml-2">{{ $page->item->type->name }}</p>
        @endif--}}
        <div class="text-sm text-gray-500 px-4 py-2">
            @php
                $description = '';
                if(! empty( request('q'))){
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
                <div class="mt-3 grid grid-cols-12">
                    <div class="col-span-1 font-bold">
                        Dates:
                    </div>
                    <div class="col-span-11">
                        <div class="grid grid-cols-4 gap-1">
                            {!! $page->dates->sortBy('date')->map(function($date){
                                return '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">'
                                            . $date->date->format('F j, Y')
                                        . '</span>';
                            })->join(" ") !!}
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @if(auth()->check() && auth()->user()->hasRole('Super Admin'))
            <div class="ml-3">
                <p class="text-sm text-gray-900">Real name: {{ $page->name }}</p>
                <p class="text-sm text-gray-900">Item: {{ $page->item->name }}</p>
                @if($page->dates->count() > 0)
                    <p class="">Dates: {{ $page->dates->map(function($date){
                        return '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">'
                                    . $date->date->format('F j, Y')
                                . '</span>';
                    })->join(" ") }}</p>
                @endif
            </div>
        @endif
    </div>
</li>
