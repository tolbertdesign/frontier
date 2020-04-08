<h4 class="ml-3 text-22 text-gray font-weight-normal">@lang('public.program_desc_header')</h4>
<div class="card theme program-overview">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 clearfix text-14 text-gray">
                @if ($program->microsite->overview_text_override)
                    <readmore-component
                        text="{{$program->microsite->overview_text_override}}"
                        :limit="319"
                        class="readmore-wrapper">
                    </readmore-component>
                @else
                    <readmore-component
                        text="@lang(
                            'public.program_info_default',
                            [
                                'event_name' => $program->event_name,
                                'unit_plural' => $program->unit->name_plural,
                            ]
                        )"
                        :limit="319"
                        class="readmore-wrapper">
                    </readmore-component>
                @endif
            </div>
        </div><!-- end .row -->
        <div class="row">
            <div class="offset-lg-4 text-center col-lg-4 mb-3 mt-3">
                <a href="{{ $specialUrl->pledgeProcessUrl() }}" class="btn btn-lg btn-round btn-success w-100 mw-200px">@lang('public.enter_pledge')</a>
            </div>
        </div><!-- end .row -->
        <div class="row">
            <div class="offset-lg-2 col-lg-4 text-center">
                <p class="text-gray text-12 mt-1 mb-1 lh-22">@lang('public.share_can_raise')</p>
                <button class="facebook-share-btn btn btn-round btn-primary w-100 mw-200px"
                    data-url="{{ $participants->first()->shareFacebookUrl() }}">
                    <span class="float-left">@lang('public.share_facebook')</span><i class="fa fa-facebook float-right leading-normal mr-2"></i>
                </button>
            </div>
            <div class="col-lg-4 text-center">
                <p class="mb-1 mt-1 text-14 text-gray">@lang('public.copy_link')</p>
                <input
                    type="button"
                    class="copy-text btn btn-round btn-outline-primary w-100 mw-200px"
                    data-tooltip="Copied!"
                    title="Copied!"
                    data-clipboard-text="{{ $participants->first()->shareLinkUrl() }}"
                    value="{{ $participants->first()->shareLinkUrl() }}" />
            </div>
        </div>
    </div>
</div>
