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
                </x-jet-authentication-card>
            </div>
        </div>
    </div>
</x-guest-layout>
