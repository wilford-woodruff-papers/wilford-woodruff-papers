<x-guest-layout>
    <x-slot name="title">
        Photos | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-16 px-2 md:col-span-3">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="col-span-12 md:col-span-9 content">
                        <h2>Photos</h2>
                        <ul class="!list-none space-y-12 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:grid-cols-3 lg:gap-x-8 my-12" x-max="1">
                            @foreach($photos as $key => $photo)
                            <li class="">
                                <a href="{{ route('media.photos.show', ['photo' => $photo->uuid]) }}"
                                   class="space-y-4">
                                    <div class="h-72 bg-center bg-cover aspect-w-3 aspect-h-2"
                                         style="background-image: url('{{ optional($photo->getFirstMedia())->getUrl('thumb') }}')">

                                    </div>

                                    <div class="space-y-2">
                                        <div class="space-y-1 text-lg leading-6">
                                            <h3 class="!text-secondary !text-lg font-medium">
                                                {{ $photo->title }}
                                            </h3>
                                            <p class="text-gray-600">
                                                {{ $photo->description }}
                                            </p>
                                            @if($photo->tags->count() > 0)
                                                <p class="mt-4">
                                                    @foreach($photo->tags as $tag)
                                                        <a href="{{ route('media.photos', ['tag[]' => $tag->name]) }}"
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
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="flex grid flex-wrap grid-cols-1 mt-8 lg:grid-cols-2 browse-controls">
                            <div class="col-span-2 items-center px-8">
                                {!! $photos->withQueryString()->links('vendor.pagination.tailwind') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
