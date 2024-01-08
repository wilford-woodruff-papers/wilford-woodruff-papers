<div>
    @if($topics->count() > 0)
        <div class="property">
            <div class="values">
                @foreach($topics->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE) as $topic)
                    <div class="value" lang="">
                        <a class="text-secondary"
                           href="{{ route('subjects.show', ['subject' => $topic]) }}">
                            {{ $topic->name }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
