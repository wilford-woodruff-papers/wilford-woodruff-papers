<x-guest-layout>
    <x-slot name="title">
        {{ $video->title }} | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-16 px-2 md:col-span-3">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="col-span-12 md:col-span-9 videos content">
                        <div class="flex overflow-hidden flex-col shadow-lg">
                            <div class="flex-shrink-0">
                                <iframe style="width: 100%; height: 480px;" src="{{ $video->embed_link }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <div class="flex flex-col flex-1 justify-between px-6 pb-3 bg-white">
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
                                    <p class="">
                                        {!! $video->credits !!}
                                    </p>
                                    @if($video->tags->count() > 0)
                                        <p class="mt-3">
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
                                @if(! empty($article->credits))
                                    <div class="p-4 my-8 bg-gray-100 divide-y">
                                        <div class="px-4">
                                            {!! $author->credits !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if(strlen($video->transcript) > 10)
                                <div class="p-6">
                                    <p class="text-xl font-semibold text-gray-900">
                                        Transcript
                                    </p>
                                    <div class="mt-8">
                                        {!! $video->transcript !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
