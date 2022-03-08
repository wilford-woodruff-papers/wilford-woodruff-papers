<div>
    @foreach($announcements as $announcement)
        @include('announcements.single', ['announcement' => $announcement])
    @endforeach
</div>
