<div x-data="map" class="">
    <x-slot name="title">
        Browse Documents by Location | {{ config('app.name') }}
    </x-slot>
    <div class="flex flex-col pb-6 md:flex-row aspect-[16/8]">
       <div class="relative w-full md:w-3/4">
           <div class="flex flex-col gap-y-2 pb-2">
               <div class="px-2">
                   <div class="flex items-center pt-4 pb-1">
                       <div class="pr-6 font-semibold">
                           Types:
                       </div>
                       <div class="grid grid-cols-3 gap-x-2 lg:grid-cols-6">
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
                                   <div class="ml-3 text-base leading-6 truncate">
                                       <label x-bind:for="'type_'+slugify(type)"
                                              class="font-medium text-gray-900"
                                              x-bind:data-name="type"
                                              x-html="type + ` <span class='hidden lg:inline'>(`+count.toLocaleString('en-US')+`)</span>`"
                                       ></label>
                                   </div>
                               </div>
                           </template>
                       </div>
                   </div>
                   <div>
                       <div>
                           <div class="flex gap-x-4 items-center">
                               <div class="pt-3 font-semibold shrink-0">
                                   Years:
                               </div>
                               <div class="relative py-3 pb-0 w-full"
                                    x-cloak
                               >

                                   <div class="flex gap-x-4 items-center">
                                       <div class="flex-0">
                                           <div>
                                               <input type="text" maxlength="4" x-on:input="mintrigger" x-model="minyear" class="py-1 px-1 w-12 text-base text-center border-0" readonly>
                                           </div>
                                       </div>
                                       <div class="flex-1">
                                           <div class="relative">
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
                                                      class="absolute z-20 -mr-4 w-full h-2 opacity-0 appearance-none cursor-pointer pointer-events-none">

                                               <div class="relative z-10 h-2">

                                                   <div class="absolute top-0 right-0 bottom-0 left-0 z-10 bg-gray-200 rounded-md"></div>

                                                   <div class="absolute top-0 bottom-0 z-20 rounded-md bg-secondary"
                                                        x-bind:style="'right:'+maxthumb+'%; left:'+minthumb+'%'"></div>

                                                   <div class="absolute top-0 left-0 z-30 -mt-2 -ml-1 w-6 h-6 rounded-full bg-secondary"
                                                        x-bind:style="'left: '+minthumb+'%'"></div>

                                                   <div class="absolute top-0 right-0 z-30 -mt-2 w-6 h-6 rounded-full bg-secondary"
                                                        x-bind:style="'right: '+maxthumb+'%'"></div>

                                               </div>

                                           </div>
                                       </div>
                                       <div class="flex-0">
                                           <div>
                                               <input type="text" maxlength="4" x-on:input="maxtrigger" x-model="maxyear" class="py-1 px-1 w-12 text-base text-center border-0" readonly>
                                           </div>
                                       </div>
                                   </div>

                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="flex relative flex-col gap-4 justify-between items-center pt-4 md:flex-row">
                       <div class="flex relative gap-4 items-start">
                           <div class="text-base font-semibold leading-6 truncate">
                               <label for="visited"
                                      class="font-semibold text-gray-900"
                                      data-name="visited"
                               >Visited Places Only</label>
                           </div>
                           <div class="flex items-center h-6">
                               <input x-model="visited"
                                      id="visited"
                                      name="visited"
                                      type="checkbox"
                                      value="true"
                                      class="w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary">
                           </div>
                       </div>
                       <div class="flex gap-4 p-2 border border-gray-3">
                            <div class="flex gap-2 items-center">
                                <span class="w-5 h-5 rounded-full bg-primary"></span>
                                <span>Click to show page</span>
                            </div>
                            <div class="flex gap-2 items-center">
                                <div class="flex items-center -space-x-3">
                                    <span class="w-5 h-5 rounded-full bg-secondary-300"></span>
                                    <span class="w-5 h-5 rounded-full bg-secondary-400"></span>
                                    <span class="w-5 h-5 rounded-full bg-secondary-500"></span>
                                    <span class="w-5 h-5 rounded-full bg-secondary-600"></span>
                                    <span class="w-5 h-5 rounded-full bg-secondary-700"></span>
                                    <span class="w-5 h-5 rounded-full bg-secondary-800"></span>
                                    <span class="w-5 h-5 rounded-full bg-secondary-900"></span>
                                </div>
                                <span>Click to zoom and filter</span>
                            </div>
                       </div>
                   </div>
               </div>
           </div>

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
           <div class="flex hidden absolute bottom-2 left-2 flex-col gap-y-2 py-1 px-2 bg-white shadow-2xl z-100">
               <div>
                   <div class="flex gap-x-4 justify-between items-center mb-2 border-b border-gray-200">
                       <div class="font-semibold">
                           Document Type
                       </div>
                       <div x-on:click="reset()"
                            class="flex gap-x-2 items-center cursor-pointer text-secondary"
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
                          <h2 class="text-base font-semibold text-black">
                              Locations (<span x-text="locations.count().toLocaleString('en-US')"></span>)
                          </h2>
                          <div x-on:click="reset()"
                               class="flex gap-x-2 items-center cursor-pointer text-secondary"
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
                              class="py-2 cursor-pointer"
                          >
                              <span x-text="name" class="pr-1 font-medium text-secondary" ></span>
                              <span x-text="' ('+location.count().toLocaleString('en-US') + ((location.count() > 1) ? ' mentions' : ' mention')+')'"></span>
                          </li>
                      </template>
                  </ul>
                  <div x-show="locations.count() === 0 && !loading"
                       x-cloak
                  >
                      <div class="flex gap-x-2 justify-between items-center pb-4">
                          <div>
                              <p class="py-2 font-semibold">0 results found. </p>
                              <p>Try resetting the filters the map and all the filters.</p>
                          </div>
                          <div x-on:click="reset()"
                               class="flex gap-x-2 items-center py-1 px-2 rounded border cursor-pointer border-gray"
                          >
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                              </svg>
                              Reset
                          </div>
                      </div>
                  </div>
              </div>
              <div x-show="view == 'documents'"
                   x-cloak
                   id="documents-container"
                   class="relative p-4"
              >
                  <div class="sticky top-0 bg-white">
                   <span x-on:click="view = 'locations'"
                         class="flex gap-x-2 items-center pb-2 cursor-pointer text-secondary"
                   >
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                        </svg>
                       Locations
                   </span>
                      <div class="flex gap-x-2 items-center pb-4">
                          <div>
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-red-700">
                                  <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                              </svg>
                          </div>
                          <h2  x-text="(currentlocation ? places.where('place', currentlocation).first().name: '')"
                               class="text-base font-medium text-black"></h2>
                      </div>
                      <div class="flex justify-between items-center pb-4">
                          <h3 class="text-base font-semibold text-black">
                              Documents (<span x-text="documents.length.toLocaleString('en-US')"></span>)
                          </h3>
                          <div x-on:click="reset()"
                               class="flex gap-x-2 items-center cursor-pointer text-secondary"
                          >
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                              </svg>
                              Reset
                          </div>
                      </div>
                  </div>
                  <ul id="documents" class="divide-y-2 divide-gray-200">
                      <template x-for="document in documents" :key="'document-'+document.id">
                          <li x-show="document.id"
                              class="py-1"
                          >
                              <div class="flex justify-between items-center">
                                  <span x-text="document.name"
                                        x-bind:title="document.name"
                                        class="py-1 pr-1 truncate"></span>
                                  <span x-text="'('+document.pages.length+')'"></span>
                              </div>
                              <ul id="pages" class="ml-4 divide-y divide-gray-200">
                                  <template x-for="page in document.pages" :key="'page-'+page.id">
                                      <li x-show="page.id" x-on:click="Livewire.dispatch('openModal', {component: 'page', arguments: {'pageId': page.id} })"

                                          class="flex gap-x-2 items-center py-1 cursor-pointer"
                                      >
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
                                          </svg>
                                          <span x-text="'Page ' + page.name" class="pr-1 font-medium text-secondary"></span>
                                      </li>
                                  </template>
                              </ul>
                          </li>
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
            .marker-pin {
                width: 30px;
                height: 30px;
                border-radius: 50% 50% 50% 0;
                /*background: #c30b82;*/
                position: absolute;
                transform: rotate(-45deg);
                left: 50%;
                top: 50%;
                margin: -15px 0 0 -15px;
            }
            /*// to draw white circle*/
               .marker-pin::after {
                   content: '';
                   width: 24px;
                   height: 24px;
                   margin: 3px 0 0 3px;
                   /*background: #fff;*/
                   position: absolute;
                   border-radius: 50%;
               }

            /*// to align icon*/
               .custom-div-icon i {
                   position: absolute;
                   width: 22px;
                   font-size: 22px;
                   left: 0;
                   right: 0;
                   margin: 10px auto;
                   text-align: center;
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
                    visited: false,
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
                        // this.places.each(function(place){
                        //     if(place.type == 'Journals'){
                        //         console.log(place);
                        //     }
                        // });
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

                        if (this.visited == true || this.visited == 'true') {
                            visiblePlaces = visiblePlaces.filter(item => (item.visited == true || item.visited == 'true'));
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
                                var marker = new PruneCluster.Marker((hit.latitude), (hit.longitude), {count: hit.usages, place: hit.place});
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

                        this.map = L.map('map', {
                                scrollWheelZoom: false,
                            })
                            .setView([37.71859, -54.140625], 3);

                        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}.png', {
                            /*maxZoom: 19,*/
                            attribution: '&copy; <a href="https://carto.com/">carto.com</a> contributors'
                        })
                            .addTo(this.map);

                        this.pruneCluster = new PruneClusterForLeaflet();

                        this.configureMarkers();

                        this.searchJs();

                        this.$watch('types', (value, oldValue) => this.drawOnMap());

                        this.$watch('visited', (value, oldValue) => this.drawOnMap());

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
                                if(data.length === 1 && data[0].count === 1){
                                    Livewire.dispatch('openModal', {component: 'page', arguments: {'pageId': data[0].pages[0].id} });
                                }
                                this.documents = [];
                                data.forEach(document => {
                                    this.documents.push(document);
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
                            //var c = 'custom-div-icon text-white bg-primary';
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
                                    html: `<span x-on:click="setLocation(${data.place})" class="flex justify-center items-center h-full rounded-full"><span>` + mentions.toLocaleString('en-US') + `</span></span>`,

                                    /*html: `<span x-on:click="setLocation(${data.place})" class="flex justify-center items-center marker-pin bg-primary"></span><span class="text-white">` + mentions.toLocaleString('en-US') + `</span>`,*/
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
    @endpush
</div>
