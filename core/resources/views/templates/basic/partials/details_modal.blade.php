<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Details')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="details"></div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        'use strict';

        (function($){
            $('.detailsBtn').on('click', function () {
                var modal   = $('#detailsModal');
                var details = $(this).data('details');

                modal.find('.details').html(`<p> ${details} </p>`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
