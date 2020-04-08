@extends("layouts.public")

@section('meta')
@if($welcomeVideos->hasImageForStudentStarVideo())
    <meta
    property="og:title"
    content="{{ htmlentities(__('public.open_graph_title', ['names'=> $participantDisplayNames, 'event_name' => $program->event_name])) }}" />
@else
    <meta
        property="og:title"
        content="{{ htmlentities(__('public.open_graph_title_no_ssv', ['names'=> $participantDisplayNames, 'event_name' => $program->event_name, 'url' => $participants->first()->shareFacebookUrl()])) }}" />
@endif
<meta
    property="og:description"
    content="{{ htmlentities(__('public.open_graph_description', ['funds_raised_for'=> $program->microsite->funds_raised_for, 'event_name' => $program->event_name, 'url' => $participants->first()->shareFacebookUrl()])) }}" />
<meta
    property="og:image"
    content="{{ htmlentities($shareImage) }}" />
@endsection

@section('dataLayer')
<script>
    dataLayer = [{
        'programSalesforceId': '{{ $program->salesforce_id }}',
        'schoolSalesforceId': '{{ $program->school->salesforce_id }}',
        'teamId': '{{ $program->team_id }}',
        'semester': '{{ $program->semester }}',
        'serviceLevel': '{{ $program->service_level }}',
        'evenOddParent': '{{ $participants->first()->parents->first()->id % 2 ? "odd" : "even" }}',
        'parentUserId': '{{ $participants->first()->parents->first()->id }}',
        'funRun': '{{ $program->fun_run }}'
    }];
</script>
@endsection

@section("content")
<div class="container">
    @include("headers.public")

    <div class="row">
        <div class="col-md-4 d-md-block d-none">
            <div class="mb-3">
                @include("cards.public_participant")
            </div>
            @if($sponsorLeaderboard->getPledges()->count() > 0)
                <div class="mb-3">
                    @include("cards.supporting_sponsors")
                </div>
            @endif
        </div>

        <div class="col-md-8">
            <div class="mb-3">
                @if($welcomeVideos->getAllPublic())
                    @include("cards.participant_description")
                @else
                    @include("cards.participant_description_no_video")
                @endif
            </div>
            <div class="mb-3 d-md-none">
                @include("cards.public_participant")
            </div>
            @if($sponsorLeaderboard->getPledges()->count() > 0)
                <div class="mb-3 d-md-none">
                    @include("cards.supporting_sponsors")
                </div>
            @endif
            <div class="mb-3">
                @include("cards.public_program_goal")
            </div>
            <div class="mb-3">
                @include("cards.business_leaderboard")
            </div>
            <div class="mb-3">
                @include("cards.program_description")
            </div>
        </div>
    </div>
</div>

@include("footers.public")

@if($hideCookiePolicy === false)
    <div id="cookiePolicy" class="bg-lt-gray mb-0 text-12 text-center text-gray cookie-policy py-2 show fixed-bottom">
        <p class="px-5 my-0">@lang('legal.cookie_policy_banner') <a href="#" class="text-gray font-weight-bold"><u>@lang('legal.cookie_policy_link_text')</u></a></p>
        <i data-toggle="collapse" aria-expanded="true" data-target="#cookiePolicy" class="fa fa-times"></i>
    </div>
@endif
<level-set :program_id="{{$program->id}}" special_url="{{ $specialUrl->pledgeProcessUrl() }}"></level-set>
@endsection
