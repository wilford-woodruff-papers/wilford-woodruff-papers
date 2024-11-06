@php
    $featured = $testimonies->pop();
@endphp
<div>
    <div class="flex flex-col gap-8 md:flex-row">
        <div class="flex flex-col flex-1 gap-8 justify-between">
            <div class="flex-1">
                <p class="pb-4 text-2xl border-b border-primary">
                    Testimonies
                </p>
                <div class="!py-0 leading-6 line-clamp-4 lg:line-clamp-6 my-4 px-2">
                    {!! strip_tags($featured->content) !!}
                </div>
                <p class="py-4 px-2 font-semibold">
                    {!! $featured->name !!}
                </p>
            </div>
            <div class="">
                <a href="{{ route('testimonies.index') }}"
                   class="flex justify-center py-2 text-base text-white uppercase lg:text-xl bg-primary"
                >
                    View All Testimonies
                </a>
            </div>
        </div>
        <div class="flex-0 h-[300px] aspect-[16/9] md:aspect-[12/16] lg:aspect-[16/9] lg:h-[400px]">
            <div class="inline-block flex overflow-hidden relative items-center w-full aspect-[16/9] image-parent bg-primary-50 md:aspect-[12/16] lg:aspect-[16/9]">
                <div class="absolute z-0 z-10 w-full h-[150%] -mt-24 bg-top bg-cover image-child"
                     style="background-image: url('{{ app()->environment('local') ? 'https://wilford-woodruff-papers.nyc3.digitaloceanspaces.com/testimonials/72366/conversions/Joan-Boren-square.jpg' : $featured->getFirstMediaUrl('images', 'square') }}')">
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-5 gap-8 mt-8">
        @foreach($testimonies as $testimony)
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
