{{ $first_name }} @if($age) ({{ $age }}) @endif @if($location) from {{ $location }} @endif

Share Anonymously? {{ $shareAnonymously }}

@if($source)
    Wilford Woodruff Source / Story: {{ $source }}
@endif

@if($topic)
Topic: {{ $topic }}
@endif

{{ $message }}
