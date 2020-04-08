<div class="footer mx-auto">
    @if( !config('privacy.hideCookiePolicy') )
        <div id="cookiePolicy" class="bg-lt-gray mb-0 text-12 text-center text-gray cookie-policy position-relative py-2 show">
            <p class="px-5 my-0">@lang('legal.cookie_policy_banner') <a data-toggle="modal" data-target="#privacyPolicyModal" href="#" class="text-gray font-weight-bold"><u>@lang('legal.cookie_policy_link_text')</u></a></p>
            <i data-toggle="collapse" aria-expanded="true" data-target="#cookiePolicy" class="fas fa-times"></i>
        </div>
    @endif
    <div class="resources pt-8px pb-3">
        <p class="text-10 mb-0">
            <span><a class="text-blackwhite" href="https://funrun.boosterthon.com/help">@lang('login.need_help')</a></span>
            <span class="text-blackwhite">|</span>
            <span><a class="text-blackwhite" target="_blank" data-share="Spanish Help Landing Page" data-category="Spanish Pdf Guide" href="https://s3.amazonaws.com/funrun-prod/assets/pdf/spanish_guide_2017.pdf">@lang('login.espanol')</a></span>
            <span class="text-blackwhite">|</span>
            <span><a class="text-blackwhite" data-toggle="modal" data-target="#privacyPolicyModal" href="#">@lang('login.privacy_policy')</a></span>
        </p>
    </div>
</div>
