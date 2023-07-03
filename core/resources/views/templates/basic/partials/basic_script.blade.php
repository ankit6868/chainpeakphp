@push('style')
    <style>
        .select2Tag input{
            background-color: transparent !important;
            padding: 0 !important;
        }
    </style>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{asset('assets/global/css/select2.min.css')}}">
@endpush

@push('script-lib')
<script src="{{asset('assets/global/js/select2.min.js')}}"></script>
 <script src="{{ asset('assets/global/js/nicEdit.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";
        $('.addExtraImage').on('click',function() {
            var html = `<div class="custom-file-wrapper removeImage">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="extra_image[]" name="avatar" id="customFile" accept=".png, .jpg, .jpeg" required>
                                <label class="custom-file-label" for="customFile">@lang('Choose file')</label>
                            </div>
                            <button class="btn btn--danger text-white border--rounded removeExtraImage"><i class="fa fa-times"></i></button>
                        </div>`;
            $('.addImage').append(html);
        });

        $('.addExtra').on('click', function () {
            var html = `<div class="col-lg-12 extraServiceRemove">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" name="extra_name[]" maxlength="255" class="form-control" placeholder="@lang("Enter service name")" required>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-group mb-3">
                                        <input type="number" step="any" class="form-control" name="extra_price[]" placeholder="@lang('Enter Price')" required>
                                        <span class="input-group-text">{{__($general->cur_text)}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn--danger text-white border--rounded btn-sm removeBtn">
                                        @lang('Remove')
                                    </button>
                                </div>
                            </div>
                        </div>`;
            $('.addExtraService').append(html);
        });

        (function($){
            bkLib.onDomLoaded(function() {
                $( ".nicEdit" ).each(function( index ) {
                    $(this).attr("id","nicEditor"+index);
                    new nicEditor({fullPanel : true}).panelInstance('nicEditor'+index,{hasPanel : true});
                });
            });

            $(document).on("change",".custom-file-input",function(){
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            $(document).on('click', '.removeExtraImage', function (){
                $(this).closest('.removeImage').remove();
            });

            $(document).on('click', '.removeBtn', function () {
                $(this).closest('.extraServiceRemove').remove();
            });

            $( document ).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain',function(){
                $('.nicEdit-main').focus();
            });

            $('.select2').select2({
                tags: true
            });

        })(jQuery);
    </script>
@endpush
