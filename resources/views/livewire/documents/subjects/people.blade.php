<div>
    @if($people->count() > 0)
        <div class="property">
            <div class="values">
                @foreach($people->sortBy('name') as $person)
                    <div class="value" lang="">
                        <a class="text-secondary"
                           href="{{ route('subjects.show', ['subject' => $person]) }}">
                            {{ $person->name }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
