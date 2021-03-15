<footer class="bg-primary">
    <div class="max-w-7xl mx-auto overflow-hidden py-12 px-4 sm:px-6 lg:px-8">
        <div class="font-serif text-3xl md:text-5xl font-medium text-highlight">
            {{ config('app.name', 'Laravel') }}
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 mt-12">
            <div>
                <div class="justify-center mt-4 md:mr-8"
                     id="search">
                    <div>
                        <form action="{{ route('search') }}" id="search-form">
                            <div class="mt-1 flex shadow-sm max-w-full">
                                <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                    <input class="block w-full rounded-none pl-2 sm:text-sm border-white"
                                           type="search"
                                           name="q"
                                           value="{{ request('q') }}"
                                           placeholder="Search website"
                                           aria-label="Search website">
                                </div>
                                <button class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2">
                                    <svg class="h-5 w-5 text-secondary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <span class="sr-only">Search website</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-span-1 md:col-span-2 mt-4 md:pl-16 text-lg">
                <a href="/s/wilford-woodruff-papers/page/contribute-documents"
                   class="cursor-pointer"
                >
                    <div class="text-white">
                        Do you know of any of Wilford Woodruff documents that we might not have heard about? Tell us
                    </div>
                </a>
            </div>
        </div>

        <div class="mt-12 grid grid-cols-2 gap-8 xl:col-span-2">
            <div class="md:grid md:grid-cols-2 md:gap-8">
                <div>
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase">
                        About
                    </h3>
                    <ul class="mt-4 space-y-4">

                        <li>
                            <a href="/s/wilford-woodruff-papers/page/about" class="text-base text-white hover:text-highlight">
                                Our Mission & Story
                            </a>
                        </li>

                        <li>
                            <a href="/s/wilford-woodruff-papers/page/meet-the-team" class="text-base text-white hover:text-highlight">
                                Meet the Team
                            </a>
                        </li>

                        <li>
                            <a href="/s/wilford-woodruff-papers/page/frequently-asked-questions" class="text-base text-white hover:text-highlight">
                                Frequently Asked Questions
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="mt-12 md:mt-0">
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase">
                        Get Involved
                    </h3>
                    <ul class="mt-4 space-y-4">

                        <li>
                            <a href="/s/wilford-woodruff-papers/page/volunteer" class="text-base text-white hover:text-highlight">
                                Volunteer
                            </a>
                        </li>

                        <li>
                            <a href="/s/wilford-woodruff-papers/page/contribute-documents" class="text-base text-white hover:text-highlight">
                                Contribute Documents
                            </a>
                        </li>

                        <li class="pt-2">
                            <a href="/s/wilford-woodruff-papers/page/donate-online" class="text-base py-2 px-4 border-2 border-highlight text-white bg-highlight">
                                Donate Online
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="md:grid md:grid-cols-3 md:gap-8">
                <div>
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase">
                        Media
                    </h3>
                    <ul class="mt-4 space-y-4">

                        <li>
                            <a href="/s/wilford-woodruff-papers/photos" class="text-base text-white hover:text-highlight">
                                Photos
                            </a>
                        </li>

                        <li>
                            <a href="/s/wilford-woodruff-papers/page/podcasts" class="text-base text-white hover:text-highlight">
                                Podcasts
                            </a>
                        </li>

                        <li>
                            <a href="/s/wilford-woodruff-papers/page/videos" class="text-base text-white hover:text-highlight">
                                Videos
                            </a>
                        </li>

                        <li>
                            <a href="/s/wilford-woodruff-papers/page/media-kit" class="text-base text-white hover:text-highlight">
                                Media Kit
                            </a>
                        </li>

                        <li>
                            <a href="/s/wilford-woodruff-papers/page/newsroom" class="text-base text-white hover:text-highlight">
                                Newsroom
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="col-span-1 md:col-span-2">
                    <script async data-uid="3502e7bc3f" src="https://wilford-woodruff-papers.ck.page/3502e7bc3f/index.js"></script>
                </div>
            </div>
        </div>

        <div class="text-white mt-8">
            <div class="">
                <div class="flex my-4 gap-4">
                    <!--<div class="">
                        <a href="https://twitter.com/WoodruffPapers" target="_blank">
                            <svg class="h-6 w-6 text-white" xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' stroke='currentColor'><title>Twitter Logo</title><path  fill="#fff" d='M496 109.5a201.8 201.8 0 01-56.55 15.3 97.51 97.51 0 0043.33-53.6 197.74 197.74 0 01-62.56 23.5A99.14 99.14 0 00348.31 64c-54.42 0-98.46 43.4-98.46 96.9a93.21 93.21 0 002.54 22.1 280.7 280.7 0 01-203-101.3A95.69 95.69 0 0036 130.4c0 33.6 17.53 63.3 44 80.7A97.5 97.5 0 0135.22 199v1.2c0 47 34 86.1 79 95a100.76 100.76 0 01-25.94 3.4 94.38 94.38 0 01-18.51-1.8c12.51 38.5 48.92 66.5 92.05 67.3A199.59 199.59 0 0139.5 405.6a203 203 0 01-23.5-1.4A278.68 278.68 0 00166.74 448c181.36 0 280.44-147.7 280.44-275.8 0-4.2-.11-8.4-.31-12.5A198.48 198.48 0 00496 109.5z'/></svg>
                        </a>
                    </div>-->
                    <div class="">
                        <a href="https://www.facebook.com/wilfordwoodruffpapersfoundation" target="_blank">
                            <svg class="h-6 w-6 text-white" xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><title>Facebook Logo</title><path fill="#fff" d='M480 257.35c0-123.7-100.3-224-224-224s-224 100.3-224 224c0 111.8 81.9 204.47 189 221.29V322.12h-56.89v-64.77H221V208c0-56.13 33.45-87.16 84.61-87.16 24.51 0 50.15 4.38 50.15 4.38v55.13H327.5c-27.81 0-36.51 17.26-36.51 35v42h62.12l-9.92 64.77H291v156.54c107.1-16.81 189-109.48 189-221.31z' fill-rule='evenodd'/></svg>
                        </a>
                    </div>
                    <div class="">
                        <a href="https://www.instagram.com/wilfordwoodruffpapers/" target="_blank">
                            <svg class="h-6 w-6 text-white" xmlns='http://www.w3.org/2000/svg' class='ionicon' viewBox='0 0 512 512'><title>Logo Instagram</title><path fill="#fff" d='M349.33 69.33a93.62 93.62 0 0193.34 93.34v186.66a93.62 93.62 0 01-93.34 93.34H162.67a93.62 93.62 0 01-93.34-93.34V162.67a93.62 93.62 0 0193.34-93.34h186.66m0-37.33H162.67C90.8 32 32 90.8 32 162.67v186.66C32 421.2 90.8 480 162.67 480h186.66C421.2 480 480 421.2 480 349.33V162.67C480 90.8 421.2 32 349.33 32z'/><path fill="#fff" d='M377.33 162.67a28 28 0 1128-28 27.94 27.94 0 01-28 28zM256 181.33A74.67 74.67 0 11181.33 256 74.75 74.75 0 01256 181.33m0-37.33a112 112 0 10112 112 112 112 0 00-112-112z'/></svg>
                        </a>
                    </div>
                    <!--<div class="">
                        <a href="#" target="_blank">
                            <svg class="h-6 w-6 text-white" xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><title>Youtube Logo</title><path fill="#fff" d='M508.64 148.79c0-45-33.1-81.2-74-81.2C379.24 65 322.74 64 265 64h-18c-57.6 0-114.2 1-169.6 3.6C36.6 67.6 3.5 104 3.5 149 1 184.59-.06 220.19 0 255.79q-.15 53.4 3.4 106.9c0 45 33.1 81.5 73.9 81.5 58.2 2.7 117.9 3.9 178.6 3.8q91.2.3 178.6-3.8c40.9 0 74-36.5 74-81.5 2.4-35.7 3.5-71.3 3.4-107q.34-53.4-3.26-106.9zM207 353.89v-196.5l145 98.2z'/></svg>
                        </a>
                    </div>-->
                    <div class="">
                        <a href="https://www.linkedin.com/company/wilford-woodruff-papers-foundation/" target="_blank">
                            <svg class="h-6 w-6 text-white" xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><title>Linkedin Logo</title><path fill="#fff" d='M444.17 32H70.28C49.85 32 32 46.7 32 66.89v374.72C32 461.91 49.85 480 70.28 480h373.78c20.54 0 35.94-18.21 35.94-38.39V66.89C480.12 46.7 464.6 32 444.17 32zm-273.3 373.43h-64.18V205.88h64.18zM141 175.54h-.46c-20.54 0-33.84-15.29-33.84-34.43 0-19.49 13.65-34.42 34.65-34.42s33.85 14.82 34.31 34.42c-.01 19.14-13.31 34.43-34.66 34.43zm264.43 229.89h-64.18V296.32c0-26.14-9.34-44-32.56-44-17.74 0-28.24 12-32.91 23.69-1.75 4.2-2.22 9.92-2.22 15.76v113.66h-64.18V205.88h64.18v27.77c9.34-13.3 23.93-32.44 57.88-32.44 42.13 0 74 27.77 74 87.64z'/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div>
                Wilford Woodruff Papers &copy <?= date('Y') ?> All Rights Reserved.
            </div>
        </div>
    <!--<p class="mt-8 text-center text-base text-gray-400">
                <?php /*if ($footerContent = $this->themeSetting('footer')): */?>
    <?php /*echo $footerContent; */?>
    <?php /*else: */?>
    <?php /*echo $this->translate('Powered by Omeka S'); */?>
    <?php /*endif; */?>
        </p>-->
    </div>
</footer>
