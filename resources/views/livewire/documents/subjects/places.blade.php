<div>
    @if($places->count() > 0)
        <div class="property">
            <div class="values">
                @foreach($places->sortBy('name') as $place)
                    <div class="value" lang="">
                        <a class="text-secondary"
                           href="{{ route('subjects.show', ['subject' => $place]) }}">
                            {{ $place->name }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
