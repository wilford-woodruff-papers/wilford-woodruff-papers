<div>
    @if(! empty($volumes))
        <div class="flex flex-wrap gap-4 mt-2 serif">
            @foreach($volumes as $key => $volume)
                <div class="inline-flex gap-x-2 items-center py-1 px-2 text-white bg-secondary">
                    <div class="text-sm font-semibold">
                        {{ $key }}:
                    </div>
                    <div class="">
                        {{ collect($volume)->map(function($item){
                            return str($item)->replace('Doctrine and Covenants ', '');
                        })->join(', ') }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
