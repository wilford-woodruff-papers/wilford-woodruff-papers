<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="facebook-domain-verification" content="jz329nocbeufu5m4s8g7dxdtz8j2qq" />

    <meta property="og:site_name" content="Wilford Woodruff Papers">

    <meta property="og:description" content="Explore Wilford Woodruff's powerful eyewitness account of the Restoration">
    <meta property="og:type" content="website" />
    <meta property="og:image" content="https://wilfordwoodruffpapers.org/img/wilford-woodruff.png">
    <meta property="og:url" content="https://wilfordwoodruffpapers.org/">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="description" content="Explore Wilford Woodruff's powerful eyewitness account of the Restoration"/>
    <meta name="keywords" content="Wilford Woodruff, Restoration, Prophet, The Church of Jesus Christ of Latter-day Saints"/>

    <title>Donate Online</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro&display=swap" rel="stylesheet">

    <x-favicon />

    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @livewireStyles
    @stack('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
</head>
<body>

    <div class="font-sans text-gray-900 antialiased">
        <div class="grid grid-cols-1 md:grid-cols-7">
            <div class="col-span-1">
                <div class="grid grid-cols-1">
                    <div class="p-4 mx-auto">
                        <a href="{{ route('donate') }}">
                            <img src="{{ asset('img/image-logo-stacked.png') }}" alt="Wilford Woodruff Papers Foundation">
                        </a>
                    </div>
                    <div class="mx-auto">
                        <img src="{{ asset('img/donate/image-1.png') }}"
                             alt=""
                             class="hidden md:block"
                        >
                    </div>
                </div>
            </div>
            <div class="col-span-1 md:col-span-3 flex flex-col">
                <div class="flex flex-1 items-center bg-dark-blue px-12 py-12 md:py-0">
                    <h1 class="text-2xl md:text-6xl text-white">Donate Online</h1>
                </div>
                <div class="flex flex-1 items-center bg-highlight px-12 py-12 md:py-0">
                    <p class="text-dark-blue text-lg text-justify"><span class="font-semibold">With your help</span>, the Wilford Woodruff Papers Foundation provides internships and creates jobs for college students. These positions represent 70% of all positions at the foundation! Your donations also allow us to take these papers, the doctrines they represent, and deliver them to an expansive LDS audience including the rising generation. Thanks to you, we deliver 65 years of church history in a personal way through videos, transcribed documents, social media, and partners such as: FamilySearch, Meridian, FAITH, and Book of Mormon Central.</p>
                </div>
            </div>
            <div class="col-span-1 md:col-span-3">
                <img src="{{ asset('img/donate/image-2.png') }}"
                     alt=""
                     class="w-auto h-full"
                >
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-7">
            <div class="col-span-1"></div>
            <div class="col-span-1 md:col-span-3 bg-dark-blue px-16 py-16">
                <script src="https://app.giveforms.com/widget.js" type="text/javascript"></script>
                <iframe src="https://app.giveforms.com/campaigns/wilfordwoodruffpapersfoundation/default-giveform" id="giveforms-form-embed" name="giveforms" height="1200px" width="100%" style="min-width: 320px; border: 0;" allowpaymentrequest="true"></iframe>
                <div class="grid sm:grid-cols-2 items-center justify-center mt-12">
                    <a href="https://www.guidestar.org/profile/84-4318803" target="_blank" class="text-center">
                        <img src="{{ asset('img/donate/gold-guidestar.png') }}"
                             alt="Wilford Woodruff Papers Foundation is a gold-level GuideStar participant, demonstrating its commitment to transparency."
                             title="Wilford Woodruff Papers Foundation is a gold-level GuideStar participant, demonstrating its commitment to transparency."
                             class="h-[120px] w-auto inline"
                        />
                    </a>
                    <a href="https://www.charitynavigator.org/ein/844318803" target="_blank" class="text-center">
                        <img src="{{ asset('img/donate/fours-star-charity-navigator.png') }}"
                             alt="Wilford Woodruff Papers Foundation 4 Star profile on Charity Navigator."
                             title="Wilford Woodruff Papers Foundation 4 Star profile on Charity Navigator."
                             class="h-[120px] w-auto inline"
                        />
                    </a>
                </div>
                <div class="flex items-center mt-12">
                    <p class="text-xl text-white text-justify px-8 md:px-0">
                        The Wilford Woodruff Papers Foundation is a 501(c)(3) nonprofit organization. Your donation to the Foundation may qualify as a charitable deduction for federal income tax purposes. The Wilford Woodruff Papers Foundation Identification Number (EIN) is 84-4318803.
                    </p>
                </div>
            </div>
            <div class="col-span-1 md:col-span-3">
                <div class="flex flex-col px-32 py-16">
                    <img src="{{ asset('img/donate/quote.png') }}"
                         alt="To be charitable and kind, brings joy and peace and the Holy Ghost. - Wilford Woodruff"
                         class="w-auto h-auto"
                    >
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-7">
            <div class="col-span-1"></div>
            <div class="col-span-1 md:col-span-3 bg-highlight px-16">
                <div class="divide-y divide-dark-blue">
                    <div class="text-xl text-dark-blue py-12">
                        <p class="text-xl py-8">
                            If you'd like to send a check, you can mail it to the address below:
                        </p>
                        <div class="text-black text-xl font-semibold">
                            <address>
                                Wilford Woodruff Papers Foundation<br />
                                4025 W. Centennial St.<br />
                                Cedar Hills, UT 84062
                            </address>
                        </div>
                    </div>
                    <div class="py-12">
                        <p class="text-xl">
                            For donation questions, please email us at <a href='&#109;&#97;il&#116;&#111;&#58;co&#110;&#116;%61ct&#64;&#37;77i&#37;6C&#102;o&#114;dwo&#111;%6&#52;%72&#37;&#55;&#53;f&#37;66%7&#48;&#97;p&#101;&#114;&#115;&#46;%6Fr&#103;' class="text-secondary underline">&#99;ont&#97;&#99;t&#64;wi&#108;f&#111;r&#100;&#119;oodruf&#102;p&#97;pers&#46;org</a> or <a href="{{ route('contact-us') }}" class="text-secondary underline">contact us using ths form</a>.
                        </pclass>
                        <p class="text-2xl py-8 text-center">
                            Thank you for your support!
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-span-3"></div>
        </div>
    </div>

@if(app()->environment(['production']))
    <x-google />
    <x-facebook-pixel />
@endif


@livewireScripts
@livewire('livewire-ui-modal')

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js" charset="utf-8"></script>
<script src="{{ mix('js/app.js') }}"></script>
@stack('scripts')

<x-constant-contact />
</body>
</html>
