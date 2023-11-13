<h2 class="text-4xl font-thin uppercase border-b-4 border-highlight">
    Journal Entry
</h2>
<div class="grid grid-cols-1 gap-y-4 gap-x-12 md:grid-cols-3">
    <div class="order-2 md:order-1 md:col-span-2">
        <div class="pb-6 text-xl font-thin text-gray-900 md:text-3xl">
            {{ $date->format('F d, Y ~ l') }}
        </div>
        <div class="text-lg leading-relaxed text-gray-900 md:text-2xl">
            {!! $content !!}
        </div>
        @if(! empty($topics))
            <div class="col-span-3 mt-6">
                <ul class="flex flex-wrap gap-3">
                    @foreach($topics as $topic)
                        <li class="">
                            <a href="{{ route('subjects.show', ['subject' => $topic->slug]) }}"
                               class="inline-flex items-center py-1 px-3 text-base text-white bg-secondary"
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
    <div class="flex flex-col order-1 gap-y-4 md:order-2">
        <div class="overflow-hidden">
            <img src="{{ $day->first()->getfirstMediaUrl(conversionName: 'web') }}"
                 alt=""
                 class="w-full h-auto scale-125 cursor-pointer"
                 x-on:click="Livewire.emit('openModal', 'page', {'pageId': {{ $day->first()->id }}})"
            />
        </div>
        <div class="flex justify-center">
            <button x-on:click="Livewire.emit('openModal', 'page', {'pageId': {{ $day->first()->id }}})">
                                    <span class="text-secondary">
                                        View Fullscreen
                                    </span>
            </button>
        </div>
    </div>
</div>
