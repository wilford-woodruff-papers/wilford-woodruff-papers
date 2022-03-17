<div>
    <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
        <form wire:submit.prevent="save"
              action="#"
              method="POST">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Save Quote</h3>
                        <p class="mt-1 text-sm text-gray-500"></p>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3">
                            <label for="selection" class="block text-sm font-medium text-gray-700"> Selection </label>
                            <div class="mt-1">
                                <div class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 p-2 block w-full sm:text-sm border border-gray-300"
                                >
                                    {{ $selection }}
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500"></p>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 flex justify-between sm:px-6">
                    <span wire:click="$emit('closeModal')"
                          class="cursor-pointer bg-gray-200 border border-transparent shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-black hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">Cancel</span>
                    <button type="submit"
                            class="bg-secondary border border-transparent shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
