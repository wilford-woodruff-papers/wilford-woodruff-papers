<x-guest-layout>
    <x-slot name="title">
        Figures | {{ config('app.name') }}
    </x-slot>

    <x-documents-banner-image :image="asset('img/banners/document.jpg')"
                              :text="'Figures'"
    />

    <div class="mx-auto max-w-7xl">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <p class="mt-2 text-sm text-gray-700">

                    </p>
                </div>
                <div class="mt-4 sm:flex-none sm:mt-0 sm:ml-16">

                </div>
            </div>
            <div class="flow-root mt-8">
                <div class="overflow-x-auto -my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                    <div class="inline-block py-2 min-w-full align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                            <tr>
                                <th scope="col" class="py-3.5 pr-3 pl-4 text-base font-semibold text-left text-gray-900 sm:pl-0">
                                    Figure
                                </th>
                                <th scope="col" class="py-3.5 px-3 text-base font-semibold text-left text-gray-900">
                                    Description
                                </th>
                                <th scope="col" class="py-3.5 px-3 text-base font-semibold text-left text-gray-900">
                                    Time of Use
                                </th>
                                <th scope="col" class="py-3.5 px-3 text-base font-semibold text-left text-gray-900">
                                    Quantitative or Qualitative Utilization Meaning
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($figures as $figure)
                                    <tr>
                                        <td class="py-4 pr-3 pl-4 text-sm font-medium text-gray-900 whitespace-normal sm:pl-0 min-w-[8em]">
                                            <img src="{{ Storage::disk('figures')->url($figure->filename) }}"
                                                 alt="{{ $figure->design_description }}"
                                                 class="h-48 w-[8em]"
                                            />
                                        </td>
                                        <td class="py-4 px-3 text-lg text-gray-900 whitespace-normal">
                                            {!! $figure->design_description !!}
                                        </td>
                                        <td class="py-4 px-3 text-lg text-gray-900 whitespace-normal">
                                            {!! $figure->period_usage !!}
                                        </td>
                                        <td class="py-4 px-3 text-lg text-gray-900 whitespace-normal">
                                            <div class="flex flex-col gap-y-2">
                                                @if(! empty($figure->quantitative_utilization))
                                                    <div>
                                                        <p class="font-black">
                                                            Quantitative:
                                                        </p>
                                                        <p>
                                                            {!! $figure->quantitative_utilization !!}
                                                        </p>
                                                    </div>
                                                @endif
                                                @if(! empty($figure->qualitative_utilization))
                                                    <div>
                                                        <p class="font-black">
                                                            Qualitative:
                                                        </p>
                                                        <p>
                                                            {!!$figure->qualitative_utilization !!}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
