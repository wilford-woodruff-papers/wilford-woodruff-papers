<x-guest-layout>
    @php

    @endphp
    <div class="flex flex-wrap w-full h-full md:flex-nowrap">
        <div class="relative pt-16 w-full min-h-screen bg-gray-900 md:w-3/5" id="document-viewer">
            <div id="openseadrgon-controls"
                 class="flex absolute left-0 top-24 z-10 flex-wrap justify-items-center w-12 bg-white">
                <button onclick="viewer.viewport.goHome(); rotation = 0; viewer.viewport.setRotation(rotation);"
                        class="inline-block py-2 mx-auto cursor-pointer">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </button>
                <button onclick="viewer.viewport.zoomBy(1.5);"
                        class="inline-block py-2 mx-auto cursor-pointer">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                </button>
                <button onclick="viewer.viewport.zoomBy(.75);"
                        class="inline-block py-2 mx-auto cursor-pointer">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7" />
                    </svg>
                </button>
                <button onclick="viewer.viewport.setRotation(rotation); rotation += 90;"
                        class="inline-block py-2 mx-auto cursor-pointer">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
                <button onclick="viewer.viewport.fitVertically();"
                        class="inline-block py-2 mx-auto cursor-pointer">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                </button>
                <button onclick="viewer.viewport.fitHorizontally();"
                        class="inline-block py-2 mx-auto cursor-pointer">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </button>
                <a href="{{ optional($page->getFirstMedia())->getUrl() }}"
                   download=""
                   class="inline-block py-2 mx-auto border-t-2 cursor-pointer border-grey-600">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                </a>
            </div>
            <div class="h-screen" id="openseadragon-document-viewer">

            </div>
            @if($pages->count() > 1)
            <div class="absolute top-0 pt-4 w-full h-20 bg-white">
                <div class="flex justify-center items-center m-auto h-16 w-100">
                    <div class="flex-initial px-8">
                       @if (! empty($previousPage = $pages->where('order', '<', $page->order)->sortByDesc('order')->first()))
                            {{--$this->hyperlink('Previous', $previousMedia->url(), ['class' => 'relative inline-flex items-center px-4 py-2 text-sm font-medium border border-secondary text-sm font-medium text-white bg-secondary hover:text-highlight', 'title' => $translate('Previous'), 'aria-label' => $translate('Previous')]);--}}
                            <a class="inline-flex relative items-center py-2 px-4 text-sm font-medium text-white border border-secondary bg-secondary hover:text-highlight"
                               href="{{ route('pages.show', ['item' => $item, 'page' =>  $previousPage]) }}">
                                Previous
                            </a>
                       @endif
                    </div>
                    <div class="relative flex-1 py-1">
                        <div class="h-2 bg-gray-200 rounded-full">
                            <div class="absolute w-0 h-2 rounded-full bg-primary" style="width: {{ floor((($pages->where('order', '<=', $page->order)->count())/$pages->count())*100) }}%;"></div>
                            <div class="flex absolute top-0 justify-center items-center -ml-2 w-4 h-4 bg-white rounded-full border border-gray-300 shadow cursor-pointer" unselectable="on" onselectstart="return false;" style="left: {{ floor((($pages->where('order', '<=', $page->order)->count())/$pages->count())*100) }}%;">
                                <div class="relative -mt-2 w-1">
                                    <div class="absolute left-0 z-40 mb-2 min-w-full opacity-100 bottom-100" style="margin-left: -33px;">
                                        <div class="relative pr-0 shadow-md">
                                            <div class="py-1 px-4 -mt-8 text-xs text-white rounded bg-primary truncate">Page {{ $page->order }}</div>
                                            <svg class="absolute left-0 w-full h-2 text-primary top-100" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve">
                                                <polygon class="fill-current" points="0,0 127.5,127.5 255,0"></polygon>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-initial px-8">
                        @if (! empty($nextPage = $pages->where('order', '>', $page->order)->sortBy('order')->first()) )
                            {{--$this->hyperlink('Next', $nextMedia->url(), ['class' => 'relative inline-flex items-center px-4 py-2 text-sm font-medium border border-secondary text-sm font-medium text-white bg-secondary hover:text-highlight', 'title' => $translate('Previous'), 'aria-label' => $translate('Previous')]);--}}
                        <a class="inline-flex relative items-center py-2 px-4 text-sm font-medium text-white border border-secondary bg-secondary hover:text-highlight"
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
        <div class="py-6 px-4 w-full md:w-2/5" id="transcript">
            <h2 class="mb-2 text-2xl border-b-2 border-gray-300 text-secondary">
                <a href="{{ route('documents.show', ['item' => $item]) }}">
                    {{ \Illuminate\Support\Str::of($item->name)->replaceMatches('/\[.*?\]/', '')->trim() }}
                </a>
            </h2>
            <div class="property">
                <h4>
                    Title
                </h4>
                <div class="values">
                    <div class="value" lang="">
                        Page {{ $page->order }}
                        @hasanyrole('Editor|Admin|Super Admin')
                            <div>
                                <a href="{{ $page->ftp_link }}" class="text-secondary" target="_blank">View in FTP</a>
                                <a href="/nova/resources/items/{{ $page->item->id }}" class="text-secondary ml-4" target="_blank">View Item in Nova</a>
                            </div>
                        @endhasanyrole
                    </div>
                </div>
            </div>


            <div class="property">
                <h4>
                    Transcript
                </h4>
                <div class="font-serif metadata">
                    @if($page->is_blank)
                        <div class="flex justify-center items-center h-64">
                            <div>
                                This page is blank.
                            </div>
                        </div>
                    @else
                        @hasanyrole('Editor|Admin|Super Admin|Tagger')
                            <livewire:transcript :page="$page" />
                        @else
                            {!! $page->text() !!}
                        @endhasanyrole
                    @endif
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

            <div class="property">
                <h4>
                    Cite this page
                </h4>
                <div class="values">
                    "{{ \Illuminate\Support\Str::of($item->name)->replaceMatches('/\[.*?\]/', '')->trim() }}," {{ $page->page_date_range }}, The Wilford Woodruff Papers, accessed {{ now()->format('F j, Y') }}, {{ URL::current() }}
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal for displaying subject quick view-->
    <script src="{{ asset('js/openseadragon.min.js') }}" charset="utf-8"></script>

    <script>
        let rotation = 90;
        window.viewer = OpenSeadragon({
            id: "openseadragon-document-viewer",
            //prefixUrl: "/openseadragon/images/",
            tileSources: [{
                'type': 'image',
                'url': '{{ $page->getFirstMediaUrl() }}'
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

