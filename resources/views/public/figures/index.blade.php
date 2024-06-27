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
                    <p class="p-4 mt-2 text-xl font-semibold text-justify text-gray-700">
                        Wilford Woodruff included over 9,000 illustrations in his journals. He used 18 symbols repeatedly in predictable contexts to identify recurring events and emotions and these symbols, indicated in the manuscript using Figures 1-18, are drawn almost 8,400 times. The remaining unique images, connected to a single event on a specific day, are indicated in the manuscript by the unnumbered word “Figure.”
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
                                <th scope="col" class="py-3.5 pr-3 pl-4 text-base font-semibold text-left text-gray-900 sm:pl-4">
                                    ID
                                </th>
                                <th scope="col" class="py-3.5 pr-3 pl-4 text-base font-semibold text-left text-gray-900 sm:pl-0">
                                    Example Figure
                                </th>
                                <th scope="col" class="py-3.5 px-3 text-base font-semibold text-left text-gray-900">
                                    Description
                                </th>
                                <th scope="col" class="py-3.5 px-3 text-base font-semibold text-left text-gray-900">
                                    Time of Use
                                </th>
                                <th scope="col" class="py-3.5 px-3 text-base font-semibold text-left text-gray-900">
                                    Meaning
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($figures as $figure)
                                    <tr>
                                        <th class="py-4 pr-8 pl-0 text-lg text-gray-900 whitespace-nowrap">
                                            Figure {!! $figure->tracking_number !!}
                                        </th>
                                        <td class="py-4 pr-3 pl-4 text-sm font-medium text-gray-900 whitespace-normal sm:pl-0 min-w-[8em]">
                                            <img src="{{ Storage::disk('figures')->url($figure->filename) }}"
                                                 alt="{{ $figure->design_description }}"
                                                 class="h-auto w-[8em]"
                                            />
                                        </td>
                                        <td class="py-4 px-3 text-lg text-gray-900 whitespace-normal">
                                            {!! $figure->design_description !!}
                                        </td>
                                        <td class="py-4 px-3 text-lg text-gray-900 whitespace-normal">
                                            <p>{!! str($figure->period_usage)->beforeLast('(') !!}</p>
                                            <p>({!! str($figure->period_usage)->afterLast('(') !!}</p>
                                        </td>
                                        <td class="py-4 px-3 text-lg text-gray-900 whitespace-normal">
                                            <div class="flex flex-col gap-y-2">
                                                @if(! empty($figure->quantitative_utilization))
                                                    <div>
                                                        <p>
                                                            {!! $figure->quantitative_utilization !!}
                                                        </p>
                                                    </div>
                                                @endif
                                                @if(! empty($figure->qualitative_utilization))
                                                    <div>
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
            <div class="my-8 bg-gray-200">
                <p class="py-8 px-4 text-xl">
                    The description of these images above derives from Joshua M. Matson, <a href="https://byustudies.byu.edu/article/decoding-the-self-tracking-symbols-of-wilford-woodruffs-journals/" target="_blank" class="underline text-secondary">"Decoding the Self-Tracking Symbols of Wilford Woodruff's Journals," BYU Studies 63:1 (2024): 151-204</a>, used by permission of the author and of BYU Studies.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
