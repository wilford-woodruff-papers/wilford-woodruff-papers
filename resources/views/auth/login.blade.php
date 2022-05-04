<x-guest-layout>
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="flex flex-col justify-center items center max-w-3xl mx-auto">
                <h1 class="text-2xl tracking-tight font-extrabold text-gray-900 sm:text-3xl md:text-4xl">
                    <span class="block xl:inline">Create an Account</span>
                </h1>
                <ul class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl pl-12 md:mt-5 md:text-xl lg:mx-0 list-disc">
                    <li>
                        Join our community discussion
                    </li>
                    <li>
                        Receive update notifications
                    </li>
                </ul>
                <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                    <div class="rounded-md shadow">
                        <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium bg-secondary text-white md:py-4 md:text-lg md:px-10">
                            Register
                        </a>
                    </div>
                </div>
            </div>
            <div>
                <x-jet-authentication-card>
                    <x-slot name="logo">
                        <x-jet-authentication-card-logo />
                    </x-slot>

                    <x-jet-validation-errors class="mb-4" />

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div>
                            <x-jet-label for="email" value="{{ __('Email') }}" />
                            <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="password" value="{{ __('Password') }}" />
                            <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                        </div>

                        <div class="block mt-4">
                            <label for="remember_me" class="flex items-center">
                                <x-jet-checkbox id="remember_me" name="remember" />
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif

                            <x-jet-button class="ml-4 bg-secondary rounded-none">
                                {{ __('Log in') }}
                            </x-jet-button>
                        </div>
                    </form>
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="px-2 bg-white text-sm text-gray-500"> or </span>
                        </div>
                    </div>
                    <div class="gap-y-4">
                        <div>
                            <a href="{{ route('login.google') }}" type="button" class="inline-flex items-center justify-center px-4 py-2 w-full border border-transparent shadow-md text-sm font-medium text-gray-500 bg-white hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <!-- Google Icon -->
                                <svg class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <g transform="matrix(1, 0, 0, 1, 27.009001, -39.238998)">
                                        <path fill="#4285F4" d="M -3.264 51.509 C -3.264 50.719 -3.334 49.969 -3.454 49.239 L -14.754 49.239 L -14.754 53.749 L -8.284 53.749 C -8.574 55.229 -9.424 56.479 -10.684 57.329 L -10.684 60.329 L -6.824 60.329 C -4.564 58.239 -3.264 55.159 -3.264 51.509 Z"/>
                                        <path fill="#34A853" d="M -14.754 63.239 C -11.514 63.239 -8.804 62.159 -6.824 60.329 L -10.684 57.329 C -11.764 58.049 -13.134 58.489 -14.754 58.489 C -17.884 58.489 -20.534 56.379 -21.484 53.529 L -25.464 53.529 L -25.464 56.619 C -23.494 60.539 -19.444 63.239 -14.754 63.239 Z"/>
                                        <path fill="#FBBC05" d="M -21.484 53.529 C -21.734 52.809 -21.864 52.039 -21.864 51.239 C -21.864 50.439 -21.724 49.669 -21.484 48.949 L -21.484 45.859 L -25.464 45.859 C -26.284 47.479 -26.754 49.299 -26.754 51.239 C -26.754 53.179 -26.284 54.999 -25.464 56.619 L -21.484 53.529 Z"/>
                                        <path fill="#EA4335" d="M -14.754 43.989 C -12.984 43.989 -11.404 44.599 -10.154 45.789 L -6.734 42.369 C -8.804 40.429 -11.514 39.239 -14.754 39.239 C -19.444 39.239 -23.494 41.939 -25.464 45.859 L -21.484 48.949 C -20.534 46.099 -17.884 43.989 -14.754 43.989 Z"/>
                                    </g>
                                </svg>
                                Sign in with Google
                            </a>
                        </div>
                    </div>
                </x-jet-authentication-card>
            </div>
        </div>
    </div>
</x-guest-layout>
