<div>
    <div x-data="{
            speaker: 'No'
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
                        <div class="sm:col-span-2">
                            <label for="salutation" class="block text-sm font-medium text-gray-700">Title</label>
                            <div class="mt-1">
                                <select wire:model="salutation"
                                        id="salutation"
                                        name="salutation"
                                        autocomplete="salutation"
                                        required
                                        class="max-w-lg block focus:ring-secondary focus:border-secondary w-full shadow-sm sm:max-w-xs sm:text-sm @error('salutation') border-red-500 @else border-gray-300 @enderror">
                                    <option selected>-- Please select --</option>
                                    <option value="Ms.">Ms.</option>
                                    <option value="Mr.">Mr.</option>
                                </select>
                                @error('salutation') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                            </div>
                        </div>
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
                        <div>
                            <label for="org-name" class="block text-sm font-medium text-gray-700">Organization Name</label>
                            <div class="mt-1">
                                <input wire:model="orgName"
                                       type="text"
                                       id="org-name"
                                       autocomplete="org-name"
                                       value=""
                                       required
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('orgName') border-red-500 @else border-gray-300 @enderror">
                            </div>
                            @error('orgName') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="org-position" class="block text-sm font-medium text-gray-700">Your Position</label>
                            <div class="mt-1">
                                <input wire:model="orgPosition"
                                       type="text"
                                       id="org-position"
                                       autocomplete="org-position"
                                       value=""
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('orgPosition') border-red-500 @else border-gray-300 @enderror">
                            </div>
                            @error('orgPosition') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                        </div>
                        <hr class="pt-4 sm:col-span-2"/>
                        <div class="sm:col-span-2">
                            <label for="speaker" class="block text-sm font-medium text-gray-700">Would you like to book a speaker?</label>
                            <div class="mt-1">
                                <select wire:model="speaker"
                                        id="speaker"
                                        name="speaker"
                                        autocomplete="document-speaker"
                                        required
                                        class="max-w-lg block focus:ring-secondary focus:border-secondary w-full shadow-sm sm:max-w-xs sm:text-sm @error('speaker') border-red-500 @else border-gray-300 @enderror">
                                    <option selected>-- Please select --</option>
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>

                                @error('speaker') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                            </div>
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
                        <div>
                            <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
                            <div class="mt-1">
                                <input wire:model="deadline"
                                       id="deadline"
                                       type="date"
                                       autocomplete="deadline"
                                       value=""
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('deadline') border-red-500 @else border-gray-300 @enderror">
                            </div>
                            @error('deadline') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
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
