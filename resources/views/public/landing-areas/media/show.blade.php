<x-guest-layout>

    <div class="py-12 px-2 mx-auto max-w-7xl">

        <div class="grid grid-cols-3 gap-x-3">
            <div class="col-span-3 sm:col-span-2">
                <div class="content">
                    <h2>{{ $press->title }}</h2>
                </div>
                <div class="">
                    @include('public.landing-areas.media.'.Str::of($press->type)->lower())
                </div>
            </div>
            <div class="sm:col-span-1 col-span-0"></div>
        </div>
    </div>

</x-guest-layout>
