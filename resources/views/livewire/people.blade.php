<div>

    <div class="">

        <div class="hidden gap-4 pb-8 max-w-7xl sm:grid sm:grid-cols-4">
            @foreach($selectCategories as $categoryOption)
                <span wire:click="$set('category', '{{ addslashes($categoryOption) }}')"
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
            <select wire:model.live="category"
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
                            August 1877 marked Wilford Woodruff's third experience in the St. George Temple that would impact temple ordinance work for generations. This experience—the appearance of the Signers of the Declaration of Independence to Wilford—changed not only his view of temple work, but has become an important symbol of the universal nature of temple work.
                        </p>
                        <p class="!mt-0 py-4 px-4 text-black">
                            This list includes the names of the 189 individuals Wilford Woodruff initiated proxy temple work for. Proxy baptisms and confirmations were administered on August 21, 1877, followed by proxy priesthood ordinations and many proxy endowments, as well as proxy sealings of some couples.
                        </p>
                        <p class="p-4 !m-0">
                            <a href="https://wilfordwoodruffpapers.org/p/voR0"
                               class="py-2 px-4 text-white bg-secondary"
                               target="_blank"
                            >
                                View August 21, 1877 Journal Entry
                            </a>
                        </p>
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
                                <p class="text-2xl font-medium leading-8 text-white">Herefordshire, Worcestershire, and Gloucestershire, England</p>
                            </div>
                        </div>
                    </div>
                    <div class=" !m-0 !mb-12 bg-gray-100">
                        <p class="!mt-0 py-4 px-4 text-black">
                            Wilford Woodruff included a 24-page booklet he titled "Wilford Woodruff’s Baptismal Record" at the front of his journal detailing his mission to England in 1840. In the booklet he recorded the names of those who were baptized and confirmed members of The Church of Jesus Christ of Latter-day Saints in the Tri-County area of Herefordshire, Worcestershire, and Gloucestershire, between March 6 and June 22, 1840, as well as the names of those who officiated in these ordinances.
                        </p>
                        <p class="!mt-0 py-4 px-4 text-black">
                            We have identified most of the 485 individuals included on Wilford Woodruff's list. If you are able to provide additional records or biographical information that will help us identify others, please send a message to <a href='ma&#105;l&#116;o&#58;c%&#54;&#70;n&#116;%61ct&#64;wi&#108;%6&#54;ordwood&#37;72u%66%6&#54;pa&#112;%65rs&#46;&#37;6F%72g' class="underline text-secondary">contac&#116;&#64;wilfordwood&#114;u&#102;fp&#97;pe&#114;&#115;&#46;or&#103;</a>.
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
                <div>
                    <div class="flex overflow-hidden relative flex-row items-end pt-16 bg-gray-900 isolate !m-0">
                        <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/united-brethren.jpg" alt="" class="object-cover object-right absolute inset-0 w-full h-full md:object-center -z-10 brightness-50">

                        <div class="hidden sm:block sm:absolute sm:-top-10 sm:right-1/2 sm:mr-10 sm:transform-gpu sm:-z-10 sm:blur-3xl" aria-hidden="true">
                            <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                        </div>
                        <div class="absolute -top-52 left-1/2 transform-gpu -translate-x-1/2 sm:ml-16 sm:transform-gpu sm:translate-x-0 -z-10 blur-3xl sm:top-[-28rem]" aria-hidden="true">
                            <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                        </div>
                        <div class="px-6 lg:px-8">
                            <div class="mx-auto max-w-3xl lg:mx-0">
                                <p class="text-3xl font-bold tracking-tight text-white sm:text-5xl">United Brethren</p>
                                <p class="text-2xl font-medium leading-8 text-white">Gadfield Elm Chapel, Pendock, Worcestershire, England, United Kingdom</p>
                            </div>
                        </div>
                    </div>
                    <div class=" !m-0 !mb-12 bg-gray-100">
                        <p class="!mt-0 py-4 px-4 text-black">
                            The United Brethren were former Wesleyan Methodists who formed an independent religious group of about 600 individuals in the Tri-County area of Herefordshire, Worcestershire, and Gloucestershire in England. Through the efforts of Wilford Woodruff and his missionary companions, most of the members of this group were baptized into The Church of Jesus Christ of Latter-day Saints in 1840.
                        </p>
                        <p class="!mt-0 py-4 px-4 text-black">
                            The list below are the individuals mentioned in Wilford Woodruff's records that we have been able to identify as members of the United Brethren.
                        </p>
{{--                        <p class="p-4 !m-0">--}}
{{--                            <a href="https://www.familysearch.org/eurona/travel/sites/98957/-british-converts?cid=fs_copy"--}}
{{--                               class="py-2 px-4 text-white bg-secondary"--}}
{{--                               target="_blank"--}}
{{--                            >--}}
{{--                                View 1840 British Converts on FamilySearch--}}
{{--                            </a>--}}
{{--                        </p>--}}
                    </div>
                </div>
            @elseif($category == 'Missionaries')
                <div>
                    <div class=" !m-0 !mb-12 bg-gray-100">
                        <p class="!mt-0 py-4 px-4 text-black">
                            As President of the Quorum of the Twelve Apostles from 1887 to 1889 and President of The Church of Jesus Christ of Latter-day Saints from 1889-1898 Wilford Woodruff sent mission calls to men and women and received letters from those called to serve.
                        </p>
                        <p class="!mt-0 py-4 px-4 text-black">
                            This is a list of the individuals who corresponded with Wilford Woodruff about their missions with a link to their letters. If one of your ancestors received a mission call between 1887 and 1898 and you have a copy of their mission call or response, or have records to help us complete their biographical information, please send a message to <a href='ma&#105;l&#116;o&#58;c%&#54;&#70;n&#116;%61ct&#64;wi&#108;%6&#54;ordwood&#37;72u%66%6&#54;pa&#112;%65rs&#46;&#37;6F%72g' class="underline text-secondary">contac&#116;&#64;wilfordwood&#114;u&#102;fp&#97;pe&#114;&#115;&#46;or&#103;</a>.
                        </p>
                    </div>
                </div>
            @elseif($category == 'Maine Mission')
                <div>
                    <div class=" !m-0 !mb-12 bg-gray-100">
                        <p class="!mt-0 py-4 px-4 text-black">
                            Wilford Woodruff left Kirtland on May 31, 1837 to preach the gospel in the Fox Islands off the coast of Maine. Between May 1837 and October 1838 he proselyted in Ohio, New York, Canada, Connecticut, Maine, Massachusetts, and New Hampshire. He then gathered a group of converts from the Fox Islands and left Maine October 4, 1838 to join the Saints in Missouri but, due to the harsh winter and the forced migration out of Missouri, they did not reunite with the main body of the Church until April of 1839 after wintering in Rochester, Illinois.
                        </p>
                        <p class="!mt-0 py-4 px-4 text-black">
                            This list is the individuals he interacted with during his mission to the Eastern United States between May 1837 and December 1838.
                        </p>
                    </div>
                </div>
            @elseif($category == 'Apostles')
                <div>
                    <div class=" !m-0 !mb-12 bg-gray-100">
                        <p class="!mt-0 py-4 px-4 text-black">
                            Joseph Smith and Oliver Cowdery were the first individuals ordained to the Melchizedek Priesthood office of apostle in this dispensation in May of 1829. Joseph Smith was ordained as President of the High Priesthood, and Oliver Cowdery as Assistant President, on January 25, 1832. Joseph Smith appointed Jesse Gause and Sydney Rigdon as counselors March 8, 1832, forming the First Presidency (a title formally used beginning in 1838). The first members of what would become the Quorum of the Twelve Apostles were ordained on February 14, 1835, and the Quorum of the Twelve has functioned since the 1830s as the second highest governing body of the Church of Jesus Christ of Latter-day Saints, under the direction of the First Presidency. Not all of those ordained to the office of apostle have served as official members of the Quorum of the Twelve. For example, some like Hyrum Smith, Daniel H. Wells, Jedediah M. Grant, and John W. Young, have been called to serve in other offices including counselors or assistant counselors to the First Presidency.
                        </p>
                        <p class="!mt-0 py-4 px-4 text-black">
                            This list includes the names of the 53 individuals ordained as apostles in The Church of Jesus Christ of Latter-day Saints between 1829 and 1898.
                        </p>
                    </div>
                </div>
            @elseif($category == 'Family')
                <div>
                    <div class=" !m-0 !mb-12 bg-gray-100">
                        <p class="!mt-0 py-4 px-4 text-black">
                            After learning of the revelations received by Joseph Smith regarding proxy baptisms, temple endowments, and sealings in the 1840s, Wilford Woodruff complete genealogical research for more than 3,000 relatives in preparation for the initiation of all proxy temple ordinances in the St. George Temple in 1877. By 1897 he completed the proxy ordinances, with the help of his extended family and friends.
                        </p>
                        <p class="!mt-0 py-4 px-4 text-black">
                            This list includes his wives, descendants, and ancestors whose names were included in his records.
                        </p>
                    </div>
                </div>
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

        <div class="pb-8 w-full text-center">
            <form wire:submit="submit">
                <input wire:model="search"
                       class="pb-2 w-full border-gray-300 shadow-sm sm:text-lg"
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
             class="grid grid-cols-1 gap-2 lg:grid-cols-3">
            @forelse($people as $key => $person)
                {{--<div class="">
                    <a class="text-secondary"
                       href="{{ route('subjects.show', ['subject' => $person])  }}"
                    >
                        {{ $person->display_name }} ({{ $person->tagged_count }})
                    </a>
                </div>--}}
                <div class="flex flex-col justify-between p-4 border border-gray-300 shadow-lg">
                    <div>
                        <a href="{{ route('subjects.show', ['subject' => $person->slug]) }}"
                           class="text-xl text-secondary"
                           target="_blank"
                        >
                            {{ $person->display_name }}
                        </a>
                        @if(! empty($display_life_years = $person->display_life_years))
                            <div>
                                {{ $display_life_years }}
                            </div>
                        @endif
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <div class="font-medium text-black">
                            <div class="mb-0.5">
                                {{ $person->tagged_count }} {{ str('mention')->plural($person->tagged_count) }}
                            </div>
                            <div>
                                {{
                                    $person
                                        ->category
                                        ->filter(fn($category) => $category->name !== 'People')
                                        ->pluck('name')
                                        ->map(fn($name) => str($name)->singular())
                                        ->join(', ')
                                }}
                            </div>
                        </div>
                        <div>
                            @if(! empty($person->pid) && $person->pid !== 'n/a')
                                <x-familysearch-button :pid="$person->pid" />
                            @endif
                        </div>
                    </div>
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
