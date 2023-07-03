<div class="modal fade" id="workModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ModalLabel">@lang('Work Delivery')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="work_type">
                    <div class="form-group">
                        <label class="form-label fw-bold">@lang('Upload Work File')</label>
                        <input class="form-control form-control-lg" name="file" type="file" accept=".zip" required>
                    </div>
                    <div class="form-group">
                        <textarea rows="8" class="form-control" name="details" placeholder="@lang('Describe Your Delivery Details')..." required></textarea>
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
            $('.workUploadBtn').on('click', function () {
                var modal    = $('#workModal');
                var route    = $(this).data('route');
                var workType = $(this).data('worktype');

                modal.find('[name=work_type]').val(workType);
                modal.find('form').attr('action', route);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
