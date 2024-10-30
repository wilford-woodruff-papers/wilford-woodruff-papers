@php
    $featured = $testimonies->pop();
@endphp
<div>
    <div class="flex gap-8 h-[400px]">
        <div class="flex flex-col flex-1 gap-8 justify-between">
            <div class="overflow-y-auto flex-1">
                <p class="pb-4 text-2xl border-b border-primary">
                    Testimonies
                </p>
                <p class="py-4">
                    {!! $featured->content !!}
                </p>
                <p class="py-4 font-semibold">
                    {!! $featured->name !!}
                </p>
            </div>
            <div class="">
                <a href="{{ route('testimonies.index') }}"
                   class="flex justify-center py-2 text-xl text-white uppercase bg-primary"
                >
                    View All Testimonies
                </a>
            </div>
        </div>
        <div class="flex-0 h-[400px] aspect-[16/9]">
            <div class="inline-block flex overflow-hidden relative items-center w-full aspect-[16/9] image-parent bg-primary-50">
                <div class="absolute z-0 z-10 w-full h-full bg-left bg-cover image-child"
                     style="background-image: url({{ $featured->getFirstMediaUrl('images', 'square') }})">
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
