<div class="flex overflow-hidden flex-col shadow">
    <div class="relative z-0 w-full bg-primary aspect-[4/3]"
    >
        <div class="grid grid-cols-4 gap-2 bg-white">
            @foreach($images as $image)
                <div class="overflow-hidden aspect-square">
                    <img src="{{ app()->environment('local') ? 'https://tree-portraits-bgt.familysearchcdn.org/jqpzd/thumb200s.jpg' : $image->portrait }}"
                         alt=""
                         class="shadow-lg"
                    />
                </div>
            @endforeach
        </div>
        <div class="absolute -bottom-60 w-[150%] h-full inset -rotate-[7deg] bg-primary -ml-[20%] z-1"></div>
    </div>
    <div class="flex relative flex-col justify-between h-full bg-primary">
        <div class="flex flex-col gap-y-2 px-4">
            <h2 class="pb-0 w-full text-2xl text-center text-white">
                WWP Relative Finder
            </h2>
            <div class="pb-8 border-b border-white">
                <p class="flex gap-2 justify-center items-center font-semibold text-white md:flex-col lg:flex-row">
                    <span>with the help of</span>
                    <img src="{{ asset('img/familytree-logo.png') }}" alt=""
                         class="inline mb-1 -mt-2 w-28 h-auto"
                    />
                </p>
            </div>
            <div>
                <p class="text-white">
                    Find out how you are related to some of the 25,000 individuals named in Wilford Woodruffs records.
                </p>
            </div>
        </div>
        <div class="px-4 pt-6 pb-4">
            <a href="{{ route('relative-finder') }}"
               class="block py-2 px-4 w-full text-base font-semibold text-center uppercase bg-white text-primary"
            >
                Connect With Your Relatives
            </a>
        </div>
    </div>
</div>
