<x-guest-layout>
    <div class="py-4 bg-gray-100">
        <div class="flex flex-col items-center pt-6 sm:pt-0">
            <div class="overflow-hidden py-2 mt-2 w-full sm:max-w-4xl prose">
                <h1 class="text-3xl font-semibold">
                    Additional Information
                </h1>
                <p>
                    Please help us understand how you plan to use the Wilford Woodruff Papers API by providing the following information.
                </p>
                <form action="{{ route('api.terms.update') }}" method="POST">
                    @csrf
                    @method('POST')
                    <x-honeypot />
                    <x-validation-errors :errors="$errors"/>
                    <div class="grid space-y-4">
                        <div class="col-span-full">
                            <label for="organization" class="block text-base font-medium leading-6 text-gray-900">Organization Affiliation (if applicable)</label>
                            <div class="mt-2">
                                <input type="text"
                                       name="organization"
                                       id="organization"
                                       autocomplete="organization"
                                       class="block py-1.5 w-full text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm sm:text-sm sm:leading-6 focus:ring-2 focus:ring-inset placeholder:text-gray-400 focus:ring-secondary-600"
                                       maxlength="191"
                                       value="{{ old("organization") }}"
                                >
                            </div>
                        </div>
                        <div x-data="{
                            text: '{{ old("proposed_use") }}',
                            count: 2000,
                        }"
                             x-init="$watch('text', text => count = 2000 - text.length)"
                             class="col-span-full">
                            <label for="proposed_use" class="block text-base font-medium leading-6 text-gray-900">How do you plan to use the Wilford Woodruff Papers API? <span class="text-red-700">*</span></label>
                            <div class="mt-2">
                            <textarea x-model="text"
                                      name="proposed_use"
                                      id="proposed_use"
                                      class="block py-1.5 w-full text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm sm:text-sm sm:leading-6 focus:ring-2 focus:ring-inset placeholder:text-gray-400 focus:ring-secondary-600"
                                      rows="4"
                            >{{ old("proposed_use") }}</textarea>
                                <div class="flex justify-end text-sm text-gray-900">Characters remaining:&nbsp;<span x-text="count"></span></div>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                            class="block py-2 w-full font-semibold text-white bg-secondary"
                    >
                        SUBMIT
                    </button>
                </form>
            </div>
        </div>
    </div>
    @push('styles')
        <style>
            ol {
                list-style-type: none;
                counter-reset: item;
                margin: 0;
                padding: 0;
            }

            ol > li {
                display: table;
                counter-increment: item;
                margin-bottom: 0.6em;
            }

            ol > li:before {
                content: counters(item, ".") ". ";
                display: table-cell;
                padding-right: 0.6em;
            }

            li ol > li {
                margin: 0;
            }

            li ol > li:before {
                content: counters(item, ".") " ";
            }
        </style>
    @endpush
</x-guest-layout>
