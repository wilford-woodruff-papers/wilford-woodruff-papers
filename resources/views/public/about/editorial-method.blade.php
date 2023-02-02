<x-guest-layout>
    <x-slot name="title">
        Editorial Method | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-16 px-2 md:col-span-3">
                        <x-submenu area="About"/>
                    </div>
                    <div class="col-span-12 md:col-span-9 content">
                        <h2>Editorial Method</h2>
                        <iframe class="w-full h-screen border-0" src="/files/wilford-woodruff-papers-editorial-method.pdf#navpanes=0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
