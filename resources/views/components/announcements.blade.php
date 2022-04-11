<div>
    @foreach($announcements as $announcement)
        <div class="bg-white mb-2">
            <div class="max-w-7xl mx-auto pt-8 md:pt-8 px-6 pb-4 xl:pt-8  md:px-6 md:pb-8">
                @include('announcements.single', ['announcement' => $announcement])
            </div>
        </div>
    @endforeach
</div>
