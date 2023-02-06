<li class="grid grid-cols-7 py-4">
    <div class="col-span-1">
        <a class="col-span-1" href="{{ route('documents.show', ['item' => $item]) }}">
            <img class="my-2 mx-auto w-20 h-auto"
                 src="{{ $item->firstPage?->getFirstMedia()?->getUrl('thumb') }}"
                 alt=""
                 loading="lazy"
            >
        </a>
    </div>
    <div class="col-span-6 py-2">
        <a href="{{ route('documents.show', ['item' => $item]) }}">
            <div class="ml-3">
                <p class="pb-1 text-lg font-medium text-secondary">{{ \Illuminate\Support\Str::of($item->name)->replaceMatches('/\[.*?\]/', '')->trim() }}</p>
                <p>{{ str($item->type?->name)->singular() }}</p>
            </div>
        </a>
    </div>
</li>
