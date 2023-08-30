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
    <div class="mx-12 bg-white border-4 border-dashed border-secondary">
        <div class="relative sm:py-8">
            <div class="px-0 mx-auto sm:px-0 sm:max-w-5xl lg:px-8 lg:max-w-7xl">
                <div class="relative">
                    <div class="text-center">
                        <h2 class="text-xl font-bold tracking-tight text-black sm:text-4xl md:text-3xl">
                            Can you help us identify this person?
                        </h2>
                        <p class="mx-auto mt-6 max-w-2xl text-xl text-gray-800">
                            If you have information that can help us identify this person, please contact us.
                        </p>
                        <p class="mt-8">
                            <a href="{{ route('contact-us', ['message' => 'I have information regarding '.$subject]) }}"
                               class="py-2 px-4 text-white bg-secondary hover:bg-secondary-dark"
                            >
                                Contact Form
                            </a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
