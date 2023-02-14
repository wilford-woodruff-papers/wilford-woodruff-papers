<header class="bg-white shadow">
    <div class="px-2 mx-auto max-w-7xl sm:px-4 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex px-2 lg:px-0">
                <div class="flex flex-shrink-0 items-center">
                    <a href="#">
                        <img class="w-auto h-8" src="{{ asset('img/admin-logo.png') }}" alt="{{ config('app.name') }}">
                    </a>
                </div>
                <nav aria-label="Global" class="hidden lg:flex lg:items-center lg:ml-6 lg:space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 @if(Route::currentRouteName() == 'admin.dashboard') text-indigo-600 @else text-gray-900 @endif text-sm font-medium"> Dashboard </a>
                    @if(auth()->user()->hasRole(\App\Models\Type::query()->whereNull('type_id')->pluck('name')->transform(function($type){ return $type . ' Supervisor'; })->all()))
                        <a href="{{ route('admin.supervisor.individual-activity') }}" class="px-3 py-2 @if(Route::currentRouteName() == 'admin.supervisor.individual-activity') text-indigo-600 @else text-gray-900 @endif text-sm font-medium"> Supervisor Dashboard </a>
                    @endif
                    @if(auth()->user()->hasRole(\App\Models\Type::query()->whereNull('type_id')->pluck('name')->transform(function($type){ return $type . ' Supervisor'; })->all()))
                        <a href="{{ route('admin.dashboard.document.index') }}" class="px-3 py-2  @if(Route::currentRouteName() == 'admin.dashboard.document.index') text-indigo-600 @else text-gray-900 @endif text-sm font-medium"> Documents </a>
                    @endif
                    @if(auth()->user()->hasAnyRole(['Quote Tagging', 'Approve Quotes', 'Admin', 'Super Admin']))
                        <a href="{{ route('admin.dashboard.quotes.index') }}" class="px-3 py-2  @if(Route::currentRouteName() == 'admin.dashboard.quotes.index') text-indigo-600 @else text-gray-900 @endif text-sm font-medium"> Quotes </a>
                    @endif
                    <x-admin.menu.dropdown :text="'ADMIN'" :links="['Goals' => ['url' => route('admin.dashboard.goals.index'), 'auth' => auth()->user()->hasRole(\App\Models\Type::query()->whereNull('type_id')->pluck('name')->transform(function($type){ return $type . ' Supervisor'; })->all())], 'Reporting' => ['url' => route('admin.reports.index'), 'auth' => auth()->user()->hasRole(\App\Models\Type::query()->whereNull('type_id')->pluck('name')->transform(function($type){ return $type . ' Supervisor'; })->all())], 'Progress Matrix' => ['url' => route('admin.reports.progress-matrix'), 'auth' => auth()->user()->hasRole(\App\Models\Type::query()->whereNull('type_id')->pluck('name')->transform(function($type){ return $type . ' Supervisor'; })->all())], 'Objectives' => ['url' => route('admin.reports.stage'), 'auth' => auth()->user()->hasRole(\App\Models\Type::query()->whereNull('type_id')->pluck('name')->transform(function($type){ return $type . ' Supervisor'; })->all())]]"/>
                </nav>
            </div>
            <div class="flex flex-1 justify-center items-center px-2 lg:justify-end lg:ml-6">
                <div class="w-full max-w-lg lg:max-w-xs">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <!-- Heroicon name: solid/search -->
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="search" name="search" class="block py-2 pr-3 pl-10 w-full leading-5 placeholder-gray-500 bg-white rounded-md border border-gray-300 shadow-sm sm:text-sm focus:placeholder-gray-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 focus:outline-none" placeholder="Search" type="search">
                    </div>
                </div>
            </div>

            <x-admin.mobile-menu />

            <div class="hidden lg:flex lg:items-center lg:ml-4">
                <button type="button" class="flex-shrink-0 p-1 text-gray-400 bg-white rounded-full hover:text-gray-500 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none">
                    <span class="sr-only">View notifications</span>
                    <!-- Heroicon name: outline/bell -->
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>

                <x-admin.profile-dropdown />
            </div>
        </div>
    </div>

    <div class="px-4 mx-auto max-w-7xl sm:px-6">
        <div class="py-3 border-t border-gray-200">
            <nav class="flex" aria-label="Breadcrumb">
                <div class="flex sm:hidden">
                    <a href="#" class="inline-flex space-x-3 text-sm font-medium text-gray-500 hover:text-gray-700 group">
                        <!-- Heroicon name: solid/arrow-narrow-left -->
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-400 group-hover:text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        <span>Back to Document</span>
                    </a>
                </div>
                <div class="hidden sm:block">
                    {{--<ol role="list" class="flex items-center space-x-4">
                        <li>
                            <div>
                                <a href="#" class="text-gray-400 hover:text-gray-500">
                                    <!-- Heroicon name: solid/home -->
                                    <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                    </svg>
                                    <span class="sr-only">Home</span>
                                </a>
                            </div>
                        </li>

                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                </svg>
                                <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Jobs</a>
                            </div>
                        </li>

                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                </svg>
                                <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Front End Developer</a>
                            </div>
                        </li>

                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                </svg>
                                <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Applicants</a>
                            </div>
                        </li>
                    </ol>--}}
                </div>
            </nav>
        </div>
    </div>
</header>
