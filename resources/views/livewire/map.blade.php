<div x-data="map" class="">
    <div class="flex flex-col pb-6 md:flex-row aspect-[16/7]">
       <div class="relative w-full md:w-3/4">
           <div x-show="loading"
               class="flex absolute z-20 justify-center items-center w-full h-full bg-white opacity-50">
               <div class="animate-ping">
                   Loading...
               </div>
           </div>
           <div id="map"
                class="z-10 w-full aspect-[16/9]"
                wire:ignore
           ></div>
           <div class="flex absolute bottom-2 left-2 flex-col gap-y-2 py-1 px-2 bg-white shadow-2xl z-100">
               <div>
                   <div class="flex gap-x-4 justify-between items-center mb-2 border-b border-gray-200">
                       <div class="font-semibold">
                           Document Type
                       </div>
                       <div x-on:click="reset()"
                            class="flex gap-x-2 items-center cursor-pointer"
                       >
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                           </svg>
                           Reset
                       </div>
                   </div>

                   <div class="grid grid-cols-2 px-2">
                       <template x-for="(count, type) in availableTypes" :key="'type-'+slugify(type)">
                           <div class="flex relative items-start pr-2">
                               <div class="flex items-center h-6">
                                   <input x-model="types"
                                          x-bind:id="'type_'+slugify(type)"
                                          name="types"
                                          type="checkbox"
                                          x-bind:value="type"
                                          class="w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary">
                               </div>
                               <div class="ml-3 text-sm leading-6">
                                   <label x-bind:for="'type_'+slugify(type)"
                                          class="font-medium text-gray-900"
                                          x-bind:data-name="type"
                                            x-text="type + ' ('+count.toLocaleString('en-US')+')'"
                                   ></label>
                               </div>
                           </div>
                       </template>
                   </div>
               </div>
               <div>
                   <div class="mb-2 font-semibold border-b border-gray-200">
                       Date Range
                   </div>
                   <div class="relative py-3 pb-0 w-full"
                        x-cloak
                   >

                       <div class="mx-4">
                           <input type="range"
                                  step="1"
                                  x-bind:min="min"
                                  x-bind:max="max"
                                  x-on:input="mintrigger"
                                  x-on:click.stop="updateLocations"
                                  x-model="minyear"
                                  class="absolute z-20 w-full h-2 opacity-0 appearance-none cursor-pointer pointer-events-none">

                           <input type="range"
                                  step="1"
                                  x-bind:min="min"
                                  x-bind:max="max"
                                  x-on:input="maxtrigger"
                                  x-on:click.stop="updateLocations"
                                  x-model="maxyear"
                                  class="absolute z-20 pr-4 w-full h-2 opacity-0 appearance-none cursor-pointer pointer-events-none">

                           <div class="relative z-10 h-2">

                               <div class="absolute top-0 right-0 bottom-0 left-0 z-10 bg-gray-200 rounded-md"></div>

                               <div class="absolute top-0 bottom-0 z-20 rounded-md bg-secondary"
                                    x-bind:style="'right:'+maxthumb+'%; left:'+minthumb+'%'"></div>

                               <div class="absolute top-0 left-0 z-30 -mt-2 -ml-1 w-6 h-6 rounded-full bg-secondary"
                                    x-bind:style="'left: '+minthumb+'%'"></div>

                               <div class="absolute top-0 right-0 z-30 -mt-2 -mr-3 w-6 h-6 rounded-full bg-secondary"
                                    x-bind:style="'right: '+maxthumb+'%'"></div>

                           </div>

                       </div>

                       <div class="flex gap-x-4 justify-between items-center pt-5 pb-2">
                           <div>
                               <input type="text" maxlength="4" x-on:input="mintrigger" x-model="minyear" class="py-1 px-1 w-12 text-sm text-center rounded border border-gray-200" readonly>
                           </div>
                           <div>
                               <input type="text" maxlength="4" x-on:input="maxtrigger" x-model="maxyear" class="py-1 px-1 w-12 text-sm text-center rounded border border-gray-200" readonly>
                           </div>
                       </div>

                   </div>
               </div>
           </div>
       </div>
       <div class="flex flex-col w-full md:w-1/4">
          <div class="overflow-y-scroll">
              <div x-show="view == 'locations'"
                   id="locations-container"
                   class="relative p-4"
              >
                  <div class="sticky top-0 bg-white">
                      <div class="flex justify-between items-center pb-4">
                          <h2 class="text-xl font-semibold text-black">
                              Locations (<span x-text="locations.count().toLocaleString('en-US')"></span>)
                          </h2>
                          <div x-on:click="reset()"
                               class="flex gap-x-2 items-center cursor-pointer"
                          >
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                              </svg>
                              Reset
                          </div>
                      </div>
                  </div>
                  <div class="mb-4">
                      <label for="search" class="sr-only">Search</label>
                      <input type="search"
                                x-model="q"
                                id="search"
                                x-on:input.debounce.250="search()"
                                class="py-2 px-4 w-full text-sm text-gray-900 bg-white rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-secondary-500 focus:border-secondary-500"
                                placeholder="Search locations..."
                      />
                  </div>
                  <ul id="locations" class="divide-y divide-gray-200">
                      <template x-for="(location, name) in locations.all()" :key="'location-'+location.first().id">
                          <li x-show="name" x-on:click="setLocation(location.first().place)"
                              class="py-1 cursor-pointer"
                          ><span x-text="name" class="pr-1" ></span> (<span x-text="location.count().toLocaleString('en-US')"></span> Mentions)</li>
                      </template>
                  </ul>
              </div>
              <div x-show="view == 'documents'"
                   x-cloak
                   id="documents-container"
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
                              Documents (<span x-text="documents.length.toLocaleString('en-US')"></span>)
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
                      <template x-for="document in documents" :key="'document-'+document.id">
                          <li x-show="document.id" x-on:click="setDocument(document.id)"

                              class="py-1 cursor-pointer"
                          ><span x-text="document.name" class="pr-1"></span> (<span x-text="document.count"></span> Pages)</li>
                      </template>
                  </ul>
              </div>
              <div x-show="view == 'pages'"
                   x-cloak
                   id="pages-container"
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
                  <ul id="pages" class="divide-y divide-gray-200">
                      <template x-for="page in pages" :key="'page-'+page.id">
                          <li x-show="page.id" x-on:click="Livewire.emit('openModal', 'page', {'pageId': page.id})"
                              x-text="page.name"
                              class="flex items-center py-1 cursor-pointer"
                          ></li>
                      </template>
                  </ul>
              </div>
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
        <style>
            input[type=range]::-webkit-slider-thumb {
                pointer-events: all;
                width: 24px;
                height: 24px;
                -webkit-appearance: none;
                /* @apply w-6 h-6 appearance-none pointer-events-auto; */
            }
        </style>
    @endpush
    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/meilisearch@latest/dist/bundles/meilisearch.umd.js'></script>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prunecluster/2.1.0/PruneCluster.min.js" integrity="sha512-TIhw+s9KAwyAGM7n2qG2hM+lvQxja1Hieb3nS3F2y9AFEDImo6SNXoooqmajF/D5lMfriBIasQ6N+pizlF0wTA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('map', () => ({
                    client: null,
                    index: null,
                    places: [],
                    view: 'locations',
                    loading: true,
                    locations: [],
                    places: [],
                    currentlocation: null,
                    documents: [],
                    currentDocument: null,
                    pages: [],
                    filters: [],
                    reload: true,
                    q: '',
                    types: [],
                    availableTypes: [],
                    minyear: '',
                    maxyear: '',
                    min: '',
                    max: '',
                    minthumb: 0,
                    maxthumb: 0,
                    drawTimeout: null,
                    async searchJs() {
                        this.loading = true;
                        this.view = 'locations';

                        const search = await this.index.search(this.q, {
                            hitsPerPage: 100000,
                            filter: this.buildFilter(),
                        });

                        this.places = collect(search.hits);
                        {{--
                        // This was added to prevent redrawing the map when the user clicks on a marker
                        // We want to redo the search to only get documents for that location
                        // But we need to keep the years selection intact
                        --}}
                        if(this.min === this.minyear && this.max == this.maxyear){
                            this.populateYears();
                        }

                        this.drawOnMap();

                        this.populateTypes();

                    },
                    drawOnMap() {
                        this.pruneCluster.RemoveMarkers();
                        this.pruneCluster.ProcessView();
                        // Add a filter fo type and years here
                        visiblePlaces = this.places;

                        if(this.types.length > 0){
                            visiblePlaces = visiblePlaces.filter(item => this.types.includes(item.type));
                        }
                        visiblePlaces = visiblePlaces.filter(item => item.year >= this.minyear && item.year <= this.maxyear);

                        visiblePlaces
                            .groupBy('name')
                            .each(place => {
                                //this.places.push(hit);
                                let hit = {};
                                hit.usages = place.count();
                                hit.name = (place.first()).name;
                                hit.place = (place.first()).place;
                                hit.latitude = (place.first())['_geo']['lat'];
                                hit.longitude = (place.first())['_geo']['lng'];
                                var marker = new PruneCluster.Marker((hit.latitude), (hit.longitude), {count: hit.usages});
                                marker.data.popup = `<button x-on:click="setLocation(${hit.place})" class="!text-secondary"><b>${hit.name}</b> (${hit.usages.toLocaleString('en-US')})</button>`;
                                marker.data.count = hit.usages;
                                this.pruneCluster.RegisterMarker(marker);
                            });

                        this.locations = visiblePlaces
                            .groupBy('name')
                            .sortKeys();

                        this.loading = false;
                        this.map.addLayer(this.pruneCluster);
                        this.pruneCluster.ProcessView();
                    },
                    buildFilter(){
                        this.filters = [];
                        let geo = this.map.getBounds();
                        this.filters.push(
                            '_geoBoundingBox(['+this.preventOutOfBounds(geo._northEast.lat)+', '+this.preventOutOfBounds(geo._northEast.lng)+'], ['+this.preventOutOfBounds(geo._southWest.lat)+', '+this.preventOutOfBounds(geo._southWest.lng)+'])'
                        );
                        return this.filters;
                    },
                    populateTypes(){
                        this.availableTypes = this.places
                            .groupBy('type')
                            .mapWithKeys(item => [item.first().type, item.count()])
                            .all();
                    },
                    populateYears() {
                        this.min = this.places
                            .reject(value => value.year < 1700)
                            .min('year');
                        this.max = this.places
                            .max('year');
                        this.minyear = this.min;
                        this.maxyear = this.max;
                    },
                    init() {
                        this.locations = collect([]);

                        this.client = new MeiliSearch({
                            host: "{{ config('scout.meilisearch.host') }}",
                            apiKey: "{{ config('scout.meilisearch.search_key') }}"
                        });

                        this.index = this.client.index('{{ (app()->environment('production') ? 'places' : 'dev-places') }}');

                        this.map = L.map('map')
                            .setView([37.71859, -54.140625], 3);

                        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            /*maxZoom: 19,*/
                            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        })
                            .addTo(this.map);

                        this.pruneCluster = new PruneClusterForLeaflet();

                        this.configureMarkers();

                        this.searchJs();

                        this.$watch('types', (value, oldValue) => this.drawOnMap());

                        this.map.on('moveend', (function() {
                            if(this.reload){
                                this.searchJs();
                            }
                            this.reload = true;
                        }).bind(this));
                    },
                    reset() {
                        this.map.setView([37.71859, -54.140625], 3);
                        this.view = 'locations';
                        this.currentlocation = null;
                        this.filters = [];
                        this.documents = [];
                        this.currentDocument = null;
                        this.pages = [];
                        this.q = '';
                        this.types = [];
                        this.minyear = this.min;
                        this.maxyear = this.max;
                        this.minthumb = 0;
                        this.maxthumb = 0;
                        this.searchJs();
                    },
                    setLocation(id) {
                        this.reload = false;
                        var l = this.places.firstWhere('place', id);
                        this.map.setZoomAround(L.latLng(l['_geo']['lat'], l['_geo']['lng']), 9, true);
                        this.currentlocation = id;
                        this.view = 'documents';
                        fetch('{{ route('map.documents') }}?location=' + id + '&types='+this.types +'&min_year='+this.minyear+'&max_year='+this.maxyear)
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
                        this.currentDocument = id;
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

                    },
                    search() {
                        this.searchJs();
                    },
                    mintrigger() {
                        this.minyear = Math.min(this.minyear, this.maxyear);
                        this.minthumb = ((this.minyear - this.min) / (this.max - this.min)) * 100;
                        clearTimeout(this.drawTimeout);
                        this.drawTimeout = setTimeout(() => {
                            this.drawOnMap();
                        }, 250);
                    },
                    maxtrigger() {
                        this.maxyear = Math.max(this.maxyear, this.minyear);
                        this.maxthumb = 100 - (((this.maxyear - this.min) / (this.max - this.min)) * 100);
                        clearTimeout(this.drawTimeout);
                        this.drawTimeout = setTimeout(() => {
                            this.drawOnMap();
                        }, 250);
                    },
                    slugify(str) {
                        return String(str)
                            .normalize('NFKD') // split accented characters into their base characters and diacritical marks
                            .replace(/[\u0300-\u036f]/g, '') // remove all the accents, which happen to be all in the \u03xx UNICODE block.
                            .trim() // trim leading or trailing whitespace
                            .toLowerCase() // convert to lowercase
                            .replace(/[^a-z0-9 -]/g, '') // remove non-alphanumeric characters
                            .replace(/\s+/g, '-') // replace spaces with hyphens
                            .replace(/-+/g, '-'); // remove consecutive hyphens
                    },
                    preventOutOfBounds(number)
                    {
                        if (number <= -180) {
                            return -180;
                        }
                        if (number >= 180) {
                            return 180;
                        }

                        return number;
                    },
                    configureMarkers(){
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
                                html: "<span class='flex justify-center items-center h-full rounded-full'><span>" + mentions.toLocaleString('en-US') + "</span></span>",
                                className: c,
                                iconSize: L.point(iconSize, iconSize)
                            });
                        };
                        this.pruneCluster.PrepareLeafletMarker = function(leafletMarker, data) {
                            var mentions = data.count;
                            var c = 'prunecluster text-white bg-primary';
                            var iconSize = 24;

                            /*if (mentions <= 2) {
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
                            }*/
                            leafletMarker.setIcon(
                                L.divIcon({
                                    html: "<span class='flex justify-center items-center h-full rounded-full'><span>" + mentions.toLocaleString('en-US') + "</span></span>",
                                    className: c,
                                    iconSize: [iconSize, iconSize],
                                })
                            );
                            leafletMarker.bindPopup(data.popup);
                        };
                    }
                }))
            })
        </script>
        <script>




        </script>
    @endpush
</div>
