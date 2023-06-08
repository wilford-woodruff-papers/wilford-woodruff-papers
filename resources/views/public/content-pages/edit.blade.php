<x-guest-layout>

    <div class="p-4 mx-auto mt-12 max-w-7xl border-2 border-gray-300 border-dashed">
        <div class="page-builder">
            {!! $contentPage->body !!}
        </div>
    </div>

    <form action="{{ route('content-page.update', ['contentPage' => $contentPage->slug]) }}"
          method="POST"
          id="page-edit-form"
          class="my-8 mx-auto max-w-4xl text-center">
        @method('PUT')
        @csrf
        <input type="hidden"
               id="body"
               name="body"
               value="" />
        <button type="submit"
                id="save-post"
                class="hidden">
            Save
        </button>

    </form>

    <div class="my-8 mx-auto max-w-4xl text-center">
        <div class="inline-flex gap-x-12">
            <x-button size="xl"
                      radius="lg"
                      id="update-post"
            >
                <span class="whitespace-nowrap">{{ __('Save') }}</span>
            </x-button>
            <x-button type="tertiary" tag="a" href="{{ route('content-page.show', ['contentPage' => $contentPage->slug]) }}" size="xl" radius="lg">
                <span class="whitespace-nowrap">{{ __('Cancel') }}</span>
            </x-button>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="/assets/minimalist-blocks/content-tailwind.css" />
        <link rel="stylesheet" href="/contentbuilder/contentbuilder.css" />
    @endpush

    @push('scripts')
        <script src="/contentbuilder/contentbuilder.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            const builder = new ContentBuilder({
                container: '.page-builder',
                framework: 'tailwind',
                disableConfig: true,
                rowTool: 'left',
                sidePanel: 'right',
                assetPath: '/assets/',
                snippetUrl: '/assets/minimalist-blocks/content.js',
                snippetPath: '/assets/minimalist-blocks/',
                snippetPathReplace: ['assets/minimalist-blocks/', '/assets/minimalist-blocks/'],
                snippetOpen: true,
                snippetDisplay: 'visible',
                fontAssetPath: '/assets/fonts/',
                plugins: [
                    { name: 'preview', showInMainToolbar: true, showInElementToolbar: true },
                    { name: 'wordcount', showInMainToolbar: true, showInElementToolbar: true },
                    { name: 'symbols', showInMainToolbar: true, showInElementToolbar: false },
                ],
                pluginPath: '/contentbuilder/',
            });
            builder.loadSnippets('/assets/minimalist-blocks/content.js');

            /*const form = document.getElementById('page-edit-form');
            form.addEventListener('submit', function(event){
                const body = document.getElementById('body');
                body.value = builder.html();

                return true;
            });*/

            var btnSave = document.querySelector('#update-post');
            btnSave.addEventListener('click', (e) => {
                builder.saveImages('{{ route('content-page.upload', ['contentPage' => $contentPage])}}', function(){

                    //Get html
                    var html = builder.html(); //Get content

                    //Submit the html to the server for saving. For example, if you're using html form:
                    document.querySelector('#body').value = html;
                    document.querySelector('#save-post').click();

                });

            });
        </script>
    @endpush
</x-guest-layout>
