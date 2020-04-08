<div class="modal fade" id="uploadPhotoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content mx-4">
            <div class="modal-body text-center text-gray">
                <div class="back-button text-left" aria-label="Close" data-dismiss="modal"><a href="#" class="text-24 text-gray"><i class="far fa-arrow-left"></i></a></div>
                <h2 class="text-30 fw-300">@lang('register.upload_photo')</h2>
                <p class="text-14 fw-300 pb-4 mw-250px mx-auto">@lang('register.upload_photo_desc')</p>
                <upload-photo-form :lang="{{ json_encode(Lang::get('register'))}}" :ssv-disabled="false"></upload-photo-form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadPhotoModalSsvDisabled" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content mx-4">
            <div class="modal-body text-center text-gray">
                <div class="back-button text-left" aria-label="Close" data-dismiss="modal"><a href="#" class="text-24 text-gray"><i class="far fa-arrow-left"></i></a></div>
                <h2 class="text-30 fw-300">@lang('register.upload_photo')</h2>
                <p class="text-14 fw-300 pb-4 mw-250px mx-auto">@lang('register.upload_photo_desc_disabled_ssv')</p>
                <upload-photo-form :lang="{{ json_encode(Lang::get('register'))}}" :ssv-disabled="true"></upload-photo-form>
            </div>
        </div>
    </div>
</div>
