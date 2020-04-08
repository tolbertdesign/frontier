@extends('auth.layout')

@section('title')
    @lang('email-preferences.email_preferences_title')
@endsection

@section('content')
        <h1 class="text-60">@lang('email_preferences.email_preferences_title')</h1>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form method="post" action="{{route('update-email-preferences')}}">
            <input
                value="{{ csrf_token() }}"
                type="hidden"
                name="_token" >
            <input
                value="{{ $emailToken }}"
                type="hidden"
                name="emailToken" >
            <label for="emailTypeIdsToBlock">
                <input
                    @if($userOptOuts->contains('user_email_type_id', 2)) {{'checked=checked'}} @endif
                    id="emailTypeIdsToBlock"
                    name="emailTypeIdsToBlock[]"
                    type="checkbox"
                    value="2">@lang('email_preferences.block_automated_pledge_requests')
            </label>
            <label for="blockAll">
                <input
                    @if($user->email_opt_out) {{'checked=checked'}} @endif
                    id="blockAll"
                    name="blockAll"
                    type="checkbox"
                    value="1">@lang('email_preferences.block_all')
            </label>
            <input type="submit">
        </form>
@endsection
