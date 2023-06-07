<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Documentation') }}
        </h2>
    </x-slot>

    <div x-data="{
        id: 'introduction',
        makeAPICall: function (url, id) {
        const options = {
                headers: {
                    'Authorization': 'Bearer {{ auth()->user()->tokens()->first()->plainTextToken }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            };
            axios.get(url, {}, options)
                .then(response => {
                    let code = document.getElementById(id);
                    code.innerHTML = JSON.stringify(response.data, null, 2);
                    hljs.highlightAll(code);
                });
        }
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
                                    <li>
                                        <a href="#people"
                                           x-on:click="id = 'people'"
                                           :class="id =='people' ? 'text-secondary' : 'text-gray-700'"
                                           class="flex gap-x-3 p-2 pl-3 text-sm font-semibold leading-6 rounded-md hover:bg-gray-50 group hover:text-secondary">People</a>
                                    </li>
                                    <li>
                                        <a href="#places"
                                           x-on:click="id = 'places'"
                                           :class="id =='places' ? 'text-secondary' : 'text-gray-700'"
                                           class="flex gap-x-3 p-2 pl-3 text-sm font-semibold leading-6 rounded-md hover:bg-gray-50 group hover:text-secondary">Places</a>
                                    </li>
                                    <li>
                                        <a href="#topics"
                                           x-on:click="id = 'topics'"
                                           :class="id =='topics' ? 'text-secondary' : 'text-gray-700'"
                                           class="flex gap-x-3 p-2 pl-3 text-sm font-semibold leading-6 rounded-md hover:bg-gray-50 group hover:text-secondary">Topics</a>
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
                                                    In addition to the Authorization header, make sure you have the following content type headers are set on every request:
                                                </p>
                                                <p class="p-1 bg-gray-300">
                                                    <code>
                                                        Accept: application/json<br />
                                                        Content-Type: application/json
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
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">per_page</td>
                                                    <td class="px-4">
                                                        <p>Number of documents to return each request. The default is 100 and the maximum is 500.</p>
                                                    </td>
                                                </tr>
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">page</td>
                                                    <td class="px-4">
                                                        <p>The page of results to return. (not required for the first page)</p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <x-example-response :id="10"
                                                                :model="new App\Models\Item"
                                                                :url="route('docs.documents.index', ['per_page' => 1])"
                                            />
                                        </div>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                Export Documents
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/documents/export
                                                </code>
                                            </p>
                                            <p class="py-4">
                                                <a href="{{ route('api.documents.export') }}"
                                                   class="py-2 px-4 text-white bg-secondary hover:bg-secondary-600"
                                                   download
                                                >
                                                    Download Export
                                                </a>
                                            </p>
                                            <p class="">
                                                Provides a CSV export of all documents and includes columns for {!!  collect(['Internal ID', 'Document Type', 'UUID', 'Name', 'Website URL', 'Short URL', 'Image URL',])->map(function($item){ return "<span class='px-0.5 bg-gray-300'>$item</span>"; })->join(', ', ', and ') !!}.
                                            </p>
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
                                            <x-example-response :id="11"
                                                                :model="new App\Models\Item"
                                                                :url="route('docs.documents.show', ['item' => \App\Models\Item::where('enabled', true)->where('type_id', 4)->first()])"
                                            />
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
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">per_page</td>
                                                    <td class="px-4">
                                                        <p>Number of pages to return each request. The default is 100 and the maximum is 500.</p>
                                                    </td>
                                                </tr>
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">page</td>
                                                    <td class="px-4">
                                                        <p>The page of results to return. (not required for the first page)</p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <x-example-response :id="20"
                                                                :model="new App\Models\Page"
                                                                :url="route('docs.pages.index', ['per_page' => 1])"
                                            />
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
                                            <p class="py-4">
                                                <a href="{{ route('api.pages.export') }}"
                                                   class="py-2 px-4 text-white bg-secondary hover:bg-secondary-600"
                                                   download
                                                >
                                                    Download Export
                                                </a>
                                            </p>
                                            <p class="">
                                                Provides a CSV export of all pages and includes columns for {!!  collect(['Document Type', 'Parent ID', 'Order', 'Parent Name', 'UUID', 'Website URL', 'Image URL', 'Original Transcript', 'Text Only Transcript', 'People', 'Places', 'Dates', 'Topics'])->map(function($item){ return "<span class='px-0.5 bg-gray-300'>$item</span>"; })->join(', ', ', and ') !!}.
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
                                            <x-example-response :id="21"
                                                                :model="new App\Models\Page"
                                                                :url="route('docs.pages.show', ['page' => \App\Models\Item::where('enabled', true)->where('type_id', 4)->first()->firstPage])"
                                            />
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
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">per_page</td>
                                                    <td class="px-4">
                                                        <p>Number of subjects to return each request. The default is 100 and the maximum is 500.</p>
                                                    </td>
                                                </tr>
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">page</td>
                                                    <td class="px-4">
                                                        <p>The page of results to return. (not required for the first page)</p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <x-example-response :id="30"
                                                                :model="new App\Models\Subject"
                                                                :url="route('docs.subjects.index', ['per_page' => 1])"
                                            />
                                        </div>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                Get Subject
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
                                            <x-example-response :id="31"
                                                                :model="new App\Models\Subject"
                                                                :url="route('docs.subjects.show', ['id' => App\Models\Subject::query()->inRandomOrder()->first()->id])"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="people"
                             x-intersect.half="id = 'people'"
                        >
                            <div class="py-6 bg-white sm:py-12 min-h-[50vh]">
                                <div class="px-6 mx-auto max-w-7xl lg:px-8">
                                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                                        <h2 class="mt-2 mb-6 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">People</h2>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                List People
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/people
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
                                                    <td class="px-4">categories[]</td>
                                                    <td class="px-4 space-y-3">
                                                        <p>
                                                            Should be an array of people categories. Valid values are: {!!  collect(['Apostles', '1840 British Converts', 'Family', 'Scriptural Figures', '1835 Southern Converts', 'Historical Figures', 'Bishops in Letters'])->map(function($item){ return "<span class='px-0.5 bg-gray-300'>$item</span>"; })->join(', ', ', and ') !!}
                                                        </p>
                                                        <p>
                                                            <code class="p-1 bg-gray-300">
                                                                /api/v1/people?categories[]=Family&categories[]=Historical%20Figures
                                                            </code>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">per_page</td>
                                                    <td class="px-4">
                                                        <p>Number of people to return each request. The default is 100 and the maximum is 500.</p>
                                                    </td>
                                                </tr>
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">page</td>
                                                    <td class="px-4">
                                                        <p>The page of results to return. (not required for the first page)</p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <x-example-response :id="40"
                                                                :model="new App\Models\Subject"
                                                                :url="route('docs.people.index', ['per_page' => 1])"
                                            />
                                        </div>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                Export People
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/people/export
                                                </code>
                                            </p>
                                            <p class="py-4">
                                                <a href="{{ route('api.people.export') }}"
                                                   class="py-2 px-4 text-white bg-secondary hover:bg-secondary-600"
                                                   download
                                                >
                                                    Download Export
                                                </a>
                                            </p>
                                            <p class="">
                                                Provides a CSV export of all people and includes columns for {!!  collect([
                                                    'Internal ID',
                                                    'Family Search ID',
                                                    'Name',
                                                    'First Name',
                                                    'Middle Name',
                                                    'Last Name',
                                                    'Suffix',
                                                    'Biography',
                                                    'Footnotes',
                                                    'Reference',
                                                    'Relationship',
                                                    'Birth Date',
                                                    'Baptism Date',
                                                    'Death Date',
                                                    'Life Years',
                                                    'Slug',
                                                    'Categories',
                                                    'Website URL',
                                                ])->map(function($item){ return "<span class='px-0.5 bg-gray-300'>$item</span>"; })->join(', ', ', and ') !!}.
                                            </p>
                                        </div>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                Get Person
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/people/{id}
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
                                                            Should be a valid person id.
                                                        </p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <x-example-response :id="41"
                                                                :model="new App\Models\Subject"
                                                                :url="route('docs.people.show', ['id' => App\Models\Subject::query()->whereRelation('category', function ($query) {
            $query->where('name', 'People');
        })->inRandomOrder()->first()->id])"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div id="places"
                             x-intersect.half="id = 'places'"
                        >
                            <div class="py-6 bg-white sm:py-12 min-h-[50vh]">
                                <div class="px-6 mx-auto max-w-7xl lg:px-8">
                                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                                        <h2 class="mt-2 mb-6 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Places</h2>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                List Places
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/places
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
                                                    <td class="px-4">per_page</td>
                                                    <td class="px-4">
                                                        <p>Number of places to return each request. The default is 100 and the maximum is 500.</p>
                                                    </td>
                                                </tr>
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">page</td>
                                                    <td class="px-4">
                                                        <p>The page of results to return. (not required for the first page)</p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <x-example-response :id="50"
                                                                :model="new App\Models\Subject"
                                                                :url="route('docs.places.index', ['per_page' => 1])"
                                            />
                                        </div>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                Export Places
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/places/export
                                                </code>
                                            </p>
                                            <p class="py-4">
                                                <a href="{{ route('api.places.export') }}"
                                                   class="py-2 px-4 text-white bg-secondary hover:bg-secondary-600"
                                                   download
                                                >
                                                    Download Export
                                                </a>
                                            </p>
                                            <p class="">
                                                Provides a CSV export of all places and includes columns for {!!  collect([
                                                    'Internal ID',
                                                    'Name',
                                                    'Address',
                                                    'Country',
                                                    'State or Province',
                                                    'County',
                                                    'City',
                                                    'Specific Place',
                                                    'Modern Location',
                                                    'Visited',
                                                    'Mentioned Only',
                                                    'Latitude',
                                                    'Longitude',
                                                    'Website URL',
                                                ])->map(function($item){ return "<span class='px-0.5 bg-gray-300'>$item</span>"; })->join(', ', ', and ') !!}.
                                            </p>
                                        </div>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                Get Place
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/places/{id}
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
                                                            Should be a valid place id.
                                                        </p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <x-example-response :id="51"
                                                                :model="new App\Models\Subject"
                                                                :url="route('docs.places.show', ['id' => App\Models\Subject::query()->whereRelation('category', function ($query) {
            $query->where('name', 'Places');
        })->inRandomOrder()->first()->id])"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="topics"
                             x-intersect.half="id = 'topics'"
                        >
                            <div class="py-6 bg-white sm:py-12 min-h-[50vh]">
                                <div class="px-6 mx-auto max-w-7xl lg:px-8">
                                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                                        <h2 class="mt-2 mb-6 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Places</h2>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                List Topics
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/topics
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
                                                    <td class="px-4">per_page</td>
                                                    <td class="px-4">
                                                        <p>Number of topics to return each request. The default is 100 and the maximum is 500.</p>
                                                    </td>
                                                </tr>
                                                <tr class="even:bg-gray-50">
                                                    <td class="px-4">page</td>
                                                    <td class="px-4">
                                                        <p>The page of results to return. (not required for the first page)</p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <x-example-response :id="60"
                                                                :model="new App\Models\Subject"
                                                                :url="route('docs.topics.index', ['per_page' => 1])"
                                            />
                                        </div>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                Export Topics
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/topics/export
                                                </code>
                                            </p>
                                            <p class="py-4">
                                                <a href="{{ \Illuminate\Support\Facades\Storage::disk('exports')->temporaryUrl('topics-export.csv', now()->addMinutes(30)) }}"
                                                   class="py-2 px-4 text-white bg-secondary hover:bg-secondary-600"
                                                   download
                                                >
                                                    Download Export
                                                </a>
                                            </p>
                                            <p class="">
                                                Provides a CSV export of all places and includes columns for {!!  collect([
                                                    'Internal ID',
                                                    'Slug',
                                                    'Name',
                                                    'Website URL',
                                                ])->map(function($item){ return "<span class='px-0.5 bg-gray-300'>$item</span>"; })->join(', ', ', and ') !!}.
                                            </p>
                                        </div>
                                        <div class="p-4 space-y-4 bg-gray-100 border border-gray-200 border-top border-bottom">
                                            <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-xl">
                                                Get Topic
                                            </h3>
                                            <p class="text-lg font-semibold">
                                                HTTP Request
                                            </p>
                                            <p>
                                                <code class="p-1 bg-gray-300">
                                                    GET /api/v1/topics/{id}
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
                                                            Should be a valid topic id.
                                                        </p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <x-example-response :id="61"
                                                                :model="new App\Models\Subject"
                                                                :url="route('docs.topics.show', ['id' => App\Models\Subject::query()->whereRelation('category', function ($query) {
            $query->where('name', 'Index');
        })->inRandomOrder()->first()->id])"
                                            />
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
    @push('styles')
        <link rel="stylesheet"
              href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/atom-one-dark.min.css">
        <stlye>

        </stlye>
    @endpush
    @push('scripts')
        <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
        {{--<script>hljs.highlightAll();</script>--}}
        <script>
            /*var myData = {"address":{"House_Number":505,"Street_Direction":"","Street_Name":"Claremont","Street_Type":"Street","Apt":"15L","Burough":"Brooklyn","State":"NY","Zip":"10451","Phone":"718-777-7777"},"casehead":0,"adults":[{"Last_Name":"Foo","First_Name":"A","Sex":"M","Date_Of_Birth":"01011980"}],"children":[]};

            var textedJson = JSON.stringify(myData, undefined, 4);
            $('#myTextarea').text(textedJson);*/
        </script>
    @endpush
</x-app-layout>
