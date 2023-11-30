<div wire:init="load">
    <div x-data="{
            share: function(url){
                window.open(url, 'Share', 'width=560,height=640');
            }
        }"
        class="grid grid-cols-12 gap-x-4">
        <div class="col-span-2">
            <div wire:loading
                 wire:target="load"
                 class="w-full h-full bg-white opacity-75"
            >
                <div class="flex justify-center py-40">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 animate-spin">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>

                </div>
            </div>
            <div class="">
                <div class="pl-4 mt-8 sticky-top">
                    <!-- Secondary navigation -->
                    <h3 class="px-3 text-sm font-medium text-gray-500" id="desktop-teams-headline">
                        Topics
                    </h3>
                    <div class="overflow-y-scroll mt-1 space-y-1 max-h-[50vh]" role="group" aria-labelledby="desktop-teams-headline">
                        @if(! empty($topics))
                            @foreach($topics as $topic)
                                <div>
                                    @if($topic->quotes_count > 0)
                                        <span wire:click="$set('selectedTopic', '{{ $topic->id }}')"
                                              wire:key="topic_{{ $topic->id }}"
                                              class="flex items-center py-2 px-2 text-sm font-medium group cursor-pointer @if($selectedTopic == $topic->id) bg-secondary text-white @endif">
                                        <span class="flex-1">
                                            {{ $topic->name }}
                                        </span>
                                        <span class="inline-block py-0.5 px-3 ml-3 text-xs font-medium @if($selectedTopic != $topic->id) bg-secondary text-white  @endif rounded-full ">
                                            {{ $topic->quotes_count }}
                                        </span>
                                    </span>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <h3 class="px-3 mt-4 text-sm font-medium text-gray-500" id="desktop-teams-headline">
                        Additional Topics
                    </h3>

                    <div class="overflow-y-scroll mt-1 space-y-1 max-h-[50vh]" role="group" aria-labelledby="desktop-teams-headline">
                        @if(! empty($additionalTopics))
                            @foreach($additionalTopics as $additionalTopic)
                                <div>
                                <span wire:click="$set('selectedAdditionalTopic', '{{ addcslashes($additionalTopic->name, "'") }}')"
                                      wire:key="additional_topic_{{ str($additionalTopic->name)->slug() }}"
                                      class="flex items-center py-2 px-2 text-sm font-medium group cursor-pointer @if($selectedAdditionalTopic == $additionalTopic->name) bg-secondary text-white @endif">
                                        <span class="flex-1">
                                            {{ $additionalTopic->name }}
                                        </span>
                                    </span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>
        <div class="col-span-10 pr-8">
            <div class="py-4 px-4">
                <div>
                    <label for="search" class="block text-sm font-medium leading-6 text-gray-900 sr-only">Search</label>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"  class="w-5 h-5 text-gray-400" >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <input wire:model.live.debounce.400="search"
                               type="search"
                               name="search"
                               id="search"
                               class="block py-1.5 pl-10 w-full text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6 focus:ring-2 focus:ring-inset placeholder:text-gray-400 focus:ring-secondary" placeholder="Search...">
                    </div>
                </div>
                <div>
                    @if($selectedTopic)
                        <div wire:click="clearTopic"
                             class="inline-flex items-center py-0.5 px-3 mt-4 text-lg text-white bg-gray-400 cursor-pointer">
                            <div class="mr-4">
                                Clear Topic
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-2 -ml-0.5 w-4 h-4 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    @endif
                    @if($selectedAdditionalTopic)
                        <div wire:click="clearAdditionalTopic"
                             class="inline-flex items-center py-0.5 px-3 mt-4 text-lg text-white bg-gray-400 cursor-pointer">
                            <div class="mr-4">
                                Clear Additional Topic
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-2 -ml-0.5 w-4 h-4 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
            <table class="mt-8 w-full divide-y divide-gray-300">
                <thead>
                    <tr>
                        <th>Page</th>
                        <th>Quote</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($quotes as $quote)
                        <tr class="">
                            <td class="py-3.5 pr-3 pl-4 max-w-lg text-lg text-left text-gray-900 whitespace-nowrap font-base">
                                <div class="flex flex-col gap-y-4">
                                    <div>
                                        <div class="">
                                            <a href="{{ route('short-url.page', ['hashid' => $quote->page->hashid]) }}"
                                               target="_blank"
                                               class="text-secondary"
                                            >
                                                Page {{ $quote->page?->order ?? str($quote->page?->name)->replace('_', ' ')->title() }}
                                            </a>
                                        </div>
                                        <div>
                                            part of
                                            <a href="{{ route('short-url.item', ['hashid' => $quote->page->parent->hashid]) }}"
                                               target="_blank"
                                               class="text-secondary"
                                            >
                                                {{ $quote->page->parent?->name }}
                                            </a>
                                        </div>
                                        <div class="p-2">
                                            <a x-on:click.prevent="share('https://facebook.com/sharer.php?u={{ route('short-url.page', ['hashid' => $quote->page->hashid]) }}')"
                                               id="share-to-facebook"
                                               class="p-1 text-white bg-secondary hover:bg-secondary-dark"
                                               href="https://facebook.com/sharer.php?u={{ route('short-url.page', ['hashid' => $quote->page->hashid]) }}">
                                                <svg class="inline w-8 h-8" aria-label="Share on Facebook" xmlns="http://www.w3.org/2000/svg" fill="white" stroke="none" viewBox="0 0 24 24"><path d="M13.397,20.997v-8.196h2.765l0.411-3.209h-3.176V7.548c0-0.926,0.258-1.56,1.587-1.56h1.684V3.127 C15.849,3.039,15.025,2.997,14.201,3c-2.444,0-4.122,1.492-4.122,4.231v2.355H7.332v3.209h2.753v8.202H13.397z"/></svg>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="shrink">
                                        <button wire:click="$dispatch('openModal', { component: 'admin.quotes.add-additional-topic-to-quote', arguments: [{{ $quote->id }}] })"
                                                type="button" class="inline-flex gap-x-2 items-center py-1 px-2 my-2 text-xs font-semibold leading-4 text-white rounded-full border border-transparent shadow-sm focus:ring-2 focus:ring-offset-2 focus:outline-none bg-secondary hover:bg-secondary focus:ring-secondary">
                                            <!-- Heroicon name: solid/mail -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Additional Topics
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 pr-3 pl-4 text-lg text-left text-gray-900 font-base">
                                <div>
                                    {!! $quote->text !!}
                                    {!! $quote->continuation?->text !!}
                                </div>
                                <div class="pt-2">
                                    <div class="grid grid-cols-6 gap-1 font-medium text-cool-gray-900">
                                        @foreach($quote->topics as $topic)
                                            <div wire:click="$set('selectedTopic', '{{ $topic->id }}')"
                                                 class="inline-flex items-center py-0.5 px-3 text-base text-white cursor-pointer bg-secondary">
                                                <div>
                                                    {{ $topic->name }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="pt-2">
                                    <div class="grid grid-cols-6 gap-1 font-medium text-cool-gray-900">
                                        @foreach($quote->tags as $tag)
                                            <div wire:click="$set('selectedAdditionalTopic', '{{ addcslashes($tag->name, "'") }}')"
                                                 class="inline-flex items-center py-0.5 px-3 text-base text-white cursor-pointer bg-primary">
                                                <div>
                                                    {{ $tag->name }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 pr-3 pl-4 text-lg font-semibold text-left text-gray-900">
                                <button class="btn btn-danger"></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="sticky bottom-0 bg-gray-100">
                    <tr>
                        <td colspan="3">
                            <div class="px-4 my-4 w-full">
                                {!! $quotes->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('scroll-to-top', postId => {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });
        </script>
    @endpush
</div>
