<div class="modal fade" id="disputeReasonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Dispute Reason')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="dispute-detail"></div>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        'use strict';

        (function($){
            $('.disputeShow').on('click', function () {
                var modal = $('#disputeReasonModal');
                var feedback = $(this).data('dispute');
                modal.find('.dispute-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

