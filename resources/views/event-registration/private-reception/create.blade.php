<x-guest-layout>
    <x-slot name="title">Evening of Appreciation with Elder Matthew Holland on March 1, 2024</x-slot>
    <div class="my-12 mx-auto max-w-7xl">
            <div class="space-y-12">
                <div class="grid grid-cols-1 gap-x-8 gap-y-10 pb-12 md:grid-cols-2">
                    <div>
                        <img src="https://wilford-woodruff-papers.nyc3.cdn.digitaloceanspaces.com/img/elder-matthew-holland-invitation.jpg"
                             class="p-4 w-full h-auto"
                             alt="Evening of Appreciation for friends of the Wilford Woodruff Papers Foundation on March 1st, 2024"
                        />
                    </div>

                    <div class="px-12">
                        @if(session('success'))
                            <div class="flex flex-col gap-12 justify-center content-center items-center h-full">
                                <div class="text-2xl text-center">
                                    {!! session('success') !!}
                                </div>
                                <div>
                                    <a href="{{ route('event.calendar') }}"
                                       class="py-3 px-6 text-sm font-semibold text-white shadow-sm bg-secondary hover:bg-secondary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-secondary-600"
                                       target="_blank"
                                    >
                                        Add to Calendar
                                    </a>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('event.register') }}"
                                  method="POST"
                                  class="sm:col-span-6">
                                @csrf
                                <x-honeypot />
                                @if ($errors->any())
                                    <div>
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
                                                        There were {{ $errors->count() }} error(s) registering for this event
                                                    </h2>
                                                    <div class="mt-2 text-sm text-red-700">
                                                        <ul class="pl-5 space-y-1 list-disc">
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ str($error)->replace('fields.', '')->replace("'", '') }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="grid grid-cols-1 gap-x-6 gap-y-8 py-12 max-w-2xl sm:grid-cols-6 md:col-span-1">
                                    <div class="sm:col-span-3">
                                        <label for="first-name" class="block text-base font-medium leading-6 text-gray-900">First name <span class="text-red-700">*</span></label>
                                        <div class="mt-2">
                                            <input type="text"
                                                   name="first_name"
                                                   id="first-name"
                                                   autocomplete="given-name"
                                                   class="block py-1.5 w-full text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm sm:text-sm sm:leading-6 focus:ring-2 focus:ring-inset placeholder:text-gray-400 focus:ring-secondary-600"
                                                   maxlength="191"
                                            >
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="last-name" class="block text-base font-medium leading-6 text-gray-900">Last name <span class="text-red-700">*</span></label>
                                        <div class="mt-2">
                                            <input type="text"
                                                   name="last_name"
                                                   id="last-name"
                                                   autocomplete="family-name"
                                                   class="block py-1.5 w-full text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm sm:text-sm sm:leading-6 focus:ring-2 focus:ring-inset placeholder:text-gray-400 focus:ring-secondary-600"
                                                   maxlength="191"
                                            >
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="email" class="block text-base font-medium leading-6 text-gray-900">Email address <span class="text-red-700">*</span></label>
                                        <div class="mt-2">
                                            <input id="email"
                                                   name="email"
                                                   type="email"
                                                   autocomplete="email"
                                                   class="block py-1.5 w-full text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm sm:text-sm sm:leading-6 focus:ring-2 focus:ring-inset placeholder:text-gray-400 focus:ring-secondary-600"
                                                   maxlength="191"
                                            >
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="fields['Phone Number']" class="block text-base font-medium leading-6 text-gray-900">
                                            Phone Number
                                        </label>
                                        <div class="mt-2">
                                            <input type="text"
                                                   name="fields['Phone Number']"
                                                   id="fields['Phone Number']"
                                                   placeholder="(123) 456-7890"
                                                   class="block py-1.5 w-full text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm sm:text-sm sm:leading-6 focus:ring-2 focus:ring-inset placeholder:text-gray-400 focus:ring-secondary-600"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-span-full">
                                        <label for="fields['How many will be attending?']" class="block text-base font-medium leading-6 text-gray-900">
                                            How many will be attending?
                                        </label>
                                        <div class="mt-2">
                                            <input type="number"
                                                   name="fields['How many will be attending?']"
                                                   id="fields['How many will be attending?']"
                                                   value="2"
                                                   class="block py-1.5 w-full text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm sm:text-sm sm:leading-6 focus:ring-2 focus:ring-inset placeholder:text-gray-400 focus:ring-secondary-600"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-span-full">
                                        <div class="flex gap-x-6 justify-center items-center mt-6">
                                            <button type="submit" class="py-3 px-6 text-sm font-semibold text-white shadow-sm bg-secondary hover:bg-secondary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-secondary-600">Register</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>




    </div>
</x-guest-layout>
