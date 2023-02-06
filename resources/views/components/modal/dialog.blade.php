@props(['id' => null, 'maxWidth' => null])

<div>
    <x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
        <div class="py-4 px-6">
            <div class="text-lg">
                {{ $title }}
            </div>

            <div class="mt-4">
                {{ $content }}
            </div>
        </div>

        <div class="flex justify-between py-4 px-6 bg-gray-100">
            {{ $footer }}
        </div>
    </x-modal>
</div>

