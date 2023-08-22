<x-guest-layout>
    <div class="py-4 bg-gray-100">
        <div class="flex flex-col items-center pt-6 sm:pt-0">
            <div class="overflow-hidden p-6 mt-6 w-full bg-white shadow-md sm:max-w-2xl prose">
                {!! $terms !!}
            </div>
        </div>
        <div class="flex flex-col items-center pt-6 sm:pt-0">
            <div class="overflow-hidden py-2 mt-2 w-full sm:max-w-2xl prose">
                <form action="{{ route('terms.submit') }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="my-4">
                        <x-label for="subscribe_to_newsletter">
                            <div class="flex items-center">
                                <x-checkbox name="subscribe_to_newsletter"
                                            id="subscribe_to_newsletter"
                                            value="true"
                                            checked="checked"
                                />

                                <div class="ml-2 text-lg">
                                    Receive regular updates from the Wilford Woodruff Papers Foundation
                                </div>
                            </div>
                        </x-label>
                    </div>

                    <button type="submit"
                            class="block py-2 w-full font-semibold text-white bg-secondary"
                    >
                        AGREE
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
