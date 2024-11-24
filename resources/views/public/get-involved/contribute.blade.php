<x-guest-layout>
    <x-slot name="title">
        Contribute | {{ config('app.name') }}
    </x-slot>
    <div id="content" role="main">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 py-16 px-2 md:col-span-3">
                        <x-submenu area="Get Involved"/>
                    </div>
                    <div class="col-span-12 md:col-span-9 content">
                        <h2>Contribute Documents</h2>
                        <p class="text-lg">
                            The mission of the Wilford Woodruff Papers Foundation is to preserve and publish all of Wilford Woodruff’s records. If you have an original document that was written by or signed by Wilford Woodruff, or a letter written to Wilford Woodruff, and you are willing to share a digital image of the document with us for inclusion in the Wilford Woodruff Papers, please complete the form below. Thank you!
                        </p>
                        <livewire:forms.contribute-documents />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
