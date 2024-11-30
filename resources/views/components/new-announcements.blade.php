<div class="">
    <div class="pb-4 mx-auto max-w-7xl md:pb-4">
        <div class="{{ $position }}-announcements">
            <a href="{{ route('donate') }}">
                <img class="w-full h-auto"
                     src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/giving-tuesday-banner-with-donate-button.png"
                     alt="Donate on Giving Tuesday"/>
            </a>

            <a href="{{ route('volunteer') }}">
                <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/volunteers-needed.png"
                     alt="Translators Needed"
                     class="w-full h-auto"
                />
            </a>

            <a href="{{ route('volunteer') }}">
                <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/translators-needed.png"
                     alt="Explore Wilford Woodruff's Scriptures"
                     class="w-full h-auto"
                />
            </a>

            <a href="{{ route('advanced-search', ['currentIndex' => 'Scriptures']) }}">
                <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/small-scripture-banner.png"
                     alt="Transcribers Needed"
                     class="w-full h-auto"
                />
            </a>

{{--            @foreach($announcements as $announcement)--}}
{{--                <div class="hidden mb-2">--}}
{{--                    <div class="px-6 pt-8 md:px-6 md:pt-8 xl:pt-8">--}}
{{--                        @include('announcements.single', ['announcement' => $announcement])--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endforeach--}}
        </div>
    </div>
{{--    @if($announcements->count() >= 1)--}}
        @push('styles')
            <link rel="stylesheet" type="text/css" href="/css/slick.css"/>
            <link rel="stylesheet" type="text/css" href="/css/slick-theme.css"/>
        @endpush
        @push('scripts')
            <script type="text/javascript" src="/js/slick.min.js"></script>
            <script>
                $(function(){
                    $('.{{ $position }}-announcements').slick({
                        arrows: false,
                        autoplay: true,
                        autoplaySpeed: 8000,
                        dots: true,
                        infinite: true,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        variableWidth: false,
                        adaptiveHeight: true
                    });
                });
            </script>
        @endpush
{{--    @endif--}}
</div>
