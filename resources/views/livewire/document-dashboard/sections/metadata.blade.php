<div>
    <div class="relative">
        <div id="{{ str('Metadata')->slug() }}" class="absolute -top-24"></div>
    </div>
    <div x-data="{ active: null }" class="mx-auto mt-4 space-y-4 w-full">
        <div x-data="{
        id: 1,
        get expanded() {
            return this.active === this.id;
        },
        set expanded(value) {
            this.active = value ? this.id : null;
        },
    }" role="region" class="">
            <h2 class="text-2xl font-thin uppercase border-b-4 md:text-3xl lg:text-4xl border-highlight">
                <button
                    x-on:click="expanded = !expanded"
                    :aria-expanded="expanded"
                    class="flex justify-between items-center w-full uppercase"
                >
                    <span>Metadata</span>
                    <span x-show="expanded" aria-hidden="true" class="ml-4">&minus;</span>
                    <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
                </button>
            </h2>

            <div x-show="expanded" x-collapse
                x-cloak
            >
                <div class="px-2 pt-4 pb-4">
                    <table class="min-w-full">
                        <thead></thead>
                        <tbody class="bg-white divide-y divide-gray-200">
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
                                <tr>
                                    <td class="py-4 pr-3 pl-4 text-base font-medium whitespace-nowrap sm:pl-6">
                                        {{ $property->name }}
                                    </td>
                                    <td class="py-4 px-3 text-base whitespace-nowrap">
                                        {!! $value->displayValue($item->values) !!}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
