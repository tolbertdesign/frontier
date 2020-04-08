@extends('auth.layout')

@section('title')
    @lang('passwords.change_password')
@endsection

@section('content')
    @include("components.buttons.back", ['back_url' => action('Auth\AuthController@welcome') ])
    <h1 class="mb-4 mt-12 font-weight-light">@lang('passwords.change_password')</h1>
    <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">
        <password-reset-fields
            email_address_label="@lang('passwords.email_address')"
            password_label="@lang('passwords.new_password')"
            password_confirm_label="@lang('passwords.confirm_password')"
            password_requirements_label="@lang('passwords.requirements')"
            :email_errors="{{ json_encode($errors->get('email')) }}"
            :password_errors="{{ json_encode($errors->get('password')) }}"></password-reset-fields>
        <button class="btn btn-primary btn-round d-block w-200px mx-auto btn-drop-shadow text-15 mb-15">@lang('passwords.update')</button>
        <a href="/v3" class="btn btn-danger btn-round d-block w-200px mx-auto btn-drop-shadow text-15 mb-15">@lang('general.cancel')</a>
    </form>
@endsection
