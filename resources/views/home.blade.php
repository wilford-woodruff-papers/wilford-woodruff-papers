<x-guest-layout>

    <div class="bg-cover bg-center h-24 md:h-28 xl:h-48"
         style="background-image: url({{ asset('img/banners/home.jpg') }})">
        <div class="max-w-7xl mx-auto">

        </div>
    </div>

    {{--@if(app()->environment(['production']))
        <div class="">
            <div class="max-w-7xl mx-auto grid grid-cols-12">
                <div class="col-span-12 md:col-span-4 md:col-start-9">
                    <div class="relative">
                        <div class="md:absolute -mt-24 md:-mt-24 xl:-mt-24">
                            <img class="mx-auto w-52 md:w-56 xl:w-62 h-auto px-2"
                                 src="{{ asset('img/wilford-woodruff.png') }}"
                                 alt=""/>
                        </div>
                    </div>

                </div>
                <div class="col-span-12 md:col-span-8 md:col-start-1">
                    <p class="font-serif text-2xl md:text-3xl leading-relaxed italic text-primary py-4 px-4 md:py-4 xl:py-8 md:px-24">
                        Explore Wilford Woodruff's powerful eyewitness account of the Restoration
                    </p>
                </div>
            </div>
        </div>
    @endif--}}

    @if(app()->environment(['production','local','development']))
        <div class="-mt-24 md:-mt-30 xl:-mt-40">
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
                <div class="max-w-7xl mx-auto pt-4 md:pt-4 px-12 pb-4 xl:pt-4 md:px-24 md:pb-8">
                    <div class="">
                        <p class="uppercase text-secondary font-semibold">
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
                        <p class="text-base my-4">
                            @if(! empty($article->excerpt))
                                {!! $article->excerpt !!}
                            @else
                                {!! \Illuminate\Support\Str::of(strip_tags($article->description))->limit(500, ' ...') !!}
                            @endif
                        </p>
                        <a href="{{ $article->url() }}"
                           class="text-secondary font-semibold"
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
            <div class="max-w-7xl mx-auto pt-8 md:pt-16 px-12 pb-4 xl:pt-24 md:px-36 md:pb-8">
                <div class="text-3xl md:text-4xl xl:text-5xl text-justify text-highlight pb-4 leading-10" style="font-family: 'Italianno', cursive;">
                    " We pray that thou wilt bring to our remembrance all things which are necessary to the writing of this history . . . that when we have gone into the world of spirits that the saints of God may be blessed in reading our record which we have kept."
                </div>
                <div class="text-xl text-highlight italic text-center">
                    -- Wilford Woodruff
                </div>
            </div>
        </div>
    @endif--}}

    @if(app()->environment(['production','local','development']))
        <x-call-to-action />
    @endif

    {{--@if(app()->environment(['production']))
        <div class="mt-4 md:my-12">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 xl:grid-cols-2 gap-2 px-4 md:px-12 md:gap-4 md:px-40">
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

    @if(app()->environment(['production','local','development']))
        <x-progress />
    @endif

    <x-home.book />

    <x-home.purpose />

    <x-bottom-announcements />

</x-guest-layout>


