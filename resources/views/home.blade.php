<x-guest-layout>

    <div class="bg-cover bg-center h-24 md:h-36 xl:h-72"
         style="background-image: url({{ asset('img/banners/home.jpg') }})">
        <div class="max-w-7xl mx-auto">

        </div>
    </div>

    <div class="">
        <div class="max-w-7xl mx-auto grid grid-cols-12">
            <div class="col-span-12 md:col-span-5 md:col-start-8">
                <div class="relative">
                    <div class="md:absolute -mt-24 md:-mt-28 xl:-mt-56">
                        <img class="mx-auto w-48 md:w-64 xl:w-96 h-auto"
                             src="{{ asset('img/wilford-woodruff.png') }}"
                             alt=""/>
                    </div>
                </div>

            </div>
            <div class="col-span-12 md:col-span-7 md:col-start-1">
                <p class="font-serif text-2xl md:text-4xl leading-relaxed italic text-primary py-4 px-4 md:py-6 xl:py-12 md:px-24">
                    Explore Wilford Woodruff's powerful eyewitness account of the Restoration
                </p>
            </div>
        </div>
    </div>

    {{--<div class="bg-white">
        <div class="max-w-7xl mx-auto pt-8 md:pt-16 px-12 pb-4 xl:pt-16  md:px-24 md:pb-8">
            <div class="">
                <p class="uppercase text-secondary font-semibold">
                    Article
                </p>
                <h2 class="text-4xl">
                    {{ $article->title }}
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
                <a href="{{ route('media.article', ['article' => $article]) }}"
                   class="text-secondary font-semibold">
                    Read more &gt;
                </a>
            </div>
        </div>
    </div>--}}

    <div class="bg-white mt-4">
        <div class="max-w-7xl mx-auto pt-8 md:pt-16 px-12 pb-4 xl:pt-16  md:px-24 md:pb-8">
            <div class="">
                <div class="max-w-full md:max-w-5xl h-auto mx-auto">
                    <a href="https://zoom.us/meeting/register/tJModOmhqDgiHd0in9L7HcddA62IeuI92i1Z"
                       target="_blank">
                        <img src="{{ asset('img/2021-10-10.png') }}" alt="Devotional with Elder LeGrand R. Curtis, Jr."/>
                    </a>
                </div>
                <div class="w-full text-center mt-4">
                    <a href="https://zoom.us/meeting/register/tJModOmhqDgiHd0in9L7HcddA62IeuI92i1Z"
                       target="_blank"
                       class="bg-secondary text-white font-semibold text-center px-6 py-3">
                        Register for Zoom &gt;
                    </a>
                </div>
            </div>
        </div>
    </div>

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

    <div class="mt-4 md:my-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 xl:grid-cols-2 gap-2 px-4 md:px-12 md:gap-4 md:px-40">
            <x-polaroid route="documents" image="img/home/documents.jpg" name="Documents" />
            <x-polaroid route="people" image="img/home/people.jpg" name="People" />
            <x-polaroid route="places" image="img/home/places.jpg" name="Places" />
            <x-polaroid route="timeline" image="img/home/historical-context.jpg" name="Timeline" />
        </div>
    </div>

    {{--@push('styles')
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&family=Source+Serif+Pro&display=swap" rel="stylesheet">
    @endpush--}}

</x-guest-layout>


