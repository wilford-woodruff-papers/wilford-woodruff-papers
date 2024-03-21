@if(
    auth()->check() && auth()->user()->hasAnyRole('Editor|Admin|Super Admin')
    && ! request()->is('relative-finder')
    && ! request()->is('my-relatives')
    )
    <div  x-data="relativeFinderPopup"
          class="fixed bottom-0 md:right-4 z-[1000]"
          x-transition:enter="transition translate-y-1/2 ease-out duration-100"
          x-transition:enter-start="opacity-0 -bottom-10"
          x-transition:enter-end="opacity-100 bottom-0 "
          x-transition:leave="transition translate-y-0 ease-in duration-100"
          x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0"
          x-cloak
    >
        <div class="fixed right-0 bottom-0 md:right-4 z-[1000]"
             x-show="! open"
        >
            <div class="px-2 pb-0 w-64 h-auto shadow-2xl bg-primary"

            >
                <div x-on:click="open = true"
                     class="flex justify-between py-2 px-2 text-lg text-white cursor-pointer bg-primary hover:bg-primary-80">
                    <span x-show="! open">Find Your Relatives</span>
                    <button x-on:click="open = true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                        </svg>

                    </button>
                </div>
            </div>
        </div>

        <div class="inset-x-1/3 max-w-2xl transform sm:mx-auto sm:w-full h-3xl"
             x-show="open">
            <div class="px-2 pb-2 w-full h-auto shadow-2xl md:w-72 bg-primary">
                <div x-on:click="hide()"
                     class="flex justify-between py-2 px-2 text-white cursor-pointer bg-primary hover:bg-primary-80">
                    <span x-show="! open">Find Your Relatives</span>
                    <span x-show="open"></span>
                    <button x-on:click="hide()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-col gap-y-8 justify-between bg-white lg:col-span-3">
                    <div class="px-4">
                        <div class="flex z-50 flex-col gap-y-2 pt-8 pb-4 text-center lg:text-left">
                            <div>
                                <img src="{{ asset('img/family-pictures.png') }}" alt="Images of Wilford's Family"/>
                            </div>
                            <h2 class="mt-2 text-xl text-black">
                                <div class="mx-auto max-w-xl text-center lg:mx-0">
                                    Discover Your Relatives in Wilford Woodruff's Papers
                                </div>
                            </h2>
                            <div class="items-end text-base text-center text-black">
                                <span>with the help of</span> <a href="https://www.familysearch.org/" target="_blank" class="inline ml-1 sm:ml-2">
                                    <img src="{{ asset('img/familytree-logo.png') }}" alt="" class="inline mb-1 w-24 h-auto">
                                </a>

                            </div>
                        </div>

                    </div>
                    <div class="px-4 mb-4 text-center lg:text-left">
                        <a href="{{ route('relative-finder') }}" class="block py-2 text-lg text-center text-white bg-secondary hover:bg-secondary-500">
                            Find Your Relatives
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @push('scripts')
            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('relativeFinderPopup', () => ({
                        open: false,
                        init() {
                            if(this.shouldPopup()){
                                setTimeout(() => {
                                    this.open = true;
                                }, 3000);
                            }
                        },
                        hide() {
                            this.open = false;
                            localStorage.setItem("relativeFinderPopup", false);
                        },
                        shouldPopup(){
                            switch(localStorage.getItem("relativeFinderPopup")){
                                case 'true':
                                case true:
                                case undefined:
                                case null:
                                    return true;
                                case 'false':
                                case false:
                                    return false;
                            }
                        }
                    }))
                })
            </script>
        @endpush
    </div>
@endif
