<!-- This example requires Tailwind CSS v2.0+ -->
<div class="">
    {{--<div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Users</h1>
            <p class="mt-2 text-sm text-gray-700">A list of all the users in your account including their name, title, email and role.</p>
        </div>
        <div class="mt-4 sm:flex-none sm:mt-0 sm:ml-16">
            <button type="button" class="inline-flex justify-center items-center py-2 px-4 text-sm font-medium text-white bg-indigo-600 rounded-md border border-transparent shadow-sm sm:w-auto hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none">Add user</button>
        </div>
    </div>--}}
    <div class="flex flex-col">
        <div class="overflow-x-auto -my-2 -mx-4 sm:-mx-6 lg:-mx-8">
            <div class="inline-block py-2 min-w-full align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden ring-1 ring-black ring-opacity-5 shadow md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-6">Activity</th>
                            <th scope="col" class="py-3.5 px-3 text-sm font-semibold text-left text-gray-900">Assigned to</th>
                            <th scope="col" class="py-3.5 px-3 text-sm font-semibold text-left text-gray-900">Completed by</th>
                            <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-6">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($model->actions->sortBy('created_at') as $action)
                                <livewire:admin.action :action="$action" />
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
