<x-guest-layout>
    <div id="content" role="main">
        <div class="max-w-7xl mx-auto px-4">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="content videos col-span-12 md:col-span-9">
                        <h2>Videos</h2>

                        <div class="mt-12 max-w-lg mx-auto grid gap-5 lg:grid-cols-1 lg:max-w-none px-4">

                            @foreach($videos as $video)

                                <div class="flex flex-col shadow-lg overflow-hidden">
                                    <div class="flex-shrink-0">
                                        <!--<a href="https://youtu.be/LGrk-8dYpVg?rel=0"
                                           target="_blank">
                                            <img class="h-48 w-full object-cover" src="/files/asset/videos/treasure-box.jpg" alt="">
                                        </a>-->
                                        {!! $video->embed !!}
                                    </div>
                                    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                                        <div class="flex-1">
                                            <p class="text-xl font-semibold text-secondary">
                                                <a href="{{ route('media.video', ['video' => $video]) }}" class="mt-2 block">
                                                    {{ $video->title }}
                                                </a>
                                            </p>
                                            <p class="">
                                                {{ $video->subtitle }}
                                            </p>
                                            <p class="">
                                                {!! $video->description !!}
                                            </p>
                                            <!--<p class="mt-3 text-base text-gray-500">
                                                <a href="/files/asset/podcasts/Treasure%20Box.pdf"
                                                   class="text-base font-semibold text-secondary hover:text-highlight"
                                                   target="_blank"
                                                >
                                                    View Transcript
                                                </a>
                                            </p>-->
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
