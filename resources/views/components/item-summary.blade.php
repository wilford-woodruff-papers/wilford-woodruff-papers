<li class="py-4 grid grid-cols-7">
    <div class="col-span-1 ">
        <a class="col-span-1" href="{{ route('documents.show', ['item' => $item]) }}">
            <img class="h-auto w-20 my-2 mx-auto"
                 src="{{ $item->firstPage?->getFirstMedia()?->getUrl('thumb') }}"
                 alt=""
                 loading="lazy"
            >
        </a>
    </div>
    <div class="col-span-6 py-2">
        <a href="{{ route('documents.show', ['item' => $item]) }}">
            <div class="ml-3">
                <p class="text-lg font-medium text-secondary pb-1">{{ \Illuminate\Support\Str::of($item->name)->replaceMatches('/\[.*?\]/', '')->trim() }}</p>
                <p>{{ str($item->type?->name)->singular() }}</p>
            </div>
        </a>
    </div>
</li>
