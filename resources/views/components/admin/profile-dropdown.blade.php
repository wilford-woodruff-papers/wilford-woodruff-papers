<!-- Profile dropdown -->
<div x-data="{
       open: false,
    }"
     class="relative flex-shrink-0 ml-4"
     x-on:click.away="open = false"
>
    <div>
        <button x-on:click="open = ! open"
                type="button" class="flex text-sm bg-white rounded-full focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
            <span class="sr-only">Open user menu</span>
            <img class="w-8 h-8 rounded-full" src="{{ auth()->user()->profile_photo_url }}" alt="">
        </button>
    </div>

    <!--
      Dropdown menu, show/hide based on menu state.

      Entering: "transition ease-out duration-100"
        From: "transform opacity-0 scale-95"
        To: "transform opacity-100 scale-100"
      Leaving: "transition ease-in duration-75"
        From: "transform opacity-100 scale-100"
        To: "transform opacity-0 scale-95"
    -->
    <div x-show="open"
         x-cloak
         class="absolute right-0 py-1 mt-2 w-48 bg-white rounded-md ring-1 ring-black ring-opacity-5 shadow-lg origin-top-right focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
        <!-- Active: "bg-gray-100", Not Active: "" -->
        <a href="#" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>

        <a href="#" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>

        <a href="#" class="block py-2 px-4 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
    </div>
</div>
