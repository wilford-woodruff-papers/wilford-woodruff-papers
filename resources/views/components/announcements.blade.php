<div>
    @foreach($announcements as $announcement)
        <div class="bg-white mt-4 mb-8">
            <div class="max-w-7xl mx-auto pt-8 md:pt-16 px-12 pb-4 xl:pt-16  md:px-24 md:pb-8">
                @include('announcements.single', ['announcement' => $announcement])
            </div>
        </div>
    @endforeach
</div>
