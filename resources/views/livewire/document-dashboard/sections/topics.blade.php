<div>
    <div class="relative">
        <div id="{{ str('Topics')->slug() }}" class="absolute -top-32"></div>
        <h2 class="text-2xl font-thin uppercase border-b-4 md:text-3xl lg:text-4xl border-highlight">
            Topics
        </h2>
        <p class="mt-4 mb-8 text-xl">
            Browse topics Wilford Woodruff mentioned in this document.
        </p>
    </div>
    <div class="grid grid-cols-1 gap-y-4 lg:grid-cols-3">
        @foreach($item->topics as $topic)
            <div class="flex gap-x-2">
                <a href="{{ route('subjects.show', ['subject' => $topic->slug]) }}"
                   class="text-xl text-secondary popup"
                   target="_blank"
                >
                    {{ $topic->name }}
                </a>
            </div>
        @endforeach
    </div>
</div>
