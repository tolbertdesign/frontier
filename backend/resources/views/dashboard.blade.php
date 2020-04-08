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
    @include('scripts.google-analytics')
    @include('scripts.hotjar')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') &mdash; {{ config('app.name', 'Boosterthon') }}</title>

    <!-- Styles -->
    <link href="{{ secure_asset(mix('/css/dashboard.css')) }}" rel="stylesheet">
    <style>
        [v-cloak] { display: none; }
    </style>
    <script>
        window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'signedIn' => Auth::check()
        ])!!};
    </script>
</head>

<body class="leading-normal antialiased">

    <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K6MGXPQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div id="app" class="min-h-screen bg-cover bg-center">
        <store-loader
            :user="{{ $user }}"
            s3_bucket="{{env('AWS_BUCKET')}}"
            :beta_banner_kill_switch="{{json_encode(env('BETA_BANNER_KILL_SWITCH'))}}"
            min_password_length="{{env('PASSWORD_MIN_LENGTH')}}"
            avatar_path="{{ env('S3_USER_PROFILE_IMAGES')}}"
            :pledge_types="{{ json_encode($pledgeTypes)}}"
            :sponsor_types="{{ json_encode($sponsorTypes)}}"
            :countries="{{ json_encode($countries) }}"
            :states="{{ json_encode($states) }}"
            :lang="{{json_encode(array_merge(Lang::get('parent_dashboard'),
                Lang::get('datetime'),
                Lang::get('easy_emailer'),
                Lang::get('edit_profile'),
                Lang::get('edit_participant'),
                Lang::get('finish_line'),
                Lang::get('general'),
                Lang::get('how_to_get_pledges'),
                Lang::get('passwords'),
                Lang::get('easy_emailer'),
                Lang::get('edit_profile'),
                Lang::get('pledges'),
                Lang::get('programs'),
                Lang::get('register'),
                Lang::get('axon'),
                Lang::get('teacher_dashboard')
                ))}}"></store-loader>
        <router-view></router-view>
    </div>

    <!-- Scripts -->
    @include('scripts.facebook')
    <script src="https://cdn.jwplayer.com/libraries/eVFvXVIt.js"></script>
    <script src="{{ secure_asset(mix('/js/dashboard.js')) }}"></script>
    <script src="{{ mix('js/bundle.js') }}"></script>
</body>
</html>
