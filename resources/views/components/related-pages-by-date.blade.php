<div>
    @if(count($hits) > 1)
        <div>
            <div class="property">
                <h4>
                    From this Day
                </h4>
                <div class="values">
                    @foreach ($hits as $hit)
                        @if(data_get($hit, 'id') != ('page_'.$page->id))
                            <div>
                                <a href="{{ data_get($hit, 'url') }}"
                                   class="w-full text-secondary"
                                >
                                    {!! data_get($hit, 'name') !!}
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>
    @endif
</div>
