<x-guest-layout>

    <div class="bg-cover bg-top" style="background-image: url({{ asset('img/banners/people.png') }})">
        <div class="max-w-7xl mx-auto py-4 xl:py-12">
            <h1 class="text-white text-4xl md:text-6xl xl:text-8xl">
                Wilford Woodruff's Wives and Children
            </h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4">

        <div class="col-span-12 px-8 py-6 mb-12">

            <div class="page-title">Recognize Wilford's influence in the lives of the individuals he interacted with</div>

            <h2 class="section-title">Wilford Woodruff's Wives and Children</h2>

            <div class="px-6 py-4" x-data="{
                                        flyoutOpen: null
                                    }">
                <div class="flow-root">
                    <div class="-mb-8">
                        @foreach($wives->groupBy('marriage_year')->sortBy('marriage_year') as $year => $marriages)
                            @foreach($marriages as $wife)
                                <div>
                                    <div class="relative pb-8"><span aria-hidden="true" class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200">&nbsp;</span>
                                        <div class="relative flex items-start space-x-3">
                                            <div class="relative">
                                                @if($loop->first)
                                                    <span class="text-xl ring-8 ring-white bg-white"> {{ $year }}
                                                        @else
                                                            <span class="text-xl"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                @endif</span> <span class="text-xl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                            </div>
                                            <x-wife :wife="$wife" />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-guest-layout>
