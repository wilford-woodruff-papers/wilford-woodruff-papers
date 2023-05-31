<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Documentation') }}
        </h2>
    </x-slot>

    <div x-data="{
        id: 'introduction'
    }"
         class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg">
                <div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-4">
                    <div class="relative col-span-1">
                        <div class="sticky top-10">
                            <nav class="flex flex-col flex-1 py-2 px-4" aria-label="Sidebar">
                                <ul role="list" class="-mx-2 space-y-1">
                                    <li>
                                        <a href="#introduction"
                                           x-on:click="id = 'introduction'"
                                           :class="id =='introduction' ? 'text-secondary' : 'text-gray-700'"
                                           class="flex gap-x-3 p-2 pl-3 text-sm font-semibold leading-6 rounded-md hover:bg-gray-50 group hover:text-secondary">Introduction</a>
                                    </li>
                                    <li>
                                        <a href="#authentication"
                                           x-on:click="id = 'authentication'"
                                           :class="id =='authentication' ? 'text-secondary' : 'text-gray-700'"
                                           class="flex gap-x-3 p-2 pl-3 text-sm font-semibold leading-6 rounded-md hover:bg-gray-50 group hover:text-secondary">Authentication</a>
                                    </li>
                                    <li>
                                        <a href="#headers"
                                           x-on:click="id = 'headers'"
                                           :class="id =='headers' ? 'text-secondary' : 'text-gray-700'"
                                           class="flex gap-x-3 p-2 pl-3 text-sm font-semibold leading-6 rounded-md hover:bg-gray-50 group hover:text-secondary">Headers</a>
                                    </li>
                                    <li>
                                        <a href="#uri"
                                           x-on:click="id = 'uri'"
                                           :class="id =='uri' ? 'text-secondary' : 'text-gray-700'"
                                           class="flex gap-x-3 p-2 pl-3 text-sm font-semibold leading-6 rounded-md hover:bg-gray-50 group hover:text-secondary">URI</a>
                                    </li>
                                    <li>
                                        <a href="#errors"
                                           x-on:click="id = 'errors'"
                                           :class="id =='errors' ? 'text-secondary' : 'text-gray-700'"
                                           class="flex gap-x-3 p-2 pl-3 text-sm font-semibold leading-6 rounded-md hover:bg-gray-50 group hover:text-secondary">Errors</a>
                                    </li>
                                    <li>
                                        <a href="#documents"
                                           x-on:click="id = 'documents'"
                                           :class="id =='documents' ? 'text-secondary' : 'text-gray-700'"
                                           class="flex gap-x-3 p-2 pl-3 text-sm font-semibold leading-6 rounded-md hover:bg-gray-50 group hover:text-secondary">Documents</a>
                                    </li>
                                    <li>
                                        <a href="#pages"
                                           x-on:click="id = 'pages'"
                                           :class="id =='pages' ? 'text-secondary' : 'text-gray-700'"
                                           class="flex gap-x-3 p-2 pl-3 text-sm font-semibold leading-6 rounded-md hover:bg-gray-50 group hover:text-secondary">Pages</a>
                                    </li>
                                    <li>
                                        <a href="#subjects"
                                           x-on:click="id = 'subjects'"
                                           :class="id =='subjects' ? 'text-secondary' : 'text-gray-700'"
                                           class="flex gap-x-3 p-2 pl-3 text-sm font-semibold leading-6 rounded-md hover:bg-gray-50 group hover:text-secondary">Subjects</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-span-3">

                        <div id="introduction"
                             x-intersect.half="id = 'introduction'"
                        >
                            <div class="py-6 bg-white sm:py-12 min-h-[50vh]">
                                <div class="px-6 mx-auto max-w-7xl lg:px-8">
                                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                                            Introduction
                                        </h2>
                                        <div class="grid grid-cols-1 gap-8 mt-10 max-w-xl text-base leading-7 text-gray-700 lg:max-w-none">
                                            <div>
                                                <p class="p-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                                   The Wilford Woodruff Papers API allows you to retrieve document metadata through a REST API.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="authentication"
                             x-intersect.half="id = 'authentication'"
                        >
                            <div class="py-6 bg-white sm:py-12 min-h-[50vh]">
                                <div class="px-6 mx-auto max-w-7xl lg:px-8">
                                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                                            Authentication
                                        </h2>
                                        <div class="grid grid-cols-1 gap-8 mt-10 max-w-xl text-base leading-7 text-gray-700 lg:max-w-none">
                                            <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                                <p>
                                                    In order to use the API, you should authenticate your request by including your API key as a bearer token value:
                                                </p>
                                                <p>
                                                    <code class="p-1 bg-gray-300">
                                                        Authorization: Bearer API_KEY_HERE
                                                    </code>
                                                </p>
                                                <p>
                                                    You may generate API keys in the <a href="{{ route('api-tokens.index') }}" class="text-secondary">API Tokens Dashboard</a> and they should have the 'read' permission.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="headers"
                             x-intersect.half="id = 'headers'"
                        >
                            <div class="py-6 bg-white sm:py-12 min-h-[50vh]">
                                <div class="px-6 mx-auto max-w-7xl lg:px-8">
                                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                                            Headers
                                        </h2>
                                        <div class="grid grid-cols-1 gap-8 mt-10 max-w-xl text-base leading-7 text-gray-700 lg:max-w-none">
                                            <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                                <p>
                                                    Make sure you have the following content type headers are set on every request:
                                                </p>
                                                <p>
                                                    <code class="p-1 bg-gray-300">
                                                        Accept: application/json Content-Type: application/json
                                                    </code>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="uri"
                             x-intersect.half="id = 'uri'"
                        >
                            <div class="py-6 bg-white sm:py-12 min-h-[50vh]">
                                <div class="px-6 mx-auto max-w-7xl lg:px-8">
                                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                                            URI
                                        </h2>
                                        <div class="grid grid-cols-1 gap-8 mt-10 max-w-xl text-base leading-7 text-gray-700 lg:max-w-none">
                                            <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                                <p>
                                                    The Wilford Woodruff Papers API is hosted on the following base URI:
                                                </p>
                                                <p>
                                                    <code class="p-1 bg-gray-300">
                                                        https://wilfordwoodruffpapers.org/api/v1
                                                    </code>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="errors"
                             x-intersect.half="id = 'errors'"
                        >
                            <div class="py-6 bg-white sm:py-12 min-h-[50vh]">
                                <div class="px-6 mx-auto max-w-7xl lg:px-8">
                                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                                            Errors
                                        </h2>
                                        <div class="grid grid-cols-1 gap-8 mt-10 max-w-xl text-base leading-7 text-gray-700 lg:max-w-none">
                                            <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                                <p>
                                                    The Wilford Woodruff Papers API uses conventional HTTP response codes to indicate the success or failure of an API request. The table below contains a summary of the typical response codes:
                                                </p>
                                                <table>
                                                    <thead class="font-semibold">
                                                    <tr>
                                                        <th class="px-4 text-left">Code</th>
                                                        <th class="px-4 text-left">Description</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr class="even:bg-gray-50">
                                                        <td class="px-4">200</td>
                                                        <td class="px-4">Everything is ok.</td>
                                                    </tr>
                                                    <tr class="even:bg-gray-50">
                                                        <td class="px-4">400</td>
                                                        <td class="px-4">Valid data was given but the request has failed.</td>
                                                    </tr>
                                                    <tr class="even:bg-gray-50">
                                                        <td class="px-4">401</td>
                                                        <td class="px-4">No valid API Key was given.</td>
                                                    </tr>
                                                    <tr class="even:bg-gray-50">
                                                        <td class="px-4">404</td>
                                                        <td class="px-4">The request resource could not be found.</td>
                                                    </tr>
                                                    <tr class="even:bg-gray-50">
                                                        <td class="px-4">422</td>
                                                        <td class="px-4">The payload has missing required parameters or invalid data was given.</td>
                                                    </tr>
                                                    <tr class="even:bg-gray-50">
                                                        <td class="px-4">429</td>
                                                        <td class="px-4">Too many attempts.</td>
                                                    </tr>
                                                    <tr class="even:bg-gray-50">
                                                        <td class="px-4">500</td>
                                                        <td class="px-4">Request failed due to an internal error in The Wilford Woodruff Papers.</td>
                                                    </tr>
                                                    <tr class="even:bg-gray-50">
                                                        <td class="px-4">503</td>
                                                        <td class="px-4">wilfordwoodruffpapers.org is offline for maintenance.</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="documents"
                             x-intersect.half="id = 'documents'"
                        >
                            <div class="py-6 bg-white sm:py-12 min-h-[50vh]">
                                <div class="px-6 mx-auto max-w-7xl lg:px-8">
                                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                                        <h2 class="mt-2 mb-6 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Documents</h2>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                List Documents
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/documents
                                                </code>
                                            </p>
                                            <p class="text-lg font-semibold">
                                                Parameters
                                            </p>
                                            <table>
                                                <thead class="font-semibold">
                                                <tr>
                                                    <th class="px-4 text-left">Key</th>
                                                    <th class="px-4 text-left">Description</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">types[]</td>
                                                    <td class="px-4 space-y-3">
                                                        <p>
                                                            Should be an array of document types. Valid values are: {!!  \App\Models\Type::whereNull('type_id')->get()->pluck('name')->map(function($item){ return "<span class='px-0.5 bg-gray-300'>$item</span>"; })->join(', ', ', and ') !!}
                                                        </p>
                                                        <p>
                                                            <code class="p-1 bg-gray-300">
                                                                /api/v1/documents?types[]=Discourses&types[]=Journals
                                                            </code>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">q</td>
                                                    <td class="px-4">
                                                        <p>Any text value to search within the document name.</p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                Get Document
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/documents/{uuid}
                                                </code>
                                            </p>
                                            <p class="text-lg font-semibold">
                                                Parameters
                                            </p>
                                            <table>
                                                <thead class="font-semibold">
                                                <tr>
                                                    <th class="px-4 text-left">Key</th>
                                                    <th class="px-4 text-left">Description</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">uuid</td>
                                                    <td class="px-4 space-y-3">
                                                        <p>
                                                            Should be a valid document UUID.
                                                        </p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="pages"
                             x-intersect.half="id = 'pages'"
                        >
                            <div class="py-6 bg-white sm:py-12 min-h-[50vh]">
                                <div class="px-6 mx-auto max-w-7xl lg:px-8">
                                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                                        <h2 class="mt-2 mb-6 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Pages</h2>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                List Pages
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/pages
                                                </code>
                                            </p>
                                            <p class="text-lg font-semibold">
                                                Parameters
                                            </p>
                                            <table>
                                                <thead class="font-semibold">
                                                <tr>
                                                    <th class="px-4">Key</th>
                                                    <th class="px-4">Description</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">types[]</td>
                                                    <td class="px-4 space-y-3">
                                                        <p>
                                                            Should be an array of document types. Valid values are: {!!  \App\Models\Type::whereNull('type_id')->get()->pluck('name')->map(function($item){ return "<span class='px-0.5 bg-gray-300'>$item</span>"; })->join(', ', ', and ') !!}
                                                        </p>
                                                        <p>
                                                            <code class="p-1 bg-gray-300">
                                                                /api/v1/pages?types[]=Discourses&types[]=Journals
                                                            </code>
                                                        </p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                Export Pages
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/pages/export
                                                </code>
                                            </p>
                                            <p class="">
                                                Provides a CSV export of all pages and includes columns for {!!  collect(['Document Type', 'Parent ID', 'Order', 'Parent Name', 'UUID', 'Website URL', 'Website URL', 'Original Transcript', 'Text Only Transcript', 'People', 'Places', 'Dates', 'Topics'])->map(function($item){ return "<span class='px-0.5 bg-gray-300'>$item</span>"; })->join(', ', ', and ') !!}.
                                            </p>
                                        </div>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                Get Page
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/pages/{uuid}
                                                </code>
                                            </p>
                                            <p class="text-lg font-semibold">
                                                Parameters
                                            </p>
                                            <table>
                                                <thead class="font-semibold">
                                                <tr>
                                                    <th class="px-4">Key</th>
                                                    <th class="px-4">Description</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">uuid</td>
                                                    <td class="px-4 space-y-3">
                                                        <p>
                                                            Should be a valid page UUID.
                                                        </p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="subjects"
                             x-intersect.half="id = 'subjects'"
                        >
                            <div class="py-6 bg-white sm:py-12 min-h-[50vh]">
                                <div class="px-6 mx-auto max-w-7xl lg:px-8">
                                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                                        <h2 class="mt-2 mb-6 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Subjects</h2>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                List Subjects
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/subjects
                                                </code>
                                            </p>
                                            <p class="text-lg font-semibold">
                                                Parameters
                                            </p>
                                            <table>
                                                <thead class="font-semibold">
                                                <tr>
                                                    <th class="px-4">Key</th>
                                                    <th class="px-4">Description</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">types[]</td>
                                                    <td class="px-4 space-y-3">
                                                        <p>
                                                            Should be an array of document types. Valid values are: {!!  collect(['People', 'Places', 'Index'])->map(function($item){ return "<span class='px-0.5 bg-gray-300'>$item</span>"; })->join(', ', ', and ') !!}
                                                        </p>
                                                        <p>
                                                            <code class="p-1 bg-gray-300">
                                                                /api/v1/subjects?types[]=People&types[]=Places
                                                            </code>
                                                        </p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                Get Subjects
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/subjects/{id}
                                                </code>
                                            </p>
                                            <p class="text-lg font-semibold">
                                                Parameters
                                            </p>
                                            <table>
                                                <thead class="font-semibold">
                                                <tr>
                                                    <th class="px-4">Key</th>
                                                    <th class="px-4">Description</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">id</td>
                                                    <td class="px-4 space-y-3">
                                                        <p>
                                                            Should be a valid subject id.
                                                        </p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
