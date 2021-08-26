<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ env('APP_URL') }}</loc>
        <lastmod>2021-08-26</lastmod>
    </url>
    @foreach($pages as $page)
        <url>
            <loc>{{ env('APP_URL') }}/{{ $page->slug }}</loc>
            <lastmod>{{ date('Y-m-d', strtotime($page->updated_at)) }}</lastmod>
        </url>
    @endforeach
</urlset>
