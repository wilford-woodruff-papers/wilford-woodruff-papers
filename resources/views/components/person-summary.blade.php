<li class="mx-2 py-2">
    <div class="px-4">
        <a href="{{ route('subjects.show', ['subject' => $person]) }}"
           class="pb-1 text-lg font-medium capitalize text-secondary"
        >
            {!! $person->name !!}
        </a>
        @if(! empty($person->bio))
            <div class="py-2 px-4 font-serif text-sm text-gray-500">
                <div class="mb-1 font-bold">
                    Bio Excerpt:
                </div>
                {!! \Illuminate\Support\Str::of($person->bio)->limit('160', '...') !!}
            </div>
        @endif
    </div>
</li>
