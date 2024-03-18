<div>
    <div class="relative">
        <div id="{{ str('Metadata')->slug() }}" class="absolute -top-24"></div>
        <h2 class="text-2xl font-thin uppercase border-b-4 md:text-3xl lg:text-4xl border-highlight">
            Metadata
        </h2>
    </div>
    <div class="grid grid-cols-3 gap-4 p-4">
        @foreach(\App\Models\Property::query()->whereIn('name', [
                '*Source Link',
                '*Repository',
                '*Collection Name',
                '*Collection Description',
                '*Collection Number',
                '*Collection Box',
                '*Collection Folder',
                '*Collection Page',
            ])->get()
            as $property)
            @if(! empty($value = $item->values->where('property_id', $property->id)->first()))
                <div>
                    <div>
                        <p class="text-lg text-black">
                            {{ $property->name }}
                        </p>
                    </div>
                    <div>
                        <p class="text-lg font-semibold text-black">
                            {!! $value->displayValue($item->values) !!}
                        </p>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
