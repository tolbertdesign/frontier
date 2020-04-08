<h4 class="ml-3 text-22 text-gray font-weight-normal">@lang('public.supporting_sponsors_header')</h4>
<div class="card theme">
    <div class="card-body">
        <div class="business-leaderboard">
            @foreach($sponsorLeaderboard->getPledges() as $pledge)
                @if($loop->index == 4)
                    <div id="more-sponsors" class="collapse more-sponsors">
                @endif
                <div class="business-entry">
                    @if(! $loop->first)
                        <hr class="my-2 mb-3">
                    @endif
                    <div class="row">
                        <span class="col-lg-12 mb-1 text-18 text-gray">
                            @if($pledge->anon == 0)
                                {{ $pledge->pledgeSponsor->first_name }} {{ $pledge->pledgeSponsor->last_name }}
                            @else
                                Anonymous
                            @endif
                        </span>
                        <span class="col-lg-12 mb-1 text-18 text-success fw-500">{{ $pledge->getFlatAmountOrRange() }} - {{ $pledge->participantUser->first_name }}</span>
                        <div class="col-12 mb-3 text-14 text-gray" v-pre>{{ ($pledge->show_comment) ? $pledge->comment : '' }}</div>
                    </div>
                </div>
                @if($loop->last && $loop->index >= 4)
                    </div>
                @endif
            @endforeach
        </div>

        @if($sponsorLeaderboard->getPledges()->count() > 4)
            <a id="smile" class="float-right text-muted font-italic" data-toggle="collapse" data-target=".more-sponsors" href="#">
                <span class="collapsed">@lang('public.show_more')</span>
                <span class="expanded collapse">@lang('public.show_less')</span>
            </a>
        @endif()
    </div>
</div>
