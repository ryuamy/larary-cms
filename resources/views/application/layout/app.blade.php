<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <!--
    Template Name: Metronic - Bootstrap 4 HTML, React, Angular 10 & VueJS Admin Dashboard Theme
    Author: KeenThemes
    Website: http://www.keenthemes.com/
    Contact: support@keenthemes.com
    Follow: www.twitter.com/keenthemes
    Dribbble: www.dribbble.com/keenthemes
    Like: www.facebook.com/keenthemes
    Purchase: https://1.envato.market/EA4JP
    Renew Support: https://1.envato.market/EA4JP
    License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
    -->

    <?php $current_route = \Route::currentRouteName(); ?>

    <head>
        <base href="{{ url('/') }}" />

        <meta charset="utf-8" />
        <meta name="description" content="{{ get_site_settings('description') }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $meta["title"].get_site_settings('title') }}</title>

        <link rel="canonical" href="{{ url('/') }}" />
        <link rel="dns-prefetch" href="//fonts.gstatic.com" />

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito" />

        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/global/style.bundle.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/global/metronic_v7.1.2/plugins/global/plugins.bundle.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/global/metronic_v7.1.2/plugins/custom/prismjs/prismjs.bundle.css') }}" />

        @foreach ($css as $c)
            <link rel="stylesheet" type="text/css" href="{{ asset('css/'.$c.'.css') }}" />
        @endforeach

        <link rel="shortcut icon" href="{{ asset('/media/favicon.ico') }}" />
    </head>

    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        </div>

		<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>

		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->

		<script src="{{ asset('/js/global/metronic_v7.1.2/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('/js/global/metronic_v7.1.2/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
		<script src="{{ asset('/js/global/scripts.bundle.js') }}"></script>
		<script src="{{ asset('/js/global/clock.js') }}"></script>

		<script>
			var baseUrl = $('body').data('baseurl');
			var cToken = $('body').data('ctoken');

			function clearconsole() {
				console.log(window.console);
				if (window.console) {
					console.clear();
				}
			}
		</script>

        <script src="{{ asset('js/app.js') }}" defer></script>

        @foreach ($js as $j)
            <script src="{{ asset('/js/'.$j.'.js') }}"></script>
        @endforeach
    </body>
</html>
