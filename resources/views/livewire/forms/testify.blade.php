<div>

    <div class="bg-white py-4 px-4 overflow-hidden">
        <div class="absolute right-4 top-2 z-20">
            <button wire:click="$emit('closeModal')"
                    type="button"
                    class="close text-2xl font-semibold"
                    aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="relative mx-auto">
            <div>
                <h2 class="text-2xl border-b-2 pb-2">
                    Share Your Testimony
                </h2>
            </div>
            <div class="mt-12">
                @if($success === false)
                    <form wire:submit.prevent="save" class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                        <input wire:model.defer="role"
                               type="hidden"
                               name="role"
                               id="role"
                               value="">
                        <div class="sm:col-span-2">
                            <div>
                                <label for="first-name" class="block text-sm font-medium text-gray-700">Name</label>
                                <div class="mt-1">
                                    <input wire:model.defer="firstName"
                                           type="text"
                                           id="first-name"
                                           autocomplete="given-name"
                                           value=""
                                           required
                                           class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('firstName') border-red-500 @else border-gray-300 @enderror">
                                </div>
                                @error('firstName') <div class="mt-1 text-red-500 text-sm">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <div class="mt-1">
                                <input wire:model.defer="email"
                                       id="email"
                                       type="email"
                                       autocomplete="email"
                                       value=""
                                       required
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('email') border-red-500 @else border-gray-300 @enderror">
                            </div>
                            @error('email') <div class="mt-1 text-red-500 text-sm">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <div class="mt-1">
                                <input wire:model.defer="phone"
                                       type="text"
                                       id="phone"
                                       autocomplete="phone"
                                       value=""
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('phone') border-red-500 @else border-gray-300 @enderror">
                            </div>
                            @error('phone') <div class="mt-1 text-red-500 text-sm">{{ $message }}</div> @enderror
                        </div>
                        <div class="hidden">
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <div class="mt-1">
                                <input wire:model.defer="location"
                                       type="text"
                                       id="location"
                                       autocomplete="location"
                                       value=""
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('location') border-red-500 @else border-gray-300 @enderror">
                            </div>
                            @error('location') <div class="mt-1 text-red-500 text-sm">{{ $message }}</div> @enderror
                        </div>
                        <div class="hidden">
                            <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                            <div class="mt-1">
                                <input wire:model.defer="age"
                                       id="age"
                                       type="text"
                                       autocomplete="age"
                                       value=""
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('age') border-red-500 @else border-gray-300 @enderror">
                            </div>
                            @error('age') <div class="mt-1 text-red-500 text-sm">{{ $message }}</div> @enderror
                        </div>
                        <div class="sm:col-span-2 hidden">
                            <label for="source" class="block text-sm font-medium text-gray-700">Source</label>
                            <div class="mt-1">
                                <input wire:model.defer="source"
                                       id="source"
                                       type="text"
                                       autocomplete="source"
                                       value=""
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('source') border-red-500 @else border-gray-300 @enderror">
                            </div>
                            @error('source') <div class="mt-1 text-red-500 text-sm">{{ $message }}</div> @enderror
                        </div>
                        <div class="sm:col-span-2 hidden">
                            <label for="topic" class="block text-sm font-medium text-gray-700">Topic</label>
                            <div class="mt-1">
                                <input wire:model.defer="topic"
                                       id="topic"
                                       type="text"
                                       autocomplete="topic"
                                       value=""
                                       class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary @error('topic') border-red-500 @else border-gray-300 @enderror">
                            </div>
                            @error('topic') <div class="mt-1 text-red-500 text-sm">{{ $message }}</div> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="message" class="block text-sm font-medium text-gray-700">Your Testimony</label>
                            <div class="mt-1">
                                <textarea wire:model.defer="message"
                                          id="message"
                                          rows="4"
                                          required
                                          class="py-3 px-4 block w-full shadow-sm focus:ring-secondary focus:border-secondary border  @error('message') border-red-500 @else border-gray-300 @enderror"></textarea>
                            </div>
                            @error('message') <div class="mt-1 text-red-500 text-sm">{{ $message }}</div> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent shadow-sm text-base uppercase font-medium text-white bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">Submit</button>
                        </div>
                    </form>
                @elseif($success === true)
                    <div>
                        <p class="pb-24 text-xl font-medium">
                            Thank you for sharing your testimony!
                        </p>
                        <div>
                            <button onclick="Livewire.emit('closeModal', 'forms.testify')"
                                    type="dismiss"
                                    class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent shadow-sm text-base uppercase font-medium text-white bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">Close</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
