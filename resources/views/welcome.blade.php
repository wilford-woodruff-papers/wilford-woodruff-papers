<x-guest-layout>

    <div class="bg-cover bg-center h-36 md:h-72"
         style="background-image: url({{ asset('img/home.jpg') }})">
        <div class="max-w-7xl mx-auto">

        </div>
    </div>

    <div class="">
        <div class="max-w-7xl mx-auto grid grid-cols-12">
            <div class="col-span-12 md:col-span-5 md:col-start-8">
                <div class="relative">
                    <div class="md:absolute -mt-24 md:-mt-56">
                        <img class="mx-auto w-48 md:w-96 h-auto"
                             src="{{ asset('img/wilford-woodruff.png') }}"
                             alt=""/>
                    </div>
                </div>

            </div>
            <div class="col-span-12 md:col-span-7 md:col-start-1">
                <p class="font-serif text-2xl md:text-4xl leading-relaxed italic text-primary py-4 px-4 md:py-12 md:px-24">
                    Explore Wilford Woodruff's powerful eyewitness account of the Restoration
                </p>
            </div>
        </div>
    </div>

    <div class="bg-primary">
        <div class="max-w-7xl mx-auto pt-12 px-12 pb-4 md:pt-24 md:px-36 md:pb-8">
            <div class="text-3xl md:text-5xl text-justify text-highlight pb-4 leading-10" style="font-family: 'Italianno', cursive;">
                " We pray that thou wilt bring to our remembrance all things which are necessary to the writing of this history . . . that when we have gone into the world of spirits that the saints of God may be blessed in reading our record which we have kept."
            </div>
            <div class="text-xl text-highlight italic text-center">
                -- Wilford Woodruff
            </div>
        </div>
    </div>

    {{--@push('styles')
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&family=Source+Serif+Pro&display=swap" rel="stylesheet">
    @endpush--}}

</x-guest-layout>


