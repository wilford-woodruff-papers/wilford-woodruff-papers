
<div>
    <div id="map"
         class="w-full aspect-[16/9]"
         style="aspect-ratio: 9/6 auto;"
    >

    </div>
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
</div>
