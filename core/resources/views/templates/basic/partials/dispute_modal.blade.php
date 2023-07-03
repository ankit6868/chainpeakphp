<div class="modal fade" id="disputeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Dispute')!</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="dispute_type">
                    <div class="form-group">
                        <textarea rows="8" class="form-control" name="reason" placeholder="@lang('Describe Your Dispute Reason')..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--base w-100 h-45">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        'use strict';

        (function($){
            $('.disputeBtn').on('click', function () {
                var modal       = $('#disputeModal');
                var disputeType = $(this).data('type');
                var route       = $(this).data('route');

                modal.find('[name=dispute_type]').val(disputeType);
                modal.find('form').attr('action', route);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
