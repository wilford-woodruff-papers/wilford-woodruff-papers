<x-guest-layout>
    <x-slot name="title">Donate to the Wilford Woodruff Papers Foundation</x-slot>

    <div class="bg-center bg-cover" style="background-image: url('{{ asset('img/donate/background.jpg') }}');">
        <div class="py-24 mx-auto max-w-5xl">
            <h1 class="text-6xl font-black text-center text-white uppercase">
                Ways to Give
            </h1>
            <p class="mt-8 text-3xl font-semibold text-center text-white">
                Your generosity makes a difference.
            </p>
        </div>
    </div>

    <div class="my-12">
        <div class="mx-auto mb-16 max-w-7xl">
            <div class="grid grid-cols-1 gap-x-4 md:grid-cols-3 md:divide-x-4 lg:gap-x-12 md:divide-secondary">
                <div class="flex flex-col gap-y-4 pt-2 pr-0 pb-12 pl-10 md:pl-16">
                    <h2 class="text-2xl uppercase sm:text-xl lg:text-3xl text-secondary">
                        Mail a Check
                    </h2>
                    <p class="text-xl">
                        Not into giving online? Feel free to send a check to our organization to help us complete this historic project.
                    </p>

                    <div class="text-xl font-semibold text-black">
                        <address>
                            Wilford Woodruff Papers Foundation<br />
                            4025 W. Centennial St.<br />
                            Cedar Hills, UT 84062
                        </address>
                    </div>
                </div>
                <div class="flex flex-col gap-y-4 pt-2 pr-10 pb-12 pl-10 md:pr-12 md:pl-24">
                    <h2 class="text-2xl uppercase sm:text-xl lg:text-3xl text-secondary">
                        Give Online
                    </h2>
                    <p>

                    </p>
                    <div class="flex flex-col gap-y-4">
                        <a href="{{ route('donate.online') }}"
                           class="flex gap-x-4 justify-center items-center py-4 px-6 text-2xl text-white border-2 border-secondary bg-secondary hover:bg-secondary-700"
                           target="_blank"
                        >
                            <span>
                                Donate Online
                            </span>
                        </a>
                        <a href="https://www.facebook.com/wilfordwoodruffpapersfoundation"
                           class="flex gap-x-4 justify-center items-center py-4 px-6 text-2xl border-2 hover:text-white text-secondary border-secondary hover:bg-secondary"
                           target="_blank"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#395693" width="24" height="24" style="scale: 1.3;" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                            <span>
                                Facebook
                            </span>

                        </a>
                        <a href="https://account.venmo.com/u/wilfordwoodruffpapers"
                           class="flex justify-center items-center py-0 px-6 text-2xl border-2 hover:text-white text-secondary border-secondary hover:bg-secondary"
                           target="_blank"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-10" width="64" height="64" style="scale: .5;"><g transform="matrix(.124031 0 0 .124031 -.000001 56.062016)"><rect y="-452" rx="61" height="516" width="516" fill="#3396cd"/><path d="M385.16-347c11.1 18.3 16.08 37.17 16.08 61 0 76-64.87 174.7-117.52 244H163.5l-48.2-288.35 105.3-10 25.6 205.17C270-174 299.43-235 299.43-276.56c0-22.77-3.9-38.25-10-51z" fill="#fff"/></g></svg>
                            <span>
                                Venmo
                            </span>
                        </a>
                    </div>
                </div>
                <div class="flex flex-col gap-y-4 pt-2 pr-12 pb-12 pl-10 md:pr-4 md:pl-8 lg:pr-12 lg:pl-16">
                    <h2 class="text-2xl uppercase sm:text-xl lg:text-3xl text-secondary">
                        Donations-in-Kind
                    </h2>
                    <p class="text-xl">
                        Interested in donating an endowment, estate gift, bequest, DAFs, stocks, bonds, securities, or other in-kind gifts?
                    </p>
                    <p class="text-xl">
                        Email us at <a href='&#109;&#97;il&#116;&#111;&#58;co&#110;&#116;%61ct&#64;&#37;77i&#37;6C&#102;o&#114;dwo&#111;%6&#52;%72&#37;&#55;&#53;f&#37;66%7&#48;&#97;p&#101;&#114;&#115;&#46;%6Fr&#103;' class="underline text-secondary">&#99;ont&#97;&#99;t&#64;wi&#108;f&#111;r&#100;&#119;oodruf&#102;p&#97;pers&#46;org</a> or use the link below to contact us.
                    </p>
                    <div>
                        <a href="{{ route('contact-us') }}"
                           class="flex gap-x-4 justify-center items-center py-4 px-6 text-2xl bg-white border-2 hover:text-white text-secondary border-secondary hover:bg-secondary"
                        >
                            <span>
                                Contact Us
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="my-12">
        <div class="mx-auto mb-16 max-w-5xl">
            <div class="grid gap-12 px-4 md:grid-cols-2 md:px-0">
                <div class="grid justify-center items-center sm:grid-cols-2">
                    <a href="https://www.guidestar.org/profile/84-4318803" target="_blank" class="text-center">
                        <img src="{{ asset('img/donate/platinum-guidestar.png') }}"
                             alt="Wilford Woodruff Papers Foundation is a gold-level GuideStar participant, demonstrating its commitment to transparency."
                             title="Wilford Woodruff Papers Foundation is a gold-level GuideStar participant, demonstrating its commitment to transparency."
                             class="inline w-auto h-[240px]"
                        />
                    </a>
                    <a href="https://www.charitynavigator.org/ein/844318803" target="_blank" class="text-center">
                        <img src="{{ asset('img/donate/fours-star-charity-navigator.png') }}"
                             alt="Wilford Woodruff Papers Foundation 4 Star profile on Charity Navigator."
                             title="Wilford Woodruff Papers Foundation 4 Star profile on Charity Navigator."
                             class="inline w-auto h-[200px]"
                        />
                    </a>
                </div>
                <div class="flex items-center">
                    <p class="px-8 text-xl md:px-0">
                        The Wilford Woodruff Papers Foundation is a 501(c)(3) nonprofit organization. Your donation to the Foundation may qualify as a charitable deduction for federal income tax purposes. The Wilford Woodruff Papers Foundation's EIN is 84-4318803.
                    </p>
                </div>
            </div>
        </div>
    </div>


    <div class="mt-12 mb-12">
        <div class="mx-auto mb-16 max-w-7xl text-center">
            <h2 class="inline-block px-12 pb-1 text-3xl uppercase border-b-4 border-highlight">
                Testimonies
            </h2>
            <p class="px-4 mx-auto mt-6 max-w-2xl text-xl md:px-8">
                See how your donation will help inspire people, especially the rising generation, to study and increase their faith in Jesus Christ.
            </p>
        </div>
        <div class="grid grid-cols-5 gap-x-4 items-center my-24 mx-auto max-w-7xl">
            <div class="order-2 col-span-5 px-4 pt-4 md:order-1 md:col-span-3 md:px-12 md:pt-0">
                <h2 class="text-base font-extrabold tracking-tight text-gray-900 lg:text-xl">
                    Wilford Woodruff Teaches How to Handle Opposition
                </h2>
                <div class="pt-1 my-4 border-t border-gray-200">
                    <div class="flex items-center mt-3 space-x-3">
                        <div class="text-sm font-medium text-gray-900 lg:text-base">
                            Scierra Clegg
                        </div>
                    </div>
                </div>
                <div class="flex gap-x-4 mt-4 text-base text-gray-800 lg:text-lg">
                    <div class="flex-initial">
                        <svg class="w-8 h-8 text-primary-80" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                        </svg>
                    </div>
                    <blockquote class="text-justify">
                        <p>We have a lot of difficulties and adversity in our lives, but when you're connected to God and you have a perspective of why you're doing the things you're doing, and who you are and your purpose, you can do anything with a good attitude.</p>
                    </blockquote>
                    <div class="flex-initial">
                        <svg class="w-8 h-8 transform rotate-180 text-primary-80" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="order-1 col-span-5 md:order-2 md:col-span-2">
                <div class="mx-auto w-[260px] h-[160px] lg:w-[480px] lg:h-[310px]">
                    <iframe class="w-[260px] h-[160px] lg:w-[480px] lg:h-[310px]" src="https://www.youtube.com/embed/Sf7toPmkOCQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-5 gap-x-4 items-center my-24 mx-auto max-w-7xl">
            <div class="order-2 col-span-5 px-4 pt-4 md:order-2 md:col-span-3 md:px-12 md:pt-0">
                <h2 class="text-base font-extrabold tracking-tight text-gray-900 lg:text-xl">
                    Knowing My Ancestry Gives Me Strength
                </h2>
                <div class="pt-1 my-4 border-t border-gray-200">
                    <div class="flex items-center mt-3 space-x-3">
                        <div class="text-sm font-medium text-gray-900 lg:text-base">
                            Kate Barrus
                        </div>
                    </div>
                </div>
                <div class="flex gap-x-4 mt-4 text-base text-gray-800 lg:text-lg">
                    <div class="flex-initial">
                        <svg class="w-8 h-8 text-primary-80" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                        </svg>
                    </div>
                    <blockquote class="text-justify">
                        <p>The reason why I decided to serve a mission was because I know that the gospel makes me happy. It's where I've found true and lasting joy.</p>
                    </blockquote>
                    <div class="flex-initial">
                        <svg class="w-8 h-8 transform rotate-180 text-primary-80" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="order-1 col-span-5 md:order-1 md:col-span-2">
                <div class="mx-auto w-[260px] h-[160px] lg:w-[480px] lg:h-[310px]">
                    <iframe class="w-[260px] h-[160px] lg:w-[480px] lg:h-[310px]" src="https://www.youtube.com/embed/2kYwDDFOn6s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-5 gap-x-4 items-center my-24 mx-auto max-w-7xl">
            <div class="order-2 col-span-5 px-4 pt-4 md:order-1 md:col-span-3 md:px-12 md:pt-0">
                <h2 class="text-base font-extrabold tracking-tight text-gray-900 lg:text-xl">
                    The Wilford Woodruff Papers Have Taught Me How a Prophet Works and Thinks
                </h2>
                <div class="pt-1 my-4 border-t border-gray-200">
                    <div class="flex items-center mt-3 space-x-3">
                        <div class="text-sm font-medium text-gray-900 lg:text-base">
                            Cory Clay
                        </div>
                    </div>
                </div>
                <div class="flex gap-x-4 mt-4 text-base text-gray-800 lg:text-lg">
                    <div class="flex-initial">
                        <svg class="w-8 h-8 text-primary-80" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                        </svg>
                    </div>
                    <blockquote class="text-justify">
                        <p>I've learned a lot from the Wilford Woodruff Papers, as I've been reading through his journals, I learned a lot about how a prophet works, how he thinks and how he gains inspiration, revelation.</p>
                    </blockquote>
                    <div class="flex-initial">
                        <svg class="w-8 h-8 transform rotate-180 text-primary-80" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="order-1 col-span-5 md:order-2 md:col-span-2">
                <div class="mx-auto w-[260px] h-[160px] lg:w-[480px] lg:h-[310px]">
                    <iframe class="w-[260px] h-[160px] lg:w-[480px] lg:h-[310px]" src="https://www.youtube.com/embed/x-eaK7Q1xNM" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                </div>
            </div>
        </div>

    </div>

    <div class="my-16 mx-auto max-w-xl text-center">
        <a href="{{ route('donate.online') }}"
           class="flex gap-x-4 justify-center items-center py-4 px-6 text-2xl text-white border-2 border-secondary bg-secondary hover:bg-secondary-700"
           target="_blank"
        >
            <span>
                Donate Online
            </span>
        </a>
    </div>

    @push('styles')
        <style>
            a:hover svg {
                fill: #ffffff;
            }
        </style>
    @endpush
</x-guest-layout>
