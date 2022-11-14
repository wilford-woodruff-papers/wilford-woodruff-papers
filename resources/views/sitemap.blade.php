<?xml version="1.0" encoding="UTF-8"?>
<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/documents</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/people</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/wives-and-children</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/places</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/timeline</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/miraculously-preserved-life</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/advanced-search</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/about</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/about/meet-the-team</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/about/editorial-method</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/about/frequently-asked-questions</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/contact-us</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/get-involved</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/volunteer</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/work-with-us/internship-opportunities</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/work-with-us</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/contribute-documents</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/media/articles</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/media/photos</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/media/podcasts</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/updates</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/media/videos</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/media/media-kit</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/media/requests</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/media/newsroom</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/donate</loc>
        <lastmod>{{ now()->toRfc3339String() }}</lastmod>
        <priority>0.80</priority>
    </url>
    @foreach($documents as $document)
        <url>
            <loc>{{ route('documents.show', ['item' => $document->uuid]) }}</loc>
            <lastmod>{{ $document->updated_at->toRfc3339String() }}</lastmod>
            <priority>0.80</priority>
        </url>
        @foreach($document->pages as $page)
            <url>
                <loc>{{ route('pages.show', ['item' => $document->uuid, 'page' => $page->uuid]) }}</loc>
                <lastmod>{{ $page->updated_at->toRfc3339String() }}</lastmod>
                <priority>0.80</priority>
            </url>
        @endforeach
    @endforeach
    @foreach($presses as $press)
        <url>
            <loc>{{ route('landing-areas.ponder.press', ['press' => $press->slug]) }}</loc>
            <lastmod>{{ $press->updated_at->toRfc3339String() }}</lastmod>
            <priority>0.80</priority>
        </url>
    @endforeach
    @foreach($subjects as $subject)
        <url>
            <loc>{{ route('subjects.show', ['subject' => $subject->slug]) }}</loc>
            <lastmod>{{ $subject->updated_at->toRfc3339String() }}</lastmod>
            <priority>0.75</priority>
        </url>
    @endforeach
</urlset>
