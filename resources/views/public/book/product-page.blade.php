<x-book-layout>
    <x-slot name="title">
        {{ __('book.Wilford Woodruff\'s Witness') }}: {{ __('book.The Development of Temple Doctrine') }} | {{ config('app.name') }}
    </x-slot>

    <div id="cover"
         class="relative bg-cover bg-center"
         style="background-image: url({{ asset('img/book/book-background-desktop.jpg') }})"
    >
        <div class="max-w-7xl mx-auto pb-8 px-8 py-8 z-10">
            <div class="flex justify-end gap-x-2">
                <div>
                    <a href=""
                       class="text-dark-blue"
                    >
                        {{ __('book.English') }}
                    </a>
                </div>
                <div class="text-dark-blue">|</div>
                <div>
                    <a href=""
                       class="text-dark-blue"
                    >
                        {{ __('book.Spanish') }}
                    </a>
                </div>
            </div>
            <h1 class="text-6xl leading-[3.0rem] text-dark-blue-500 font-serif text-center">
                {{ __('book.Wilford Woodruff\'s Witness') }}<br/>
                <small class="text-3xl">{{ __('book.The Development of Temple Doctrine') }}</small>
            </h1>
        </div>

        {{--<div class="max-w-7xl mx-auto relative z-10 h-[1400px]">
            <div class="slow-parallax absolute w-1/3 h-auto top-10 right-10">
                <img src="{{ asset('img/book/book-cover-paperback.jpg') }}"
                     class=""
                >
            </div>
            <div class="grid grid-cols-2 gap-x-8">
                <div class="">
                    <h2 class="text-3xl font-serif py-8 text-dark-blue-500">
                        {{ __('book.Purchase from Deseret Book') }}
                    </h2>
                    <div class="grid md:grid-cols-3 gap-4">
                        <a href=""
                            class="px-4 py-4 rounded-3xl bg-secondary text-white text-center font-sans uppercase drop-shadow-lg">
                            {{ __('book.Paperback') }}
                        </a>
                        <a href=""
                            class="px-4 py-4 rounded-3xl bg-secondary text-white text-center font-sans uppercase drop-shadow-lg">
                            {{ __('book.Audiobook') }}
                        </a>
                        <a href=""
                            class="px-4 py-4 rounded-3xl bg-secondary text-white text-center font-sans uppercase drop-shadow-lg">
                            {{ __('book.eBook') }}
                        </a>
                    </div>
                    <div class="grid grid-cols-2 py-8">
                        <div>

                        </div>
                        <div class="text-sm text-right text-dark-blue-500">
                            {{ __('book.All sales of the eBook and Audiobook go to support the Wilford Woodruff Papers Foundation') }}
                        </div>
                    </div>
                    <div class="pt-8 pb-16">
                        <h2 class="text-3xl font-serif py-8 text-dark-blue-500">
                            {{ __('book.About the book') }}
                        </h2>
                        <div class="flex flex-col gap-y-4 text-xl font-sans text-dark-blue-600">
                            {!! __('book.Book Summary') !!}
                        </div>
                        <div class="h-32"></div>
                    </div>
                </div>
                <div class="">

                </div>
            </div>
        </div>--}}
    </div>

    <div>
        <div class="max-w-7xl mx-auto">

        </div>
    </div>
</x-book-layout>
