<div wire:ignore>
    @if($featured->count())
        <div x-data="{}"
             x-cloak
        >
            <div class="max-w-7xl mx-auto px-4">

                <div class="content col-span-12 px-8 pt-6">

                    <div class="page-title">Testimonials</div>

                </div>

            </div>

            <div id="featured-testimonials"
                 class="py-8"
            >
                @foreach($featured as $feature)
                    <div onclick='Livewire.emit("openModal", "testimonial", {{ json_encode(["testimonial" => $feature->id]) }})'
                         class="w-[240px] h-[240px] mx-14 cursor-pointer relative group overflow-hidden">
                        <img class="" src="{{ $feature->getFirstMediaUrl('images', 'square') }}" alt="{{ $feature->name }}">
                        <div class="title absolute bottom-[-100px] left-0 right-0 w-full py-2 text-secondary text-lg font-medium bg-white-80  group-hover:bottom-0 h-auto ease-in-out duration-300 transition-all">
                            <div class="uppercase flex flex-row items-center justify-center">
                                {!! $feature->icon !!}
                                {{ $feature->call_to_action }}
                            </div>
                            <div class="flex text-black text-base font-medium py-2 px-4 items-center justify-center">
                                {!! $feature->title !!}
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>


            @push('scripts')
                <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
                <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
                <script type="text/javascript" src="/vendor/slick/slick.min.js"></script>
                <script>
                    $('#featured-testimonials').slick({
                        dots: true,
                        initialSlide: 0,
                        slidesToShow: 3,
                        responsive: [
                            {
                                breakpoint: 768,
                                settings: {
                                    arrows: true,
                                    slidesToShow: 3
                                }
                            },
                            {
                                breakpoint: 480,
                                settings: {
                                    arrows: true,
                                    slidesToShow: 1
                                }
                            }
                        ]
                    });
                </script>
            @endpush

            @push('styles')
                <link rel="stylesheet" type="text/css" href="/vendor/slick/slick.css"/>
                <link rel="stylesheet" type="text/css" href="/vendor/slick/slick-theme.css"/>
                <style>

                </style>
            @endpush
        </div>
    @endif
</div>
