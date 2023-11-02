<x-guest-layout>
    {{ $date->toFormattedDateString() }}
    @foreach($day as $entry)
        {!! $entry->text !!}
    @endforeach
</x-guest-layout>
