<div>
    <div x-data="{

        }"
         class="overflow-hidden py-4 px-4 mx-auto max-w-7xl bg-white">
        <div class="">
            <img src=""
                 class=""
                 alt=""
            />
        </div>
        <div class="relative mx-auto">
            <div class="content">
                <h2>Building Latter-day Faith - 2023 Conference Art Contest Submission Form</h2>
            </div>
            <div class="mt-12">
                @if($success === false)
                    <form wire:submit.prevent="save" class="grid grid-cols-1 gap-y-6 sm:gap-x-8">
                        <input wire:model.defer="role"
                               type="hidden"
                               name="role"
                               id="role"
                               value="">
                        <div class="m2-4">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Contact Info</h3>
                            <div class="my-2 text-xs font-medium">Fields with <span class="text-base text-red-700">*</span> are required.</div>
                        </div>
                        <div>
                            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                                <div>
                                    <label for="first-name" class="block text-sm font-medium text-gray-700">First name <span class="text-base text-red-700">*</span></label>
                                    <div class="mt-1">
                                        <input wire:model.defer="firstName"
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
                                    <label for="last-name" class="block text-sm font-medium text-gray-700">Last name <span class="text-base text-red-700">*</span></label>
                                    <div class="mt-1">
                                        <input wire:model.defer="lastName"
                                               type="text"
                                               id="last-name"
                                               autocomplete="family-name"
                                               value=""
                                               required
                                               class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('lastName') border-red-500 @else border-gray-300 @enderror">
                                    </div>
                                    @error('lastName') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-base text-red-700">*</span></label>
                                    <div class="mt-1">
                                        <input wire:model.defer="email"
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
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone <span class="text-base text-red-700">*</span></label>
                                    <div class="mt-1">
                                        <input wire:model.defer="phone"
                                               id="phone"
                                               type="text"
                                               autocomplete="phone"
                                               value=""
                                               required
                                               class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('phone') border-red-500 @else border-gray-300 @enderror">
                                    </div>
                                    @error('phone') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-4 space-y-4">
                                <div class="flex relative items-start">
                                    <div class="flex items-center h-5">
                                        <input wire:model.defer="subscribeToNewsletter"
                                               id="subscribe_to_newsletter"
                                               name="subscribe_to_newsletter"
                                               type="checkbox"
                                               class="w-4 h-4 border-gray-300 text-secondary focus:ring-secondary"
                                               value="1"
                                        >
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="subscribe_to_newsletter" class="font-medium text-gray-700">Receive monthly updates from the Wilford Woodruff Papers Foundation</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="grid grid-cols-1 gap-y-6">
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700">Address <span class="text-base text-red-700">*</span></label>
                                    <div class="mt-1">
                                        <input wire:model.defer="address"
                                               id="address"
                                               type="text"
                                               autocomplete="address"
                                               value=""
                                               required
                                               class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('address') border-red-500 @else border-gray-300 @enderror">
                                    </div>
                                    @error('address') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="pt-4"/>

                        <div>
                            <div class="mb-4 space-y-4">
                                <p class="text-sm">
                                    ORIGINAL WORK <span class="text-base text-red-700">*</span>
                                </p>
                                <p class="text-sm">
                                    All entries must be original works, based on the entrant’s own concept or premise. Entries that infringe on copyright or have been plagiarized entirely or contain plagiarized elements will be disqualified.
                                </p>
                                <div class="flex relative items-start">
                                    <div class="flex items-center h-5">
                                        <input wire:model.defer="original"
                                               id="original"
                                               name="original"
                                               type="checkbox"
                                               required
                                               class="w-4 h-4 border-gray-300 text-secondary focus:ring-secondary"
                                               value="1"
                                        >
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="original" class="font-medium text-gray-700">I understand</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-4 space-y-4">
                                <p class="text-sm">
                                    APPROPRIATE CONTENT <span class="text-base text-red-700">*</span>
                                </p>
                                <p class="text-sm">
                                    The Wilford Woodruff Papers Foundation seeks to be a positive influence for young artists and their families. Consequently, only submissions deemed “family-friendly” in nature will be accepted. Entries that contain violent, bigoted, or sexually-explicit elements will not be considered for entry in the contest or for display at the venue. The Foundation reserves the right to determine whether any entry meets these standards.
                                </p>
                                <div class="flex relative items-start">
                                    <div class="flex items-center h-5">
                                        <input wire:model.defer="appropriate"
                                               id="appropriate"
                                               name="appropriate"
                                               type="checkbox"
                                               required
                                               class="w-4 h-4 border-gray-300 text-secondary focus:ring-secondary"
                                               value="1"
                                        >
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="appropriate" class="font-medium text-gray-700">I understand</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <button type="submit"
                                    class="inline-flex justify-center items-center py-3 px-6 w-full text-base font-medium text-white uppercase border border-transparent shadow-sm focus:ring-2 focus:ring-offset-2 focus:outline-none bg-secondary focus:ring-secondary">Submit</button>
                        </div>
                    </form>
                @elseif($success === true)
                    <div>
                        <p class="p-4 text-xl font-medium">
                            Thank you for updating your contact information!
                        </p>
                        <p class="p-4 text-lg">
                            Judging will take place after the deadline of January 6th, 2023. If there are any issues with your submission we will contact you as soon as possible.
                        </p>
                        <p class="p-4 text-lg">
                            We look forward to seeing you at the conference in March!
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
