<x-guest-layout>

    <div class="max-w-7xl py-12 mx-auto px-2">

        <div class="grid grid-cols-3 gap-x-3">
            <div class="col-span-3 sm:col-span-2">
                <div class="content">
                    <h2>{{ $press->title }}</h2>
                </div>
                <div class="">
                    @include('public.landing-areas.media.'.Str::of($press->type)->lower())
                </div>
            </div>
            <div class="col-span-0 sm:col-span-1"></div>
        </div>
    </div>

</x-guest-layout>
