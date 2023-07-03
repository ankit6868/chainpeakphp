<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">@lang('Start new conversation')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('user.inbox.create')}}" method="POST">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{encrypt($user->id)}}">
                    <div class="form-group">
                        <label for="subject" class="fw-bold">@lang('Subject')</label>
                        <input type="text" class="form-control" name="subject" placeholder="@lang('Enter Subject')" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="message" class="fw-bold">@lang('Message')</label>
                        <textarea rows="5" class="form-control" name="message" maxlength="500" placeholder="@lang('Enter Message')" required></textarea>
                    </div>
                    <button type="submit" class="btn btn--base w-100 h-45">@lang('Submit')</button>
                </form>
            </div>
        </div>
    </div>
</div>
