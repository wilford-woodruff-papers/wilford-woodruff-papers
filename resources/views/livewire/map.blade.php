<x-guest-layout>
    <div id="map"
         class="w-full aspect-[16/9]"
         wire:ignore
    ></div>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@latest/dist/MarkerCluster.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@latest/dist/MarkerCluster.Default.css" />

    @endpush
    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script src="https://unpkg.com/leaflet.markercluster@latest/dist/leaflet.markercluster-src.js"></script>
        <script>
            const map = L.map('map')
                .setView([37.71859, -54.140625], 3);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                })
                .addTo(map);

            var markers = L.markerClusterGroup();


            fetch("{{ route('map.locations') }}")
                .then(response => response.json())
                .then(data => {
                    data.forEach(point => {
                        var marker = L.marker([point.latitude, point.longitude])
                            .bindPopup(`<a href="${point.url}" target="_blank" class="!text-secondary"><b>${point.name}</b></a><br>${point.description}`)
                            .openPopup();
                        markers.addLayer(marker);
                    });

                    map.addLayer(markers);
                })
                .catch(error => console.error('Error fetching data: ', error));
        </script>
    @endpush
</x-guest-layout>
