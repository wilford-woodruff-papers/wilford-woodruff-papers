<x-guest-layout>
    <div id="content" role="main">
        <div class="max-w-7xl mx-auto px-4">
            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="col-span-12 md:col-span-3 px-2 py-16">
                        <x-submenu area="Donate"/>
                    </div>
                    <div class="content col-span-12 md:col-span-9">
                        <h2>Donate Online</h2>
                        {{--<iframe class="border-0" src="https://wp.wilfordwoodruffpapers.org/donate/" style="height: 1800px; width: 100%;"></iframe>--}}
                        <script src="https://app.giveforms.com/widget.js" type="text/javascript"></script>
                        <iframe src="https://app.giveforms.com/campaigns/wilfordwoodruffpapersfoundation/default-giveform" id="giveforms-form-embed" name="giveforms" height="1200px" width="100%" style="min-width: 320px; border: 0;" allowpaymentrequest="true"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
