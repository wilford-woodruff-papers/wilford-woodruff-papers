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
            @foreach($periods as $period)
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
                    >{{ $period->start->toFormattedDateString() }} - {{ $period->end->toFormattedDateString() }}</button>
                </li>
            @endforeach
        </ul>

        <!-- Panels -->
        <div role="tabpanels" class="bg-white border border-gray-200 rounded-b-md">
            <!-- Panel -->
            @foreach($periods as $period)
                <section
                    x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                    :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                    role="tabpanel"
                    class="p-8"
                    x-cloak
                >
                    @foreach($types as $key => $type)
                        @php
                            /*$actions = collect([]);
                            $data = $type->each(function($item, $key) use (&$actions){
                                return $actions = $actions->merge($item->actions);
                            });
                            $actions = $actions->sortBy('type.order_column')->groupBy(function($item, $key){
                                return $item->type->name;
                            });*/

                            // TODO: Completed actions are not filtered to user
                            $actions = \App\Models\Action::query()
                                                            ->where(
                                                                'actionable_type',
                                                                'App\Models\Item'
                                                            )
                                                            //->where('assigned_to', auth()->id())
                                                            ->whereHasMorph(
                                                                'actionable',
                                                                [\App\Models\Item::class],
                                                                function (\Illuminate\Database\Eloquent\Builder $query) use ($type){
                                                                    $query->where('type_id', $type->id);
                                                                }
                                                            )
                                                            ->whereBetween('created_at', [$period->start, $period->end])
                                                            ->get();
                            // Check for a goal during the time period. If one doesn't exist just use the latest goal
                            $goals = collect([]);
                            foreach ($actionTypes as $actionType){
                                $goals->push(
                                    \App\Models\Goal::query()
                                                        ->where('type_id', $type->id)
                                                        ->where('action_type_id', $actionType->id)
                                                        ->whereBetween('finish_at', [$period->start, $period->end])
                                                        ->first()?->target
                                    ?? (
                                        \App\Models\Goal::query()
                                                        ->where('type_id', $type->id)
                                                        ->where('action_type_id', $actionType->id)
                                                        ->latest('finish_at')
                                                        ->first()?->target ?? 0
                                    )
                                );
                            }

                            /*$goals = \App\Models\Goal::query()
                                                        ->where('type_id', $type->id)
                                                        ->latest()
                                                        ->limit($actionTypes->count())
                                                        ->get()
                                                        ->sortBy('action_type.order_column');*/

                            $completedActions = collect([]);
                            $actionTypes->transform(function($item, $key) use ($actions){
                                $item->action_count = $actions->whereNotNull('completed_at')
                                                        ->where('action_type_id', $item->id)
                                                        ->count();
                                return $item;
                            });
                        @endphp
                        <h2 class="font-medium text-lg">{{ $type->name }}</h2>
                        <div x-data="{
                        labels: [{{ $actionTypes->pluck('name')->map(function($type, $key){
                                return "'".$type."'";
                            })->join(', ') }}],
                        values: [
                            {
                                label: 'Goal',
                                data: [{{ $goals->join(', ') }}],
                                backgroundColor: 'rgb(11, 40, 54, .5)'
                            },
                            {
                                label: 'Completed',
                                data: [{{ $actionTypes->pluck('action_count')->join(', ') }}],
                                backgroundColor: 'rgba(20, 83, 45, .6)'
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
