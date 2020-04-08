@extends('auth.layout')

@section('title')
    @lang('register.sign_up')
@endsection

@section('content')
    @include('components.progress-bars.thin', ['width' => 'w-40pct'])
    @include('components.buttons.back', ['back_url' => action('Auth\RegisterController@parents')])
@endsection

@push('scripts')
<script type="text/javascript" src="{{ secure_asset(mix('/js/registration.js')) }}"

@endpush
