<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="google" content="notranslate">
    <meta http-equiv="Content-Language" content="{{ app()->getLocale() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Tag Manager -->

    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-K6MGXPQ');</script>
    <!-- End Google Tag Manager -->

    @yield('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @if($program->event_name)
    <title>{{ $program->event_name }}</title>
    @endif

    <!-- Styles -->
    <link href="{{ secure_asset(mix('/v3-assets/public/css/public.css')) }}" rel="stylesheet">

    <!-- Scripts -->
    @yield('dataLayer')
    @include('partials.google_analytics')

    <!-- Scripts -->
    @include('partials.hotjar')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ouibounce/0.0.12/ouibounce.js" integrity="sha256-1Gug6C6d34ZqtEakkSAoNdRNlY+7LaPXp/1OSKIyD/w=" crossorigin="anonymous"></script>
</head>
<body class="{{ $program->getTheme() }}">
    <!-- Google Tag Manager (noscript) -->

    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K6MGXPQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    @include('partials.facebook')
    <div id="app">
        <div id="wrapper">
            <div id="page-content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ secure_asset(mix('/v3-assets/public/js/public.js')) }}"></script>
</body>
</html>
