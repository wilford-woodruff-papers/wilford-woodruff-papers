<div wire:init="loadEvents">
    <ul>
        @foreach($events as $event)
            <li>
                {{ data_get($event, 'title') }}
            </li>
        @endforeach
    </ul>
</div>
