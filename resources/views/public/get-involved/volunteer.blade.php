<x-guest-layout>
    <x-slot name="title">
        Volunteer | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-16 px-2 md:col-span-3">
                        <x-submenu area="Get Involved"/>
                    </div>
                    <div class="col-span-12 md:col-span-9 content">
                        <h2>Volunteer</h2>
                        {{--<iframe src="https://form.asana.com/?k=CpIOlOM3HUepk-79q03DPw&d=1201868115729037"
                                class="w-full border-0 h-[1000px]"
                        ></iframe>--}}
                        <iframe src="https://form.asana.com/?k=CpIOlOM3HUepk-79q03DPw&d=1201868115729037&embed=true"
                                id="volunteer-form"
                                class="w-full border-0 h-[1200px] md:h-[1000px]"
                                name="Volunteer Form"
                        ></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
