<x-admin-layout>
    <main class="relative mt-8"
        x-data="{
            shadow: false,
            showSuccess: true,
            skip_tagging: @if(empty(old('skip_tagging', $place->skip_tagging))) false @else {{ old('skip_tagging', $place->skip_tagging) }} @endif,
            correction_needed: @if(empty(old('correction_needed', $place->correction_needed))) false @else {{ old('correction_needed', $place->correction_needed) }} @endif,
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
                    @if($place->exists)
                    <form action="{{ route('admin.dashboard.identification.places.update', ['identification' => $place]) }}"
                          method="POST"
                          class="divide-y divide-gray-200 lg:col-span-12">
                        @method('PUT')
                    @else
                    <form action="{{ route('admin.dashboard.identification.places.store') }}"
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
                                    <button type="submit"
                                            name="action"
                                            value="new"
                                            class="inline-flex justify-center py-2 px-12 ml-12 text-sm font-medium text-white bg-green-700 rounded-md border border-transparent shadow-sm hover:bg-green-800 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:outline-none">Save & New</button>
                                <a href="{{ route('admin.places.identification') }}"
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
                                @if($place->exists)
                                    <h2 class="text-2xl font-bold leading-6 text-gray-900">
                                        {{ $place->location }}
                                    </h2>
                                    <div class="flex gap-x-8 mt-1 text-base font-semibold text-gray-500">
                                        <div>
                                            Unique ID: {{ $place->id ?? 'N/A' }}
                                        </div>
                                        <div>
                                            Last Updated: {{ $place->updated_at?->toDayDateTimeString() }}
                                        </div>
                                        <div>
                                            Created: {{ $place->created_at?->toDayDateTimeString() }}
                                        </div>
                                    </div>
                                @else
                                    <h2 class="text-2xl font-bold leading-6 text-gray-900">
                                        Add New Unknown Place
                                    </h2>
                                @endif
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">
                                <div class="col-span-6">
                                    <label for="editorial_assistant"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Editorial Assistant</span>
                                    </label>
                                    <input type="text"
                                           name="editorial_assistant"
                                           id="editorial_assistant"
                                           value="{{ old('editorial_assistant', $place->editorial_assistant) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                                <div class="col-span-3">
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
                                                           @checked(old('correction_needed', $place->correction_needed))
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
                                    <label for="guess"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Possible Parent Location</span>
                                    </label>
                                    <input type="text"
                                           name="guess"
                                           id="guess"
                                           value="{{ old('guess', $place->guess) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
                                </div>
                                <div class="col-span-3">
                                    <label for="location"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Name of Location as Written <span class="text-red-600">*</span></span>
                                    </label>
                                    <input type="text"
                                           name="location"
                                           id="location"
                                           value="{{ old('location', $place->location) }}"
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
                                           value="{{ old('link_to_ftp', $place->link_to_ftp) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    >
                                </div>
                                <div class="col-span-1">
                                    @if(! empty($place->link_to_ftp))
                                        <a href="{{ $place->link_to_ftp }}" target="_blank" class="inline-flex justify-center py-2 px-12 ml-12 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">View in FTP</a>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-6 mt-6">

                                <div class="col-span-12">
                                    <label for="notes"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Additional Information</span>
                                    </label>
                                    <textarea type="text"
                                           name="notes"
                                           id="notes"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none summernote focus:border-sky-500 focus:ring-sky-500"
                                    >{!! old('notes', $place->notes) !!}</textarea>
                                </div>


                                <div class="col-span-12">
                                    <label for="other"
                                           class="block text-sm font-medium text-gray-700"
                                    >
                                        <span class="font-semibold">Other Notes</span>
                                    </label>
                                    <input type="text"
                                           name="other"
                                           id="other"
                                           value="{{ old('other', $place->other) }}"
                                           class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                    />
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
                                                       value="{{ old('completed_at', $place->completed_at) }}"
                                                       class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 shadow-sm sm:text-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500"
                                                />
                                            @else
                                                <div>
                                                    @if(! empty($place->completed_at))
                                                        {!! $place->completed_at !!}
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
                                                           @checked(old('skip_tagging', $place->skip_tagging))
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
                                    <a href="{{ route('admin.places.identification') }}"
                                       class="inline-flex justify-center py-2 px-12 ml-12 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-sky-500">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mt-12 divide-y divide-gray-200">
                    <div class="flex justify-end py-4 px-4 sm:px-6">
                        @if($place->exists)
                            <form action="{{ route('admin.dashboard.identification.places.destroy', ['identification' => $place]) }}"      method="POST">
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
