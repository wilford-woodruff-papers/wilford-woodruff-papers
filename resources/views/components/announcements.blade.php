<div>
    @foreach($announcements as $announcement)
        <div class="bg-white mt-8 mb-2">
            <div class="max-w-7xl mx-auto pt-8 md:pt-16 px-12 pb-4 xl:pt-16  md:px-24 md:pb-8">
                @include('announcements.single', ['announcement' => $announcement])
            </div>
        </div>
    @endforeach
</div>
