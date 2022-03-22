<div>
    <div x-data="{
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
                                        var highlightIndex = annotator.search((line))
                                        if (highlightIndex !== -1) {
                                            document.getElementById('transcript-text').innerHTML = annotator.highlight(highlightIndex);
                                        }
                                    });
                                });
                            });

            },
            captureSelection: function(){
                if(rangy.getSelection().toString() !== ''){
                    this.selection = rangy.getSelection();
                    this.highlighter.highlightSelection('highlight');
                    Livewire.emit('openModal', 'add-quote', [{{ $page->id }}, this.selection.toString()]);

                }
            }
            {{-- TODO: Load all quotes for the page and highlight them. Might need to use https://www.npmjs.com/package/text-annotator, but watch out for html entities --}}
        }"
         x-on:mouseup="captureSelection()"
         id="transcript-text"
    >
        {!! $page->text() !!}

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
                background-color: yellow;
            }
        </style>
    @endpush
</div>
