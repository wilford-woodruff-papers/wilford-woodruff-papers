{{--<p class="mt-8 text-center text-xs text-80">
    <a href="https://nova.laravel.com" class="text-primary dim no-underline">Laravel Nova</a>
    <span class="px-1">&middot;</span>
    &copy; {{ date('Y') }} Laravel LLC - By Taylor Otwell, David Hemphill, and Steve Schoger.
    <span class="px-1">&middot;</span>
    v{{ \Laravel\Nova\Nova::version() }}
</p>--}}

<script>
    function copyShortUrlToClipboard(event) {
        let shortUrl = event.dataset.url;
        navigator.clipboard.writeText(shortUrl).then(() => {
            // Alert the user that the action took place.
            // Nobody likes hidden stuff being done under the hood!
            console.log(shortUrl + " copied to clipboard");
        });
    }
</script>
