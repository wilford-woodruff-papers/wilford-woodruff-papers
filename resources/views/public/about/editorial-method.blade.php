<x-guest-layout>
    <x-slot name="title">
        Editorial Method | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="max-w-7xl mx-auto px-4">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="About"/>
                    </div>
                    <div class="content col-span-12 md:col-span-9">
                        <h2>Editorial Method</h2>
                        <iframe class="border-0 w-full h-screen" src="/files/wilford-woodruff-papers-editorial-method.pdf#navpanes=0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
