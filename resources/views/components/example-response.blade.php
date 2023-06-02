@php
    $modelName = str(class_basename($model::class))->lower();
    $modelNameSingular = $modelName->singular();
    $modelNamePlural = $modelName->plural();
@endphp
<div>
    @ray($model::query()->inRandomOrder()->first())
    <p class="text-lg font-semibold">
        Example Response
    </p>
    <div x-data="{
        id: {{ $id }},
        loaded: false,
        get expanded() {
            return this.active === this.id
        },
        set expanded(value) {
            if(! this.loaded){
                this.makeAPICall('{{ $url }}', '{{ $modelName }}-{{ $id }}-response');
                this.loaded = true;
            }

            this.active = value ? this.id : null
        },
    }" role="region" class="bg-white rounded-lg shadow">
        <h2>
            <button
                x-on:click="expanded = !expanded"
                :aria-expanded="expanded"
                class="flex justify-between items-center py-4 px-6 w-full text-xl font-bold"
            >
                <span>Show / Hide</span>
                <span x-show="expanded" aria-hidden="true" class="ml-4">&minus;</span>
                <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
            </button>
        </h2>

        <div x-show="expanded" x-collapse>
            <div class="px-6 pb-4">
            <pre>
                <code class="language-json" id="{{ $modelName }}-{{ $id }}-response"></code>
            </pre>
            </div>
        </div>
    </div>
</div>
