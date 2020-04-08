@extends('auth.layout')

@section('title')
@lang('login.reset_password')
@endsection

@section('content')
    @if (session('status') || $errors->has('email'))
        <div class="auth-reset-modal mt-20 mb-4">
    @endif

    <div class="back-button text-left {{$errors->has('email') || session('status') ? 'modal-view' : '' }}">
        <a class="text-24" href="{{ $errors->has('email') ? '/v3/password/reset' : '/v3/login' }}"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1 class="mb-4 mt-12 font-weight-light">@lang('login.reset_password')</h1>

    @if (session('status') || $errors->has('email'))
            @if ($errors->has('email'))
                {!! $errors->first('email') !!}
            @endif
            @if (session('status'))
                {!! session('status') !!}
            @endif
        </div>
    @else
        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label sr-only">@lang('login.your_email')</label>
                <input id="email" type="email" class="form-control mw-250px mx-auto mb-4" name="email" value="{{ old('email') }}" placeholder="@lang('login.your_email')"
                    oninvalid="this.setCustomValidity('Please enter valid email address.')" oninput="this.setCustomValidity('')" required>
                </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-round d-block w-200px mx-auto btn-drop-shadow text-16">
                    @lang('login.reset_password')
                </button>
            </div>
        </form>
    @endif
@endsection
