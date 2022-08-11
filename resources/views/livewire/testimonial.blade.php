<div class="">
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
