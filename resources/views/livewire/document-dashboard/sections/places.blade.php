<div x-data="places">
    <div class="">
        <div class="relative">
            <div id="{{ str('Places')->slug() }}" class="absolute -top-32"></div>
            <h2 class="text-2xl font-thin uppercase border-b-4 md:text-3xl lg:text-4xl border-highlight">
                Places
            </h2>
            <p class="mt-4 mb-8 text-xl">
                Browse places mentioned by Wilford Woodruff in this document.
            </p>
        </div>
        <div class="flex gap-x-4 justify-end py-2">
            <div x-on:click="sort('name')" class="flex gap-x-1 items-center cursor-pointer">
                <span>Name</span>
                <div x-show="column == 'name'" x-cloak>
                    <span x-show="direction == 'asc'">
                        <x-heroicon-c-arrow-up class="w-4 h-4 text-cool-gray-500" />
                    </span>
                    <span x-show="direction == 'desc'" x-cloak>
                        <x-heroicon-c-arrow-down class="w-4 h-4 text-cool-gray-500" />
                    </span>
                </div>
            </div>
            <div x-on:click="sort('count')" class="flex gap-x-1 items-center cursor-pointer">
                <span>Count</span>
                <div x-show="column == 'count'" x-cloak>
                    <span  x-show="direction == 'asc'">
                        <x-heroicon-c-arrow-up class="w-4 h-4 text-cool-gray-500" />
                    </span>
                    <span x-show="direction == 'desc'" x-cloak>
                        <x-heroicon-c-arrow-down class="w-4 h-4 text-cool-gray-500" />
                    </span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-x-6 aspect-[16/6]">
            <div class="order-2 col-span-2 md:order-1">
                <div x-data="map"
                     id="map"
                     class="w-full z-[5] aspect-[16/9]"
                ></div>
            </div>
            <div class="overflow-auto order-1 col-span-1 md:order-2">
                <div class="grid grid-cols-1 gap-y-4 pr-2">
                    <template x-for="place in places">
                        <div class="flex gap-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-red-700 shrink-0">
                                <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                            <a x-bind:href="'{{ route('places') }}/subjects/'+place.slug"
                               target="_blank"
                            >
                                <span x-text="place.name" class="text-xl text-secondary"></span>
                                <span x-text="'('+place.count.toLocaleString()+')'" class="text-base text-black"></span>
                            </a>
                        </div>
                    </template>
                </div>
            </div>
        </div>

    </div>
    <div>

        @push('styles')
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        @endpush
        @push('scripts')
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('places', () => ({
                        column: 'name',
                        direction: 'asc',
                        places: @json($item->places),
                        sort(column){
                            if(this.column !== column){
                                this.direction = 'asc';
                                this.column = column;
                            } else {
                                this.direction = (this.direction === 'asc') ? 'desc' : 'asc';
                            }
                            this.places = this.places.sort((a, b) => {
                                if(this.direction === 'asc'){
                                    return a[this.column] > b[this.column] ? 1 : -1;
                                } else {
                                    return a[this.column] < b[this.column] ? 1 : -1;
                                }
                            });
                        }
                    }));
                });
                document.addEventListener('alpine:init', () => {
                    Alpine.data('map', () => ({
                        map: null,
                        init(){
                            this.map = L.map('map', {
                                scrollWheelZoom: false,
                            })
                                .setView([37.71859, -54.140625], 3);

                            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://carto.com/">carto.com</a> contributors'
                            })
                                .addTo(this.map);

                            @foreach($item->places as $place)
                                @if(empty($place->latitude) || empty($place->longitude))
                                    @continue
                                @endif

                                L.marker([{{ $place->latitude }}, {{ $place->longitude }}])
                                .addTo(this.map)
                                .bindPopup(`
                                        <a href="{{ route('subjects.show', ['subject' => $place->slug]) }}"
                                           class="text-base !text-secondary"
                                           target="_blank"
                                        >
                                            {{ $place->name }}
                                        </a>
                                    `)
                                @if($item->places->count() === 1)
                                    .openPopup()
                                @endif
                            ;

                            @endforeach
                        }
                    }));
                });
            </script>
        @endpush
    </div>
</div>
