<div class="modal fade" id="privacyPolicyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('legal.privacy_policy_title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang('legal.privacy_policy_intro')</p>
                <h4>@lang('legal.privacy_visiting_our_website_header')</h4>
                <p>@lang('legal.privacy_visiting_our_website_content')</p>
                <h4>@lang('legal.privacy_children_privacy_protection_header')</h4>
                <p>@lang('legal.privacy_children_privacy_protection_content')</p>
                <h4>@lang('legal.privacy_information_and_how_header')</h4>
                <p>
                    <strong>@lang('legal.privacy_how_we_collect_information')</strong>
                    @lang('legal.privacy_how_we_collect_information_desc')
                </p>
                <p>
                    <strong>@lang('legal.privacy_how_we_use_information')</strong>
                    @lang('legal.privacy_how_we_use_information_desc')
                </p>
                <p class="break-all"><a href="@lang('legal.google_privacy_policy')" target="_blank">@lang('legal.google_privacy_policy')</a></p>
                <p>@lang('legal.privacy_we_may_share')</p>
                @lang('legal.privacy_we_may_share_list')
                <p>@lang('legal.privacy_if_participants_choose_we_may')</p>
                <h4>@lang('legal.privacy_collected_by_third_parties')</h4>
                <p>@lang('legal.privacy_third_party_websites')</p>
                <h4>@lang('legal.privacy_cookies')</h4>
                <p>@lang('legal.privacy_cookie_desc')</p>
                <h4>@lang('legal.privacy_questions_header')</h4>
                <p>
                    <strong>@lang('legal.privacy_questions')</strong>
                    @lang('legal.privacy_if_you_have_questions')
                </p>
                <p>
                    <strong>@lang('legal.privacy_further_information')</strong>
                    @lang('legal.privacy_policy_can_change')
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('general.close')</button>
            </div>
        </div>
    </div>
</div>
