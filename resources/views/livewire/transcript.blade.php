<div>
    <div x-data="{
            options: false,
            selection: '',
            highlighter: '',
            quotes: [],
            init: function(){
                rangy.init();
                this.highlighter = rangy.createHighlighter();
                this.highlighter.addClassApplier(rangy.createClassApplier('highlight', {
                    ignoreWhiteSpace: true,
                    tagNames: ['span', 'a']
                }));
                quotes = fetch('{{ route('quotes.page.show', ['page' => $page]) }}')
                            .then(function(response){ return response.json()})
                            .then(function (data){
                                quotes = data;

                                var annotator = new TextAnnotator({content: document.getElementById('transcript-text').innerHTML});
                                quotes.forEach(function(quote){
                                    let lines = quote.text.split(/\r?\n/);
                                    lines.forEach(function(line){
                                        var highlightIndex = annotator.search((line), {caseSensitive: true})
                                        if (highlightIndex !== -1) {
                                            document.getElementById('transcript-text').innerHTML = annotator.highlight(highlightIndex, {highlightClass: 'quote-highlight'});
                                        }
                                    });
                                });
                            });

                themes = fetch('{{ route('themes.page.show', ['page' => $page]) }}')
                            .then(function(response){ return response.json()})
                            .then(function (data){
                                quotes = data;

                                var annotator = new TextAnnotator({content: document.getElementById('transcript-text').innerHTML});
                                quotes.forEach(function(quote){
                                    let lines = quote.text.split(/\r?\n/);
                                    lines.forEach(function(line){
                                        var highlightIndex = annotator.search((line), {caseSensitive: true})
                                        if (highlightIndex !== -1) {
                                            document.getElementById('transcript-text').innerHTML = annotator.highlight(highlightIndex, {highlightClass: 'theme-highlight'});
                                        }
                                    });
                                });
                            });

            },
            captureSelection: function(e){
                if(rangy.getSelection().toString() !== ''){
                    this.selection = rangy.getSelection();
                    this.highlighter.highlightSelection('highlight');
                    new Popper({
                        getBoundingClientRect: () => ({
                            top: event.clientY - 60,
                            right: event.clientX,
                            bottom: event.clientY - 60,
                            left: event.clientX,
                            width: 0,
                            height: 0
                        }),
                        clientWidth: 0,
                        clientHeight: 0 }, document.getElementById('pop'), {
                  });
                  this.options = true;
                }
            },
            cancel: function(){
                this.options = false;
                rangy.getSelection().removeAllRanges();
                $('.highlight').removeClass('highlight');
            }
            {{-- TODO: Load all quotes for the page and highlight them. Might need to use https://www.npmjs.com/package/text-annotator, but watch out for html entities --}}
        }"
         id="transcript-text"
         @close-options.window="options=false"
    >
        <div x-on:mouseup="captureSelection($event)">
            {!! $page->text(auth()->check() && auth()->user()->hasAnyRole(['Quote Tagging', 'Super Admin'])) !!}
        </div>


        <div x-show="options"
             id="pop">
            <span class="inline-flex relative z-0 rounded-md shadow-sm">
                <button x-on:click="Livewire.emit('openModal', 'add-quote', [{{ $page->id }}, selection.toString()]);"
                        type="button"
                        class="inline-flex relative items-center py-2 px-4 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:text-white focus:z-10 focus:outline-none hover:bg-secondary">
                    Add Quote
                </button>
                <button x-on:click="Livewire.emit('openModal', 'add-theme', [{{ $page->id }}, selection.toString()]);"
                        type="button"
                        class="inline-flex hidden relative items-center py-2 px-4 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:text-white focus:z-10 focus:outline-none hover:bg-secondary">
                    Tag Theme
                </button>
                <button x-on:click="cancel"
                        type="button"
                        class="inline-flex relative items-center py-2 px-4 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:text-white focus:z-10 focus:outline-none hover:bg-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </span>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/text-annotator.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
        <script>
            window.onload = function() {
                // Enable multiple selections in IE
                try {
                    document.execCommand("MultipleSelection", true, true);
                } catch (ex) {}
            };
            window.addEventListener('deselect', function() {
                rangy.getSelection().removeAllRanges();
            });
        </script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
        <style>
            .highlight {
                background-color: #ffb7b7;
            }
            .quote-highlight {
                background-color: #fff2a8;
            }
            .theme-highlight {
                background-color: #a8d1ff;
            }
        </style>
    @endpush
</div>
