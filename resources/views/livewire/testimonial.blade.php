<div class="p-8">
    <div class="absolute top-2 right-4">
        <button wire:click="$dispatch('closeModal')"
                type="button"
                class="text-2xl font-semibold close"
                aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="pr-8 content">
        <h2>{{ $testimonial->title }}</h2>
    </div>
    @if($testimonial->type == 'Image')
        <img src="{{ $testimonial->getFirstMediaUrl('images') }}"
             alt="{{ $testimonial->title }}"
             class="w-full h-auto"
        >
    @elseif($testimonial->type == 'Video')
        <div class="mx-auto w-[840px] h-[620px]">
            <iframe class="w-[840px] h-[620px]" src="{{ $testimonial->embed_link }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    @endif

    <div class="p-12 content">
        <div class="text-lg font-semibold">
            {{ $testimonial->title }}
        </div>
        <div class="py-4 text-base font-medium">
            {{ $testimonial->name }}
        </div>
        <div class="">
            {!! $testimonial->content !!}
        </div>
        <div class="">
            {!! $testimonial->bio !!}
        </div>
    </div>

</div>
