@php
    $places = [];

    foreach ($subjects as $place) {
        $subject = [
            'name' => $place->name,
            #'url' => '/s/'.$page->params['site-slug'].'/page/'.$page->params['page-slug'],
            'url' => route('subjects.show', ['subject' => $place]),
        ];
        $places[] = $subject;

    }

    usort($places, function ($a, $b, $column = 'name')
    {
        if ($a[$column] == $b[$column]) {
            return 0;
        }
        return ($a[$column] < $b[$column]) ? -1 : 1;
    });
@endphp

<x-guest-layout>

    <div class="bg-cover bg-top" style="background-image: url({{ asset('img/banners/places.png') }})">
        <div class="max-w-7xl mx-auto py-12">
            <h1 class="text-white text-8xl">
                Places
            </h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4">

        <div class="content col-span-12 px-8 py-6">

            <div class="page-title">Discover Wilford Woodruff's impact in the places he lived, taught, and served</div>

        </div>

    </div>

    <script>
        window.places = @json($places);

        function search(){
            return {
                q: null,
                filteredPlaces: window.places,
                filter() {
                    this.filteredPlaces = places.filter( place => place.name.toUpperCase().indexOf(this.q.toUpperCase()) > -1 );
                },
                initPlaces(){
                    this.filteredPlaces = window.places;
                }
            }
        }
    </script>

    <div class="max-w-7xl mx-auto px-4">

        <div class="content col-span-12 px-8 py-6">

            <div x-data="search()"
                 x-init="initPlaces()"
                 class="-12">
                <div class="max-w-7xl text-center">
                    <input class="max-w-xl w-full shadow-sm sm:max-w-xl sm:text-sm border-gray-300"
                           x-model="q"
                           x-on:keyup="filter()"
                           type="search"
                           name="q"
                           value=""
                           placeholder="Search Places"
                           aria-label="Search Places"
                    >
                </div>

                <div class="px-2 mt-8">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <template x-for="(place, index) in filteredPlaces" :key="index">
                            <div class="">
                                <a class="text-secondary"
                                   x-bind:href="place.url"
                                   x-text="place.name"
                                >
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="px-2 text-secondary"
                     x-show="q && filteredPlaces.length < 1"
                     x-cloak
                >
                    No results
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>
