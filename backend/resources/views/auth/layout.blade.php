<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="google" content="notranslate">
    <meta http-equiv="Content-Language" content="{{ app()->getLocale() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('scripts.datalayer.usertype')
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-K6MGXPQ');</script>
        <!-- End Google Tag Manager -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title')
        @else
            Boosterthon
        @endif
    </title>

    <!-- Styles -->
    <link href="{{ mix('/css/auth.css') }}" rel="stylesheet">
    {{-- <link href="{{ mix('/css/animate.css') }}" rel="stylesheet"> --}}

    <!-- Scripts -->
    @include('scripts.google-analytics')
    @include('scripts.hotjar')

</head>
<body class="login {{$bodyClass ?? 'hand-stack-bg'}}">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K6MGXPQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="app">
        <div id="wrapper h-full">
            <div id="page-content-wrapper">
                <div class="d-flex align-items-center justify-content-center py-0 auth-full">
                    <div class="auth-wrapper">
                        <div class="auth mx-auto">
                            <div class="card-body text-center text-813-gray text-white">
                                @yield('content')
                            </div>
                            @include('auth.partials.footer')
                        </div>
                        @include('modals.privacy-policy')
                        @include('modals.school-search-help')
                        @include('modals.sponsor-instructions')
                        @include('modals.reg-buttons-explanation')
                        @include('modals.upload-photo')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('/js/auth.js') }}"></script>
    {{-- @stack('scripts') --}}
    @include('scripts.facebook')
    @include('scripts.hotjar')
</body>
</html>
