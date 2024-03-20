<div  x-data="relativeFinderPopup"
      class="fixed right-4 -bottom-10"
     x-transition:enter="transition translate-y-1/2 ease-out duration-100"
     x-transition:enter-start="opacity-0 -bottom-10"
     x-transition:enter-end="opacity-100 bottom-0 "
     x-transition:leave="transition translate-y-0 ease-in duration-100"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
      x-cloak
>
    <div class="inset-x-1/3 z-50 max-w-2xl bg-white transform sm:mx-auto sm:w-full h-3xl"
         x-show="open">
        <div class="p-4 h-80">
            <div class="flex justify-end">
                <button x-on:click="open = false">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            Popup content
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
                                console.log("Popup opened");
                            }, 3000);
                        }
                    },
                    toggle() {
                        this.open = ! this.open;
                        localStorage.setItem("relativeFinderPopup", false);
                    },
                    shouldPopup(){
                        return true;
                        //return !! localStorage.getItem("relativeFinderPopup");
                    }
                }))
            })
        </script>
    @endpush
</div>
