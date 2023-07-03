@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-area">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="card custom--card">
                        <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                            <h4 class="card-title mb-0">{{__($pageTitle)}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="card-form-wrapper">
                                <form  action="{{route('ticket.store')}}"  method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>@lang('Name')</label>
                                            <input type="text" name="name" value="{{@$user->firstname . ' '.@$user->lastname}}" class="form-control" required readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>@lang('Email Address')</label>
                                            <input type="email"  name="email" value="{{@$user->email}}" class="form-control" required readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>@lang('Subject')</label>
                                            <input type="text" name="subject" value="{{old('subject')}}" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>@lang('Priority')</label>
                                            <select name="priority" class="form-control" required>
                                                <option value="3">@lang('High')</option>
                                                <option value="2">@lang('Medium')</option>
                                                <option value="1">@lang('Low')</option>
                                            </select>
                                        </div>
                                        <div class="col-12 form-group">
                                            <label>@lang('Message')</label>
                                            <textarea name="message" id="inputMessage" rows="6" class="form-control" required>{{old('message')}}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <div class="file-upload">
                                            <label>@lang('Attachments')</label>
                                            <small class="text--danger mb-2">@lang('Max 5 files can be uploaded'). @lang('Maximum upload size is') {{ ini_get('upload_max_filesize') }}</small>
                                            <div class="input-group ticket-input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="attachments[]">
                                                    <label class="custom-file-label">@lang('Choose file')</label>
                                                </div>
                                                <button type="button" class=" addFile input-group-text text-white">
                                                    <i class="las la-plus"></i>
                                                </button>
                                            </div>
                                            <div id="fileUploadsContainer"></div>
                                            <p class="ticket-attachments-message text-muted">
                                                @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                            </p>
                                        </div>
                                    </div>

                                    <button class="submit-btn w-100" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;@lang('Submit')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
    <style>
        .input-group-text:focus{
            box-shadow: none !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";

            var fileAdded = 0;

            $('.addFile').on('click',function() {
                if (fileAdded >= 4) {
                    notify('error','You\'ve added maximum number of file');
                    return false;
                }

                fileAdded++;

                $("#fileUploadsContainer").append(
                    `<div class="input-group ticket-input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="attachments[]" required>
                            <label class="custom-file-label">@lang('Choose file')</label>
                        </div>
                        <button type="button" class="input-group-text remove-btn text-white"><i class="las la-times"></i></button>
                    </div>`);
            });

            $(document).on('click','.remove-btn',function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
