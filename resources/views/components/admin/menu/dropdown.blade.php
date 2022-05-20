<div class="flex justify-center">
    <div
        x-data="{
            open: false,
            toggle() {
                if (this.open) {
                    return this.close()
                }

                this.$refs.button.focus()

                this.open = true
            },
            close(focusAfter) {
                if (! this.open) return

                this.open = false

                focusAfter && focusAfter.focus()
            }
        }"
        x-on:keydown.escape.prevent.stop="close($refs.button)"
        x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
        x-id="['dropdown-button']"
        class="relative"
    >
        <!-- Button -->
        <button
            x-ref="button"
            x-on:click="toggle()"
            :aria-expanded="open"
            :aria-controls="$id('dropdown-button')"
            type="button"
            class="px-3 py-2 text-gray-900 text-sm font-medium"
        >
            <span>{{ $text }}</span>
        </button>

        <!-- Panel -->
        <div
            x-ref="panel"
            x-show="open"
            x-transition.origin.top.left
            x-on:click.outside="close($refs.button)"
            :id="$id('dropdown-button')"
            style="display: none;"
            class="absolute left-0 mt-2 w-40 bg-white rounded shadow-md overflow-hidden"
        >
            <div>
                @foreach($links as $key => $link)
                    <a href="{{ $link }}" class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-50 disabled:text-gray-500" >
                        {{ $key }}
                    </a>
                @endforeach
            </div>

        </div>
    </div>
</div>
