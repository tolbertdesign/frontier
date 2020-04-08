<div>
    <p>{{ $sponsorFirstName }},</p>
    <p>{{ __('pledges.email.thank_you') }} {{ $participantName }} {{ __('pledges.email.in_the') }} {{ $eventName }}!</p>
    <p>{{ $parentFirstName }} {{ __('pledges.email.sent_you') }}:</p>
    <p><a href="{{ $payLink }}">{{ $payLink }}</a></p>
    <p>
        {{ __('pledges.email.we_want_to') }} <a href="{{ $surveyLink }}" target="_blank">{{ __('pledges.email.here') }}</a> {{ __('pledges.email.golden') }}.
    </p>
    <p>- {{ $eventName }}</p>
</div>
