<li class="grid grid-cols-7 py-4">
    <div class="col-span-1 px-2">
        <a class="col-span-1 my-2 mx-auto w-20 h-auto" href="{{ route('pages.show', ['item' => $quote->page->item, 'page' => $quote->page]) }}">
            <img src="{{ $quote->page->getFirstMedia()?->getUrl('thumb') }}"
                 alt=""
                 loading="lazy"
            >
        </a>
    </div>
    <div class="col-span-6 py-2 px-4">
        <p class="pb-1 text-lg font-medium capitalize text-secondary">
            <a href="{{ route('pages.show', ['item' => $quote->page->item, 'page' => $quote->page]) }}">Page {{ $quote->page->order }}</a>
        </p>
        <div class="flex gap-x-3 ml-2 text-base font-medium">
            <div>
                <span class="text-gray-600">Part of </span>
                <span class="text-secondary">
                    <a href="{{ route('documents.show', ['item' => $quote->page->item]) }}">{{ \Illuminate\Support\Str::of($quote->page->item?->name)->replaceMatches('/\[.*?\]/', '')->trim() }}</a>
                </span>
            </div>
            <div>
                @auth()
                    @hasanyrole('CFM Researcher')
                    <div>
                        @if($quote->page->item?->enabled)
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
            @if(! empty($quote->text))
                <div class="flex gap-x-4 mt-4 text-base text-gray-800 lg:text-lg">
                    <div class="flex-initial">
                        <svg class="w-8 h-8 text-primary-80" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                        </svg>
                    </div>
                    <blockquote class="text-justify">
                        {!! $quote->text !!}
                    </blockquote>
                    <div class="flex-initial">
                        <svg class="w-8 h-8 transform rotate-180 text-primary-80" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                        </svg>
                    </div>
                </div>

            @endif

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
        {{--@hasanyrole('Editor|Admin|Super Admin')
            <div class="ml-3">
                <p class="text-sm text-gray-900">Real name: {{ $page->name }}</p>
                <p class="text-sm text-gray-900">Item: {{ $page->item->name }}</p>
                @if($page->quotes_count > 0)
                    <p class="text-sm text-gray-900">Quotes: {{ $page->quotes_count }}</p>
                @endif
            </div>
        @endhasanyrole--}}
    </div>
</li>
