<div>

    <div class="">

        <div class="hidden gap-4 pb-8 max-w-7xl sm:grid sm:grid-cols-4">
            @foreach($selectCategories as $categoryOption)
                <span wire:click="$set('category', '{{ $categoryOption }}')"
                      @class([
                        'flex justify-center items-center px-3 py-1 text-lg cursor-pointer',
                        'bg-white text-secondary border border-secondary' => $category != $categoryOption,
                        'bg-secondary text-white' => $category == $categoryOption,
                      ])
                >
                    {{ $categoryOption }}
                </span>
            @endforeach
        </div>

        <div class="block pb-8 max-w-7xl sm:hidden">
            <label for="category-select" class="block text-sm font-medium text-gray-700"> Category </label>
            <select wire:model="category"
                    id="category-select"
                    class="block relative w-full bg-transparent border-gray-300 sm:text-base focus:z-10 focus:ring-secondary focus:border-secondary"
            >
                @foreach($selectCategories as $categoryOption)
                    <option wire:click="$set('category', '{{ $categoryOption }}')"
                            value="{{ $categoryOption }}"
                    >
                    {{ $categoryOption }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            @if($category == 'Eminent Men and Women')
                <div>
                    <div class="flex overflow-hidden relative flex-row items-end pt-16 bg-gray-900 isolate !m-0">
                        <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/st-george-temple.jpeg"
                             alt=""
                             class="object-cover object-right absolute inset-0 w-full h-full md:object-center -z-10 brightness-50">

                        <div class="hidden sm:block sm:absolute sm:-top-10 sm:right-1/2 sm:mr-10 sm:transform-gpu sm:-z-10 sm:blur-3xl" aria-hidden="true">
                            <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
                                 style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                        </div>
                        <div class="absolute -top-52 left-1/2 transform-gpu -translate-x-1/2 sm:ml-16 sm:transform-gpu sm:translate-x-0 -z-10 blur-3xl sm:top-[-28rem]" aria-hidden="true">
                            <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
                                 style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                        </div>
                        <div class="px-6 lg:px-8">
                            <div class="mx-auto max-w-2xl lg:mx-0">
                                <p class="text-3xl font-bold tracking-tight text-white sm:text-5xl">Eminent Men and Women</p>
                                <p class="text-2xl font-medium leading-8 text-white">St. George, Utah, United States</p>
                            </div>
                        </div>
                    </div>
                    <div class=" !m-0 !mb-12 bg-gray-100">
                        <p class="!mt-0 py-4 px-4 text-black">
                            August 1877 marked Wilford's third experience in the St. George Temple that would impact temple ordinance work for generations. This experience&mdash;the appearance of the Signers of the Declaration of Independence to Wilford&mdash;changed not only his view of temple work, but has become an important symbol of the universal nature of temple work.
                        </p>
                        {{--<p class="p-4 !m-0">
                            <a href="https://www.familysearch.org/eurona/travel/sites/98957/-british-converts?cid=fs_copy"
                               class="py-2 px-4 text-white bg-secondary"
                               target="_blank"
                            >
                                View 1840 British Converts on FamilySearch
                            </a>
                        </p>--}}
                    </div>
                </div>
            @elseif($category == '1840 British Converts')
                <div>
                    <div class="flex overflow-hidden relative flex-row items-end pt-16 bg-gray-900 isolate !m-0">
                        <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/1840-british-converts.jpg" alt="" class="object-cover object-right absolute inset-0 w-full h-full md:object-center -z-10 brightness-50">

                        <div class="hidden sm:block sm:absolute sm:-top-10 sm:right-1/2 sm:mr-10 sm:transform-gpu sm:-z-10 sm:blur-3xl" aria-hidden="true">
                            <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                        </div>
                        <div class="absolute -top-52 left-1/2 transform-gpu -translate-x-1/2 sm:ml-16 sm:transform-gpu sm:translate-x-0 -z-10 blur-3xl sm:top-[-28rem]" aria-hidden="true">
                            <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                        </div>
                        <div class="px-6 lg:px-8">
                            <div class="mx-auto max-w-2xl lg:mx-0">
                                <p class="text-3xl font-bold tracking-tight text-white sm:text-5xl">1840 British Converts</p>
                                <p class="text-2xl font-medium leading-8 text-white">Preston, Lancashire, England, United Kingdom</p>
                            </div>
                        </div>
                    </div>
                    <div class=" !m-0 !mb-12 bg-gray-100">
                        <p class="!mt-0 py-4 px-4 text-black">
                            The first missionaries arrived in England on July 19, 1837. Apostle Heber C. Kimball baptized the first converts on July 30, 1837 in the River Ribble, near Preston, Lancashire, England. The Preston Ward is the longest continuously functioning Latter Day Saint congregation in the world.
                        </p>
                        <p class="p-4 !m-0">
                            <a href="https://www.familysearch.org/eurona/travel/sites/98957/-british-converts?cid=fs_copy"
                               class="py-2 px-4 text-white bg-secondary"
                               target="_blank"
                            >
                                View 1840 British Converts on FamilySearch
                            </a>
                        </p>
                    </div>
                </div>
            @elseif($category == 'United Brethren')
                {{--<div>
                    <div class="flex overflow-hidden relative flex-row items-end pt-16 bg-gray-900 isolate !m-0">
                        <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/1840-british-converts.jpg" alt="" class="object-cover object-right absolute inset-0 w-full h-full md:object-center -z-10 brightness-50">

                        <div class="hidden sm:block sm:absolute sm:-top-10 sm:right-1/2 sm:mr-10 sm:transform-gpu sm:-z-10 sm:blur-3xl" aria-hidden="true">
                            <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                        </div>
                        <div class="absolute -top-52 left-1/2 transform-gpu -translate-x-1/2 sm:ml-16 sm:transform-gpu sm:translate-x-0 -z-10 blur-3xl sm:top-[-28rem]" aria-hidden="true">
                            <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                        </div>
                        <div class="px-6 lg:px-8">
                            <div class="mx-auto max-w-2xl lg:mx-0">
                                <p class="text-3xl font-bold tracking-tight text-white sm:text-5xl">1840 British Converts</p>
                                <p class="text-2xl font-medium leading-8 text-white">Preston, Lancashire, England, United Kingdom</p>
                            </div>
                        </div>
                    </div>
                    <div class=" !m-0 !mb-12 bg-gray-100">
                        <p class="!mt-0 py-4 px-4 text-black">
                            The first missionaries arrived in England on July 19, 1837. Apostle Heber C. Kimball baptized the first converts on July 30, 1837 in the River Ribble, near Preston, Lancashire, England. The Preston Ward is the longest continuously functioning Latter Day Saint congregation in the world.
                        </p>
                        <p class="p-4 !m-0">
                            <a href="https://www.familysearch.org/eurona/travel/sites/98957/-british-converts?cid=fs_copy"
                               class="py-2 px-4 text-white bg-secondary"
                               target="_blank"
                            >
                                View 1840 British Converts on FamilySearch
                            </a>
                        </p>
                    </div>
                </div>--}}
            @elseif($category == '1835 Southern Converts')
                <div>
                    <div class="flex overflow-hidden relative flex-row items-end pt-16 bg-gray-900 isolate !m-0">
                        <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/1835-southern-converts.jpg" alt="" class="object-cover object-right absolute inset-0 w-full h-full md:object-center -z-10 brightness-50">

                        <div class="hidden sm:block sm:absolute sm:-top-10 sm:right-1/2 sm:mr-10 sm:transform-gpu sm:-z-10 sm:blur-3xl" aria-hidden="true">
                            <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                        </div>
                        <div class="absolute -top-52 left-1/2 transform-gpu -translate-x-1/2 sm:ml-16 sm:transform-gpu sm:translate-x-0 -z-10 blur-3xl sm:top-[-28rem]" aria-hidden="true">
                            <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                        </div>
                        <div class="px-6 lg:px-8">
                            <div class="mx-auto max-w-2xl lg:mx-0">
                                <p class="text-3xl font-bold tracking-tight text-white sm:text-5xl">1835 Southern Converts</p>
                                <p class="text-2xl font-medium leading-8 text-white">Paris, Henry, Tennessee, United States</p>
                            </div>
                        </div>
                    </div>
                    <div class="!mt-0 !mb-12 bg-gray-100">
                        <p class="py-4 px-4 text-black !my-0">
                            David W. Patten and Warren Parish arrived in Tennessee in October 1834 and, after baptizing 31 people, organized the first branch of the Church of Jesus Christ of Latter-day Saints in Paris, Tennessee. The area of the original Paris Tennessee branch has since grown to 57,422 members in 114 congregations.
                        </p>
                        <p class="py-4 px-4 text-black !my-0">
                            This list of individuals was compiled by Wilford Woodruff during his missionary service in the Southern United States between 1835 and 1837.
                        </p>
                        <p class="p-4 !m-0">
                            <a href="https://www.familysearch.org/eurona/travel/sites/98958/-southern-converts?cid=fs_copy"
                               class="py-2 px-4 text-white bg-secondary"
                               target="_blank"
                            >
                                View 1835 Southern Converts on FamilySearch
                            </a>
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <div class="max-w-7xl text-center">
            <form wire:submit.prevent="submit">
                <input wire:model.defer="search"
                       class="pb-2 w-full max-w-xl border-gray-300 shadow-sm sm:max-w-xl sm:text-base"
                       type="search"
                       name="q"
                       value=""
                       placeholder="Search People"
                       aria-label="Search People"
                >
            </form>
        </div>

        <div>
            @if($category == 'All')
                <div class="h-16">
                    <div class="grid overflow-x-scroll grid-flow-col auto-cols-max gap-4 mb-4 no-scrollbar"
                    >
                        @foreach(range('A', 'Z') as $l)
                            <div wire:click="$set('letter', '{{ $l }}')"
                                 class="text-xl font-semibold cursor-pointer px-2 pb-1 hover:text-secondary hover:border-b-2 hover:border-secondary @if($l == $letter) text-secondary border-b-2 border-secondary @endif">
                                {{ $l }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div wire:loading.remove
             class="grid grid-cols-1 gap-1 px-2 mb-4 sm:grid-cols-2 md:grid-cols-3">
            @forelse($people as $key => $person)
                <div class="">
                    <a class="text-secondary"
                       href="{{ route('subjects.show', ['subject' => $person])  }}"
                    >
                        {{ $person->display_name }} ({{ $person->tagged_count }})
                    </a>
                </div>
            @empty
                <div class="px-2 text-secondary">
                    No results
                </div>
            @endforelse
        </div>
        <div wire:loading.grid
             class="grid grid-cols-1 px-2 mb-4 sm:grid-cols-2 md:grid-cols-3">
            @foreach(range(1, 15) as $placeholder)
                <div class="">
                    <div data-placeholder class="overflow-hidden relative mr-2 w-80 h-6 bg-gray-200 animate-pulse">
                        <a class="text-secondary"
                           href="#"
                        >
                            &nbsp;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
