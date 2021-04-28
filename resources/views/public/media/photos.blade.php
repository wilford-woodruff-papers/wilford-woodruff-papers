<x-guest-layout>
    <div id="content" role="main">
        <div class="max-w-7xl mx-auto px-4">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="content col-span-12 md:col-span-9">
                        <h2>Photos</h2>
                        <ul class="space-y-12 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:grid-cols-3 lg:gap-x-8 my-12" x-max="1">
                            @foreach($photos as $key => $photo)
                            <li>
                                <a href="{{ route('media.photos.show', ['photo' => $photo->uuid]) }}"
                                   class="space-y-4">
                                    <div class="aspect-w-3 aspect-h-2 bg-cover bg-center h-72"
                                         style="background-image: url('{{ optional($photo->getFirstMedia())->getUrl('thumb') }}')">

                                    </div>

                                    <div class="space-y-2">
                                        <div class="text-lg leading-6 font-medium space-y-1">
                                            <h3 class="text-secondary text-lg">
                                                {{ $photo->title }}
                                            </h3>
                                            <p class="text-gray-600">
                                                {{ $photo->description }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="browse-controls flex flex-wrap grid grid-cols-1 lg:grid-cols-2 mt-8">
                            <div class="items-center col-span-2 px-8">
                                {!! $photos->withQueryString()->links('vendor.pagination.tailwind') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
