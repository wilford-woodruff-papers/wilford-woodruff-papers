<x-guest-layout>

    <div class="flex flex-wrap md:flex-nowrap h-full w-full">
        <div class="w-full min-h-screen pt-16 md:w-3/5 bg-gray-900 relative" id="document-viewer">
            <div id="openseadrgon-controls"
                 class="flex flex-wrap justify-items-center absolute left-0 top-24 w-12 bg-white z-10">
                <button onclick="viewer.viewport.goHome(); rotation = 0; viewer.viewport.setRotation(rotation);"
                        class="mx-auto inline-block py-2 cursor-pointer">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </button>
                <button onclick="viewer.viewport.zoomBy(1.5);"
                        class="mx-auto inline-block py-2 cursor-pointer">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                </button>
                <button onclick="viewer.viewport.zoomBy(.75);"
                        class="mx-auto inline-block py-2 cursor-pointer">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7" />
                    </svg>
                </button>
                <button onclick="viewer.viewport.setRotation(rotation); rotation += 90;"
                        class="mx-auto inline-block py-2 cursor-pointer">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
                <button onclick="viewer.viewport.fitVertically();"
                        class="mx-auto inline-block py-2 cursor-pointer">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                </button>
                <button onclick="viewer.viewport.fitHorizontally();"
                        class="mx-auto inline-block py-2 cursor-pointer">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </button>
                <a href="{{ optional($page->getFirstMedia())->getUrl() }}"
                   download=""
                   class="mx-auto inline-block py-2 border-t-2 border-grey-600 cursor-pointer">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                </a>
            </div>
            <div class="h-screen" id="openseadragon-document-viewer">

            </div>
            @if($item->pages->count() > 1)
            <div class="w-full h-20 absolute top-0 bg-white pt-4">
                <div class="flex w-100 m-auto items-center h-16 justify-center">
                    <div class="flex-initial px-8">
                       @if (! empty($previousPage = $item->pages->where('order', '<', $page->order)->sortByDesc('order')->first()))
                            {{--$this->hyperlink('Previous', $previousMedia->url(), ['class' => 'relative inline-flex items-center px-4 py-2 text-sm font-medium border border-secondary text-sm font-medium text-white bg-secondary hover:text-highlight', 'title' => $translate('Previous'), 'aria-label' => $translate('Previous')]);--}}
                            <a class="relative inline-flex items-center px-4 py-2 text-sm font-medium border border-secondary text-sm font-medium text-white bg-secondary hover:text-highlight"
                               href="{{ route('pages.show', ['item' => $item, 'page' =>  $previousPage]) }}">
                                Previous
                            </a>
                       @endif
                    </div>
                    <div class="flex-1 py-1 relative">
                        <div class="h-2 bg-gray-200 rounded-full">
                            <div class="absolute h-2 rounded-full bg-primary w-0" style="width: {{ floor((($item->pages->where('order', '<', $page->order)->count())/$item->pages->count())*100) }}%;"></div>
                            <div class="absolute h-4 flex items-center justify-center w-4 rounded-full bg-white shadow border border-gray-300 -ml-2 top-0 cursor-pointer" unselectable="on" onselectstart="return false;" style="left: {{ floor((($item->pages->where('order', '<', $page->order)->count())/$item->pages->count())*100) }}%;">
                                <div class="relative -mt-2 w-1">
                                    <div class="absolute z-40 opacity-100 bottom-100 mb-2 left-0 min-w-full" style="margin-left: -20.5px;">
                                        <div class="relative shadow-md pr-1">
                                            <div class="bg-primary -mt-8 text-white truncate text-xs rounded py-1 px-4">{{ $item->pages->where('order', '<', $page->order)->count() + 1 }}</div>
                                            <svg class="absolute text-primary w-full h-2 left-0 top-100" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve">
                                                <polygon class="fill-current" points="0,0 127.5,127.5 255,0"></polygon>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-initial px-8">
                        @if (! empty($nextPage = $item->pages->where('order', '>', $page->order)->sortBy('order')->first()) )
                            {{--$this->hyperlink('Next', $nextMedia->url(), ['class' => 'relative inline-flex items-center px-4 py-2 text-sm font-medium border border-secondary text-sm font-medium text-white bg-secondary hover:text-highlight', 'title' => $translate('Previous'), 'aria-label' => $translate('Previous')]);--}}
                        <a class="relative inline-flex items-center px-4 py-2 text-sm font-medium border border-secondary text-sm font-medium text-white bg-secondary hover:text-highlight"
                           href="{{ route('pages.show', ['item' => $item, 'page' =>  $nextPage]) }}">
                            Next
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="h-screen" id="separator"></div>
        <div class="w-full md:w-2/5 py-6 px-4" id="transcript">
            <h2 class="text-2xl text-secondary border-b-2 border-gray-300 mb-2">
                <a href="{{ route('documents.show', ['item' => $item]) }}">
                    {{ $item->name }}
                </a>
            </h2>
            <div class="property">
                <h4>
                    Title
                </h4>
                <div class="values">
                    <div class="value" lang="">
                        {{ $page->name }}
                    </div>
                </div>
            </div>


            <div class="property">
                <h4>
                    Transcript
                </h4>
                <div class="metadata">
                    {!! $page->text() !!}
                </div>
            </div>

            @if($page->subjects->count() > 0)
                <div class="property">
                    <h4>
                        People & Places
                    </h4>
                    <div class="values">
                        @foreach($page->subjects->sortBy('name') as $subject)
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

            @if($page->dates->count() > 0)
                <div class="property">
                    <h4>
                        Dates
                    </h4>
                    <div class="values">
                        @foreach($page->dates as $date)
                            <div class="value" lang="">
                                {{ $date->date->format('F j, Y') }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
    <!-- End Modal for displaying subject quick view-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js" charset="utf-8"></script>
    <script src="{{ asset('js/openseadragon.min.js') }}" charset="utf-8"></script>

    <script>
        let rotation = 90;
        window.viewer = OpenSeadragon({
            id: "openseadragon-document-viewer",
            //prefixUrl: "/openseadragon/images/",
            tileSources: [{
                'type': 'image',
                'url': '{{ optional($page->getFirstMedia())->getUrl() }}'
            }],
            sequenceMode: true,
            showRotationControl: false,
            showZoomControl: false,
            showFullPageControl: false,
            showHomeControl: false,
            showSequenceControl: false
        });
    </script>

</x-guest-layout>

