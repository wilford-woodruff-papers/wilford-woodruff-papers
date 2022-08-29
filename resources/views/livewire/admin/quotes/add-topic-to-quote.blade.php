<div>
    <div x-data="{
            multiple: true,
            selectedTopics: @entangle('selectedTopics').defer,
            value: [],
            options: [
                @foreach($topics as $key => $topic) {'value': {{ $key }}, 'label': '{{ addslashes($topic) }}'}, @endforeach
            ],
            init() {
                this.$nextTick(() => {
                    let choices = new Choices(this.$refs.select)

                    let refreshChoices = () => {
                        let selection = this.multiple ? this.value : [this.value]

                        choices.clearStore()
                        choices.setChoices(this.options.map(({ value, label }) => ({
                            value,
                            label,
                            selected: selection.includes(value),
                        })))
                    }

                    refreshChoices()

                    this.$refs.select.addEventListener('change', () => {
                        this.value = choices.getValue(true)
                        this.selectedTopics = choices.getValue(true)
                    })

                    this.$watch('value', () => refreshChoices())
                    this.$watch('options', () => refreshChoices())
                })
            },
            close: function(){
                Livewire.emit('closeModal');
                rangy.getSelection().removeAllRanges();
                $('.highlight').removeClass('highlight');
                $dispatch('close-options');
            }
        }"
         class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
        <form wire:submit.prevent="save"
              action="#"
              method="POST">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Add Topic(s)</h3>
                        <p class="mt-1 text-sm text-gray-500"></p>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3">
                            <label for="selection" class="block text-sm font-medium text-gray-700"> Quote </label>
                            <div class="mt-1">
                                <div class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 p-2 block w-full sm:text-sm border border-gray-300"
                                >
                                    {{ $quote->text }}
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500"></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3">
                            <label for="topics" class="block text-sm font-medium text-gray-700"> Topics </label>
                            <div class="mt-1">
                                <div class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 p-2 block w-full sm:text-sm border border-gray-300"
                                >
                                    <select x-ref="select" :multiple="multiple"></select>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500"></p>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 flex justify-between sm:px-6">
                    <span x-on:click="close"
                          class="cursor-pointer bg-gray-200 border border-transparent shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-black hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">Cancel</span>
                    <button type="submit"
                            class="bg-secondary border border-transparent shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
