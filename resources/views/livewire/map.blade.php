<div x-data="map">
    <div class="grid grid-cols-12">
       <div class="col-span-12 md:col-span-9">
           <div id="map"
                class="z-10 w-full aspect-[16/9]"
                wire:ignore
           ></div>
       </div>
       <div class="col-span-12 md:col-span-3 overflow-y-scroll max-h-[calc(100vh-34em)]">
           <div x-show="view == 'locations'"
                class="relative p-4"
           >
               <div class="sticky top-0 bg-white">
                   <div class="flex justify-between items-center pb-4">
                       <h2 class="text-xl font-semibold text-black">
                           Locations (<span x-text="locations.length"></span>)
                       </h2>
                       <div x-on:click="map.setView([37.71859, -54.140625], 3)"
                            class="flex gap-x-2 items-center cursor-pointer"
                       >
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                           </svg>
                           Reset
                       </div>
                   </div>
               </div>
                <ul id="locations" class="divide-y divide-gray-200">
                    <template x-for="location in locations" :key="location.id">
                        <li x-show="location.id" x-on:click="setLocation(location.id)"
                            class="py-1 cursor-pointer"
                        ><span x-text="location.name" class="pr-1"></span> (<span x-text="location.usages"></span>)</li>
                    </template>
                </ul>
           </div>
           <div x-show="view == 'documents'"
                class="relative p-4"
           >
               <div class="sticky top-0 bg-white">
                   <span x-on:click="view = 'locations'"
                         class="flex gap-x-2 items-center pb-2 cursor-pointer"
                   >
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                        </svg>
                       Locations
                   </span>
                   <div class="flex justify-between items-center pb-4">
                       <h2 class="text-xl font-semibold text-black">
                           Documents (<span x-text="documents.length"></span>)
                       </h2>
                       <div x-on:click="map.setView([37.71859, -54.140625], 3)"
                            class="flex gap-x-2 items-center cursor-pointer"
                       >
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                           </svg>
                           Reset
                       </div>
                   </div>
               </div>
               <ul id="documents" class="divide-y divide-gray-200">
                   <template x-for="document in documents" :key="document.id">
                       <li x-show="document.id" x-on:click="setDocument(document.id)"

                           class="py-1 cursor-pointer"
                       ><span x-text="document.name" class="pr-1"></span> (<span x-text="document.count"></span>)</li>
                   </template>
               </ul>
           </div>
           <div x-show="view == 'pages'"
                class="relative p-4"
           >
               <div class="sticky top-0 bg-white">
                   <span x-on:click="view = 'documents'"
                         class="flex gap-x-2 items-center pb-2 cursor-pointer"
                   >
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                        </svg>
                       Documents
                   </span>
                   <div class="flex justify-between items-center pb-4">
                       <h2 class="text-xl font-semibold text-black">
                           Pages (<span x-text="pages.length"></span>)
                       </h2>
                       <div x-on:click="map.setView([37.71859, -54.140625], 3)"
                            class="flex gap-x-2 items-center cursor-pointer"
                       >
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                           </svg>
                           Reset
                       </div>
                   </div>
               </div>
               <ul id="pages">
                   <template x-for="page in pages" :key="page.id">
                       <li x-show="page.id" x-on:click="Livewire.emit('openModal', 'page', {'pageId': page.id})"
                           x-text="page.name"
                           class="flex items-center py-1 cursor-pointer"
                       ></li>
                   </template>
               </ul>
           </div>
       </div>
    </div>


    <livewire:side-panel />

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prunecluster/2.1.0/LeafletStyleSheet.css" integrity="sha512-P8CCL50Ti0jhvdVYle38K5TaE0sL9m9H1Sj3GDGwwA14Qc96ydQLS1Ldq4AFPN5sKd+IWq7+1eyBDLuKR331kQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .prunecluster{
                border-radius: 100%;
            }
        </style>
    @endpush
    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prunecluster/2.1.0/PruneCluster.min.js" integrity="sha512-TIhw+s9KAwyAGM7n2qG2hM+lvQxja1Hieb3nS3F2y9AFEDImo6SNXoooqmajF/D5lMfriBIasQ6N+pizlF0wTA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('map', () => ({
                    view: 'locations',
                    locations: [],
                    currentlocation: null,
                    documents: [],
                    document: null,
                    pages: [],
                    reload: true,
                    init() {
                        this.map = L.map('map')
                            .setView([37.71859, -54.140625], 3);

                        let geo = this.map.getBounds();

                        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        })
                            .addTo(this.map);

                        this.pruneCluster = new PruneClusterForLeaflet();

                        this.pruneCluster.BuildLeafletClusterIcon = function(cluster) {
                            var c = 'prunecluster ';
                            var iconSize = 38;
                            var maxPopulation = this.Cluster.GetPopulation();
                            var mentions = this.Cluster.FindMarkersInArea(cluster.bounds).reduce((a, b) => a + (b.data['count'] || 0), 0);

                            if (mentions <= 2) {
                                c += 'bg-secondary-200';
                                iconSize = 20;
                            } else if (mentions > 2 && mentions <= 5) {
                                c += 'bg-secondary-300';
                                iconSize = 24;
                            } else if (mentions > 5 && mentions <= 10) {
                                c += 'bg-secondary-400';
                                iconSize = 28;
                            } else if (mentions > 10 && mentions <= 50) {
                                c += 'text-white bg-secondary-600';
                                iconSize = 34;
                            } else if (mentions > 50 && mentions <= 100) {
                                c += 'text-white bg-secondary-700';
                                iconSize = 40;
                            } else if (mentions > 100 && mentions <= 200) {
                                c += 'text-white bg-secondary-800';
                                iconSize = 46;
                            } else if (mentions > 200) {
                                c += 'text-white bg-secondary-900';
                                iconSize = 52;
                            }

                            return new L.DivIcon({
                                //html: "<div><span>Test:" + cluster.population + "</span></div>",
                                html: "<span class='flex justify-center items-center h-full rounded-full'><span>" + mentions + "</span></span>",
                                className: c,
                                iconSize: L.point(iconSize, iconSize)
                            });
                        };
                        this.pruneCluster.PrepareLeafletMarker = function(leafletMarker, data) {
                            var mentions = data.count;
                            var c = 'prunecluster ';
                            var iconSize = 38;

                            if (mentions <= 2) {
                                c += 'bg-secondary-200';
                                iconSize = 20;
                            } else if (mentions > 2 && mentions <= 5) {
                                c += 'bg-secondary-300';
                                iconSize = 24;
                            } else if (mentions > 5 && mentions <= 10) {
                                c += 'bg-secondary-400';
                                iconSize = 28;
                            } else if (mentions > 10 && mentions <= 50) {
                                c += 'text-white bg-secondary-600';
                                iconSize = 34;
                            } else if (mentions > 50 && mentions <= 100) {
                                c += 'text-white bg-secondary-700';
                                iconSize = 40;
                            } else if (mentions > 100 && mentions <= 200) {
                                c += 'text-white bg-secondary-800';
                                iconSize = 46;
                            } else if (mentions > 200) {
                                c += 'text-white bg-secondary-900';
                                iconSize = 52;
                            }
                            leafletMarker.setIcon(
                                L.divIcon({
                                    html: "<span class='flex justify-center items-center h-full rounded-full'><span>" + mentions + "</span></span>",
                                    className: c,
                                    iconSize: [iconSize, iconSize],
                                })
                            );
                            leafletMarker.bindPopup(data.popup);
                        };

                        fetch('{{ route('map.locations') }}?geo[southWest][lat]=' + geo._southWest.lat + '&geo[southWest][lng]=' + geo._southWest.lng  + '&geo[northEast][lat]=' + geo._northEast.lat + '&geo[northEast][lng]=' + geo._northEast.lng)
                            .then(response => response.json())
                            .then(data => {
                                this.locations = [];
                                data.forEach(point => {
                                    this.locations.push(point);
                                    // Leaflet Way
                                    /*var marker = L.marker([point.latitude, point.longitude])
                                        .bindPopup(`<a href="${point.url}" target="_blank" class="!text-secondary"><b>${point.name}</b></a><br>${point.description}`)
                                        .openPopup()
                                        .addTo(map);*/

                                    // PruneCluster Way
                                    var marker = new PruneCluster.Marker(point.latitude, point.longitude, {count: point.usages});
                                    marker.data.popup = `<button x-on:click="setLocation(${point.id})" class="!text-secondary"><b>${point.name}</b> (${point.usages})</button><br>${point.description}`;
                                    marker.data.count = point.usages;
                                    this.pruneCluster.RegisterMarker(marker);

                                    //markers.addLayer(marker);
                                });

                                this.map.addLayer(this.pruneCluster);
                            })
                            .catch(error => console.error('Error fetching data: ', error));

                        this.map.on('moveend', (function() {
                            if(this.reload){
                                this.updateLocations();
                            }
                            this.reload = true;
                        }).bind(this));
                    },
                    setLocation(id) {
                        var l = this.locations.find((location) => location.id == id);
                        this.reload = false;
                        this.map.setZoomAround(L.latLng(l.latitude, l.longitude), 9, true);
                        this.currentlocation = id;
                        this.documents = [];
                        this.view = 'documents';
                        fetch('{{ route('map.documents') }}?location=' + id)
                            .then(response => response.json())
                            .then(data => {
                                this.documents = [];
                                data.forEach(document => {
                                    this.documents.push(document);
                                });
                            })
                            .catch(error => console.error('Error fetching data: ', error));
                    },
                    setDocument(id) {
                        this.document = id;
                        this.pages = [];
                        this.view = 'pages';
                        fetch('{{ route('map.pages') }}?location=' + this.currentlocation + '&item=' + id)
                            .then(response => response.json())
                            .then(data => {
                                this.pages = [];
                                data.forEach( page => {
                                    this.pages.push(page);
                                });
                            })
                            .catch(error => console.error('Error fetching data: ', error));
                    },
                    updateLocations() {
                        this.view = 'locations';
                        this.pruneCluster.RemoveMarkers();
                        this.pruneCluster.ProcessView();
                        let geo = this.map.getBounds();
                        fetch('{{ route('map.locations') }}?geo[southWest][lat]=' + geo._southWest.lat + '&geo[southWest][lng]=' + geo._southWest.lng  + '&geo[northEast][lat]=' + geo._northEast.lat + '&geo[northEast][lng]=' + geo._northEast.lng)
                            .then(response => response.json())
                            .then(data => {
                                this.locations = [];
                                data.forEach(point => {
                                    this.locations.push(point);

                                    // PruneCluster Way
                                    var marker = new PruneCluster.Marker(point.latitude, point.longitude, {count: point.usages});
                                    marker.data.popup = `<button x-on:click="setLocation(${point.id})" class="!text-secondary"><b>${point.name}</b> (${point.usages})</button><br>${point.description}`;
                                    marker.data.count = point.usages;
                                    this.pruneCluster.RegisterMarker(marker);
                                });

                                this.map.addLayer(this.pruneCluster);
                                this.pruneCluster.ProcessView();
                            })
                            .catch(error => console.error('Error fetching data: ', error));
                    }
                }))
            })
        </script>
        <script>




        </script>
    @endpush
</div>
