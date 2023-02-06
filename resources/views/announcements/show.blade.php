<x-guest-layout>
    <div class="mt-4 mb-8 bg-white">
        <div class="px-12 pt-8 pb-4 mx-auto max-w-7xl md:px-24 md:pt-16 md:pb-8 xl:pt-16">
            <div id="content" role="main">
                <div class="content">
                    <h2>{{ $announcement->title }}</h2>
                    @include('announcements.single')
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
