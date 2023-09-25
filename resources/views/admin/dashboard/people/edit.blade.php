<x-admin-layout>
    <main class="relative mt-8"
        x-data="{
            shadow: false,
            showSuccess: true,
            incomplete_identification: @if(empty(old('incomplete_identification', $person->incomplete_identification))) false @else {{ old('incomplete_identification', $person->incomplete_identification) }} @endif,
            setResearcher: function(userid){
                document.getElementById('researcher').value = userid;
            },
            setDateToNow: function(id){
                document.getElementById(id).value = new Date().toISOString().slice(0, 10);
            }
        }"
        x-init="setTimeout(() => showSuccess = false, 3000)"
    >
        <div class="px-4 pb-6 mx-auto max-w-screen-xl sm:px-6 lg:px-8 lg:pb-16">
            <div class="bg-white rounded-lg shadow">
                <div x-intersect:leave="shadow = true"
                     x-intersect:enter="shadow = false"
                ></div>
                <div class="divide-y divide-gray-200 lg:grid lg:grid-cols-12 lg:divide-y-0 lg:divide-x">
                    @if($person->exists)
                    <form action="{{ route('admin.dashboard.people.update', ['person' => $person]) }}"
                          method="POST"
                          class="divide-y divide-gray-200 lg:col-span-12">
                        @method('PUT')
                    @else
                    <form action="{{ route('admin.dashboard.people.store') }}"
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
                                <a href="{{ route('admin.people.index') }}"
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
                            @if(session('updated'))
                                    <div class="p-4 bg-yellow-50 rounded-md">
                                        <div class="flex">
                                            <div class="flex-shrink-0 pt-1">
                                                <svg class="w-5 h-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-lg font-medium text-yellow-800">Attention needed</h3>
                                                <div class="mt-2 text-sm text-yellow-700">
                                                    <p>
                                                        If you haven't already, please update the Research Log with your changes.
                                                    </p>
                                                    <p class="mt-4">
                                                        <a href="{{ $person->log_link }}"
                                                           class="font-semibold text-yellow-900 hover:text-yellow-700"
                                                           target="_research_log"
                                                        >
                                                            Update the Research Log
                                                        </a>
                                                    </p>
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
                                <div class="flex gap-x-4">
                                    <h2 class="text-2xl font-bold leading-6 text-gray-900">
                                        @if($person->exists)
                                            <a href="{{ route('subjects.show', ['subject' => $person->slug]) }}"
                                               target="_blank"
                                               class="text-secondary"
                                            >
                                                {{ $person->name }}
                                            </a>
                                        @endif
                                    </h2>
                                    <span>
                                        @if(! empty($person->subject_uri))
                                            <a class="flex gap-x-1 items-center font-semibold text-[#4d4040] break-word"
                                               href="{{ $person->subject_uri }}"
                                               target="_blank">
                                                            FTP
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                                            </svg>

                                                        </a>
                                        @endif
                                    </span>
                                </div>

                                <div class="flex gap-x-8 mt-1 text-base font-semibold text-gray-500">
                                    <div>
                                        Unique ID: {{ $person->unique_id ?? 'N/A' }}
                                    </div>
                                    <div>
                                        Last Updated: {{ $person->updated_at?->tz(auth()->user()->timzone ?? 'America/Denver')->toDayDateTimeString() }}
                                    </div>
                                    <div>
                                        Created: {{ $person->created_at?->tz(auth()->user()->timzone ?? 'America/Denver')->toDayDateTimeString() }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-6">
                                    <label for="researcher"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Researcher</span>
                                    </label>
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
                                            @if(empty($person->researcher_id))
                                                <button x-on:click.prevent="setResearcher({{ auth()->id() }})"
                                                        type="button"
                                                        class="inline-flex justify-center py-2 px-4 mr-24 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">
                                                    Assign to Me
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    @if(empty($person->researcher_id) && ! empty($person->researcher_text))
                                        <div class="p-1">
                                            <span class="font-semibold">Previously Assigned Researcher:</span> {{ $person->researcher_text }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-span-3">
                                    <label for="pid"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">PID</span>
                                    </label>
                                    <input type="text"
                                           name="pid"
                                           id="pid"
                                           value="{{ old('pid', $person->pid) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                                <div class="col-span-3">
                                    <label for="pid_identified_at"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">PID Identified At</span>
                                    </label>
                                    <div class="flex gap-x-2 items-center">
                                        <div class="flex-1">
                                            <input type="date"
                                                   name="pid_identified_at"
                                                   id="pid_identified_at"
                                                   value="{{ old('pid_identified_at', $person->pid_identified_at) }}"
                                                   class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                            />
                                        </div>
                                        <div>
                                            <button x-on:click.prevent="setDateToNow('pid_identified_at')"
                                                    type="button"
                                                    class="inline-flex justify-center py-2 px-4 mt-1 mr-2 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">
                                                Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="grid grid-cols-12 gap-6 mt-12">
                                <div class="col-span-6">
                                    <label for="name"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Full Name (As used in FTP)</span> <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           value="{{ old('name', $person->name) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                                <div class="col-span-3">
                                    <label for="added_to_ftp_at"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Added to FTP At</span>
                                    </label>
                                    <div class="flex gap-x-2 items-center">
                                        <div class="flex-1">
                                            <input type="date"
                                                   name="added_to_ftp_at"
                                                   id="added_to_ftp_at"
                                                   value="{{ old('added_to_ftp_at', $person->added_to_ftp_at?->toDateString()) }}"
                                                   class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                            />
                                        </div>
                                        <div>
                                            <button x-on:click.prevent="setDateToNow('added_to_ftp_at')"
                                                    type="button"
                                                    class="inline-flex justify-center py-2 px-4 mt-1 mr-2 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">
                                                Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 gap-6 mt-12">
                                <div class="col-span-12">
                                    <label for="subject_uri"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Full FTP URL</span> <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text"
                                           name="subject_uri"
                                           id="subject_uri"
                                           value="{{ old('subject_uri', $person->subject_uri) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                            </div>
                            <div class="grid grid-cols-12 gap-6 mt-12">
                                <div class="col-span-3">
                                    <label for="first_name"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Given Name</span>
                                    </label>
                                    <input type="text"
                                           name="first_name"
                                           id="first_name"
                                           value="{{ old('first_name', $person->first_name) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                                <div class="col-span-3">
                                    <label for="middle_name"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Middle Name</span>
                                    </label>
                                    <input type="text"
                                           name="middle_name"
                                           id="middle_name"
                                           value="{{ old('middle_name', $person->middle_name) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                                <div class="col-span-3">
                                    <label for="last_name"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Surname</span>
                                    </label>
                                    <input type="text"
                                           name="last_name"
                                           id="last_name"
                                           value="{{ old('last_name', $person->last_name) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                                <div class="col-span-3">
                                    <label for="suffix"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Suffix</span>
                                    </label>
                                    <input type="text"
                                           name="suffix"
                                           id="suffix"
                                           value="{{ old('suffix', $person->suffix) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-3">
                                    <label for="alternate_names"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Alternate Names</span>
                                    </label>
                                    <input type="text"
                                           name="alternate_names"
                                           id="alternate_names"
                                           value="{{ old('alternate_names', $person->alternate_names) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                                <div class="col-span-3">
                                    <label for="maiden_name"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Maiden Name</span>
                                    </label>
                                    <input type="text"
                                           name="maiden_name"
                                           id="maiden_name"
                                           value="{{ old('maiden_name', $person->maiden_name) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-3">
                                    <label for="reference"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Reference</span>
                                    </label>
                                    <input type="text"
                                           name="reference"
                                           id="reference"
                                           value="{{ old('reference', $person->reference) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                                <div class="col-span-3">
                                    <label for="relationship"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Relationship to Wilford Woodruff</span>
                                    </label>
                                    <input type="text"
                                           name="relationship"
                                           id="relationship"
                                           value="{{ old('relationship', $person->relationship) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-3">
                                    <label for="birth_date"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Birth Date</span>
                                    </label>
                                    <input type="date"
                                           name="birth_date"
                                           id="birth_date"
                                           value="{{ old('birth_date', $person->birth_date) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    >
                                </div>
                                <div class="col-span-3">
                                    <label for="baptism_date"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Baptism Date</span>
                                    </label>
                                    <input type="date"
                                           name="baptism_date"
                                           id="baptism_date"
                                           value="{{ old('baptism_date', $person->baptism_date) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    >
                                </div>
                                <div class="col-span-3">
                                    <label for="death_date"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Death Date</span>
                                    </label>
                                    <input type="date"
                                           name="death_date"
                                           id="death_date"
                                           value="{{ old('death_date', $person->death_date) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                                <div class="col-span-3">
                                    <label for="life_years"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">B-D Dates</span>
                                    </label>
                                    <input type="text"
                                           name="life_years"
                                           id="life_years"
                                           value="{{ old('life_years', $person->life_years) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    >
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-12">
                                <fieldset class="col-span-12">
                                    <legend class="block mb-1 text-sm font-semibold text-gray-700">Special Categories</legend>
                                    <div class="flex gap-x-4">
                                        @foreach($categories as $category)
                                            <div class="flex relative items-start">
                                                <div class="flex items-center h-6">
                                                    <input id="categories_{{ $category->id }}"
                                                           name="categories[]"
                                                           value="{{ $category->id }}"
                                                           type="checkbox"
                                                           @checked($person->category->contains($category->id))
                                                           class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-600"
                                                    />
                                                </div>
                                                <div class="ml-1 text-sm leading-6">
                                                    <label for="categories_{{ $category->id }}" class="font-medium text-gray-900">{{ $category->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-span-12 py-8">
                                <label for="subcategory"
                                       class="block text-sm font-medium text-gray-700"
                                >
                                    <span class="font-semibold">Subcategory</span>
                                </label>
                                <div class="flex gap-x-8 items-center">
                                    <div class="flex-1">
                                        <select name="subcategory"
                                                id="subcategory"
                                                class="block flex-1 py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                        >
                                            <option value="">
                                                -- Assign Subcategory --
                                            </option>
                                            @foreach($subcategories as $subcategory)
                                                <option value="{{ $subcategory }}"
                                                        @if($subcategory == old('subcategory', $person->subcategory)) selected @endif
                                                >
                                                    {{ $subcategory }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-12">
                                    <label for="bio"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Biography</span>
                                    </label>
                                    @if(auth()->user()->hasRole('Bio Admin'))
                                        <textarea type="text"
                                                  name="bio"
                                                  id="bio"
                                                  class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none summernote focus:border-sky-500 focus:ring-sky-500"
                                        >{!! old('bio', $person->bio) !!}</textarea>
                                    @else
                                        <div>
                                            @if(! empty($person->bio))
                                                {!! old('bio', $person->bio) !!}
                                            @else
                                                <span class="text-gray-500">No biography available.</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="grid grid-cols-12 col-span-12 gap-6 mb-6">
                                    <div class="col-span-3">
                                        <label for="bio_completed_at"
                                               class="block text-sm font-medium text-gray-700"
                                        >
                                            <span class="font-semibold">Biography Completed At</span>
                                        </label>
                                        <div class="flex gap-x-2 items-center">
                                            <div class="flex-1">
                                                <input type="date"
                                                       name="bio_completed_at"
                                                       id="bio_completed_at"
                                                       value="{{ old('bio_completed_at', $person->bio_completed_at) }}"
                                                       class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                                />
                                            </div>
                                            <div>
                                                <button x-on:click.prevent="setDateToNow('bio_completed_at')"
                                                        type="button"
                                                        class="inline-flex justify-center py-2 px-4 mt-1 mr-2 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">
                                                    Now
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-3">
                                        <label for="bio_approved_at"
                                               class="block text-sm font-medium text-gray-700"
                                        >
                                            <span class="font-semibold">Biography Approved At</span>
                                        </label>
                                        @if(auth()->user()->hasRole('Bio Admin'))
                                            <div class="flex gap-x-2 items-center">
                                                <div class="flex-1">
                                                    <input type="date"
                                                           name="bio_approved_at"
                                                           id="bio_approved_at"
                                                           value="{{ old('bio_approved_at', $person->bio_approved_at) }}"
                                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                                    />
                                                </div>
                                                <div>
                                                    <button x-on:click.prevent="setDateToNow('bio_approved_at')"
                                                            type="button"
                                                            class="inline-flex justify-center py-2 px-4 mt-1 mr-2 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">
                                                        Now
                                                    </button>
                                                </div>
                                            </div>
                                        @else
                                            @if(! empty($person->bio_approved_at)))
                                                <div class="pt-3 text-gray-500">{{ $person->bio_approved_at }}</div>
                                            @else
                                                <div class="pt-3 text-gray-500 text-red-700">Not Approved</div>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                <div class="col-span-12">
                                    <label for="footnotes"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Footnotes</span>
                                    </label>
                                    @if(auth()->user()->hasRole('Bio Admin'))
                                        <textarea type="text"
                                               name="footnotes"
                                               id="footnotes"
                                               class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none summernote focus:border-sky-500 focus:ring-sky-500"
                                        >{!! old('footnotes', $person->footnotes) !!}</textarea>
                                    @else
                                        <div>
                                            @if(! empty($person->footnotes))
                                                {!! old('footnotes', $person->footnotes) !!}
                                            @else
                                                <span class="text-gray-500">No footnotes available.</span>
                                            @endif
                                        </div>
                                    @endif
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
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-11">
                                    <label for="log_link"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Log Link</span>
                                    </label>
                                    <input type="text"
                                           name="log_link"
                                           id="log_link"
                                           value="{{ old('log_link', $person->log_link) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    >
                                </div>
                                <div class="col-span-1">
                                    @if(! empty($log_link = old('log_link', $person->log_link)))
                                        <a href="{{ $log_link }}" target="_blank" class="inline-flex justify-center py-2 px-12 ml-12 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">View Log</a>
                                    @endif
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
                                                                <input x-model="incomplete_identification"
                                                                       id="incomplete_identification"
                                                                       name="incomplete_identification"
                                                                       type="checkbox"
                                                                       value="1"
                                                                       @checked(old('incomplete_identification', $person->incomplete_identification))
                                                                       class="w-4 h-4 text-yellow-600 rounded border-gray-300 focus:ring-yellow-600"
                                                                >
                                                                <input id="incomplete_identification"
                                                                       name="incomplete_identification"
                                                                       type="hidden"
                                                                       value="0"
                                                                       :disabled="incomplete_identification"
                                                                >
                                                            </div>
                                                            <div class="ml-3 text-sm leading-6">
                                                                <label for="incomplete_identification" class="font-medium text-gray-900">
                                                                    Incomplete Identification
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
                                    <button type="submit" class="inline-flex justify-center py-2 px-12 text-sm font-medium text-white rounded-md border border-transparent shadow-sm focus:ring-2 focus:ring-offset-2 focus:outline-none bg-sky-700 hover:bg-sky-800 focus:ring-sky-500">Save</button>
                                    <button type="submit"
                                            name="action"
                                            value="new"
                                            class="inline-flex justify-center py-2 px-12 ml-12 text-sm font-medium text-white bg-green-700 rounded-md border border-transparent shadow-sm hover:bg-green-800 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:outline-none">Save & New</button>
                                    <a href="{{ route('admin.people.index') }}"
                                       class="inline-flex justify-center py-2 px-12 ml-12 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mt-12 divide-y divide-gray-200">
                    <div class="flex justify-end py-4 px-4 sm:px-6">
                        @if(auth()->user()->hasRole('Bio Admin') && $person->exists)
                            <form action="{{ route('admin.dashboard.people.destroy', ['person' => $person]) }}"      method="POST">
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
