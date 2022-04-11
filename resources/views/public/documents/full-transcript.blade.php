<div class="max-w-7xl mx-auto p-6 lg:p-12">
    <h1>{{ $item->name }}</h1>
    <h2>Document Transcript</h2>
    @foreach($item->pages as $page)
        <div class="font-serif metadata">
            {!! $page->text() !!}
        </div>
    @endforeach
</div>
