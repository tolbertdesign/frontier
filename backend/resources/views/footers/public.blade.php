<div class="py-4 text-center w-full bg-gray text-gray-lighter">
    <div>
        <a class="text-gray-lighter text-white-hover" href="{{ secure_url('/help') }}"><u>@lang('public.need_help')</u></a>
    </div>
    <div class="my-2">
        <a href="{{ config('external_links.sponsor_survey_url') }}" class="btn btn-round btn-primary">@lang('public.share_feedback')</a>
    </div>
    <div>
        @lang('public.booster_footer')
    </div>
    <div>
        &copy; Booster 2018 | <a class="text-gray-lighter text-white-hover" href="#" data-toggle="modal" data-target="#privacyPolicyModal"><u>@lang('public.privacy_policy')</u></a> |
        <span><div class="fb-like" data-href="https://www.facebook.com/Boosterthon" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div></span><span class="text-gray-lighter ml-1">@lang('public.us_facebook')</span>
    </div>
    @include('modals.privacy_policy')

</div>
