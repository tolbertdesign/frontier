<!-- Modal -->
    <div id="ouibounce-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="privacyPolicyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="removeEvent">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title text-center" id="privacyPolicyModalLabel">
                        {{$participantDisplayNames}} needs you!   
                    </h2>
                    <div class="text-center">
                        @foreach($participants as $participant)
                            @if($participant->profile->imageUrl())
                                <img class="rounded-circle mx-auto" style="width:100px; height: 100px;" src="{{$participant->profile->imageUrl()}}" />
                            @endif
                        @endforeach
                    </div>
                    <p>
                    </p>
                    <h5>
                        {{$participantDisplayNames}} {{$participants->count() > 1 ? 'are' : 'is'}} raising funds for {{$program->microsite->funds_raised_for}}. Will you please help today?
                    </h5>
                    <p>

                    </p>
                    <div class="offset-lg-4 text-center col-lg-4 mb-3 mt-3">
                        <a href="{{ $specialUrl->pledgeProcessUrl() }}" class="btn btn-lg btn-round btn-success w-100 mw-200px">Give Now!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
// Exit intent
function addEvent(obj, evt, fn) {
  if (obj.addEventListener) {
    obj.addEventListener(evt, fn, false);
  } else if (obj.attachEvent) {
    obj.attachEvent("on" + evt, fn);
  }
}

// Exit intent trigger
setTimeout(function() {
    addEvent(document, 'mouseout', function(evt) {
  if (evt.toElement === null && evt.relatedTarget === null && !localStorage.getItem('exitintent_show')) {
    $('#ouibounce-modal').modal('show');
    //localStorage.setItem('exitintent_show', 'true'); // Set the flag in localStorage
  }
}); 
}, 1000);
    </script>
