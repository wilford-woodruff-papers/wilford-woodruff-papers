<div class="p-6 bg-white border-b border-gray-200 sm:px-20">
    <div>
        <x-application-logo class="block w-auto h-12" />
    </div>

    <div class="mt-8 text-2xl">
        Welcome to the Wilford Woodruff Papers Developer Dashboard!
    </div>

    <div class="mt-6 text-gray-500">
        <div>
            <dl class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-3">
                <div class="overflow-hidden py-5 px-4 bg-white rounded-lg shadow sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Documents</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ number_format($totalDocuments, 0, ',') }}</dd>
                </div>
                <div class="overflow-hidden py-5 px-4 bg-white rounded-lg shadow sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Pages</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ number_format($totalPages, 0, ',') }}</dd>
                </div>
                <div class="overflow-hidden py-5 px-4 bg-white rounded-lg shadow sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Subjects</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ number_format($totalSubjects, 0, ',') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-2">
    <div class="p-6">
        <div class="flex items-center">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            <div class="ml-4 text-lg font-semibold leading-7 text-gray-600"><a href="{{ route('documentation') }}">Documentation</a></div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                We provide a simple read only API for retrieving information from the Wilford woodruff Papers Project.
            </div>

            <a href="{{ route('documentation') }}">
                <div class="flex items-center mt-3 text-sm font-semibold text-secondary">
                        <div>Explore the documentation</div>

                        <div class="ml-1 text-secondary">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </div>
                </div>
            </a>
        </div>
    </div>

    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 20.25h12m-7.5-3v3m3-3v3m-10.125-3h17.25c.621 0 1.125-.504 1.125-1.125V4.875c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125z" />
            </svg>
            <div class="ml-4 text-lg font-semibold leading-7 text-gray-600"><a href="https://www.youtube.com/playlist?list=PLlSeyHKjHLO2TF3ZDdF7Vo0CbnuknLU1N" target="_blank">Videos</a></div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                We've created a few videos to help get you started with the Wilford Woodruff Papers API.
            </div>

            <a href="https://www.youtube.com/playlist?list=PLlSeyHKjHLO2TF3ZDdF7Vo0CbnuknLU1N" target="_blank">
                <div class="flex items-center mt-3 text-sm font-semibold text-secondary">
                        <div>Start watching videos</div>

                        <div class="ml-1 text-secondary">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </div>
                </div>
            </a>
        </div>
    </div>

    <div class="p-6">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
            </svg>

            <div class="ml-4 text-lg font-semibold leading-7 text-gray-600"><a href="{{ route('api-tokens.index') }}">API Keys</a></div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                Manage your personal API Keys for interacting with our API.
            </div>

            <a href="{{ route('api-tokens.index') }}">
                <div class="flex items-center mt-3 text-sm font-semibold text-secondary">
                    <div>Manage API Keys</div>

                    <div class="ml-1 text-secondary">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>

            <div class="ml-4 text-lg font-semibold leading-7 text-gray-600"><a href="{{ route('profile.show') }}">Profile</a></div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                Update your profile and enable two-factor authentication.
            </div>

            <a href="{{ route('profile.show') }}">
                <div class="flex items-center mt-3 text-sm font-semibold text-secondary">
                    <div>Manage Your Profile</div>

                    <div class="ml-1 text-secondary">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
