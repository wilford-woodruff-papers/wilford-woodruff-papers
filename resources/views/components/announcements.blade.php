<div>
    @foreach($announcements as $announcement)
        <div class="bg-white mb-2">
            <div class="max-w-7xl mx-auto pt-8 md:pt-8 px-12 pb-4 xl:pt-8  md:px-24 md:pb-8">
                @include('announcements.single', ['announcement' => $announcement])
            </div>
        </div>
    @endforeach
</div>
