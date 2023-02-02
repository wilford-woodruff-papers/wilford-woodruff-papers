<x-guest-layout>
    <div class="mx-auto max-w-7xl">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="flex flex-col justify-center mx-auto max-w-3xl items center">
                <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl md:text-4xl">
                    <span class="block xl:inline">Create an Account</span>
                </h1>
                <ul class="pl-12 mt-3 text-base list-disc text-gray-500 sm:mt-5 sm:max-w-xl sm:text-lg md:mt-5 md:text-xl lg:mx-0">
                    <li>
                        Join our community discussion
                    </li>
                    <li>
                        Receive update notifications
                    </li>
                </ul>
                <div class="mt-5 sm:flex sm:justify-center sm:mt-8 lg:justify-start">
                    <div class="rounded-md shadow">
                        <a href="{{ route('register') }}" class="flex justify-center items-center py-3 px-8 w-full text-base font-medium text-white uppercase border border-transparent md:py-4 md:px-10 md:text-lg bg-secondary">
                            Register
                        </a>
                    </div>
                </div>
            </div>
            <div>
                <x-jet-authentication-card>
                    <x-slot name="logo">

                    </x-slot>

                    <x-jet-validation-errors class="mb-4" />

                    @if (session('status'))
                        <div class="mb-4 text-sm font-medium text-green-600">
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

                        <div class="flex flex-col gap-y-2 justify-center mt-4">
                            <x-jet-button class="py-3 text-center rounded-none md:py-4 bg-secondary">
                                <span class="mx-auto text-base font-medium md:text-lg">
                                    {{ __('Log in') }}
                                </span>
                            </x-jet-button>
                            @if (Route::has('password.request'))
                                <a class="text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif

                        </div>
                    </form>
                    <div class="relative">
                        <div class="flex absolute inset-0 items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="flex relative justify-center">
                            <span class="px-2 text-sm text-gray-500 bg-white"> or </span>
                        </div>
                    </div>
                    <div class="grid gap-y-4">
                        <div>
                            <a href="{{ route('login.google') }}" type="button" class="inline-flex justify-center items-center py-2 px-4 w-full text-sm font-medium text-gray-500 bg-white border border-transparent shadow-md hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:outline-none">
                                <!-- Google Icon -->
                                <svg class="mr-2 -ml-1 w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
                        <div>
                            <a href="{{ route('login.facebook') }}" type="button" class="inline-flex justify-center items-center py-2 px-4 w-full text-sm font-medium text-gray-500 bg-white border border-transparent shadow-md hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:outline-none">
                                <!-- Facebook Icon -->
                                <svg class="mr-2 -ml-1 w-5 h-5" version="1.1" id="facebook-icon"
                                     xmlns="http://www.w3.org/2000/svg"
                                     x="0px" y="0px"
                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;"
                                     xml:space="preserve">
                                    <path style="fill:#385C8E;" d="M134.941,272.691h56.123v231.051c0,4.562,3.696,8.258,8.258,8.258h95.159
                                        c4.562,0,8.258-3.696,8.258-8.258V273.78h64.519c4.195,0,7.725-3.148,8.204-7.315l9.799-85.061c0.269-2.34-0.472-4.684-2.038-6.44
                                        c-1.567-1.757-3.81-2.763-6.164-2.763h-74.316V118.88c0-16.073,8.654-24.224,25.726-24.224c2.433,0,48.59,0,48.59,0
                                        c4.562,0,8.258-3.698,8.258-8.258V8.319c0-4.562-3.696-8.258-8.258-8.258h-66.965C309.622,0.038,308.573,0,307.027,0
                                        c-11.619,0-52.006,2.281-83.909,31.63c-35.348,32.524-30.434,71.465-29.26,78.217v62.352h-58.918c-4.562,0-8.258,3.696-8.258,8.258
                                        v83.975C126.683,268.993,130.379,272.691,134.941,272.691z"/>
                                                                        <
                                </svg>
                                Sign in with Facebook
                            </a>
                        </div>
                    </div>
                </x-jet-authentication-card>
            </div>
        </div>
    </div>
</x-guest-layout>
