<h4 class="ml-3 text-22 text-gray font-weight-normal">@lang('public.business_leaderboard_header')</h4>
<div class="card theme">
    <div class="card-body">
        <div class="business-leaderboard">
            @if($businessLeaderboard->getPledges()->count())
                @foreach($businessLeaderboard->getPledges() as $pledge)
                    @if($loop->index == 5)
                        <div id="more-businesses" class="collapse">
                    @endif
                    <div class="business-entry">
                        @if(! $loop->first)
                            <hr class="my-2 mb-3">
                        @endif
                        <div class="row">
                            <div class="col-1 text-center mb-1 text-18 text-gray text-nowrap">{{ $loop->index + 1 }}</div>
                            <div class="col-11">
                                <div class="row">
                                    <span class="col-lg-9 mb-1 text-18 text-gray">
                                        @if($pledge->business_website)
                                            <a target="_blank" href="{{$pledge->business_website}}"><u>{{ $pledge->business_name }}</u></a>
                                        @else
                                            {{ $pledge->business_name }}
                                        @endif
                                    </span>
                                    <span class="col-lg-3 mb-1 text-18 text-success fw-500">{{ $pledge->getBusinessLeaderboardAmount() }}</span>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-3 text-14 text-gray" v-pre>{{ ($pledge->show_comment) ? $pledge->comment : '' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($loop->last && $loop->index >= 5)
                        </div>
                    @endif
                @endforeach
            @else
                <div class="business-entry">
                    <div class="row">
                        <div class="offset-1 col-11">
                            <div class="row">
                                <span class="col-lg-9 mb-1 text-18 text-gray">
                                        @lang('public.top_business_pledge')
                                </span>
                                <span class="col-lg-3 mb-1 text-18 text-success fw-500">$0</span>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3 text-14 text-gray">@lang('public.your_note_here')</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @if($businessLeaderboard->getPledges()->count() > 5)
            <div class="toggle-more-businesses">
                <a class="float-right text-muted font-italic" data-toggle="collapse" data-target="#more-businesses" href="#">
                    <span class="collapsed">@lang('public.show_more')</span>
                    <span class="expanded collapse">@lang('public.show_less')</span>
                </a>
            </div>
        @endif()
    </div>
</div>
