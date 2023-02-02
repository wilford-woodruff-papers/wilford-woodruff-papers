<div wire:ignore>
    @if($featured->count())
        <div x-data="{}"
             x-cloak
             class=""
        >
            <div class="px-4 mx-auto max-w-7xl">

                <div class="col-span-12 px-8 pt-6 content">

                    <div class="page-title">Testimonies</div>

                </div>

            </div>

            <div id="featured-testimonials"
                 class="py-2 mx-12 md:py-8"
            >
                @foreach($featured as $feature)
                    <div onclick='Livewire.emit("openModal", "testimonial", {{ json_encode(["testimonial" => $feature->id]) }})'
                         class="overflow-hidden relative mx-14 cursor-pointer w-[240px] h-[240px] group">
                        <img class="" src="{{ $feature->getFirstMediaUrl('images', 'square') }}" alt="{{ $feature->name }}">
                        <div class="absolute right-0 left-0 py-2 w-full h-auto text-lg font-medium transition-all duration-300 ease-in-out group-hover:bottom-0 title bottom-[-200px] text-secondary bg-white-80">
                            <div class="flex flex-row justify-center items-center uppercase">
                                {!! $feature->icon !!}
                                {{ $feature->call_to_action }}
                            </div>
                            <div class="flex justify-center items-center py-2 px-4 text-base font-medium text-center text-black">
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
                                breakpoint: 1024,
                                settings: {
                                    arrows: true,
                                    slidesToShow: 3
                                }
                            },
                            {
                                breakpoint: 600,
                                settings: {
                                    arrows: false,
                                    slidesToShow: 1
                                }
                            },
                            {
                                breakpoint: 480,
                                settings: {
                                    arrows: false,
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
