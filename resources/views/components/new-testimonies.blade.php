<div>
    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
        <div class="flex flex-col flex-1 gap-8 justify-between">
            <div class="flex-1">
                <h2 class="pb-4 text-3xl font-semibold border-b border-primary">
                    Testimonies
                </h2>
                <div class="!py-0 leading-6 line-clamp-4 lg:line-clamp-6 my-4 px-2">
                    {!! strip_tags($featuredTestimony->excerpt) !!}
                </div>
                <p class="py-4 px-2 font-semibold">
                    {!! $featuredTestimony->name !!}
                </p>
            </div>
            <div class="">
                <a href="{{ route('testimonies.index') }}"
                   class="flex justify-center py-2 text-base font-semibold text-white uppercase lg:text-xl bg-primary"
                >
                    View All Testimonies
                </a>
            </div>
        </div>
        <div class="flex-0 aspect-[16/9]">
            <div class="inline-block flex relative items-center w-full aspect-[16/9]">
                <div class="w-full h-auto aspect-[16/9]">
                    <iframe class="w-full h-auto aspect-[16/9]" src="{{ $featuredTestimony->embed_link }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-5 gap-8 mt-8">
        @foreach($testimonies->take(5) as $testimony)
            <div>
                <a href="{{ route('testimonies.index', ['testimony' => $testimony->slug]) }}">
                    <div class="overflow-hidden shadow cursor-pointer">
                        <img src="{{ $testimony->getFirstMediaUrl('images', 'square') }}"
                             class="object-cover w-full h-full"
                             alt="{{ $testimony->name }}"
                             title="{{ $testimony->name }}"
                        />
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
