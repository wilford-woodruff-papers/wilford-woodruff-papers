<nav class="submenu space-y-1" aria-label="Sidebar">
    <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
    <h2 class="text-gray-500 text-xl uppercase mb-4">
        {{ $area }}
    </h2>
    @switch($area)

        @case('About')
            <div class="mt-1 space-y-1 pb-4 pl-4" aria-labelledby="media-library-headline">
                <a href="{{ route('about') }}"
                   class="group flex items-center px-3 py-2 text-sm font-medium @if(request()->is('about')) active @else @endif">
                            <span class="truncate">
                                Mission
                            </span>
                </a>
                <a href="{{ route('about.meet-the-team') }}"
                   class="group flex items-center px-3 py-2 text-sm font-medium @if(request()->is('about/meet-the-team')) active @else @endif">
                            <span class="truncate">
                                Meet the Team
                            </span>
                </a>
                <a href="{{ route('about.editorial-method') }}"
                   class="group flex items-center px-3 py-2 text-sm font-medium @if(request()->is('about/editorial-method')) active @else @endif">
                            <span class="truncate">
                                Editorial Method
                            </span>
                </a>
                <a href="{{ route('about.frequently-asked-questions') }}"
                   class="group flex items-center px-3 py-2 text-sm font-medium @if(request()->is('about/frequently-asked-questions')) active @else @endif">
                            <span class="truncate">
                                Frequently Asked Questions
                            </span>
                </a>
            </div>
            @break

        @case('Donate')
            <div class="mt-1 space-y-1 pb-4 pl-4" aria-labelledby="">
                <a href="{{ route('donate.online') }}"
                   class="group flex items-center px-3 py-2 text-sm font-medium @if(request()->is('donate-online')) active @else @endif">
                <span class="truncate">
                    Donate Online
                </span>
                </a>
                <!--<a href="/s/wilford-woodruff-papers/page/check-or-wire"
               class="group flex items-center px-3 py-2 text-sm font-medium <?php /*if (strpos($this->serverUrl(true), '/page/check-or-wire')) {
                   echo 'text-white bg-secondary hover:text-gray-900 hover:bg-gray-50';
               } else {
                   echo 'text-secondary hover:text-gray-900 hover:bg-gray-50';
               } */?>">
                <span class="truncate">
                    Check or Wire
                </span>
            </a>-->
                <a href="{{ route('donate.questions') }}"
                   class="group flex items-center px-3 py-2 text-sm font-medium @if(request()->is('donation-questions')) active @else @endif">
                <span class="truncate">
                    Contact Us
                </span>
                </a>
            </div>
            @break

        @case('Get Involved')
            <div class="mt-1 space-y-1 pb-4 pl-4" aria-labelledby="media-library-headline">
                <a href="{{ route('volunteer') }}"
                   class="group flex items-center px-3 py-2 text-sm font-medium @if(request()->is('volunteer')) active @else @endif">
                <span class="truncate">
                    Volunteer
                </span>
                </a>
                <!--
                <a href="/s/wilford-woodruff-papers/page/transcribe"
                   class="group flex items-center px-3 py-2 text-sm font-medium <?php /*if(strpos($this->serverUrl(true), '/page/transcribe')){ echo 'text-white bg-secondary hover:text-gray-900 hover:bg-gray-50'; } else { echo 'text-secondary hover:text-gray-900 hover:bg-gray-50'; } */?>">
                                <span class="truncate">
                                    Transcribe
                                </span>
                </a>
                <a href="/s/wilford-woodruff-papers/page/research"
                   class="group flex items-center px-3 py-2 text-sm font-medium <?php /*if(strpos($this->serverUrl(true), '/page/research')){ echo 'text-white bg-secondary hover:text-gray-900 hover:bg-gray-50'; } else { echo 'text-secondary hover:text-gray-900 hover:bg-gray-50'; } */?>">
                                <span class="truncate">
                                    Research
                                </span>
                </a>-->
                <a href="{{ route('contribute-documents') }}"
                   class="group flex items-center px-3 py-2 text-sm font-medium @if(request()->is('contribute-documents')) active @else @endif">
                    <span class="truncate">
                        Contribute Documents
                    </span>
                </a>
                <!--<a href="/s/wilford-woodruff-papers/page/host-event"
                   class="group flex items-center px-3 py-2 text-sm font-medium <?php /*if(strpos($this->serverUrl(true), '/page/host-event')){ echo 'text-white bg-secondary hover:text-gray-900 hover:bg-gray-50'; } else { echo 'text-secondary hover:text-gray-900 hover:bg-gray-50'; } */?>">
                                <span class="truncate">
                                    Host an Event
                                </span>
                </a>-->
            </div>
            @break

        @case('Media')
            <h3 class="px-3 text-xs font-semibold text-primary uppercase tracking-wider" id="media-library-headline">
                Media Library
            </h3>
            <div class="mt-1 space-y-1 pb-4 pl-4" aria-labelledby="media-library-headline">
                <a href="{{ route('media.photos') }}"
                   class="group flex items-center px-3 py-2 text-sm font-medium  @if(request()->is('media/photos*')) active @else @endif">
                            <span class="truncate">
                                Photos
                            </span>
                </a>
                <a href="{{ route('media.podcasts') }}"
                   class="group flex items-center px-3 py-2 text-sm font-medium @if(request()->is('media/podcasts')) active @else @endif">
                            <span class="truncate">
                                Podcasts
                            </span>
                </a>
                <a href="{{ route('media.videos') }}"
                   class="group flex items-center px-3 py-2 text-sm font-medium @if(request()->is('media/videos')) active @else @endif">
                            <span class="truncate">
                                Videos
                            </span>
                </a>
            </div>
            <h3 class="px-3 text-xs font-semibold text-primary uppercase tracking-wider" id="media-press-center-headline">
                Media Center
            </h3>
            <div class="mt-1 space-y-1 pb-4 pl-4" aria-labelledby="media-press-center-headline">
                <a href="{{ route('media.kit') }}"
                   class="group flex items-center px-3 py-2 text-sm font-medium @if(request()->is('media/media-kit')) active @else @endif">
                            <span class="truncate">
                                Media Kit
                            </span>
                </a>
                <a href="{{ route('media.requests') }}"
                   class="group flex items-center px-3 py-2 text-sm font-medium @if(request()->is('media/requests')) active @else @endif">
                            <span class="truncate">
                                Media Requests
                            </span>
                </a>
                <!--
                <a href="/s/wilford-woodruff-papers/page/news-releases"
                   class="group flex items-center px-3 py-2 text-sm font-medium <?php /*if(strpos($this->serverUrl(true), '/page/news-releases')){ echo 'text-white bg-secondary hover:text-gray-900 hover:bg-gray-50'; } else { echo 'text-secondary hover:text-gray-900 hover:bg-gray-50'; } */?>">
                                <span class="truncate">
                                    News Releases
                                </span>
                </a>-->
                <a href="{{ route('media.news') }}"
                   class="group flex items-center px-3 py-2 text-sm font-medium @if(request()->is('media/news')) active @else @endif">
                            <span class="truncate">
                                Newsroom
                            </span>
                </a>
            </div>
            @break

    @endswitch
</nav>
