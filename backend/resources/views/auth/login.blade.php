@extends('auth.layout')

@section('title')
    @lang('login.login_title')
@endsection

@section('content')
    @include("components.buttons.back", ['back_url' => action('Auth\AuthController@welcome') ])
    <h1 class="mb-4">Login</h1>
    <div class="social-login">
        <google-login :set_lang="{{ json_encode(Lang::get('register')) }}"></google-login>
    </div>
    <p class="text-12 gap-strike my-4 mw-200px mx-auto"><span class="strike"></span><span>@lang('login.or')</span><span class="strike"></span></p>
    <div class="">
        <form action="/v3/login" method="post">
            {{csrf_field()}}
           <login-fields email_address_label="@lang('login.email_address')" password_label="@lang('login.password')" remember_me_label="@lang('login.remember_me')" show_password_label="@lang('login.show_password')"></login-fields>
            @forelse($errors->all() as $error)
                <p class="error-msg is-large text-center mx-auto mw-250px">{{$error}}</p>
                @empty
            @endforelse
            <button class="btn btn-primary btn-round d-block w-200px mx-auto btn-drop-shadow text-15 mb-15">@lang('login.login')</button>
            <a id="forgot-password-link" href="/v3/password/reset/">@lang('login.forgot_password')</a>
        </form>
    </div>
    @if($showSnow == 'true')
        <Snowf
            :amount="150"
            :size="5"
            :speed="1.7"
            :wind="0"
            :opacity="0.8"
            :swing="1"
            :image="null"
            :z-index="-1"
            :resize="true"
            color="#fff"/>
    @endif
@endsection
