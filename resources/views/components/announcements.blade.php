<div>
    <div class="pb-4 mx-auto max-w-7xl md:pb-8">
        <div class="{{ $position }}-announcements">
            @foreach($announcements as $announcement)
                <div class="mb-2 @if(! $loop->first) hidden @endif">
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
