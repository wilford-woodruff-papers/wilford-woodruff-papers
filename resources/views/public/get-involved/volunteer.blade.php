<x-guest-layout>
    <x-slot name="title">
        Volunteer | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="max-w-7xl mx-auto px-4">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="Get Involved"/>
                    </div>
                    <div class="content col-span-12 md:col-span-9">
                        <h2>Volunteer</h2>
                        {{--<iframe src="https://form.asana.com/?k=CpIOlOM3HUepk-79q03DPw&d=1201868115729037"
                                class="w-full h-[1000px] border-0"
                        ></iframe>--}}
                        <iframe src="https://form.asana.com/?k=CpIOlOM3HUepk-79q03DPw&d=1201868115729037&embed=true"
                                id="volunteer-form"
                                class="w-full h-[1200px] md:h-[1000px] border-0"
                                name="Volunteer Form"
                        ></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
