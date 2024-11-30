<div class="">
    @if($announcements->count() > 0 )
        <div class="pb-4 mx-auto max-w-7xl md:pb-4">
            <div class="{{ $position }}-announcements">
                @foreach($announcements as $announcement)
                    <a href="{{ $announcement->link }}">
                        <img class="w-full h-auto"
                             src="{{ \Illuminate\Support\Facades\Storage::disk('announcements')->url($announcement->image) }}"
                             alt="{{ $announcement->title }}"/>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
    
    @if($announcements->count() > 1 )
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
