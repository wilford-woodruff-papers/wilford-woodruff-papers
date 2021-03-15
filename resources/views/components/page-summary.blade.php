<li class="py-4 grid grid-cols-7">
    <div class="col-span-1 px-2">
        <a class="col-span-1 h-auto w-20 my-2 mx-auto" href="{{ route('pages.show', ['item' => $page->item, 'page' => $page]) }}">
            <img src="{{ optional($page->getFirstMedia())->getUrl('thumb') }}" alt="">
        </a>
    </div>
    <div class="col-span-6 py-2 px-4">
        <p class="text-lg font-medium text-secondary pb-1 capitalize">
            <a href="{{ route('pages.show', ['item' => $page->item, 'page' => $page]) }}">{{ $page->name }}</a>
        </p>
        <p class="text-base font-medium ml-2">
            <span class="text-gray-600">Part of </span>
            <span class="text-secondary">
                <a href="{{ route('documents.show', ['item' => $page->item]) }}">{{ $page->item->name }}</a>
            </span>
        </p>
        @if($page->item->type)
            <p class="text-base text-primary ml-2">{{ $page->item->type->name }}</p>
        @endif
        <div class="text-sm text-gray-500 px-4 py-2">
            {!! Str::of( strip_tags( $page->text() ) )->words(50) !!}
        </div>
    </div>
</li>
