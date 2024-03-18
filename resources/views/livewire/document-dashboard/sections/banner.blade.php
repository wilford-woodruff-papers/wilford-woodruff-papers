<div>
    <div class="flex overflow-hidden flex-col shadow-lg">
        <div class="flex-shrink-0">
            <div class="mx-auto w-full max-w-full h-auto md:max-w-7xl aspect-[176/53]">
                <a href="{{ route('pages.show', ['item' => $item, 'page' => $item->firstPage]) }}">
                    <img class="w-full h-auto"
                         src="{{ $item->getFirstMediaUrl() }}"
                         alt="{{ $item->name }}"
                    />
                </a>
            </div>
        </div>
    </div>
</div>
