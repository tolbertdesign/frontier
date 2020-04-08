<div class="card">
    <div class="card-body">
        <div class="row position-relative">
            <div class="col-md-12">
                @if($participants->first()->profile->pledge_page_text)
                    <readmore-component class="text-gray text-14"
                        text="{{ $participants->first()->profile->pledge_page_text }}"
                        :limit=5
                        :limit-height=true>
                    </readmore-component>
                @else
                    <readmore-component
                        text="@lang(
                            'public.welcome_default',
                            [
                                'event_name' => $program->event_name,
                                'funrun_date' => date('m/d/y', strtotime($program->fun_run)),
                                'unit_data_name_plural' => $program->unit->name_plural,
                                'funds_raised_for' => $program->microsite->funds_raised_for
                            ]
                        )"
                        :limit=5
                        :limit-height=true>
                    </readmore-component>
                @endif
            </div>
        </div>
    </div>
</div>
