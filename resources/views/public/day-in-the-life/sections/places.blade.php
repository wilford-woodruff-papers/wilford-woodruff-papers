@if(! empty($section['items']) && $section['items']->count() > 0)
    <div>
        <div class="relative">
            <div id="{{ str($section['name'])->slug() }}" class="absolute -top-32"></div>
            <h2 class="text-2xl font-thin uppercase border-b-4 md:text-3xl lg:text-4xl border-highlight">
                {{ $section['name'] }}
            </h2>
            <p class="mt-4 mb-8 text-xl">
                Browse places mentioned in Wilford Woodruff's journal entry on this day.
            </p>
        </div>
        <div class="grid grid-cols-1 gap-y-4 lg:grid-cols-3">
            @foreach($section['items'] as $place)
                <div class="flex gap-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-red-700">
                        <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                    </svg>
                    <a href="{{ route('subjects.show', ['subject' => $place->slug]) }}"
                       class="text-xl text-secondary popup"
                       target="_blank"
                    >
                        {{ $place->name }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <div>
        <div x-data="map"
             id="map"
             class="z-10 w-full aspect-[16/9]"
        ></div>
        @push('styles')
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        @endpush
        @push('scripts')
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
            <script>
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

                            @foreach($section['items'] as $place)
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
                                @if($section['items']->count() === 1)
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
@endif
