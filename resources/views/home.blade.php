<x-guest-layout>

    <div class="h-24 bg-center bg-cover md:h-28 xl:h-48"
         style="background-image: url({{ asset('img/banners/home.jpg') }})">
        <div class="mx-auto max-w-7xl">

        </div>
    </div>

    {{--@if(app()->environment(['production']))
        <div class="">
            <div class="grid grid-cols-12 mx-auto max-w-7xl">
                <div class="col-span-12 md:col-span-4 md:col-start-9">
                    <div class="relative">
                        <div class="-mt-24 md:absolute md:-mt-24 xl:-mt-24">
                            <img class="px-2 mx-auto w-52 h-auto md:w-56 xl:w-62"
                                 src="{{ asset('img/wilford-woodruff.png') }}"
                                 alt=""/>
                        </div>
                    </div>

                </div>
                <div class="col-span-12 md:col-span-8 md:col-start-1">
                    <p class="py-4 px-4 font-serif text-2xl italic leading-relaxed md:py-4 md:px-24 md:text-3xl xl:py-8 text-primary">
                        Explore Wilford Woodruff's powerful eyewitness account of the Restoration
                    </p>
                </div>
            </div>
        </div>
    @endif--}}

    @if(app()->environment(['production','local','development']))
        <div class="-mt-24 xl:-mt-40 md:-mt-30">
            <x-top-announcements />
        </div>
    @else
        <div>
            <x-top-announcements />
        </div>
    @endif

    @if(app()->environment(['production','local','development', 'testing']))
        <x-article-preview-carousel />
    @endif

    @if(app()->environment(['local','development']))
        <div class="">
            <x-home-page-buttons />
        </div>
    @endif

    @if(app()->environment(['production','local','development', 'testing']))

        <div class="py-12">
            <x-home.video />
        </div>
    @endif

    {{--@if(app()->environment(['production']))
        @if(! empty($article))
            <div class="bg-white">
                <div class="px-12 pt-4 pb-4 mx-auto max-w-7xl md:px-24 md:pt-4 md:pb-8 xl:pt-4">
                    <div class="">
                        <p class="font-semibold uppercase text-secondary">
                            Article
                        </p>
                        <h2 class="text-4xl">
                            <a href="{{ $article->url() }}"
                               @if(! empty($article->link)) target="_blank" @endif
                            >
                                {{ $article->title }}
                            </a>
                        </h2>
                        <p class="text-gray-600">
                            {{ $article->date->toFormattedDateString() }}
                        </p>
                        <p class="my-4 text-base">
                            @if(! empty($article->excerpt))
                                {!! $article->excerpt !!}
                            @else
                                {!! \Illuminate\Support\Str::of(strip_tags($article->description))->limit(500, ' ...') !!}
                            @endif
                        </p>
                        <a href="{{ $article->url() }}"
                           class="font-semibold text-secondary"
                           @if(! empty($article->link)) target="_blank" @endif
                        >
                            Read more &gt;
                        </a>
                    </div>
                </div>
            </div>
        @endif
    @endif--}}

    {{--@if(app()->environment(['production']))
        <div class="bg-primary">
            <div class="px-12 pt-8 pb-4 mx-auto max-w-7xl md:px-36 md:pt-16 md:pb-8 xl:pt-24">
                <div class="pb-4 text-3xl leading-10 text-justify md:text-4xl xl:text-5xl text-highlight" style="font-family: 'Italianno', cursive;">
                    " We pray that thou wilt bring to our remembrance all things which are necessary to the writing of this history . . . that when we have gone into the world of spirits that the saints of God may be blessed in reading our record which we have kept."
                </div>
                <div class="text-xl italic text-center text-highlight">
                    -- Wilford Woodruff
                </div>
            </div>
        </div>
    @endif--}}

    @if(app()->environment(['production','local','development']))
        <x-progress />
    @endif

    @if(app()->environment(['production','local','development']))
        <x-call-to-action />
    @endif

    @if(app()->environment(['production','local','development']))
        <x-home-page-testimonies />
    @endif

    {{--@if(app()->environment(['production']))
        <div class="mt-4 md:my-12">
            <div class="grid grid-cols-1 gap-2 px-4 mx-auto max-w-7xl md:grid-cols-4 md:gap-4 md:px-12 md:px-40 xl:grid-cols-2">
                <x-polaroid route="documents" image="img/home/documents.jpg" name="Documents" />
                <x-polaroid route="people" image="img/home/people.jpg" name="People" />
                <x-polaroid route="places" image="img/home/places.jpg" name="Places" />
                <x-polaroid route="timeline" image="img/home/historical-context.jpg" name="Timeline" />
            </div>
        </div>
    @endif--}}
    {{--@push('styles')
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&family=Source+Serif+Pro&display=swap" rel="stylesheet">
    @endpush--}}



    <x-home.book />

    <x-home.purpose />

    <x-bottom-announcements />

</x-guest-layout>


