<div class="inline">
    <div class="flex items-center">
        <a class="text-secondary popup"
           href="{{ route('subjects.show', ['subject' => $subject])  }}"
        >
            {{ $subject->name }} ({{ $subject->tagged_count }})
        </a>
        <div>
            @auth()
                <div>
                    @if(auth()->user()->hasAnyRole(['Super Admin']))
                        <button wire:click.stop="$toggle('subject.hide_on_index')"
                                class="ml-2"
                        >
                            @if($subject->hide_on_index)
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-red-800 w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-green-800 w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            @endif
                        </button>
                        <button wire:click="$toggle('showModal');"
                                class="ml-2"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                            </svg>
                        </button>
                        <div>
                            <x-modal.dialog wire:model="showModal">
                                <x-slot name="title">Editing: <span class="font-semibold">{{ $subject->name }}</span></x-slot>

                                <x-slot name="content">
                                    <div class="py-4">
                                        <label for="query" class="sr-only text-sm font-medium text-gray-700">Name</label>
                                        <div class="relative mt-1 rounded-md shadow-sm">
                                            <input wire:model.debounce="subject.name"
                                                   type="text"
                                                   name="name"
                                                   id="name"
                                                   class="block w-full rounded-md border-gray-300 pl-4 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                   placeholder="Topic name"
                                            >
                                        </div>
                                    </div>
                                    <div class="py-4">
                                        <label for="query" class="sr-only text-sm font-medium text-gray-700">Search for parent</label>
                                        <div class="relative mt-1 rounded-md shadow-sm">
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                                </svg>
                                            </div>
                                            <input wire:model.debounce="query"
                                                   type="text"
                                                   name="query"
                                                   id="query"
                                                   class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                   placeholder="Search for parent"
                                                   autofocus
                                            >
                                        </div>
                                    </div>
                                    <div>
                                        @if($parents->count() > 0)
                                            <div>
                                                <div class="mt-6 flow-root">
                                                    <dl role="list" class="-my-5 divide-y divide-gray-200">
                                                        @foreach($parents as $parent)
                                                            <dt class="py-1">
                                                                <div class="inline">
                                                                    <div class="flex items-center space-x-4">
                                                                        <div class="min-w-0 flex-1">
                                                                            <p class="truncate text-sm font-medium text-gray-900">
                                                                                {{ $parent->name }}
                                                                            </p>
                                                                        </div>
                                                                        <div>
                                                                            <button wire:click="$set('subject.subject_id', {{ $parent->id }})"
                                                                                    wire:loading.attr="disabled"
                                                                                    class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">
                                                                                Save
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </dt>
                                                        @endforeach
                                                    </dl>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                </x-slot>

                                <x-slot name="footer">
                                    @if(! empty($subject->subject_id))
                                    <x-button.primary wire:click="$set('subject.subject_id', null)"
                                                        wire:loading.attr="disabled">Remove Parent</x-button.primary>
                                    @else
                                        <div></div>
                                    @endif
                                    <x-button.secondary wire:click.prevent="$set('showModal', false)">Cancel</x-button.secondary>
                                </x-slot>
                            </x-modal.dialog>
                        </div>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</div>
