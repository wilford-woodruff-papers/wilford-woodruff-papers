<x-admin-layout>
    <main class="relative mt-8"
        x-data="{
            shadow: false,
            showSuccess: true,
            cant_be_identified: @if(empty(old('cant_be_identified', $person->cant_be_identified))) false @else {{ old('cant_be_identified', $person->cant_be_identified) }} @endif,
            skip_tagging: @if(empty(old('skip_tagging', $person->skip_tagging))) false @else {{ old('skip_tagging', $person->skip_tagging) }} @endif,
            correction_needed:  @if(empty(old('correction_needed', $person->correction_needed))) false @else {{ old('correction_needed', $person->correction_needed) }} @endif,
            setResearcher: function(userid){
                document.getElementById('researcher').value = userid;
            },
            setDateToNow: function(id){
                document.getElementById(id).value = new Date().toISOString().slice(0, 10);
            }
        }"
        x-init="setTimeout(() => showSuccess = false, 3000); $watch('skip_tagging', function(value){
            if(value){
                document.getElementById('completed_at').value = new Date().toISOString().slice(0, 10);
            }
        });"
    >
        <div class="px-4 pb-6 mx-auto max-w-screen-xl sm:px-6 lg:px-8 lg:pb-16">
            <div class="bg-white rounded-lg shadow">
                <div x-intersect:leave="shadow = true"
                     x-intersect:enter="shadow = false"
                ></div>
                <div class="divide-y divide-gray-200 lg:grid lg:grid-cols-12 lg:divide-y-0 lg:divide-x">
                    @if($person->exists)
                    <form action="{{ route('admin.dashboard.identification.people.update', ['identification' => $person]) }}"
                          method="POST"
                          class="divide-y divide-gray-200 lg:col-span-12">
                        @method('PUT')
                    @else
                    <form action="{{ route('admin.dashboard.identification.people.store') }}"
                          method="POST"
                          class="divide-y divide-gray-200 lg:col-span-12">
                        @method('POST')
                    @endif
                        @csrf()
                        <div class="sticky top-0 z-10 bg-white"
                             :class="shadow && 'drop-shadow-md'"
                        >
                            <div class="divide-y divide-gray-200">
                                <div class="flex justify-center py-4 px-4 sm:px-6">
                                    <button type="submit"
                                            name="action"
                                            value="continue"
                                            class="inline-flex justify-center py-2 px-12 text-sm font-medium text-white rounded-md border border-transparent shadow-sm focus:ring-2 focus:ring-offset-2 focus:outline-none bg-sky-700 hover:bg-sky-800 focus:ring-sky-500">Save</button>
                                    @if(! $person->exists)
                                        <button type="submit"
                                                name="action"
                                                value="new"
                                                class="inline-flex justify-center py-2 px-12 ml-12 text-sm font-medium text-white bg-green-700 rounded-md border border-transparent shadow-sm hover:bg-green-800 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:outline-none">Save & New</button>
                                    @endif
                                <a href="{{ route('admin.people.identification') }}"
                                   class="inline-flex justify-center py-2 px-12 ml-12 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">Cancel</a>
                                </div>
                            </div>
                        </div>

                        <!-- Fields section -->
                        <div class="">
                            @if(session('success'))
                                <div x-show="showSuccess"
                                     x-transition
                                     class="p-4 bg-green-50 rounded-md">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <!-- Heroicon name: mini/check-circle -->
                                            <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-green-800">{!! session('success') !!}</p>
                                        </div>
                                        <div class="pl-3 ml-auto">
                                            <div class="-my-1.5 -mx-1.5">
                                                <button type="button"
                                                        x-on:click="showSuccess = false;"
                                                        class="inline-flex p-1.5 text-green-500 bg-green-50 rounded-md hover:bg-green-100 focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50 focus:outline-none">
                                                    <span class="sr-only">Dismiss</span>
                                                    <!-- Heroicon name: mini/x-mark -->
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="p-4 bg-red-50 rounded-md">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <!-- Heroicon name: solid/x-circle -->
                                            <svg class="w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h2 class="text-sm font-medium text-red-800">
                                                There were {{ $errors->count() }} error(s) saving this resource
                                            </h2>
                                            <div class="mt-2 text-sm text-red-700">
                                                <ul class="pl-5 space-y-1 list-disc">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="py-6 px-4 sm:p-6 lg:pb-8">
                            <div>
                                @if($person->exists)
                                    <h2 class="text-2xl font-bold leading-6 text-gray-900">
                                        {{ str($person->first_middle_name)->replace('_', ' ') }} {{ str($person->last_name)->replace('_', ' ') }}
                                    </h2>
                                    <div class="flex gap-x-8 mt-1 text-base font-semibold text-gray-500">
                                        <div>
                                            Unique ID: {{ $person->id ?? 'N/A' }}
                                        </div>
                                        <div>
                                            Last Updated: {{ $person->updated_at?->tz(auth()->user()->timzone ?? 'America/Denver')->toDayDateTimeString() }}
                                        </div>
                                        <div>
                                            Created: {{ $person->created_at?->tz(auth()->user()->timzone ?? 'America/Denver')->toDayDateTimeString() }}
                                        </div>
                                    </div>
                                @else
                                    <h2 class="text-2xl font-bold leading-6 text-gray-900">
                                        Add New Unidentified Person or Submit Correction
                                    </h2>
                                @endif
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-5">
                                    <label for="researcher"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Researcher</span>
                                    </label>
                                    @if(! empty($person->researcher_text))
                                        <input type="text"
                                               name="researcher_text"
                                               id="researcher"
                                               value="{{ $person->researcher_text }}"
                                               class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                        />
                                    @else
                                        <div class="flex gap-x-8 items-center">
                                            <div class="flex-1">
                                                <select name="researcher_id"
                                                        id="researcher"
                                                        class="block flex-1 py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                                >
                                                    <option value="">
                                                        -- Assign to Researcher --
                                                    </option>
                                                    @foreach($researchers as $researcher)
                                                        <option value="{{ $researcher->id }}"
                                                                @if($researcher->id == old('researcher_id', $person->researcher_id)) selected @endif
                                                        >
                                                            {{ $researcher->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                @if(@empty($person->researcher_id))
                                                    <button x-on:click.prevent="setResearcher({{ auth()->id() }})"
                                                            type="button"
                                                            class="inline-flex justify-center py-2 px-4 mr-24 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">
                                                        Assign to Me
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-span-5">
                                    <label for="editorial_assistant"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Editorial Assistant</span>
                                    </label>
                                    <input type="text"
                                           name="editorial_assistant"
                                           id="editorial_assistant"
                                           value="{{ old('editorial_assistant', $person->editorial_assistant) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                                <div class="col-span-2">
                                    <fieldset>
                                        <legend class="block text-sm font-semibold text-gray-700">Needs Correction?</legend>
                                        <div class="flex gap-x-8 items-center">
                                            <div class="flex relative items-start py-3">
                                                <div class="flex items-center h-6">
                                                    <input x-model="correction_needed"
                                                           id="correction_needed"
                                                           name="correction_needed"
                                                           type="checkbox"
                                                           value="1"
                                                           @checked(old('correction_needed', $person->correction_needed))
                                                           class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-600"
                                                    >
                                                    <input id="correction_needed"
                                                           name="correction_needed"
                                                           type="hidden"
                                                           value="0"
                                                           :disabled="correction_needed"
                                                    >
                                                </div>
                                                <div class="ml-3 text-sm leading-6">
                                                    <label for="correction_needed" class="font-medium text-gray-900">Correction Needed</label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>


                            <div class="grid grid-cols-12 gap-6 mt-12">
                                <div class="col-span-3">
                                    <label for="title"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Title</span>
                                    </label>
                                    <input type="text"
                                           name="title"
                                           id="title"
                                           value="{{ old('title', $person->title) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                                <div class="col-span-3">
                                    <label for="first_middle_name"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">First and Middle Names or Initials</span>
                                    </label>
                                    <input type="text"
                                           name="first_middle_name"
                                           id="first_middle_name"
                                           value="{{ old('first_middle_name', $person->first_middle_name) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                                <div class="col-span-3">
                                    <label for="last_name"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Surname or initial</span>
                                    </label>
                                    <input type="text"
                                           name="last_name"
                                           id="last_name"
                                           value="{{ old('last_name', $person->last_name) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                                <div class="col-span-3">
                                    <label for="other"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Other</span>
                                    </label>
                                    <input type="text"
                                           name="other"
                                           id="other"
                                           value="{{ old('other', $person->other) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>

                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-11">
                                    <label for="link_to_ftp"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">FTP Link <span class="text-red-600">*</span></span>
                                    </label>
                                    <input type="text"
                                           name="link_to_ftp"
                                           id="link_to_ftp"
                                           value="{{ old('link_to_ftp', $person->link_to_ftp) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    >
                                </div>
                                <div class="col-span-1">
                                    @if(! empty($person->link_to_ftp))
                                        <a href="{{ $person->link_to_ftp }}" target="_blank" class="inline-flex justify-center py-2 px-12 ml-12 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">View in FTP</a>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-12">
                                    <label for="guesses"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Guesses or notes, if any</span>
                                    </label>
                                    <textarea type="text"
                                              name="guesses"
                                              id="guesses"
                                              class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none summernote focus:border-sky-500 focus:ring-sky-500"
                                    >{!! old('guesses', $person->guesses) !!}</textarea>
                                </div>

                                <div class="col-span-12">
                                    <label for="notes"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Notes</span>
                                    </label>
                                    <textarea type="text"
                                           name="notes"
                                           id="notes"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none summernote focus:border-sky-500 focus:ring-sky-500"
                                    >{!! old('notes', $person->notes) !!}</textarea>
                                </div>
                                <div class="col-span-3">
                                    <label for="fs_id"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">FS ID</span>
                                    </label>
                                    <input type="text"
                                           name="fs_id"
                                           id="fs_id"
                                           value="{{ old('fs_id', $person->fs_id) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-3">
                                    <label for="approximate_birth_date"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Approx Birth</span>
                                    </label>
                                    <input type="date"
                                           name="approximate_birth_date"
                                           id="approximate_birth_date"
                                           value="{{ old('approximate_birth_date', $person->approximate_birth_date) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    >
                                </div>
                                <div class="col-span-3">
                                    <label for="approximate_death_date"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Approx Death</span>
                                    </label>
                                    <input type="date"
                                           name="approximate_death_date"
                                           id="approximate_death_date"
                                           value="{{ old('approximate_death_date', $person->approximate_death_date) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    >
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-12">
                                    <label for="nauvoo_database"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Nauvoo Database</span>
                                    </label>
                                    <input type="text"
                                           name="nauvoo_database"
                                           id="nauvoo_database"
                                           value="{{ old('nauvoo_database', $person->nauvoo_database) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-12">
                                    <label for="pioneer_database"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Pioneer Database</span>
                                    </label>
                                    <input type="text"
                                           name="pioneer_database"
                                           id="pioneer_database"
                                           value="{{ old('pioneer_database', $person->pioneer_database) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-12">
                                    <label for="missionary_database"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Missionary Database</span>
                                    </label>
                                    <input type="text"
                                           name="missionary_database"
                                           id="missionary_database"
                                           value="{{ old('missionary_database', $person->missionary_database) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-12">
                                    <label for="boston_index"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Boston Index</span>
                                    </label>
                                    <input type="text"
                                           name="boston_index"
                                           id="boston_index"
                                           value="{{ old('boston_index', $person->boston_index) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-12">
                                    <label for="st_louis_index"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">St. Louis Index</span>
                                    </label>
                                    <input type="text"
                                           name="st_louis_index"
                                           id="st_louis_index"
                                           value="{{ old('st_louis_index', $person->st_louis_index) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-12">
                                    <label for="british_mission"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">British Mission</span>
                                    </label>
                                    <input type="text"
                                           name="british_mission"
                                           id="british_mission"
                                           value="{{ old('british_mission', $person->british_mission) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-12">
                                    <label for="eighteen_forty_census"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">1840 Census</span>
                                    </label>
                                    <input type="text"
                                           name="eighteen_forty_census"
                                           id="eighteen_forty_census"
                                           value="{{ old('eighteen_forty_census', $person->eighteen_forty_census) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-12">
                                    <label for="eighteen_fifty_census"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">1850 Census</span>
                                    </label>
                                    <input type="text"
                                           name="eighteen_fifty_census"
                                           id="eighteen_fifty_census"
                                           value="{{ old('eighteen_fifty_census', $person->eighteen_fifty_census) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-12">
                                    <label for="eighteen_sixty_census"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">1860 Census</span>
                                    </label>
                                    <input type="text"
                                           name="eighteen_sixty_census"
                                           id="eighteen_sixty_census"
                                           value="{{ old('eighteen_sixty_census', $person->eighteen_sixty_census) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-12">
                                    <label for="other_census"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Other Census</span>
                                    </label>
                                    <input type="text"
                                           name="other_census"
                                           id="other_census"
                                           value="{{ old('other_census', $person->other_census) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-12">
                                    <label for="other_records"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Other Records</span>
                                    </label>
                                    <input type="text"
                                           name="other_records"
                                           id="other_records"
                                           value="{{ old('other_records', $person->other_records) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-12">
                                    <label for="location"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Location</span>
                                    </label>
                                    @if(auth()->user()->hasRole('Bio Admin'))
                                        <input type="text"
                                               name="location"
                                               id="location"
                                               value="{{ old('location', $person->location) }}"
                                               class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                        />
                                    @else
                                        <div class="pt-3 text-gray-500">
                                            {{ $person->location }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-3">
                                    <label for="added_to_ftp_at"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Completed At</span>
                                    </label>
                                    <div class="flex gap-x-2 items-center">
                                        <div class="flex-1">
                                            @if(auth()->user()->hasRole('Bio Admin'))
                                                <input type="date"
                                                       name="completed_at"
                                                       id="completed_at"
                                                       value="{{ old('completed_at', $person->completed_at?->toDateString()) }}"
                                                       class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                                />
                                            @else
                                                <div>
                                                    @if(! empty($person->completed_at))
                                                        {!! $person->completed_at?->toDateString() !!}
                                                    @else
                                                        <span class="text-gray-500">Not completed.</span>
                                                    @endif
                                                </div>
                                            @endif

                                        </div>
                                        <div>
                                            <button x-on:click.prevent="setDateToNow('completed_at')"
                                                    type="button"
                                                    class="inline-flex justify-center py-2 px-4 mt-1 mr-2 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">
                                                Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <fieldset>
                                        <legend class="block text-sm font-semibold text-gray-700">Doesn't need to be tagged</legend>
                                        <div class="flex gap-x-8 items-center">
                                            <div class="flex relative items-start py-3">
                                                <div class="flex items-center h-6">
                                                    <input x-model="skip_tagging"
                                                           id="skip_tagging"
                                                           name="skip_tagging"
                                                           type="checkbox"
                                                           value="1"
                                                           @checked(old('skip_tagging', $person->skip_tagging))
                                                           class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-600"
                                                    >
                                                    <input id="skip_tagging"
                                                           name="skip_tagging"
                                                           type="hidden"
                                                           value="0"
                                                           :disabled="skip_tagging"
                                                    >
                                                </div>
                                                <div class="ml-3 text-sm leading-6">
                                                    <label for="skip_tagging" class="font-medium text-gray-900">Skip Tagging</label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="my-6">
                                <div class="p-4 bg-yellow-50 border-l-4 border-yellow-400">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm text-yellow-700">
                                                <fieldset>
                                                    <div class="flex gap-x-8 items-center">
                                                        <div class="flex relative items-start">
                                                            <div class="flex items-center h-6">
                                                                <input x-model="cant_be_identified"
                                                                       id="cant_be_identified"
                                                                       name="cant_be_identified"
                                                                       type="checkbox"
                                                                       value="1"
                                                                       @checked(old('cant_be_identified', $person->cant_be_identified))
                                                                       class="w-4 h-4 text-yellow-600 rounded border-gray-300 focus:ring-yellow-600"
                                                                >
                                                                <input id="cant_be_identified"
                                                                       name="cant_be_identified"
                                                                       type="hidden"
                                                                       value="0"
                                                                       :disabled="cant_be_identified"
                                                                >
                                                            </div>
                                                            <div class="ml-3 text-sm leading-6">
                                                                <label for="cant_be_identified" class="font-medium text-gray-900">
                                                                    Can't be Identified
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-12 divide-y divide-gray-200">
                                <div class="flex justify-center py-4 px-4 sm:px-6">
                                    <button type="submit"
                                            name="action"
                                            value="continue"
                                            class="inline-flex justify-center py-2 px-12 text-sm font-medium text-white rounded-md border border-transparent shadow-sm focus:ring-2 focus:ring-offset-2 focus:outline-none bg-sky-700 hover:bg-sky-800 focus:ring-sky-500">Save</button>
                                    <button type="submit"
                                            name="action"
                                            value="new"
                                            class="inline-flex justify-center py-2 px-12 ml-12 text-sm font-medium text-white bg-green-700 rounded-md border border-transparent shadow-sm hover:bg-green-800 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:outline-none">Save & New</button>
                                    <a href="{{ route('admin.people.identification') }}"
                                       class="inline-flex justify-center py-2 px-12 ml-12 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mt-12 divide-y divide-gray-200">
                    <div class="flex justify-center py-4 px-4 sm:px-6">
                        @if($person->exists)
                            <form action="{{ route('admin.dashboard.identification.people.copyToPeople', ['identification' => $person]) }}"      method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="inline-flex justify-center py-2 px-12 text-sm font-medium text-white bg-teal-700 rounded-md border border-transparent shadow-sm hover:bg-teal-800 focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 focus:outline-none">Copy to Known People</button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="mt-12 divide-y divide-gray-200">
                    <div class="flex justify-end py-4 px-4 sm:px-6">
                        @if($person->exists)
                            <form action="{{ route('admin.dashboard.identification.people.destroy', ['identification' => $person]) }}"      method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex justify-center py-2 px-12 text-sm font-medium text-white bg-red-700 rounded-md border border-transparent shadow-sm hover:bg-red-800 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none">Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
        <script src="{{ asset('js/summernote-cleaner.js') }}"></script>
        <script>
            $('.summernote').summernote({
                tabsize: 2,
                height: 240,
                toolbar: [
                    ['cleaner', ['cleaner']],
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                cleaner: {
                    action: 'both', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
                    icon: '<span class="note-icon"><svg xmlns="http://www.w3.org/2000/svg" id="libre-paintbrush" viewBox="0 0 14 14" width="14" height="14"><path d="m 11.821425,1 q 0.46875,0 0.82031,0.311384 0.35157,0.311384 0.35157,0.780134 0,0.421875 -0.30134,1.01116 -2.22322,4.212054 -3.11384,5.035715 -0.64956,0.609375 -1.45982,0.609375 -0.84375,0 -1.44978,-0.61942 -0.60603,-0.61942 -0.60603,-1.469866 0,-0.857143 0.61608,-1.419643 l 4.27232,-3.877232 Q 11.345985,1 11.821425,1 z m -6.08705,6.924107 q 0.26116,0.508928 0.71317,0.870536 0.45201,0.361607 1.00781,0.508928 l 0.007,0.475447 q 0.0268,1.426339 -0.86719,2.32366 Q 5.700895,13 4.261155,13 q -0.82366,0 -1.45982,-0.311384 -0.63616,-0.311384 -1.0212,-0.853795 -0.38505,-0.54241 -0.57924,-1.225446 -0.1942,-0.683036 -0.1942,-1.473214 0.0469,0.03348 0.27455,0.200893 0.22768,0.16741 0.41518,0.29799 0.1875,0.130581 0.39509,0.24442 0.20759,0.113839 0.30804,0.113839 0.27455,0 0.3683,-0.247767 0.16741,-0.441965 0.38505,-0.753349 0.21763,-0.311383 0.4654,-0.508928 0.24776,-0.197545 0.58928,-0.31808 0.34152,-0.120536 0.68974,-0.170759 0.34821,-0.05022 0.83705,-0.07031 z"/></svg></span>',
                    keepHtml: true,
                    keepTagContents: ['span'], //Remove tags and keep the contents
                    badTags: ['applet', 'col', 'colgroup', 'embed', 'noframes', 'noscript', 'script', 'style', 'title', 'meta', 'link', 'head'], //Remove full tags with contents
                    badAttributes: ['bgcolor', 'border', 'height', 'cellpadding', 'cellspacing', 'lang', 'start', 'style', 'valign', 'width', 'data-(.*?)'], //Remove attributes from remaining tags
                    limitChars: 0, // 0|# 0 disables option
                    limitDisplay: 'both', // none|text|html|both
                    limitStop: false, // true/false
                    notTimeOut: 850, //time before status message is hidden in miliseconds
                    imagePlaceholder: 'https://via.placeholder.com/200'
                }
            });
        </script>
    @endpush
</x-admin-layout>
