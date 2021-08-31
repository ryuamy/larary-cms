<base href="{{ url('/') }}" />

<title>
    {{ !empty($meta['title']) ? $meta['title'] : get_site_settings('title') }}
    {{ get_site_settings('separator') }}
    {{ get_site_settings('tagline') }}
</title>

<meta charset="utf-8" />
<meta name="description" content="{{ !empty($meta['description']) ? $meta['description'] : get_site_settings('description') }}" />
@if (get_site_settings('search_engine_visibility') === 1)
    <meta name="google-site-verification" content="{{ get_site_settings('google_verification_code') }}" />
    <meta name="msvalidate.01" content="{{ get_site_settings('bing_verification_code') }}" />
@endif
{{-- <meta name="keywords" content="meta tags, meta tag, meta tags seo, meta tags definition, what is a meta tag" />
<meta name="Generator" content="Drupal 8 (https://www.drupal.org)" />
<meta name="MobileOptimized" content="width" />
<meta name="HandheldFriendly" content="true" /> --}}
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="twitter:card" content="summary">
<meta name="twitter:image" content="{{ isset($meta['image']) ? $meta['image'] : asset('/media/admin/layout/no-image-available.png') }}">
<meta name="twitter:title" content="{{ !empty($meta['title']) ? $meta['title'] : get_site_settings('title') }}" />
<meta name="twitter:description" content="{{ !empty($meta['description']) ? $meta['description'] : get_site_settings('description') }}" />
<meta property="og:type" content="{{ isset($meta['og_type']) ? $meta['og_type'] : 'website' }}">
<meta property="og:locale" content="{{ get_site_settings('language') }}" />
<meta property="og:site_name" content="{{ get_site_settings('title') }}" />
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ !empty($meta['title']) ? $meta['title'] : get_site_settings('title') }}">
<meta property="og:description" content="{{ !empty($meta['description']) ? $meta['description'] : get_site_settings('description') }}">
<meta property="og:updated_time" content="{{ isset($meta['og_updated_time']) ? $meta['og_updated_time'] : date('Y-m-d H:i:s') }}">
<meta property="og:image" content="{{ isset($meta['image']) ? $meta['image'] : asset('/media/admin/layout/no-image-available.png') }}">
{{-- <meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="1280">
<meta property="og:image:height" content="639"> --}}
@if (isset($meta['article_section']))
<meta name="article:section" content="{{ $meta['article_section'] }}" />
@endif
@if (isset($meta['article_published_time']))
    <meta name="article:published_time" content="{{ $meta['article_published_time'] }}" />
@endif
@if (isset($meta['article_modified_time']))
    <meta name="article:modified_time" content="{{ $meta['article_modified_time'] }}" />
@endif

<link rel="shortlink" href="{{ url('/') }}" />
<link rel="canonical" href="{{ url()->current() }}" />
<link rel="revision" href="{{ url('/') }}" />

<link rel="dns-prefetch" href="//fonts.gstatic.com" />
<link rel="shortcut icon" href="{{ app_media().'favicon.ico' }}" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito" />
<link rel="stylesheet" type="text/css" href="{{ app_css().'app.css' }}" />
<link rel="stylesheet" type="text/css" href="{{ app_css().'global/style.bundle.css' }}" />
<link rel="stylesheet" type="text/css" href="{{ app_css().'global/metronic_v7.1.2/plugins/global/plugins.bundle.css' }}" />
<link rel="stylesheet" type="text/css" href="{{ app_css().'global/metronic_v7.1.2/plugins/custom/prismjs/prismjs.bundle.css' }}" />
