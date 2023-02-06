<x-guest-layout>
    <x-slot name="title">
        Videos | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-16 px-2 md:col-span-3">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="col-span-12 md:col-span-9 content videos">
                        <h2>Videos</h2>
                        @if($tags = \Spatie\Tags\Tag::withType('videos')->get())
                            <div class="flex gap-4 px-4">
                                @foreach($tags as $tag)
                                    <a href="{{ route('media.videos', ['tag[]' => $tag->name]) }}"
                                       class="inline-flex items-center py-0.5 px-3 text-lg text-white bg-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 -ml-0.5 w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                        <div class="grid gap-5 px-4 mx-auto mt-12 max-w-lg lg:grid-cols-1 lg:max-w-none">

                            @foreach($videos as $video)

                                <div class="flex overflow-hidden flex-col shadow-lg">
                                    <div class="flex-shrink-0">
                                        <!--<a href="https://youtu.be/LGrk-8dYpVg?rel=0"
                                           target="_blank">
                                            <img class="object-cover w-full h-48" src="/files/asset/videos/treasure-box.jpg" alt="">
                                        </a>-->
                                        <iframe style="width: 100%; height: 480px;" src="{{ $video->embed_link }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                    <div class="flex flex-col flex-1 justify-between px-6 pb-3 bg-white">
                                        <div class="flex-1">
                                            <p class="text-xl font-semibold text-secondary">
                                                <a href="{{ route('media.video', ['video' => $video]) }}" class="block mt-2">
                                                    {{ $video->title }}
                                                </a>
                                            </p>
                                            <p class="">
                                                {{ $video->subtitle }}
                                            </p>
                                            <div class="">
                                                {!! $video->description !!}
                                            </div>
                                            <div class="">
                                                {!! $video->credits !!}
                                            </div>

                                            <!--<p class="mt-3 text-base text-gray-500">
                                                <a href="/files/asset/podcasts/Treasure%20Box.pdf"
                                                   class="text-base font-semibold text-secondary hover:text-highlight"
                                                   target="_blank"
                                                >
                                                    View Transcript
                                                </a>
                                            </p>-->
                                            @if($video->tags->count() > 0)
                                                <p class="mt-4">
                                                    @foreach($video->tags as $tag)
                                                        <a href="{{ route('media.videos', ['tag[]' => $tag->name]) }}"
                                                           class="inline-flex items-center py-0.5 px-2 text-xs font-medium text-white bg-secondary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 -ml-0.5 w-2 h-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                            </svg>
                                                            {{ $tag->name }}
                                                        </a>
                                                    @endforeach
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                        <div class="flex grid flex-wrap grid-cols-1 mt-8 lg:grid-cols-2 browse-controls">
                            <div class="col-span-2 items-center px-8">
                                {!! $videos->withQueryString()->links('vendor.pagination.tailwind') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
