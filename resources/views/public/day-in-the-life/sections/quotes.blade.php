@if(! empty($section['items']) && $section['items']->count() > 0)
    <div>
        <div class="relative">
            <div id="{{ str($section['name'])->slug() }}" class="absolute -top-32"></div>
            <h2 class="my-8 text-4xl font-thin uppercase border-b-4 border-highlight">
                {{ $section['name'] }}
            </h2>
            <p class="mt-4 mb-8 text-xl">
                View selected quotes from this page in Wilford Woodruff's journal.
            </p>
        </div>
        <div class="">
            @foreach($section['items'] as $quote)
                <div class="">
                    <div class="py-2 px-4 font-serif text-sm text-gray-500">
                        <div class="flex gap-x-4 mt-4 text-base text-gray-800 lg:text-lg">
                            <div class="flex-initial">
                                <x-ri-double-quotes-l class="w-6 h-6 md:w-8 md:h-8 text-primary-80" />
                            </div>
                            <div class="flex-1">
                                <blockquote class="text-justify">
                                    {!! $quote->text !!}
                                </blockquote>
                                <div class="text-right">
                                    ~ {{ (empty($quote->author) ? 'Wilford Woodruff': $quote->author) }}
                                </div>

                            </div>
                            <div class="flex-initial">
                                <x-ri-double-quotes-r class="w-6 h-6 md:w-8 md:h-8 text-primary-80" />
                            </div>
                        </div>
                        <div class="px-12">
                            @if($quote->topics->count() > 0)
                                <div class="mt-4">
                                    <ul class="flex flex-wrap gap-3">
                                        @foreach($quote->topics as $topic)
                                            <li class="">
                                                <a href="{{ route('subjects.show', ['subject' => $topic->slug]) }}"
                                                   class="inline-flex items-center py-0.5 px-1.5 text-sm text-white md:py-1 md:px-3 md:text-base bg-secondary"
                                                   target="_blank"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 -ml-0.5 w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                    </svg>
                                                    {{ $topic->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
