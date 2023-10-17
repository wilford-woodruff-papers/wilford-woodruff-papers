<div class="p-4">
    <div class="p-4 mb-4 bg-white">
        <fieldset>
            <legend class="sr-only">Notifications</legend>
            <div class="space-y-5">
                <div class="flex relative items-start">
                    <div class="flex items-center h-6">
                        <input wire:model="filterToNoRating"
                               id="filterToNoRating"
                               value="true"
                               aria-describedby="filterToNoRating-description"
                               name="filterToNoRating"
                               type="checkbox"
                               class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-600"
                        >
                    </div>
                    <div class="ml-3 text-sm leading-6">
                        <label for="filterToNoRating" class="font-medium text-gray-900">Only show sessions with questions a zero rating</label>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div id="pagination-top"
         class="pb-3"
    >
        {!! $sessions->links() !!}
    </div>
    <table class="min-w-full">
        <thead class="bg-white">
                <th scope="col" class="py-3.5 pr-3 pl-4 text-lg font-semibold text-left text-gray-900 sm:pl-3"></th>
                <th scope="col" class="py-3.5 px-3 text-lg font-semibold text-left text-gray-900">Question</th>
                <th scope="col" class="py-3.5 px-3 text-lg font-semibold text-left text-gray-900">Answer</th>
                <th scope="col" class="py-3.5 px-3 text-lg font-semibold text-left text-gray-900">Rating</th>
                <th scope="col" class="py-3.5 px-3 text-lg font-semibold text-left text-gray-900">Topics</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach($sessions as $session)
                <tr class="border-t border-gray-200" id="session-{{ $session->session_id }}">
                    <th colspan="4" scope="colgroup" class="py-2 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:pl-3">
                        {{ $session->session_id }}
                    </th>
                    <th colspan="1" scope="colgroup" class="py-2 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:pl-3">
                        Imported {{ $session->created_at->toFormattedDateString() }}
                    </th>
                </tr>
                @foreach($session->questions as $question)
                    <tr class="border-t border-gray-300" id="question-{{ $question->id }}">
                        <td class="py-4 pr-3 pl-4 text-sm font-medium text-gray-700 whitespace-nowrap sm:pl-3"></td>
                        <td class="py-4 pr-3 pl-4 text-lg font-medium text-gray-700 sm:pl-3">
                            {{ $question->question }}
                        </td>
                        <td class="py-4 px-3 text-lg text-gray-900">
                            {!! $question->answer !!}
                        </td>
                        <td class="py-4 px-3 text-sm text-white whitespace-nowrap">
                            <div class="flex gap-x-2 items-center">
                                <button wire:click="rate({{ $question->id }}, 1)"
                                    type="button" class="inline-flex gap-x-1.5 items-center py-1.5 px-2.5 text-sm font-semibold text-white bg-green-700 rounded-md shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ml-0.5 w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                                    </svg>
                                </button>
                                <div class="text-lg text-black">
                                    {{ $question->rating }}
                                </div>
                                <button wire:click="rate({{ $question->id }}, -1)"
                                        type="button" class="inline-flex gap-x-1.5 items-center py-1.5 px-2.5 text-sm font-semibold text-white bg-red-800 rounded-md shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ml-0.5 w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 15h2.25m8.024-9.75c.011.05.028.1.052.148.591 1.2.924 2.55.924 3.977a8.96 8.96 0 01-.999 4.125m.023-8.25c-.076-.365.183-.75.575-.75h.908c.889 0 1.713.518 1.972 1.368.339 1.11.521 2.287.521 3.507 0 1.553-.295 3.036-.831 4.398C20.613 14.547 19.833 15 19 15h-1.053c-.472 0-.745-.556-.5-.96a8.95 8.95 0 00.303-.54m.023-8.25H16.48a4.5 4.5 0 01-1.423-.23l-3.114-1.04a4.5 4.5 0 00-1.423-.23H6.504c-.618 0-1.217.247-1.605.729A11.95 11.95 0 002.25 12c0 .434.023.863.068 1.285C2.427 14.306 3.346 15 4.372 15h3.126c.618 0 .991.724.725 1.282A7.471 7.471 0 007.5 19.5a2.25 2.25 0 002.25 2.25.75.75 0 00.75-.75v-.633c0-.573.11-1.14.322-1.672.304-.76.93-1.33 1.653-1.715a9.04 9.04 0 002.86-2.4c.498-.634 1.226-1.08 2.032-1.08h.384" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="py-4 px-3 text-sm text-gray-500 whitespace-nowrap w-[300px]">
                            <label for="topics_{{ $question->id }}"
                                   class="sr-only"
                            >
                                Topics
                            </label>{{--
                            <select id="topics_{{ $question->id }}">
                                <option value="">-- Choose Topics --</option>
                                @foreach($topics as $topic)
                                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                @endforeach
                            </select>--}}
                            <div wire:ignore
                                x-data="{
                                    multiple: true,
                                    value: @json($question->topics->pluck('id')),
                                    options: [
                                        @foreach($topics as $topic)
                                            { value: {{ $topic->id }}, label: '{{ addslashes($topic->name) }}' },
                                        @endforeach
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
                                            })

                                            this.$watch('value', () => {
                                                refreshChoices();
                                                $wire.updateTopics({{ $question->id }}, this.value);
                                            })
                                            this.$watch('options', () => refreshChoices())
                                        })
                                    }
                                }"
                                class="w-full max-w-sm"
                            >
                                <select x-ref="select"
                                        :multiple="multiple"
                                        id="topics_{{ $question->id }}"
                                ></select>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    <div id="pagination-bottom">
                        {!! $sessions->links() !!}
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    @endpush
    @push('scripts')
        <script>
            Livewire.on('scroll', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        </script>
    @endpush
</div>
