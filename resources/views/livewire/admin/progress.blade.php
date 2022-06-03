<div>

    <!-- Tabs -->
    <div
        x-data="{
            selectedId: null,
            init() {
                // Set the first available tab on the page on page load.
                this.$nextTick(() => this.select(this.$id('tab', 1)))
            },
            select(id) {
                this.selectedId = id
            },
            isSelected(id) {
                return this.selectedId === id
            },
            whichChild(el, parent) {
                return Array.from(parent.children).indexOf(el) + 1
            }
        }"
        x-id="['tab']"
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
    >
        <!-- Tab List -->
        <ul
            x-ref="tablist"
            @keydown.right.prevent.stop="$focus.wrap().next()"
            @keydown.home.prevent.stop="$focus.first()"
            @keydown.page-up.prevent.stop="$focus.first()"
            @keydown.left.prevent.stop="$focus.wrap().prev()"
            @keydown.end.prevent.stop="$focus.last()"
            @keydown.page-down.prevent.stop="$focus.last()"
            role="tablist"
            class="-mb-px flex items-stretch"
        >
            <!-- Tab -->
            @foreach($targetsDates as $targetsDate)
                <li>
                    <button
                        :id="$id('tab', whichChild($el.parentElement, $refs.tablist))"
                        @click="select($el.id)"
                        @mousedown.prevent
                        @focus="select($el.id)"
                        type="button"
                        :tabindex="isSelected($el.id) ? 0 : -1"
                        :aria-selected="isSelected($el.id)"
                        :class="isSelected($el.id) ? 'border-gray-200 bg-white' : 'border-transparent'"
                        class="inline-flex px-5 py-2.5 border-t border-l border-r rounded-t-md"
                        role="tab"
                    >{{ $targetsDate->publish_at->toFormattedDateString() }}</button>
                </li>
            @endforeach
        </ul>

        <!-- Panels -->
        <div role="tabpanels" class="bg-white border border-gray-200 rounded-b-md">
            <!-- Panel -->
            @foreach($targetsDates as $targetsDate)
                @php
                    $types = $targetsDate->items->groupBy(function($item, $key){
                        return $item->type?->name;
                    });
                @endphp
                <section
                    x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                    :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                    role="tabpanel"
                    class="p-8"
                    x-cloak
                >
                    @foreach($types as $key => $type)
                        @php
                            $actions = collect([]);
                            $data = $type->each(function($item, $key) use (&$actions){
                                return $actions = $actions->merge($item->actions);
                            });
                            $actions = $actions->groupBy(function($item, $key){
                                return $item->type->name;
                            });
                        @endphp
                        <h2 class="font-medium text-lg">{{ $key }}</h2>
                        <div x-data="{
                        labels: [{{ $actions->keys()->map(function($item, $key){
                                return "'".$item."'";
                            })->join(', ') }}],
                        values: [
                            {
                                label: 'Pending',
                                data: [{{ $actions->map(function($item, $key){
                                    return $item->whereNull('completed_at')->count();
                                })->join(', ') }}],
                                backgroundColor: '#EBCCD1' // red
                            },
                            {
                                label: 'Completed',
                                data: [{{ $actions->map(function($item, $key){
                                    return $item->whereNotNull('completed_at')->count();
                                })->join(', ') }}],
                                backgroundColor: '#D6E9C6' // green
                            }
                        ],
                        init() {
                            let chart = new Chart(this.$refs.canvas.getContext('2d'), {
                                type: 'bar',
                                data: {
                                    labels: this.labels,
                                    datasets: this.values,
                                },
                                options: {
                                    interaction: { intersect: false },
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: { display: true },
                                        tooltip: {
                                            displayColors: false,
                                            callbacks: {

                                            }
                                        }
                                    },
                                    scales: {
                                        x: {
                                            stacked: true,
                                        },
                                        y: {
                                            stacked: true,
                                            ticks: {
                                              min: 0,
                                              max: 100,
                                              stepSize: 1,
                                            }
                                        }
                                    }
                                }
                            })

                            this.$watch('values', () => {
                                chart.data.labels = this.labels
                                chart.data.datasets[0].data = this.values
                                chart.update()
                            })
                        }
                    }"
                             class="h-64"
                        >
                            <canvas x-ref="canvas" class="bg-white rounded-lg p-8"></canvas>
                        </div>
                    @endforeach
                </section>
            @endforeach
        </div>
    </div>

    @push('scripts')
        <!-- https://www.chartjs.org/ -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    @endpush
</div>
