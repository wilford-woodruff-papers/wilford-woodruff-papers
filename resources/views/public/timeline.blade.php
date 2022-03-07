<x-guest-layout>

    <div class="max-w-7xl mx-auto px-4">

        <div class="page-title">Appreciate Wilford&#39;s experiences in the context of Church and American history</div>
    </div>
    <div class="max-w-7xl mx-auto px-4">
        <div id='timeline-embed' style="width: 100%; height: 600px"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4">
        <div class="content col-span-12 px-8 py-6">
            <h1 class="sr-only">Timeline</h1>
            <div class="">
                <div>
                    <div class="shadow overflow-hidden border-b border-gray-200">
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <div class="flex flex-col">
                            <div class="-my-2 sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Date
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Description
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($events as $event)
                                                    @if($loop->odd)
                                                        <!-- Odd row -->
                                                        <tr class="bg-white">
                                                            <td class="px-6 py-4 whitespace-normal text-sm font-medium text-gray-900">
                                                                @if($event->start_month) {{ $event->start_at->toFormattedDateString() }} @else {{ $event->start_year }} @endif
                                                                @if($event->end_at)
                                                                    - @if($event->end_month) {{ $event->end_at->toFormattedDateString() }} @else {{ $event->end_year }} @endif
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($event->photos->count() > 0)
                                                                    <img class="h-12 w-auto"
                                                                         src="{{ $event->photos->first()->getFirstMediaUrl('default','thumb') }}"
                                                                         alt=""/>
                                                                @endif
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                                                <div>
                                                                    {!! $event->text !!}
                                                                </div>
                                                                @if($event->pages->count() > 0)
                                                                    <div class="mt-2">
                                                                        @foreach($event->pages as $page)
                                                                            <div>
                                                                                <a class="text-secondary"
                                                                                   href="{{ route('pages.show', ['item' => $page->parent->uuid, 'page' => $page->uuid]) }}"
                                                                                   target="_blank">
                                                                                    Page {{ $page->order }} from {{ $page->parent->name }}
                                                                                </a>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <!-- Even row -->
                                                        <tr class="bg-gray-50">
                                                            <td class="px-6 py-4 whitespace-normal text-sm font-medium text-gray-900">
                                                                @if($event->start_month) {{ $event->start_at->toFormattedDateString() }} @else {{ $event->start_year }} @endif
                                                                @if($event->end_at)
                                                                    - @if($event->end_month) {{ $event->end_at->toFormattedDateString() }} @else {{ $event->end_year }} @endif
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($event->photos->count() > 0)
                                                                    <img class="h-12 w-auto"
                                                                         src="{{ $event->photos->first()->getFirstMediaUrl('default','thumb') }}"
                                                                         alt=""/>
                                                                @endif
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                                                <div>
                                                                    {!! $event->text !!}
                                                                </div>
                                                                @if($event->pages->count() > 0)
                                                                    <div class="mt-2">
                                                                        @foreach($event->pages as $page)
                                                                            <div>
                                                                                <a class="text-secondary"
                                                                                   href="{{ route('pages.show', ['item' => $page->parent->uuid, 'page' => $page->uuid]) }}"
                                                                                   target="_blank">
                                                                                    Page {{ $page->order }} from {{ $page->parent->name }}
                                                                                </a>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

    @push('styles')
        <link title="timeline-styles" rel="stylesheet"
              href="https://cdn.knightlab.com/libs/timeline3/latest/css/timeline.css">
        <style>
            .tl-timemarker .tl-timemarker-content-container .tl-timemarker-content .tl-timemarker-text h2.tl-headline,
            .tl-timemarker .tl-timemarker-content-container .tl-timemarker-content .tl-timemarker-text h2.tl-headline p {
                color: black;
            }
            .tl-menubar-button {
                color: black;
            }
            div.tl-timegroup:nth-child(5){
                background-color: rgba(11,40,54,.2) !important;
            }
            div.tl-timegroup:nth-child(5) .tl-timegroup-message{
                color: rgba(11,40,54,1) !important;
            }
            div.tl-timegroup:nth-child(6){
                background-color: rgba(11,40,54,.25) !important;
            }
            div.tl-timegroup:nth-child(6) .tl-timegroup-message{
                color: rgba(11,40,54,1) !important;
            }
            div.tl-timegroup:nth-child(7){
                background-color: rgba(11,40,54,.3) !important;
            }
            div.tl-timegroup:nth-child(7) .tl-timegroup-message{
                color: rgba(11,40,54,1) !important;
            }
            div.tl-timegroup:nth-child(8){
                background-color: rgba(11,40,54,.35) !important;
            }
            div.tl-timegroup:nth-child(8) .tl-timegroup-message{
                color: rgba(11,40,54,1) !important;
            }
            div.tl-timegroup:nth-child(9){
                background-color: rgba(11,40,54,.4) !important;
            }
            div.tl-timegroup:nth-child(9) .tl-timegroup-message{
                color: rgba(11,40,54,1) !important;
            }

            .tl-timemarker.tl-timemarker-active .tl-timemarker-content-container,
            .tl-timemarker .tl-timemarker-content-container:hover{
                background-color: rgba(11,40,54,1) !important;
            }

            .tl-timemarker.tl-timemarker-active .tl-timemarker-content-container .tl-timemarker-content .tl-timemarker-text .tl-headline,
            .tl-timemarker .tl-timemarker-content-container:hover .tl-timemarker-content .tl-timemarker-text .tl-headline{
                color: #ffffff !important;
            }
        </style>
    @endpush
    @push('scripts')
        <script src="https://cdn.knightlab.com/libs/timeline3/latest/js/timeline.js"></script>
        <script type="text/javascript">
            // make_the_json() is some javascript function you've written
            // which creates the appropriate JSON configuration
            window.timeline = new TL.Timeline('timeline-embed', @json($timeline_json));
        </script>
    @endpush
</x-guest-layout>
