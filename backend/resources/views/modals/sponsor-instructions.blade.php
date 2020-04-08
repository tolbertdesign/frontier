<div class="modal fade" id="sponsorInstructionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content mx-4">
            <div class="modal-body">
                <div class="back-button text-left" role="button" data-dismiss="modal">
                    <span class="text-24"><i class="fas fa-arrow-left"></i></span>
                </div>
                <h4 class="modal-title text-center mb-3 text-40 font-weight-bold">@lang('login.pledge_instruction_header')</h5>
                <p class="mx-4 text-center text-14 mb-5">@lang('login.pledge_instruction')</p>
                <p class="text-center text-14">
                    @lang('login.pledge_instruction_payment')<br>
                    <a href="{{ action('Auth\LoginController@login') }}">@lang('login.pledge_instruction_login')</a>
                </p>
            </div>
        </div>
    </div>
</div>
