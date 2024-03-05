<div>
    <div class="relative">
        <div id="{{ str('People')->slug() }}" class="absolute -top-32"></div>
        <h2 class="text-2xl font-thin uppercase border-b-4 md:text-3xl lg:text-4xl border-highlight">
            People
        </h2>
        <p class="mt-4 mb-8 text-xl">
            Browse people Wilford Woodruff mentioned in this document.
        </p>
    </div>
    <div class="grid grid-cols-1 gap-2 lg:grid-cols-3">
        <div class="col-span-3 mb-16 mx-auto w-full h-[350px] w-[70%]"
            wire:ignore
        >
            <div>
                <canvas id="people-chart" class="max-h-[400px]"></canvas>
            </div>
        </div>
        <div wire:loading x-cloak class="col-span-3">
            <div class="flex justify-center items-center w-full aspect-[16/6]">
                <x-heroicon-o-arrow-path class="w-16 h-16 text-gray-400 animate-spin" />
            </div>
        </div>
        @foreach($item->people->shift(9) as $person)
            <div class="flex flex-col justify-between p-4 border border-gray-300 shadow-lg" wire:loading.remove>
                <div>
                    <a href="{{ route('subjects.show', ['subject' => $person->slug]) }}"
                       class="text-xl text-secondary popup"
                       target="_blank"
                    >
                        {{ $person->display_name }}
                    </a>
                    @if(! empty($display_life_years = $person->display_life_years))
                        <div>
                            {{ $display_life_years }}
                        </div>
                    @endif
                </div>
                <div class="flex justify-between items-center pt-2">
                    <div class="font-medium text-gray-900">
                        <div class="mb-0.5">
                            {{ $person->tagged_count }} {{ str('mention')->plural($person->tagged_count) }}
                        </div>
                        <div class="text-gray-900">
                            {{
                                $person
                                    ->category
                                    ->filter(fn($category) => $category->name !== 'People')
                                    ->pluck('name')
                                    ->map(fn($name) => str($name)->singular())
                                    ->join(', ')
                            }}
                        </div>
                    </div>
                    <div>
                        @if(! empty($person->pid) && $person->pid !== 'n/a')
                            <a href="https://www.familysearch.org/tree/person/details/{{ $person->pid }}"
                               class="block px-2 pt-1 pb-2 text-sm bg-white rounded-md border border-gray-200"
                               target="_blank"
                            >
                                <img src="{{ asset('img/familytree-logo.png') }}"
                                     alt="FamilySearch"
                                     class="w-auto h-6"
                                />
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if($item->people->count() > 0)
        <div x-data="{ active: 0 }" class="mx-auto space-y-4 w-full">
            <div x-data="{
                id: 1,
                get expanded() {
                    return this.active === this.id
                },
                set expanded(value) {
                    this.active = value ? this.id : null
                },
            }" role="region" class="">
                <h2 class="my-4">
                    <button
                        x-on:click="expanded = !expanded"
                        :aria-expanded="expanded"
                        class="flex items-center px-2 w-full text-lg text-secondary"
                    >
                        <span x-show="expanded" aria-hidden="true" class="mr-4" x-cloak>&minus;</span>
                        <span x-show="!expanded" aria-hidden="true" class="mr-4">&plus;</span>
                        <span>Show more</span>
                    </button>
                </h2>

                <div x-show="expanded" x-collapse x-cloak>
                    <div class="">
                        <div class="grid grid-cols-1 gap-2 lg:grid-cols-3">
                            @foreach($item->people as $person)
                                <div class="flex flex-col justify-between p-4 border border-gray-300 shadow-lg">
                                    <div>
                                        <a href="{{ route('subjects.show', ['subject' => $person->slug]) }}"
                                           class="text-xl text-secondary popup"
                                           target="_blank"
                                        >
                                            {{ $person->display_name }}
                                        </a>
                                        @if(! empty($display_life_years = $person->display_life_years))
                                            <div>
                                                {{ $display_life_years }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex justify-between items-center pt-2">
                                        <div class="font-medium text-gray-900">
                                            <div class="mb-0.5">
                                                {{ $person->tagged_count }} {{ str('mention')->plural($person->tagged_count) }}
                                            </div>
                                            <div class="text-gray-900">
                                                {{
                                                    $person
                                                        ->category
                                                        ->filter(fn($category) => $category->name !== 'People')
                                                        ->pluck('name')
                                                        ->map(fn($name) => str($name)->singular())
                                                        ->join(', ')
                                                }}
                                            </div>
                                        </div>
                                        <div>
                                            @if(! empty($person->pid) && $person->pid !== 'n/a')
                                                <a href="https://www.familysearch.org/tree/person/details/{{ $person->pid }}"
                                                   class="block px-2 pt-1 pb-2 text-sm bg-white rounded-md border border-gray-200"
                                                   target="_blank"
                                                >
                                                    <img src="{{ asset('img/familytree-logo.png') }}"
                                                         alt="FamilySearch"
                                                         class="w-auto h-6"
                                                    />
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @push('styles')
            <!-- https://www.chartjs.org/ -->
{{--            <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.min.js"></script>--}}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://unpkg.com/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min.js"></script>
        @endpush
        @push('scripts')
            <script>
                const pieDoughnutLegendClickHandler = Chart.controllers.doughnut.overrides.plugins.legend.onClick;
                const ctx = document.getElementById('people-chart');
                let currentCategory = null;

                const chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: @json(array_keys($this->categories)),
                        datasets: [{
                            label: '# of People',
                            data:  @json(array_values($this->categories)),
                            backgroundColor: [
                                'rgba(11, 40, 54, .1)',
                                'rgba(11, 40, 54, .2)',
                                'rgba(11, 40, 54, .3)',
                                'rgba(11, 40, 54, .4)',
                                'rgba(11, 40, 54, .5)',
                                'rgba(11, 40, 54, .6)',
                                'rgba(11, 40, 54, .7)',
                                'rgba(11, 40, 54, .8)',
                                '#0B2836'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: true,
                                position: 'left',
                                labels: {
                                    font: {
                                        size: 18
                                    }
                                },
                                onClick: function (e, legendItem, legend) {
                                    currentCategory = legendItem.index;
                                    legend.legendItems.forEach((e) => {
                                        if (currentCategory !== legendItem.index && legend.chart.getDataVisibility(e.index) === false) legend.chart.toggleDataVisibility(e.index);
                                        if(e.index !== legendItem.index){
                                            legend.chart.toggleDataVisibility(e.index);
                                        }
                                    });
                                    legend.chart.update();
                                    updateCategories(legendItem.text);
                                }
                            },
                            // labels: {
                            //     fontSize: 16,
                            //     fontFamily: "sans-serif",
                            //     render: 'label',
                            //     fontColor: '#000',
                            //     position: 'default',
                            //     textShadow: true,
                            //     overlap: true,
                            //     render: function (args) {
                            //         // args will be something like:
                            //         // { label: 'Label', value: 123, percentage: 50, index: 0, dataset: {...} }
                            //         return args.label + ' ('+ args.value + ')';
                            //         // return object if it is image
                            //         // return { src: 'image.png', width: 16, height: 16 };
                            //     }
                            // }
                        },
                        // onClick: (e) => {
                        //     console.log(e);
                        //     // const canvasPosition = Chart.helpers.getRelativePosition(e, chart);
                        //     //
                        //     // // Substitute the appropriate scale IDs
                        //     // const dataX = chart.scales.x.getValueForPixel(canvasPosition.x);
                        //     // const dataY = chart.scales.y.getValueForPixel(canvasPosition.y);
                        // }
                    }
                });
                const canvas = document.getElementById('people-chart');
                canvas.onclick = (evt) => {
                    const res = chart.getElementsAtEventForMode(
                        evt,
                        'nearest',
                        { intersect: true },
                        true
                    );
                    // If didn't click on a bar, `res` will be an empty array
                    if (res.length === 0) {
                        return;
                    }
                    // Alerts "You clicked on A" if you click the "A" chart
                    //alert('You clicked on ' + chart.data.labels[res[0].index]);
                    currentCategory = res[0].index;
                    chart.legend.legendItems.forEach((e) => {
                        if (currentCategory !== res[0].index && chart.legend.chart.getDataVisibility(e.index) === false) chart.legend.chart.toggleDataVisibility(e.index);
                        if(e.index !== res[0].index){
                            chart.legend.chart.toggleDataVisibility(e.index);
                        }
                    });
                    chart.legend.chart.update();
                    updateCategories(chart.data.labels[res[0].index]);
                };

                function updateCategories(category){
                    Livewire.dispatch('filterPeopleByCategory', {title: category});
                }
            </script>
        @endpush
    @endif
</div>
