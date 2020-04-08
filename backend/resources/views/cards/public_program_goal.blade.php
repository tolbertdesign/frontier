<h4 class="ml-3 text-22 text-gray font-weight-normal">@lang('public.our_goal_header')</h4>
<div class="card theme">
    <div class="card-body">

        <div class="row mb-15">
            <div class="col-md-6">

                @if($program->microsite->fundsRaisedVideoUrl())
                    <!--STUB: Display our goal video. -->
                @else
                    @include('carousels.our_goal')
                @endif

            </div>

            <div class="{{ ($program->microsite->fundsRaisedImageUrls()->count() > 0 || $program->microsite->fundsRaisedVideoUrl()) ? 'col-md-6' : 'col-md-12' }}">
                <div class="text-right align-items-baseline">
                    @if($program->clientFlatTotal() < $program->client_goal)
                        <span class="text-16 text-gray">@lang('public.school_goal'): ${{ number_format($program->client_goal, 0) }}</span>
                    @endif
                </div>
                @if($program->clientFlatTotal() < $program->client_goal)
                    <div class="progress progress-skinny mb-15">
                        <div class="progress-bar progress-bar-custom-green" role="progressbar" aria-valuenow="{{ $program->percentToGoal() }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $program->percentToGoal() }}%;">
                            <span class="sr-only">{{ $program->percentToGoal() }}% @lang('public.complete')</span>
                        </div>
                    </div>
                @endif
                <div class="mb-15 text-sm">
                    <div class="text-12 text-16 text-gray"><span class="fw-500">@lang('public.event_date'): </span>{{ date('m/d/Y', strtotime($program->fun_run)) }}</div>
                    @if($program->daysUntilEvent() > 0)
                        <div class="mb-15 text-16 text-gray"><span class="fw-500">@lang('public.days_remaining'): </span> {{ $program->daysUntilEvent() }}</div>
                    @endif
                    @if($program->microsite->funds_raised_for)
                        <div><p class="text-14 text-gray">@lang('public.funds_for') {!! $program->microsite->funds_raised_for !!}</p></div>
                    @endif
                </div>
            </div>
        </div><!-- end .row -->
    </div>
</div>
