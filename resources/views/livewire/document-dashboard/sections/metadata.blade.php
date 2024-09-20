<div>
    <div class="relative">
        <div id="{{ str('Metadata')->slug() }}" class="absolute -top-24"></div>
    </div>
    <div x-data="{ active: null }" class="mx-auto mt-0 space-y-4 w-full">
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
                            @if(empty($value = $item->values->whereIn('property.name', ['Courtesy Of', '*Courtesy Of Exception'])->first()?->value))
                                <tr>
                                    <td class="py-4 pr-3 pl-4 text-base font-medium whitespace-nowrap sm:pl-6">
                                        Courtesy Of
                                    </td>

                                    <td class="py-4 px-3 text-base whitespace-nowrap">
                                        {!! $item->values->whereIn('property.name', ['Repository', '*Repository'])->first()?->repository?->courtesy_of !!}
                                    </td>
                                </tr>
                            @endif
                            @foreach(\App\Models\Property::query()->whereIn('name', [
                                '*Source Link',
                                '*Collection Name',
                                '*Collection Description',
                                '*Collection Number',
                                '*Collection Box',
                                '*Collection Folder',
                                '*Collection Page',
                                '*Courtesy Of Exception',
                            ])->get()
                            as $property)
                                @if(
                                    ! empty($value = $item->values->where('property_id', $property->id)->first())
                                    && ! empty($value->displayValue($item->values))
                                )
                                    <tr>
                                        <td class="py-4 pr-3 pl-4 text-base font-medium whitespace-nowrap sm:pl-6">
                                            {{ str($property->name)->replace('*', '')->replace('Exception', '')->trim() }}
                                        </td>
                                        <td class="py-4 px-3 text-base whitespace-wrap">
                                            {!! $value->displayValue($item->values) !!}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr>
                                <td class="py-4 pr-3 pl-4 text-base font-medium whitespace-nowrap sm:pl-6">
                                    Rights and Use
                                </td>

                                <td class="py-4 px-3 text-base whitespace-nowrap">
                                    <a href="{{ route('media.copyright') }}"
                                        class="underline text-secondary"
                                       target="_blank"
                                    >
                                        Copyright and Use Information
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 pr-3 pl-4 text-base font-medium whitespace-nowrap sm:pl-6">
                                    Transcript
                                </td>

                                <td class="py-4 px-3 text-base whitespace-nowrap">
                                    <a href="{{ route('documents.show.transcript', ['item' => $item->uuid]) }}"
                                        class="underline text-secondary"
                                       target="_blank"
                                    >
                                        View Full Transcript
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
