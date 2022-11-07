<x-guest-layout>
    <x-slot name="title">Giving Tuesday</x-slot>

    <div class="bg-cover bg-center" style="background-image: url('{{ asset('img/giving-tuesday/background.jpg') }}');">
        <div class="max-w-5xl mx-auto py-24">
            <h1 class="text-6xl text-white font-black text-center uppercase">
                Ways to Give
            </h1>
            <p class="text-white text-center font-semibold text-2xl mt-8">
                Your generosity makes a difference.
            </p>
        </div>
    </div>
    <div class="my-12">
        <div class="max-w-7xl mx-auto mb-16">
            <div class="grid grid-cols-1 md:grid-cols-3 divide-x-4 divide-secondary">
                <div class="flex flex-col gap-y-4 pt-2 pr-12 pb-12 pl-24">
                    <h2 class="text-secondary text-3xl uppercase">
                        Give Online
                    </h2>
                    <p>

                    </p>
                    <div class="flex flex-col gap-y-4">
                        <a href="https://form-renderer-app.donorperfect.io/give/wilford-woodruff-papers-foundation/online-donation-form"
                           class="flex items-center justify-center gap-x-4 text-secondary text-2xl border-2 border-secondary px-6 py-4 hover:text-white hover:bg-secondary"
                           target="_blank"
                        >
                            <span>
                                Online
                            </span>
                        </a>
                        <a href=""
                           class="flex items-center justify-center gap-x-4 text-secondary text-2xl border-2 border-secondary px-6 py-4 hover:text-white hover:bg-secondary"
                           target="_blank"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#395693" width="24" height="24" style="scale: 1.3;" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                            <span>
                                Facebook
                            </span>

                        </a>
                        <a href=""
                           class="flex items-center justify-center text-secondary text-2xl border-2 border-secondary px-6 py-0 hover:text-white hover:bg-secondary"
                           target="_blank"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-10" width="64" height="64" style="scale: .5;"><g transform="matrix(.124031 0 0 .124031 -.000001 56.062016)"><rect y="-452" rx="61" height="516" width="516" fill="#3396cd"/><path d="M385.16-347c11.1 18.3 16.08 37.17 16.08 61 0 76-64.87 174.7-117.52 244H163.5l-48.2-288.35 105.3-10 25.6 205.17C270-174 299.43-235 299.43-276.56c0-22.77-3.9-38.25-10-51z" fill="#fff"/></g></svg>
                            <span>
                                Venmo
                            </span>
                        </a>
                    </div>
                </div>
                <div class="flex flex-col gap-y-4 pt-2 pb-12 px-12">
                    <h2 class="text-secondary text-3xl uppercase">
                        Send in a Check
                    </h2>
                    <p class="text-base">
                        Not into giving online? Feel free to send a check to our organization to help us make a difference in the community.
                    </p>

                    <div class="text-black text-xl font-semibold">
                        <address>
                            Wilford Woodruff Papers Foundation<br />
                            4025 W. Centennial St.<br />
                            Cedar Hills, UT 84062
                        </address>
                    </div>
                </div>
                <div class="flex flex-col gap-y-4 pt-2 pb-12 px-12">
                    <h2 class="text-secondary text-3xl uppercase">
                        Other Ways to Give
                    </h2>
                    <p>

                    </p>
                    <div>
                        <a href="">
                            Give Online
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('styles')
        <style>
            a:hover svg {
                fill: #ffffff;
            }
        </style>
    @endpush
</x-guest-layout>
