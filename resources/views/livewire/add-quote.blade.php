<div>
    <div x-data="{
            multiple: true,
            selectedTopics: @entangle('selectedTopics').defer,
            selectedAdditionalTopics: @entangle('selectedAdditionalTopics').defer,
            value: [],
            additional_value: [],
            options: [
                @foreach($topics as $key => $topic) {'value': {{ $key }}, 'label': '{{ addslashes($topic) }}'}, @endforeach
            ],
            additional_options: [
                @foreach($additional_topics as $additional_topic) {'value': '{{ addslashes($additional_topic->name) }}', 'label': '{{ addslashes($additional_topic->name) }}'}, @endforeach
            ],
            init() {
                this.$nextTick(() => {
                    let choices = new Choices(this.$refs.select);
                    let additional_choices = new Choices(this.$refs.additional_select, {
                        addItems: true,
                    });

                    let refreshChoices = () => {
                        let selection = this.multiple ? this.value : [this.value]

                        choices.clearStore()
                        choices.setChoices(this.options.map(({ value, label }) => ({
                            value,
                            label,
                            selected: selection.includes(value),
                        })))
                    }

                    let refreshAdditionalChoices = () => {
                        let additional_selection = this.multiple ? this.additional_value : [this.additional_value]

                        additional_choices.clearStore();
                        additional_choices.clearInput();
                        additional_choices.setChoices(this.additional_options.map(({ value, label }) => ({
                            value,
                            label,
                            selected: additional_selection.includes(value),
                        })))
                    }

                    refreshChoices();
                    refreshAdditionalChoices();

                    this.$refs.select.addEventListener('change', () => {
                        this.value = choices.getValue(true)
                        this.selectedTopics = choices.getValue(true)
                    })

                    this.$refs.additional_select.addEventListener('change', () => {
                        this.value = additional_choices.getValue(true)
                        this.selectedAdditionalTopics = additional_choices.getValue(true)
                    })

                    this.$watch('value', () => refreshChoices())
                    this.$watch('options', () => refreshChoices())

                    this.$watch('additional_value', () => refreshChoices())
                    this.$watch('additional_options', () => refreshAdditionalChoices())
                })
            },
            close: function(){
                Livewire.emit('closeModal');
                rangy.getSelection().removeAllRanges();
                $('.highlight').removeClass('highlight');
                $dispatch('close-options');
            }
        }"
         class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0">
        <form wire:submit.prevent="save"
              action="#"
              method="POST">
            <div class="shadow sm:overflow-hidden sm:rounded-md">
                <div class="py-6 px-4 space-y-6 bg-white sm:p-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Save Quote</h3>
                        <p class="mt-1 text-sm text-gray-500"></p>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3">
                            <label for="selection" class="block text-sm font-medium text-gray-700"> Selection </label>
                            <div class="mt-1">
                                <div class="block p-2 mt-1 w-full border border-gray-300 shadow-sm sm:text-sm focus:ring-secondary focus:border-secondary"
                                >
                                    {{ $selection }}
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500"></p>
                        </div>
                    </div>

                    <div>
                        <label for="author" class="block text-sm font-medium text-gray-700">Author</label>
                        <div class="mt-1">
                            <input wire:model.defer="author"
                                   type="text"
                                   name="author"
                                   id="author"
                                   class="block w-full border-gray-300 shadow-sm sm:text-sm focus:border-secondary focus:ring-secondary"
                                   placeholder="Add Author's name if not Wilford Woodruff">
                        </div>
                    </div>


                    <div class="flex relative items-start">
                        <div class="flex items-center h-5">
                            <input wire:model.defer="continuedOnNextPage"
                                   id="continuedOnNextPage"
                                   name="continuedOnNextPage"
                                   type="checkbox"
                                   class="w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary"
                            >
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="continuedOnNextPage"
                                   class="font-medium text-gray-700"
                            >
                                Continued on next page
                            </label>
                        </div>
                    </div>

                    <div class="flex relative items-start">
                        <div class="flex items-center h-5">
                            <input wire:model.defer="continuedFromPreviousPage"
                                   id="continuedFromPreviousPage"
                                   name="continuedFromPreviousPage"
                                   type="checkbox"
                                   class="w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary"
                            >
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="continuedFromPreviousPage"
                                   class="font-medium text-gray-700"
                            >
                                Continued from previous page
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3">
                            <label for="topics" class="block text-sm font-medium text-gray-700"> Topics </label>
                            <div class="mt-1">
                                <div class="block p-2 mt-1 w-full border border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <select x-ref="select" :multiple="multiple"></select>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500"></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3">
                            <label for="additional_topics" class="block text-sm font-medium text-gray-700"> Additional Topics </label>
                            <div class="mt-1">
                                <div class="block p-2 mt-1 w-full border border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <select x-ref="additional_select" :multiple="multiple"></select>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500"></p>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between py-3 px-4 bg-gray-50 sm:px-6">
                    <span x-on:click="close"
                          class="inline-flex justify-center py-2 px-4 text-sm font-medium text-black bg-gray-200 border border-transparent shadow-sm cursor-pointer hover:bg-gray-300 focus:ring-2 focus:ring-offset-2 focus:outline-none focus:ring-secondary">Cancel</span>
                    <button type="submit"
                            class="inline-flex justify-center py-2 px-4 text-sm font-medium text-white border border-transparent shadow-sm focus:ring-2 focus:ring-offset-2 focus:outline-none bg-secondary hover:bg-secondary focus:ring-secondary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
