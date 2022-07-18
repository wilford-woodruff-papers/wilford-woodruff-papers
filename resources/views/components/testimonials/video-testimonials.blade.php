@if($videos->count())
    <div x-data="{}"
         x-cloak
    >
        <div class="max-w-7xl mx-auto px-4">

            <div class="content col-span-12 px-8 pt-6">

                <div class="page-title">Testimonials</div>

            </div>

        </div>

        <div id="video-testimonials"
             class="py-8"
        >
            @foreach($videos as $video)
                <div class="w-[380px] aspect-video px-14">
                    <iframe class="w-full aspect-video" src="{{ $video->embed_link }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            @endforeach

        </div>


        @push('scripts')
            <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
            <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
            <script type="text/javascript" src="/vendor/slick/slick.min.js"></script>
            <script>
                $('#video-testimonials').slick({
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
