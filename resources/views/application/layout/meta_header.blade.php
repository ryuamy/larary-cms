<base href="{{ url('/') }}" />

<title>
    {{ !empty($meta["title"]) ? $meta["title"] : get_site_settings('title') }}
    {{ get_site_settings('separator') }}
    {{ get_site_settings('tagline') }}
</title>

<meta charset="utf-8" />
<meta name="description" content="{{ get_site_settings('description') }}" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="canonical" href="{{ url('/') }}" />
<link rel="dns-prefetch" href="//fonts.gstatic.com" />

<link rel="shortcut icon" href="{{ app_media().'favicon.ico' }}" />

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito" />

<link rel="stylesheet" type="text/css" href="{{ app_css().'app.css' }}" />
<link rel="stylesheet" type="text/css" href="{{ app_css().'global/style.bundle.css' }}" />
<link rel="stylesheet" type="text/css" href="{{ app_css().'global/metronic_v7.1.2/plugins/global/plugins.bundle.css' }}" />
<link rel="stylesheet" type="text/css" href="{{ app_css().'global/metronic_v7.1.2/plugins/custom/prismjs/prismjs.bundle.css' }}" />
