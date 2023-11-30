<div>
    <div x-data="{
            multiple: true,
            selectedAdditionalTopics: @entangle('selectedAdditionalTopics'),
            additional_value: [],
            additional_options: [
                @foreach($additional_topics as $additional_topic) {'value': '{{ addslashes($additional_topic->name) }}', 'label': '{{ addslashes($additional_topic->name) }}'}, @endforeach
            ],
            init() {
                this.$nextTick(() => {

                    let additional_choices = new Choices(this.$refs.additional_select, {
                        addItems: true,
                    });

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

                    refreshAdditionalChoices();

                    this.$refs.additional_select.addEventListener('change', () => {
                        this.value = additional_choices.getValue(true)
                        this.selectedAdditionalTopics = additional_choices.getValue(true)
                    })

                    this.$watch('additional_value', () => refreshChoices())
                    this.$watch('additional_options', () => refreshAdditionalChoices())
                })
            },
            close: function(){
                Livewire.dispatch('closeModal');
                rangy.getSelection().removeAllRanges();
                $('.highlight').removeClass('highlight');
                $dispatch('close-options');
            }
        }"
         class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0">
        <form wire:submit="save"
              action="#"
              method="POST">
            <div class="shadow sm:overflow-hidden sm:rounded-md">
                <div class="py-6 px-4 space-y-6 bg-white sm:p-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Add Additional Topic(s)</h3>
                        <p class="mt-1 text-sm text-gray-500"></p>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3">
                            <label for="selection" class="block text-sm font-medium text-gray-700"> Quote </label>
                            <div class="mt-1">
                                <div class="block p-2 mt-1 w-full border border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    {{ $quote->text }}
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
