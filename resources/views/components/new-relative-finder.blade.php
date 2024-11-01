<div class="flex overflow-hidden flex-col shadow">
    <div class="relative z-0 w-full bg-center bg-cover bg-primary aspect-[4/3]"
         style="background-image: url('{{ app()->environment('local') ? 'https://tree-portraits-bgt.familysearchcdn.org/jqpzd/thumb200s.jpg' : $image }}'); background-size: 160%;"
    >
        <div class="absolute -bottom-60 w-[150%] h-full inset -rotate-[7deg] bg-primary -ml-[20%] z-1"></div>
    </div>
    <div class="flex relative flex-col justify-between h-full bg-primary">
        <div class="flex flex-col gap-y-2 px-4">
            <h2 class="pb-0 w-full text-2xl text-center text-white">
                Relative Finder
            </h2>
            <div class="pb-8 border-b border-white">
                <p class="flex gap-2 justify-center items-center font-semibold text-white md:flex-col lg:flex-row">
                    <span>with the help of</span>
                    <img src="{{ asset('img/familytree-logo.png') }}" alt=""
                         class="inline mb-1 -mt-2 w-28 h-auto"
                    />
                </p>
            </div>
        </div>
        <div class="px-4 pt-6 pb-4">
            <a href="{{ route('relative-finder') }}"
               class="block py-2 px-4 w-full text-base font-semibold text-center bg-white text-primary"
            >
                Find Your Own Relatives
            </a>
        </div>
    </div>
</div>



<div class="hidden overflow-hidden relative shadow">
    <div class="absolute -bottom-60 w-[150%] h-full inset -rotate-[7deg] bg-primary -ml-[20%] z-0"></div>
    <div class="h-[3/4] bg-primary z-1">
        <img src="{{ $image }}"
             class="-mt-24 w-full h-auto min-h-[384px]"
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

        <div class="flex -mb-0.5 w-full">
            <a href="{{ route('relative-finder') }}"
               class="block py-2 px-4 w-full text-base font-semibold text-center bg-white text-primary"
            >
                Find Your Own Relatives
            </a>
        </div>
    </div>
</div>
