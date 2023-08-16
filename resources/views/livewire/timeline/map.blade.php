<div x-ref="container"
     class="relative"
>

    <div wire:ignore
         class="w-full">
        <div id="map"
             class="z-10 w-full aspect-[16/9]"

        ></div>
    </div>
    <div id="event-selector"
         class="hidden top-0 w-full h-20 bg-gray-800 opacity-25">
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prunecluster/2.1.0/LeafletStyleSheet.css" integrity="sha512-P8CCL50Ti0jhvdVYle38K5TaE0sL9m9H1Sj3GDGwwA14Qc96ydQLS1Ldq4AFPN5sKd+IWq7+1eyBDLuKR331kQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endpush
</div>
