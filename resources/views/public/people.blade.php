@php
    $alpha = [];
    $people = [];
    foreach ($subjects as $person) {
        $name_suffix = explode(',', $person->name);
        $name = array_shift($name_suffix);
        $name = explode(' ', $name);
        $index = substr(end($name), 0, 1);
        if(! array_key_exists($index, $alpha)){
            $alpha[$index] = [];
        }

        $subject = [
            'last_name' => array_pop($name),
            'first_name' => implode(" ", $name) . (! empty($name_suffix)? ' ('.trim(implode(', ', $name_suffix)).')':''),
            'url' => route('subjects.show', ['subject' => $person]),
            #'url' => '/s/'.$page->params['site-slug'].'/page/'.$page->params['page-slug'],
        ];
        $subject['full_name'] = $subject['first_name'] .' '.$subject['last_name'];
        $subject['sort_name'] = $subject['last_name'] .' '.$subject['first_name'];

        $alpha[$index][] = $subject;
        $people[] = $subject;

    }

    function lastNameSort($a, $b)
    {
        if ($a['sort_name'] == $b['sort_name']) {
            return 0;
        }
        return ($a['sort_name'] < $b['sort_name']) ? -1 : 1;
    }

    ksort($alpha);

    usort($people, "lastNameSort");
@endphp
<x-guest-layout>

    <div class="bg-cover bg-top" style="background-image: url({{ asset('img/banners/people.png') }})">
        <div class="max-w-7xl mx-auto py-4 xl:py-12">
            <h1 class="text-white text-4xl md:text-6xl xl:text-8xl">
                People
            </h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4">

        <div class="content col-span-12 px-8 py-6">

            <div class="page-title">Recognize Wilford's influence in the lives of the individuals he interacted with</div>

            <h2 class="section-title">People Mentioned in Wilford Woodruff's Papers</h2>
            <p class="text-black">Explore the biographical sketches of the many people who interacted with Wilford Woodruff. Discover their stories through Wilford Woodruff's daily journal entries and their correspondence with him.</p>

            <script>
                var people = @json($people);

                function trim (s, c) {
                    if (c === "]") c = "\\]";
                    if (c === "^") c = "\\^";
                    if (c === "\\") c = "\\\\";
                    return s.replace(new RegExp(
                        "^[" + c + "]+|[" + c + "]+$", "g"
                    ), "");
                }

                function search(){
                    return {
                        tab: '{{ array_key_first($alpha) }}',
                        q: null,
                        filteredPeople: [],
                        filter() {
                            this.filteredPeople = people.filter( person => this.checkName(person.full_name, trim(this.q.toUpperCase(), " ").split(" ") ) );
                        },
                        checkName(full_name, term) {
                            let match = false;
                            full_name = full_name.toUpperCase();
                            if(term.length == 1){
                                match = full_name.indexOf(term[0]) > -1;
                            } else if(term.length == 2) {
                                match = (full_name.indexOf(trim(term[0], ',')) > -1) && (full_name.indexOf(trim(term[1], ',')) > -1);
                            } else if(term.length > 2) {
                                for(name of term){
                                    if(full_name.indexOf(trim(name, ',')) > -1){
                                        match = true;
                                    }
                                }
                            }
                            return match;
                        }
                    }
                }
            </script>

            <div x-data="search()"
                 class="mb-12">

                <div class="max-w-7xl text-center mb-8">
                    <input class="max-w-xl w-full shadow-sm sm:max-w-xl sm:text-sm border-gray-300"
                           x-model="q"
                           x-on:keyup.debounce.500ms="filter()"
                           type="search"
                           name="q"
                           value=""
                           placeholder="Search People"
                           aria-label="Search People"
                    >
                </div>

                <div class="h-16">
                    <div class="grid grid-flow-col auto-cols-max gap-4 mb-4"
                         x-show="!q"
                    >
                        @foreach($alpha as $letter => $group)
                        <div class="text-xl font-semibold cursor-pointer pt-2 px-2 pb-1 hover:text-secondary hover:border-b-2 hover:border-secondary"
                             x-on:click="tab = '{{ $letter }}'"
                             :class="{ 'text-secondary border-b-2 border-secondary': tab == '{{ $letter }}'}"
                        >
                            {{ $letter }}
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-flow-col auto-cols-max gap-4 mb-4 px-2"
                     x-show="!q"
                     x-cloak
                >
                    @foreach($alpha as $letter => $group)
                        <div class="grid grid-cols-1 gap-2"
                             x-show="tab == '{{ $letter }}'"
                        >

                            @php usort($group, "lastNameSort") @endphp
                            @foreach($group as $key => $page)
                                <div class="">
                                    <a class="text-secondary popup"
                                       href="{{ $page['url'] }}"
                                    >
                                        {{ $page['last_name'] }}@if(strlen($page['first_name'])), @endif {{ $page['first_name'] }}
                                    </a>
                                </div>
                            @endforeach

                        </div>

                    @endforeach

                </div>

                <div class="grid grid-flow-col auto-cols-max px-2"
                     x-show="q"
                     x-cloak
                >
                    <div class="grid grid-cols-1 gap-2">
                        <template x-for="person in filteredPeople" :key="person.url">
                            <div class="">
                                <a class="text-secondary popup"
                                   x-bind:href="person.url"
                                   x-text="person.last_name + ', ' + person.first_name"
                                >
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="px-2 text-secondary"
                     x-show="q && filteredPeople.length < 1"
                     x-cloak
                >
                    No results
                </div>

            </div>

            <p>&nbsp;</p>
            <p>&nbsp;</p>

            <h2 class="section-title">Wilford Woodruff's Wives and Children</h2>

            <div class="px-6 py-4" x-data="{
                                        flyoutOpen: null
                                    }">
                <div class="flow-root">
                    <div class="-mb-8">
                        @foreach($wives->groupBy('marriage_year')->sortBy('marriage_year') as $year => $marriages)
                            @foreach($marriages as $wife)
                                <div>
                                    <div class="relative pb-8"><span aria-hidden="true" class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200">&nbsp;</span>
                                        <div class="relative flex items-start space-x-3">
                                            <div class="relative">
                                                @if($loop->first)
                                                    <span class="text-xl ring-8 ring-white bg-white"> {{ $year }}
                                                        @else
                                                            <span class="text-xl"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                @endif</span> <span class="text-xl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                            </div>
                                            <x-wife :wife="$wife" />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-guest-layout>
