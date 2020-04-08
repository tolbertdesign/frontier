<div class="card">
    <div class="card-body">
        <div class="row text-center mb-3">
            <div class="col-md-12">
                <a href="{{ $specialUrl->pledgeProcessUrl() }}" class="btn btn-lg btn-round btn-success w-100 mw-200px">@lang('public.enter_pledge')</a>
            </div>
        </div>
        <hr class="mt-4 mb-4"/>
        @foreach ($participants as $participant)
            <div class="row">
                <div class="col-md-12 text-center">
                    @if($participant->profile->imageUrl())
                        <img class="rounded-circle w-100px align-middle" src="{{ $participant->profile->imageUrl() }}" alt="">
                    @else
                        <i class="rounded-circle fa w-100px fa-user default-profile-image align-middle"></i>
                    @endif
                    <div class="align-middle text-center">
                        <div class="text-22 text-gray"><strong>{{$participant->first_name}}</strong></div>
                        <div class="text-16 text-gray pb-2">
                            @if($program->getProgramPledgeSetting()->flat_donate_only)
                                ${{ $participant->participantInfo->flatFormatted() }}
                            @else
                                ${{ $participant->participantInfo->ppuFormatted() }} {{ $program->unit->modifier }} {{ $program->unit->name }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if($participant->participantInfo->percentToGoal() < 100)
            <div class="row">
                <div class="col-md-12">
                    <div class="text-14 text-capitalize text-center text-gray">
                        @if($program->getProgramPledgeSetting()->flat_donate_only)
                            @lang('public.my_goal'): ${{ number_format($participant->profile->pledge_goal, 0) }}
                        @else
                            @lang('public.my_goal'): ${{ number_format($participant->profile->pledge_goal, 0) }} {{ $program->unit->modifier }} {{ $program->unit->name }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="row pb-0">
                <div class="col-md-12 mb-15">
                    <div class="progress progress-skinny">
                        <div class="progress-bar progress-bar-custom-green"
                            role="progressbar"
                            aria-valuenow="{{ $participant->participantInfo->percentToGoal() }}"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            style="width: {{ $participant->participantInfo->percentToGoal() }}%;">
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="row mb-15">
                <div class="col-md-12">
                    <div class="text-16 text-gray text-center">@lang('public.event_date'): {{ date('m/d/Y', strtotime($program->fun_run)) }}</div>
                    @if($program->daysUntilEvent() >= 0)
                        <div class="text-16 text-gray text-center">@lang('public.days_remaining'): {{$program->daysUntilEvent()}}</div>
                    @endif
                </div>
            </div>
            <hr class="mt-4 mb-4"/>
        @endforeach
        <div class="row text-center mb-3">
            <div class="col-md-12">
                <p class="text-12 mt-1 mb-2 text-gray">@lang('public.share_can_raise')</p>
                <button class="facebook-share-btn btn btn-round btn-primary w-100 mw-200px"
                    data-url="{{ $participants->first()->shareFacebookUrl() }}">
                    <span class="mr-1">@lang('public.share_facebook')</span><i class="fa fa-facebook lh-23"></i>
                </button>
            </div>
        </div>
        <div class="text-center">
            <div class="text-14 text-gray">@lang('public.copy_link')</div>
            <input
                type="button"
                class="copy-text btn btn-round btn-outline-primary w-100 mw-200px btn-light"
                data-tooltip="Copied!"
                title="Copied!"
                data-clipboard-text="{{$participants->first()->shareLinkUrl()}}"
                value="{{$participants->first()->shareLinkUrl()}}" />
        </div>
    </div>
</div>
