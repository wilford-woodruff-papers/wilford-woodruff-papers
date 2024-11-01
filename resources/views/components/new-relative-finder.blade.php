<div class="overflow-hidden relative shadow">
    <div class="absolute -bottom-60 w-[150%] h-full inset -rotate-[7deg] bg-primary -ml-[20%] z-0"></div>
    <div class="h-[3/4] bg-primary z-1">
        <img src="{{ $image }}"
             class="-mt-24 w-full h-auto"
             alt="" />
    </div>
    <div class="flex relative z-10 flex-col justify-between px-4 h-1/3">
        <div>
            <h2 class="pb-2 w-full text-3xl text-center text-white">
                Relative Finder
            </h2>
            <div class="pb-4 border-b border-white">
                <p class="flex gap-x-2 justify-center items-center font-semibold text-white">
                    <span>with the help of</span>
                    <img src="{{ asset('img/familytree-logo.png') }}" alt=""
                         class="inline mb-1 -mt-2 w-28 h-auto"
                    />
                </p>
            </div>
        </div>

        <div class="flex w-full">
            <a href="{{ route('relative-finder') }}"
               class="block py-2 px-4 w-full text-base font-semibold text-center bg-white text-primary"
            >
                Find Your Own Relatives
            </a>
        </div>
    </div>
</div>
