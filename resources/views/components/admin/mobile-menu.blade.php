<div x-data="{
       open: false,
}"
     class="flex items-center lg:hidden"
>
    <div class="flex items-center lg:hidden">
        <!-- Mobile menu button -->
        <button x-on:click="open = ! open"
                type="button" class="inline-flex justify-center items-center p-2 text-gray-400 rounded-md hover:text-gray-500 hover:bg-gray-100 focus:ring-2 focus:ring-inset focus:ring-blue-500 focus:outline-none" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <!-- Heroicon name: outline/menu -->
            <svg class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile menu, show/hide based on mobile menu state. -->
    <div class="lg:hidden"
         x-show="open"
         x-cloak
    >
        <!--
          Mobile menu overlay, show/hide based on mobile menu state.

          Entering: "duration-150 ease-out"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "duration-150 ease-in"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div class="fixed inset-0 z-20 bg-black bg-opacity-25" aria-hidden="true"></div>

        <!--
          Mobile menu, show/hide based on mobile menu state.

          Entering: "duration-150 ease-out"
            From: "opacity-0 scale-95"
            To: "opacity-100 scale-100"
          Leaving: "duration-150 ease-in"
            From: "opacity-100 scale-100"
            To: "opacity-0 scale-95"
        -->
        <div class="absolute top-0 right-0 z-30 p-2 w-full max-w-none transition transform origin-top">
            <div class="bg-white rounded-lg divide-y divide-gray-200 ring-1 ring-black ring-opacity-5 shadow-lg">
                <div class="pt-3 pb-2">
                    <div class="flex justify-between items-center px-4">
                        <div>
                            <img class="w-auto h-8" src="https://tailwindui.com/img/logos/workflow-mark-blue-600.svg" alt="Workflow">
                        </div>
                        <div class="-mr-2">
                            <button  x-on:click="open = ! open"
                                     type="button" class="inline-flex justify-center items-center p-2 text-gray-400 bg-white rounded-md hover:text-gray-500 hover:bg-gray-100 focus:ring-2 focus:ring-inset focus:ring-blue-500 focus:outline-none">
                                <span class="sr-only">Close menu</span>
                                <!-- Heroicon name: outline/x -->
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="px-2 mt-3 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="block py-2 px-3 text-base font-medium text-gray-900 rounded-md hover:text-gray-800 hover:bg-gray-100">Dashboard</a>
                    </div>
                </div>
                @auth()
                    <div class="pt-4 pb-2">
                        <div class="flex items-center px-5">
                            <div class="flex-shrink-0">
                                <img class="w-10 h-10 rounded-full" src="{{ auth()->user()->profile_photo_url }}" alt="">
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                                <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                            </div>
                            <button type="button" class="flex-shrink-0 p-1 ml-auto text-gray-400 bg-white rounded-full hover:text-gray-500 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none">
                                <span class="sr-only">View notifications</span>
                                <!-- Heroicon name: outline/bell -->
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </button>
                        </div>
                        <div class="px-2 mt-3 space-y-1">
                            <a href="#" class="block py-2 px-3 text-base font-medium text-gray-900 rounded-md hover:text-gray-800 hover:bg-gray-100">Your Profile</a>

                            <a href="#" class="block py-2 px-3 text-base font-medium text-gray-900 rounded-md hover:text-gray-800 hover:bg-gray-100">Settings</a>

                            <a href="#" class="block py-2 px-3 text-base font-medium text-gray-900 rounded-md hover:text-gray-800 hover:bg-gray-100">Sign out</a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>


