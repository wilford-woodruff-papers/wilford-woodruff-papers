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
                        {{--<script src="https://app.giveforms.com/widget.js" type="text/javascript"></script>
                        <iframe src="https://app.giveforms.com/campaigns/wilfordwoodruffpapersfoundation/default-giveform" id="giveforms-form-embed" name="giveforms" height="1200px" width="100%" style="min-width: 320px; border: 0;" allowpaymentrequest="true"></iframe>--}}
                        {{--<iframe src="https://form-renderer-app.donorperfect.io/give/wilford-woodruff-papers-foundation/online-donation-form" id="donorperfect-form-embed" name="donorperfect" class="h-[3600px] sm:h-[3300px] md:h-[2800px]" width="100%" style="min-width: 320px; border: 0;" allowpaymentrequest="true"></iframe>--}}
                        <p>
                            We are currently upgrading our online donation form. If you'd like to donate online please check back.
                        </p>
                        <p>
                            If you'd like to send a check, you can mail it to the address below.
                        </p>
                        <div class="text-black text-xl font-semibold">
                            <address>
                                Wilford Woodruff Papers Foundation<br />
                                4025 W. Centennial St.<br />
                                Cedar Hills, UT 84062
                            </address>
                        </div>
                        <p class="text-base">
                            For donation questions, please email us at <a href='&#109;&#97;il&#116;&#111;&#58;co&#110;&#116;%61ct&#64;&#37;77i&#37;6C&#102;o&#114;dwo&#111;%6&#52;%72&#37;&#55;&#53;f&#37;66%7&#48;&#97;p&#101;&#114;&#115;&#46;%6Fr&#103;' class="text-secondary underline">&#99;ont&#97;&#99;t&#64;wi&#108;f&#111;r&#100;&#119;oodruf&#102;p&#97;pers&#46;org</a> or use this link to <a href="{{ route('contact-us') }}" class="text-secondary underline"
                            >contact us</a>.
                        </p>
                        <p>
                            Thank you for your support!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
