<x-guest-layout>
    <x-slot name="title">
        Timeline of Events | {{ config('app.name') }}
    </x-slot>
    <div class="px-4 mx-auto max-w-7xl">

        <div class="page-title">Appreciate Wilford&#39;s experiences in the context of Church and American history</div>
    </div>
    <div class="px-4 mx-auto max-w-7xl">
        <div id='timeline-embed' style="width: 100%; height: 600px"></div>
    </div>
    <div class="px-4 mx-auto max-w-7xl">
        <div class="col-span-12 py-6 px-8 content">
            <h1 class="sr-only">Timeline</h1>
            <div class="">
                <div>
                    <div class="overflow-hidden border-b border-gray-200 shadow">
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <div class="flex flex-col">
                            <div class="-my-2 sm:-mx-6 lg:-mx-8">
                                <div class="inline-block py-2 min-w-full align-middle sm:px-6 lg:px-8">
                                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                    Date
                                                </th>
                                                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">

                                                </th>
                                                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                    Description
                                                </th>
                                                @if(auth()->check() && auth()->user()->hasAnyRole(['Editor', 'Super Admin', 'Admin']))
                                                    <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                        Place
                                                    </th>
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($events as $event)
                                                    <tr id="event-{{ $event->id }}"
                                                        class="odd:bg-white even:bg-gray-50">
                                                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-normal">
                                                            @if($event->pages->count() > 0 && $event->pages->first()->parent?->uuid && $event->pages->first()?->uuid)
                                                                <a class="text-secondary"
                                                                   href="{{ route('pages.show', ['item' => $event->pages->first()->parent->uuid, 'page' => $event->pages->first()->uuid]) }}"
                                                                   target="_timeline"
                                                                >
                                                            @endif

                                                            {{ $event->display_date }}

                                                            @if($event->pages->count() > 0 && $event->pages->first()->parent?->uuid && $event->pages->first()?->uuid)
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($event->photos->count() > 0 && $event->photos->first()?->uuid)
                                                                <a class="text-secondary"
                                                                   href="{{ route('media.photos.show', ['photo' => $event->photos->first()->uuid]) }}"
                                                                   target="_timeline"
                                                                >
                                                                    <img class="w-auto h-12"
                                                                         src="{{ $event->photos->first()->getFirstMediaUrl('default','thumb') }}"
                                                                         alt=""/>
                                                                </a>
                                                            @elseif($event->pages->count() > 0 && $event->pages->first()->parent?->uuid && $event->pages->first()?->uuid)
                                                                <a class="text-secondary"
                                                                   href="{{ route('pages.show', ['item' => $event->pages->first()->parent->uuid, 'page' => $event->pages->first()->uuid]) }}">
                                                                    <img class="w-auto h-12"
                                                                         src="{{ $event->pages->first()->getFirstMediaUrl('default','thumb') }}"
                                                                         alt=""/>
                                                                </a>
                                                            @elseif($event->media->count() > 0)
                                                                <img class="w-auto h-12"
                                                                     src="{{ $event->getFirstMediaUrl('default','thumb') }}"
                                                                     alt=""/>
                                                            @elseif(auth()->check() && auth()->user()->hasAnyRole(['Editor', 'Super Admin', 'Admin']))
                                                                <a href="/nova/resources/photos/new"
                                                                   class="underline whitespace-nowrap text-secondary"
                                                                   target="_upload_photo"
                                                                >
                                                                    Upload Photo
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td class="py-4 px-6 text-sm text-gray-500 whitespace-normal">
                                                            <div>
                                                                {!! str($event->text)->addScriptureLinks()->addSubjectLinks() !!}
                                                            </div>
                                                            @if($event->pages->count() > 0)
                                                                <div class="mt-2">
                                                                    @foreach($event->pages as $page)
                                                                        @if($page->parent?->uuid)
                                                                            <div>
                                                                                <a class="text-secondary"
                                                                                   href="{{ route('pages.show', ['item' => $page->parent->uuid, 'page' => $page->uuid]) }}"
                                                                                   target="_blank">
                                                                                    Page {{ $page->order }} from {{ str($page->parent->name)->stripBracketedID() }}
                                                                                </a>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </td>
                                                        @if(auth()->check() && auth()->user()->hasAnyRole(['Editor', 'Super Admin', 'Admin']))
                                                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-normal">
                                                                @if($event->places->count() > 0)
                                                                    @foreach($event->places as $place)
                                                                        <a class="text-secondary"
                                                                           href="{{ route('subjects.show', ['subject' => $place->slug]) }}"
                                                                           target="_blank">
                                                                            {{ $place->name }}
                                                                        </a>
                                                                    @endforeach
                                                                @else
                                                                    <a class="text-secondary"
                                                                       href="{{ url('/nova/resources/events/'.$event->id) }}"
                                                                       target="_blank">
                                                                        Add Place
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        @endif
                                                    </tr>
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
            .view-more a.bg-secondary {
                color: #ffffff !important;
                margin-top: 8px;
                display: inline-block;
            }
            .view-more a.text-secondary {
                color: rgb(103, 30, 13) !important;
            }
            .tl-timemarker .tl-timemarker-content-container .tl-timemarker-content .tl-timemarker-text h2.tl-headline,
            .tl-timemarker .tl-timemarker-content-container .tl-timemarker-content .tl-timemarker-text h2.tl-headline p {
                color: black;
            }
            .tl-menubar-button {
                color: black;
            }
            div.tl-timegroup:nth-child(4){
                background-color: rgba(11,40,54,.2) !important;
            }
            div.tl-timegroup:nth-child(4) .tl-timegroup-message{
                color: rgba(11,40,54,1) !important;
            }
            div.tl-timegroup:nth-child(5){
                background-color: rgba(11,40,54,.25) !important;
            }
            div.tl-timegroup:nth-child(5) .tl-timegroup-message{
                color: rgba(11,40,54,1) !important;
            }
            div.tl-timegroup:nth-child(6){
                background-color: rgba(11,40,54,.3) !important;
            }
            div.tl-timegroup:nth-child(6) .tl-timegroup-message{
                color: rgba(11,40,54,1) !important;
            }
            div.tl-timegroup:nth-child(7){
                background-color: rgba(11,40,54,.35) !important;
            }
            div.tl-timegroup:nth-child(7) .tl-timegroup-message{
                color: rgba(11,40,54,1) !important;
            }
            div.tl-timegroup:nth-child(8){
                background-color: rgba(11,40,54,.4) !important;
            }
            div.tl-timegroup:nth-child(8) .tl-timegroup-message{
                color: rgba(11,40,54,1) !important;
            }
            div.tl-timegroup:nth-child(9){
                background-color: rgba(11,40,54,.45) !important;
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
