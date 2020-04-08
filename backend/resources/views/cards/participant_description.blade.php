<div class="card">
    <div class="card-body">
        @include('carousels.welcome')
        <br/>
        <div class="row position-relative">
            <div class="col-md-6">
                <div class="d-md-block d-none">
                    @include('carousels.welcome_title')
                    <hr/>
                </div>
                @if($participants->first()->profile->pledge_page_text)
                    @if (str_replace($participants->first()->profile->pledge_page_text, ' ', '')  === '<p></p>' || $participants->first()->profile->pledge_page_text === '') 
                        <readmore-component class="text-gray text-14"
                            text="@lang(
                                'public.default_pledge_page_message',
                                [
                                    'funds_raised_for' => $program->microsite->funds_raised_for,
                                    'event_date' => date('m/d/y', strtotime($program->fun_run)),
                                    'unit_type' => $program->unit->name_plural,
                                    'event_name' => $program->event_name,
                                    'link' => $specialUrl->pledgeProcessUrl()
                                ]
                            )"
                            :limit=5
                            :limit-height=true>
                        </readmore-component>
                    @else
                        <readmore-component class="text-gray text-14"
                            text="{{ $participants->first()->profile->pledge_page_text }}"
                            :limit=5
                            :limit-height=true>
                        </readmore-component>
                    @endif
                @else
                    <readmore-component
                        text="@lang(
                            'public.welcome_default',
                            [
                                'event_name' => $program->event_name,
                                'funrun_date' => date('m/d/y', strtotime($program->fun_run)),
                                'unit_data_name_plural' => $program->unit->name_plural,
                                'funds_raised_for' => $program->microsite->funds_raised_for,
                                'link' => $specialUrl->pledgeProcessUrl()
                            ]
                        )"
                        link="{{ $specialUrl->pledgeProcessUrl() }}"
                        :limit=5
                        :limit-height=true>
                    </readmore-component>
                @endif
            </div>
            <div class="col-md-6 border-left d-md-block d-none vertical-stretch position-absolute absolute-right overflow-y-scroll">
                <ul class="list-group pl-0">
                    @foreach($welcomeVideos->getAllPublic() as $video)
                        <li data-slide-to="{{ $loop->index }}"
                            data-target="#welcomeCarousel"
                            class="media list-group-item-action {{ $loop->last ? '' : 'mb-2' }}">
                            <div data-slide-to="{{ $loop->index }}"
                                data-target="#welcomeCarouselTitle"
                                class="media list-group-item-action position-relative">
                                <div class="w-40">
                                    @if ($video->source == 'youtube')
                                        <img id="video_{{ $video->hash }}"
                                            src="https://img.youtube.com/vi/{{ $video->hash }}/mqdefault.jpg"
                                            class="card-img-top"
                                            alt="{{ $video->description }}" />
                                    @elseif ($video->source == 'jwplayer')
                                        <img id="video_{{ $video->hash }}"
                                            class="card-img-top"
                                            src="https://content.jwplatform.com/thumbs/{{ $video->hash }}-320.jpg"
                                            alt="{{ $video->description }}" />
                                    @elseif ($video->source == 'vimeo')
                                        <vimeo-thumbnail hash="{{$video->hash}}"></vimeo-thumbnail>
                                    @else
                                        <img id="video_{{ $video->hash }}"
                                            class="card-img-top"
                                            src="{{ secure_asset('/v3-assets/public/images/default_video_thumbnail.jpg') }}" />
                                    @endif
                                </div>
                                <div class="w-60 l-40 px-1 ellipsis centered-child text-gray text-14">
                                    {{ $video->description }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
