<div>
    <div class="relative">
        <div id="{{ str('Metadata')->slug() }}" class="absolute -top-32"></div>
        <h2 class="text-2xl font-thin uppercase border-b-4 md:text-3xl lg:text-4xl border-highlight">
            Metadata
        </h2>
    </div>
    <div class="grid grid-cols-3">
        @foreach(\App\Models\Property::query()->whereIn('name', [
                '*Source',
                '*Repository',
                '*Collection Name',
                '*Collection Description',
                '*Collection Number',
                '*Collection Box',
                '*Collection Folder',
                '*Collection Page',
            ])
            as $property)
            @if(! empty($value = $item->values->where('property_id', $property->id)->first()))
                <div>
                    <div>
                        <p class="text-lg font-semibold text-secondary">
                            {{ $property->name }}
                        </p>
                    </div>
                    <div>
                        <p class="text-lg font-semibold text-secondary">
                            {{ $value->value }}
                        </p>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
