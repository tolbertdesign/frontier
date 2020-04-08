@extends('auth.layout')

@section('title')
    @lang('login.welcome_title')
@endsection

@section('content')
<registration-handler login_url="{{ action('Auth\LoginController@login') }}"
        :lang="{{ json_encode(array_merge(Lang::get('register'), Lang::get('datetime.months'), Lang::get('login'), Lang::get('general'))) }}"
        :errors="{{ $errors->toJson()}}"
        user_type="{{ Session::get('userType') }}"
        csrf="{{ csrf_token() }}"
        register_url="{{ route('register') }}"
        social_register_url="{{ route('complete_social_register') }}"
        :old="{{ json_encode(session()->getOldInput()) }}"
        :is-beta-user="{{ json_encode($isBetaUser) }}"
        :is-org-admin="{{ json_encode($isOrgAdmin) }}"
        home_Url="{{action('Auth\AuthController@welcome')}}"
        :user="{{ json_encode(Auth::user() ? Auth::user()->load('participants') : null ) }}"
        default_image_url="/img/userpic_60px.svg"
        :show_snow="{{$showSnow}}"
        @isset($loggedInBackAction)
            logged_in_back_action="{{$loggedInBackAction}}"
        @endisset
        @isset($startingPosition)
            starting_position="{{$startingPosition}}"
        @endisset
/>
@endsection
