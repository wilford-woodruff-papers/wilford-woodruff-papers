<!-- Activity table (small breakpoint and up) -->
<div {{ $attributes->merge(['class' => 'min-w-full align-middle shadow sm:rounded-lg']) }}>
    <table
        x-data="{
                open: $persist(null)
            }"
        class="min-w-full divide-y divide-cool-gray-200">
        <thead class="sticky top-0 z-50"
               :class="shadow && 'drop-shadow-md'"
        >
            <tr class="bg-gray-100">
                {{ $head }}
            </tr>
        </thead>

        <tbody class="bg-white divide-y divide-cool-gray-200">
            {{ $body }}
        </tbody>
    </table>
</div>
