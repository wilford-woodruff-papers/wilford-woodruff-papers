<div x-ref="container"
     class="relative"
>
    <div id="map"
         class="z-10 w-full aspect-[16/9]"
         wire:ignore
    ></div>
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prunecluster/2.1.0/LeafletStyleSheet.css" integrity="sha512-P8CCL50Ti0jhvdVYle38K5TaE0sL9m9H1Sj3GDGwwA14Qc96ydQLS1Ldq4AFPN5sKd+IWq7+1eyBDLuKR331kQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endpush
    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prunecluster/2.1.0/PruneCluster.min.js" integrity="sha512-TIhw+s9KAwyAGM7n2qG2hM+lvQxja1Hieb3nS3F2y9AFEDImo6SNXoooqmajF/D5lMfriBIasQ6N+pizlF0wTA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            const map = L.map('map')
                .setView([37.71859, -54.140625], 3);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            })
                .addTo(map);

            var pruneCluster = new PruneClusterForLeaflet();


            fetch("{{ route('map.locations') }}")
                .then(response => response.json())
                .then(data => {
                    data.forEach(point => {
                        /*var marker = L.marker([point.latitude, point.longitude])
                            .bindPopup(`<a href="${point.url}" target="_blank" class="!text-secondary"><b>${point.name}</b></a><br>${point.description}`)
                            .openPopup();*/
                        var marker = new PruneCluster.Marker(point.latitude, point.longitude);
                        marker.data.popup = `<button onclick="Livewire.emit('openPanel', 'Related Documents', ${point.id}, 'location')" class="!text-secondary"><b>${point.name}</b></button><br>${point.description}`;
                        pruneCluster.RegisterMarker(marker);
                        //markers.addLayer(marker);
                    });

                    map.addLayer(pruneCluster);
                })
                .catch(error => console.error('Error fetching data: ', error));
        </script>
    @endpush
</div>
