<x-guest-layout>
    <x-slot name="title">
        Wilford Woodruff Papers Foundation Conference 2023
    </x-slot>
    <div class="px-4 pt-8 pb-4 mx-auto max-w-5xl md:pb-8">
        <div class="grid relative z-10 grid-cols-5 items-center">
            <div class="col-span-5 md:col-span-3">
                <h1 class="mt-4 mb-8 font-sans text-5xl tracking-wide text-secondary leading-[3.5rem]">
                    <small class="block mb-2 text-3xl tracking-normal uppercase text-dark-blue">
                        Saturday, March 4, 2023
                    </small>
                    Wilford Woodruff Papers Foundation Conference
                </h1>
            </div>
            <div class="col-span-5 md:col-span-2">
                <img src="{{ asset('img/conferences/2023/conference-logo-color.png') }}"
                     alt="Building Latter-day Faith"
                     class="px-12 w-full h-auto md:block"
                />
            </div>
        </div>
    </div>

    <div class="px-4 pb-4 mx-auto max-w-5xl md:pb-8">
        <iframe class="w-full aspect-[16/9]" src="https://www.youtube.com/embed/LisB6yEJ_Dk?rel=0" title="Building Latter-day Faith Conference | March 4, 2023 Highlight Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div>


    <div class="px-4 pb-4 mx-auto max-w-7xl md:pb-8">
        <h2 class="pt-12 text-4xl font-black text-center md:text-6xl text-secondary">
            Featured Speakers
        </h2>

        <div class="grid grid-cols-1 gap-8 px-8">
            @foreach($speakers as $speaker)
                <div class="grid grid-cols-5 gap-x-4 items-center my-24 mx-auto max-w-7xl">
                    <div class="col-span-5 md:col-span-3 @if($loop->odd) order-2 md:order-1 @else order-2 md:order-2 @endif pt-4 md:pt-0 px-4 md:px-12">
                        <h2 class="text-base font-extrabold tracking-tight text-gray-900 lg:text-2xl">
                            {{ $speaker['title'] }}
                        </h2>
                        <div class="pt-1 my-4 border-t border-gray-200">
                            <div class="flex items-center mt-3 space-x-3">
                                <div class="text-sm font-semibold text-gray-900 lg:text-lg">
                                    {{ $speaker['name'] }}
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-x-4 mt-4 text-base text-gray-800 lg:text-lg">
                            @if(! empty($speaker['bio']))
                                <div class="text-sm text-dark-blue">
                                    {!! $speaker['bio'] !!}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-span-5 md:col-span-2 @if($loop->odd) order-1 md:order-2 @else order-1 md:order-1 @endif">
                        @if(! empty($speaker['video']))
                            <div class="mx-auto w-[260px] h-[160px] lg:w-[480px] lg:h-[310px]">
                                <iframe class="w-[260px] h-[160px] lg:w-[480px] lg:h-[310px]" src="{{ $speaker['video'] }}?rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        @else
                            <div class="flex justify-center items-center text-2xl font-semibold">
                                Coming Soon
                            </div>
                        @endif
                        @if(! empty($speaker['article']))
                            <a href="{{ $speaker['article'] }}"
                               class="group"
                                target="_blank"
                            >
                                <div class="flex gap-x-2 justify-center items-center pt-4 text-lg text-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="group-hover:underline">
                                        Read Article
                                    </span>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>




                {{--<div class="grid grid-cols-5">
                    <div class="col-span-2">
                        <iframe class="w-full aspect-[16/9]"
                                src="{{ $speaker['video'] }}?rel=0"
                                title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                    <div class="col-span-3">
                        <div class="py-4 text-center">
                            <div class="text-2xl font-black text-dark-blue">
                                {{ $speaker['name'] }}
                            </div>
                            @if(! empty($speaker['title']))
                                <div class="text-2xl text-dark-blue">
                                    {{ $speaker['title'] }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if(! empty($speaker['bio']))
                    <div class="text-base text-dark-blue">
                        {!! $speaker['bio'] !!}
                    </div>
                @endif--}}
            @endforeach
        </div>
{{--
        <div class="grid z-50 grid-cols-1 px-16 md:grid-cols-3 md:h-[580px]">
            <div class="grid order-2 content-end h-full md:order-1">
                <img src="{{ asset('img/conferences/2023/Jennifer-Mackley.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Jennifer Ann Mackley
                    </div>
                    <a href="https://drive.google.com/file/d/1JSWddDy2GAp6viIfOhnawWSN2LmyDDmS/view?usp=share_link"
                       target="_blank"
                       class="flex justify-center items-center text-2xl text-dark-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 010 .656l-5.603 3.113a.375.375 0 01-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112z" />
                        </svg>
                        <span class="ml-2">
                            Watch
                        </span>
                    </a>
                </div>
            </div>
            <div class="grid order-1 content-start h-full md:order-2">
                <img src="{{ asset('img/conferences/2023/Laurel-Thatcher-Ulrich.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Laurel Thatcher Ulrich
                    </div>
                    <div class="text-2xl text-dark-blue">
                        Pulitzer Prize Winning Historian
                    </div>
                </div>
            </div>
            <div class="grid order-3 content-end h-full md:order-3">
                <img src="{{ asset('img/conferences/2023/Steve-Harper.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Steven C. Harper
                    </div>
                    <div class="text-2xl text-dark-blue">

                    </div>
                </div>
            </div>
        </div>

        <div class="grid z-40 grid-cols-1 px-16 md:grid-cols-3 md:-mt-24 md:h-[580px]">
            <div class="grid order-1 content-end h-full md:order-1">
                <img src="{{ asset('img/conferences/2023/Amy-Harris.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Amy Harris
                    </div>
                    <div class="text-2xl text-dark-blue">

                    </div>
                </div>
            </div>
            <div class="grid order-2 content-start h-full md:order-2">
                --}}{{--<img src="{{ asset('img/conferences/2023/Steve-Harper.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Steve Harper
                    </div>
                    <div class="text-2xl text-dark-blue">
                        Keynote Speaker
                    </div>
                </div>--}}{{--
            </div>
            <div class="grid order-3 content-end h-full md:order-3">
                <img src="{{ asset('img/conferences/2023/Steven-Wheelright.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Steven C. Wheelwright
                    </div>
                    <div class="text-2xl text-dark-blue">

                    </div>
                </div>
            </div>
        </div>

        <div class="grid z-30 grid-cols-1 px-16 md:grid-cols-3 md:-mt-24 md:h-[580px]">
            <div class="grid order-1 content-end h-full md:order-1">
                <img src="{{ asset('img/conferences/2023/Hovan-Lawton.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Hovan Lawton
                    </div>
                    <div class="text-2xl text-dark-blue">

                    </div>
                </div>
            </div>
            <div class="grid order-2 content-start h-full md:order-2">
                <img src="{{ asset('img/conferences/2023/Ellie-Hancock.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Ellie Hancock
                    </div>
                    <div class="text-2xl text-dark-blue">

                    </div>
                </div>
            </div>
            <div class="grid order-3 content-end h-full md:order-3">
                <img src="{{ asset('img/conferences/2023/Josh-Matson.png') }}"
                     alt=""
                     class="w-full h-auto"
                />
                <div class="py-4 text-center">
                    <div class="text-2xl font-black text-dark-blue">
                        Joshua M. Matson
                    </div>
                    <div class="text-2xl text-dark-blue">

                    </div>
                </div>
            </div>
        </div>
        --}}
    </div>

    <div class="h-16"></div>

    <div class="mb-32">
        <x-gallery.photo />
    </div>

    <div class="mx-auto max-w-7xl">
        {{--<div class="grid grid-cols-4 gap-4">
            @foreach($photos as $photo)
                <div class="overflow-hidden aspect-[16/9]">
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('spaces')->url($photo) }}"
                         class="w-full h-auto"
                         alt=""/>
                </div>
            @endforeach
        </div>--}}

        <h2 class="py-8 mb-12 text-4xl font-black text-center md:text-6xl text-secondary">
            Conference Photos
        </h2>
        <div class="gallery-container" id="animated-thumbnails-gallery">
            @foreach($photos as $photo)
                <a href="{{ \Illuminate\Support\Facades\Storage::disk('spaces')->url(str($photo)->replace('thumbnails', 'medium')) }}" data-lg-size="1600-2400">
                    <img alt=""
                         src="{{ \Illuminate\Support\Facades\Storage::disk('spaces')->url($photo) }}"
                    />
                </a>
            @endforeach
        </div>
    </div>
    @push('styles')
    @endpush
    @push('scripts')
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/justifiedGallery@3.8.1/dist/css/justifiedGallery.css'>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/lightgallery.css') }}" />

        <!-- lightgallery plugins -->
        <link type="text/css" rel="stylesheet" href="{{ asset('css/lg-zoom.css') }}" />
        <link type="text/css" rel="stylesheet" href="{{ asset('css/lg-thumbnail.css') }}" />

        <script src='https://cdn.jsdelivr.net/npm/justifiedGallery@3.8.1/dist/js/jquery.justifiedGallery.js'></script>
        <script src="{{ asset('js/lightgallery.min.js') }}"></script>

        <!-- lightgallery plugins -->
        <script src="{{ asset('js/light-ballery-plugins/lg-thumbnail.min.js') }}"></script>
        <script src="{{ asset('js/light-ballery-plugins/lg-zoom.min.js') }}"></script>
        <script type="text/javascript">

            jQuery("#animated-thumbnails-gallery")
                .justifiedGallery({
                    captions: false,
                    lastRow: "hide",
                    rowHeight: 180,
                    margins: 5
                })
                .on("jg.complete", function () {
                    window.lightGallery(
                        document.getElementById("animated-thumbnails-gallery"),
                        {
                            autoplayFirstVideo: false,
                            pager: false,
                            galleryId: "nature",
                            mousewheel: true,
                            plugins: [lgZoom, lgThumbnail],
                            mobileSettings: {
                                controls: false,
                                showCloseIcon: false,
                                download: false,
                                rotate: false
                            }
                        }
                    );
                });
            /*lightGallery(document.getElementById('animated-thumbnails-gallery'), {
                plugins: [lgZoom, lgThumbnail],
                animateThumb: false,
                zoomFromOrigin: false,
                allowMediaOverlap: true,
                toggleThumb: true,
                speed: 500,
                licenseKey: '0000-0000-000-0000'
            });*/
        </script>
    @endpush
</x-guest-layout>
