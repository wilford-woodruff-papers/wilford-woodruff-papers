@foreach(config('open-graph-image.metatags') as $property => $key)
    @if($attributes->has($key))
        <meta property="{{ $property }}" content="{!! html_entity_decode(html_entity_decode(str($attributes->get($key))->replace('_', ' ')->trim())) !!}">
    @endif
@endforeach

<meta property="og:locale" content="en_US" />
<link rel="image_src" href="{{ og($attributes) }}" />
<meta property="og:image" content="{{ og($attributes) }}">
<meta property="og:image:url" content="{{ og($attributes) }}">
<meta property="og:image:secure_url" content="{{ og($attributes) }}" />
<meta property="og:image:type" content="image/{{ config('open-graph-image.image.extension') }}">
<meta property="og:image:width" content="{{ config('open-graph-image.image.width') }}">
<meta property="og:image:height" content="{{ config('open-graph-image.image.height') }}">
