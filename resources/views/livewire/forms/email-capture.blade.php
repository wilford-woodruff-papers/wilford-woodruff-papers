<div>
    <!--
  This example requires Tailwind CSS v2.0+

  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
    <div class="bg-white">
        <div class="relative sm:py-8">
            <div aria-hidden="true" class="hidden sm:block">
                <div class="absolute inset-y-0 left-0 w-1/2 rounded-r-3xl"></div>
                {{--<svg class="absolute top-8 left-1/2 -ml-3" width="404" height="392" fill="none" viewBox="0 0 404 392">
                    <defs>
                        <pattern id="8228f071-bcee-4ec8-905a-2a059a2cc4fb" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="404" height="392" fill="url(#8228f071-bcee-4ec8-905a-2a059a2cc4fb)" />
                </svg>--}}
            </div>
            <div class="mx-auto max-w-xl px-4 sm:max-w-4xl sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="relative overflow-hidden bg-secondary px-6 py-10 shadow-xl sm:px-12 sm:py-20">
                    <div aria-hidden="true" class="absolute inset-0 -mt-72 sm:-mt-32 md:mt-0">
                        <svg class="absolute inset-0 h-full w-full" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 1463 360">
                            <path class="text-secondary-500 text-opacity-40" fill="currentColor" d="M-82.673 72l1761.849 472.086-134.327 501.315-1761.85-472.086z" />
                            <path class="text-secondary-700 text-opacity-40" fill="currentColor" d="M-217.088 544.086L1544.761 72l134.327 501.316-1761.849 472.086z" />
                        </svg>
                    </div>

                    @if($success)
                        <div class="relative">
                            <div class="sm:text-center">
                                <h2 class="text-xl md:text-3xl font-bold tracking-tight text-white sm:text-4xl">
                                    {{ $component['success_title'] }}
                                </h2>
                                <p class="mx-auto mt-6 max-w-2xl text-lg text-white">
                                    {{ $component['success_description'] }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="relative">
                            <div class="text-center">
                                <h2 class="text-xl md:text-3xl font-bold tracking-tight text-white sm:text-4xl">
                                    {{ $component['title'] }}
                                </h2>
                                <p class="mx-auto mt-6 max-w-2xl text-lg text-indigo-200">
                                    {{ $component['description'] }}
                                </p>
                            </div>
                            <form wire:submit.prevent="save()"
                                  action="#"
                                  class="mt-12 sm:mx-auto sm:flex sm:max-w-lg">
                                <div class="min-w-0 flex-1">
                                    <label for="cta-email" class="sr-only">Email address</label>
                                    <input wire:model.defer="contact.email"
                                           id="cta-email"
                                           type="email"
                                           class="block w-full border border-transparent px-5 py-3 text-base text-gray-900 placeholder-gray-700 shadow-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600"
                                           placeholder="Enter your email"
                                           required
                                    >
                                </div>
                                <div class="mt-4 sm:mt-0 sm:ml-3">
                                    <button wire:loading.attr="disabled"
                                            wire:loading.class="bg-gray-400"
                                            wire:loading.class.remove="bg-white"
                                            type="submit"
                                            class="block w-full border border-transparent bg-white px-5 py-3 text-base font-semibold text-secondary shadow hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600 sm:px-10 uppercase">
                                        <span wire:loading.remove>Notify me</span>
                                        <span wire:loading
                                              class="flex items-center px-7"
                                        >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="animate-spin w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                        </svg>

                                    </span>
                                    </button>
                                </div>
                            </form>
                            @error('contact.email')
                            <div class="bg-white py-2 mt-2 sm:mx-auto sm:max-w-lg">
                                <div class="text-red-500 text-sm text-center">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
