<x-guest-layout>
    <div id="content" role="main">
        <div class="max-w-7xl mx-auto px-4">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="videos content col-span-12 md:col-span-9">
                        <div class="flex flex-col shadow-lg overflow-hidden">
                            <div class="flex-shrink-0">
                                {!! $video->embed !!}
                            </div>
                            <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                                <div class="flex-1">
                                    <p class="text-xl font-semibold text-gray-900">
                                        {{ $video->title }}
                                    </p>
                                    <p class="">
                                        {{ $video->subtitle }}
                                    </p>
                                    <p class="">
                                        {!! $video->description !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
