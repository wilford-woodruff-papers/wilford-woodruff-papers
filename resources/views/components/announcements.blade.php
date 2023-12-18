<div>
    <div class="pb-4 mx-auto max-w-7xl md:pb-8">
        <div class="{{ $position }}-announcements">
            @if(auth()->check() && auth()->user()->hasAnyRole(['Admin', 'Super Admin']))
                @if(! empty($dayInTheLife) && ! empty($dayInTheLife->getFirstMediaUrl('banner')))
                    <div class="mb-2">
                        <div class="px-6 pt-8 md:px-6 md:pt-8 xl:pt-8">
                            <div class="bg-white">
                                <div class="flex overflow-hidden flex-col shadow-lg">
                                    <div class="flex-shrink-0">
                                        <div class="mx-auto max-w-full h-auto md:max-w-7xl">
                                            <a href="{{ route('day-in-the-life', ['date' => $dayInTheLife->date->toDateString()]) }}">
                                                <img class="w-full h-auto"
                                                     src="{{ $dayInTheLife->getFirstMediaUrl('banner') }}"
                                                     alt="{{ $dayInTheLife->date->toDateString() }}"/>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            @foreach($announcements as $announcement)
                <div class="hidden mb-2">
                    <div class="px-6 pt-8 md:px-6 md:pt-8 xl:pt-8">
                        @include('announcements.single', ['announcement' => $announcement])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @if($announcements->count() > 1)
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
    @endif
</div>
