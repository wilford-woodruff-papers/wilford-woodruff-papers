<x-guest-layout>
    <div id="content" role="main">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-16 px-2 md:col-span-3">
                        <x-submenu area="Media"/>
                    </div>
                    <div class="col-span-12 md:col-span-9 content">
                        <h2>Media Requests</h2>
                        <livewire:forms.media-request />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
