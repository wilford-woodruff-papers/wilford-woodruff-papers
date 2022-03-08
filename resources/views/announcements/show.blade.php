<x-guest-layout>
    <div class="bg-white mt-4 mb-8">
        <div class="max-w-7xl mx-auto pt-8 md:pt-16 px-12 pb-4 xl:pt-16  md:px-24 md:pb-8">
            <div id="content" role="main">
                <div class="content">
                    <h2>{{ $announcement->title }}</h2>
                    @include('announcements.single')
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
