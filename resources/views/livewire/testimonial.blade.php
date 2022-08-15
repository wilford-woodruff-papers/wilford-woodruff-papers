<div class="p-8">
    <div class="absolute right-4 top-2">
        <button wire:click="$emit('closeModal')"
                type="button"
                class="close text-2xl font-semibold"
                aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="content pr-8">
        <h2>{{ $testimonial->title }}</h2>
    </div>
    @if($testimonial->type == 'Image')
        <img src="{{ $testimonial->getFirstMediaUrl('images') }}"
             alt="{{ $testimonial->title }}"
             class="w-full h-auto"
        >
    @elseif($testimonial->type == 'Video')
        <div class="w-[840px] h-[620px] mx-auto">
            <iframe class="w-[840px] h-[620px]" src="{{ $testimonial->embed_link }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    @endif

    <div class="content p-12">
        <div class="font-semibold text-lg">
            {{ $testimonial->title }}
        </div>
        <div class="font-medium text-base py-4">
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
