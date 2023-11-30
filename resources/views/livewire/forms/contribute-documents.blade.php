<div>
    <div x-data="{
            attach: 'No'
        }"
         class="overflow-hidden py-4 px-4 bg-white">
        <div class="relative mx-auto">
            <div class="mt-12">
                @if($success === false)
                    <form wire:submit="save" class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                        <input wire:model="role"
                               type="hidden"
                               name="role"
                               id="role"
                               value="">
                        <div>
                            <label for="first-name" class="block text-sm font-medium text-gray-700">First name</label>
                            <div class="mt-1">
                                <input wire:model="firstName"
                                       type="text"
                                       id="first-name"
                                       autocomplete="given-name"
                                       value=""
                                       required
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('firstName') border-red-500 @else border-gray-300 @enderror">
                            </div>
                            @error('firstName') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="last-name" class="block text-sm font-medium text-gray-700">Last name</label>
                            <div class="mt-1">
                                <input wire:model="lastName"
                                       type="text"
                                       id="last-name"
                                       autocomplete="family-name"
                                       value=""
                                       required
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('lastName') border-red-500 @else border-gray-300 @enderror">
                            </div>
                            @error('lastName') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <div class="mt-1">
                                <input wire:model="email"
                                       id="email"
                                       type="email"
                                       autocomplete="email"
                                       value=""
                                       required
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('email') border-red-500 @else border-gray-300 @enderror">
                            </div>
                            @error('email') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <div class="mt-1">
                                <input wire:model="phone"
                                       id="phone"
                                       type="text"
                                       autocomplete="phone"
                                       value=""
                                       required
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('phone') border-red-500 @else border-gray-300 @enderror">
                            </div>
                            @error('phone') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                        </div>
                        <hr class="pt-4 sm:col-span-2"/>
                        <div class="sm:col-span-2">
                            <label for="type" class="block text-sm font-medium text-gray-700">Document Type</label>
                            <div class="mt-1">
                                <select wire:model="type"
                                        id="type"
                                        name="type"
                                        autocomplete="document-type"
                                        class="max-w-lg block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:max-w-xs sm:text-sm  @error('email') border-red-500 @else border-gray-300 @enderror rounded-md">
                                    <option value="Biographies">Biographies</option>
                                    <option value="Discourses">Discourses</option>
                                    <option value="Images">Images</option>
                                    <option value="Journal Entries">Journal Entries</option>
                                    <option value="Legal Documents">Legal Documents</option>
                                    <option value="Letters">Letters</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            @error('type') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="attach" class="block text-sm font-medium text-gray-700">Need to attach a file?</label>
                            <div class="mt-1">
                                <select x-model="attach"
                                        id="attach"
                                        name="attach"
                                        autocomplete="document-attach"
                                        class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm sm:max-w-xs sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div x-show="attach === 'Yes'"
                             x-cloak
                             class="sm:col-span-2">
                            <label for="photo" class="block text-sm font-medium text-gray-700">
                                File
                            </label>
                            <div class="flex items-center mt-1">
                                <input wire:model.live="file"
                                       type="file"
                                       class="py-2 px-3 ml-5 text-sm font-medium leading-4 text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none" />
                            </div>
                            @error('file') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                            <div class="mt-1">
                                <textarea wire:model="message"
                                          id="message"
                                          rows="4"
                                          required
                                          class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary border  @error('message') border-red-500 @else border-gray-300 @enderror"></textarea>
                            </div>
                            @error('message') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <button type="submit"
                                    class="inline-flex justify-center items-center py-3 px-6 w-full text-base font-medium text-white uppercase border border-transparent shadow-sm focus:ring-2 focus:ring-offset-2 focus:outline-none bg-secondary focus:ring-secondary">Submit</button>
                        </div>
                    </form>
                @elseif($success === true)
                    <div>
                        <p class="p-4 text-xl font-medium">
                            Thank you for getting in touch!
                        </p>
                        <p class="p-4 text-lg">
                            We will get back with you shortly.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
