<div>
    <div x-data="{
            selection: '',
            highlighter: '',
            init: function(){
                rangy.init();
                this.highlighter = rangy.createHighlighter();
                this.highlighter.addClassApplier(rangy.createClassApplier('highlight', {
                    ignoreWhiteSpace: true,
                    tagNames: ['span', 'a']
                }));
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
         id="transcript"
    >
        {!! $page->text() !!}
    </div>



    @push('scripts')
        <script src="{{ asset('js/text-annotator.min.js') }}"></script>
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
        <style>
            .highlight {
                background-color: yellow;
            }
        </style>
    @endpush
</div>
