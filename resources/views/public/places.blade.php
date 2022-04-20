{{--
@php
    $alpha = [];
    $places = [];

    foreach ($subjects as $place) {

        $index = substr($place->name, 0, 1);
        if(! array_key_exists($index, $alpha)){
            $alpha[$index] = [];
        }

        $subject = [
            'name' => $place->name,
            #'url' => '/s/'.$page->params['site-slug'].'/page/'.$page->params['page-slug'],
            'url' => route('subjects.show', ['subject' => $place]),
        ];

        $alpha[$index][] = $subject;
        $places[] = $subject;

    }

    function placeNameSort($a, $b)
    {
        if ($a['name'] == $b['name']) {
            return 0;
        }
        return ($a['name'] < $b['name']) ? -1 : 1;
    }

    usort($places, function ($a, $b, $column = 'name')
    {
        if ($a[$column] == $b[$column]) {
            return 0;
        }
        return ($a[$column] < $b[$column]) ? -1 : 1;
    });

    ksort($alpha);

@endphp
--}}

<x-guest-layout>

    <div class="bg-cover bg-top" style="background-image: url({{ asset('img/banners/places.png') }})">
        <div class="max-w-7xl mx-auto py-4 xl:py-12">
            <h1 class="text-white text-4xl md:text-6xl xl:text-8xl">
                Places
            </h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4">

        <div class="content col-span-12 px-8 py-6">

            <div class="page-title">Discover Wilford Woodruff's impact in the places he lived, taught, and served</div>

        </div>

    </div>

    {{--<script>
        window.places = @json($places);

        function search(){
            return {
                tab: '{{ array_key_first($alpha) }}',
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
    </script>--}}

    <div class="max-w-7xl mx-auto px-4">

        <div class="content col-span-12 px-8 py-6">
            <livewire:places />
        </div>
    </div>

</x-guest-layout>
