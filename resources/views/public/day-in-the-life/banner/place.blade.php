<div class="w-[120%] h-[120%]">
    <div id="map"
         class="w-full scale-125 aspect-[16/9]"
    >

    </div>
</div>
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush
@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>

        window.map = {
            map: null,
        };

        $(document).ready(function() {
            window.map.map = L.map('map')
                .setView([
                    {{ $place->latitude ?? 37.71859 }},
                    {{ $place->longitude ?? -54.140625 }}
                ], 7);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://carto.com/">carto.com</a> contributors'
            })
                .addTo(window.map.map);

            @if(! empty($place->latitude) && ! empty($place->longitude))
                L.marker([
                    {{ $place->latitude }},
                    {{ $place->longitude }}
                ])
                    .addTo(window.map.map);
            @endif
        });
    </script>
@endpush
