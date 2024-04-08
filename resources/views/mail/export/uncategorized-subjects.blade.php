<x-mail::message>
# Your export is ready.

<x-mail::button :url="$download">
Download
</x-mail::button>

<x-mail::button :url="$link">
View in Nova
</x-mail::button>

Thank you!,<br>
{{ config('app.name') }}
</x-mail::message>
