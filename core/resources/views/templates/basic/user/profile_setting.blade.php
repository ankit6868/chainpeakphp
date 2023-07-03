@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <form class="user-profile-form" action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card custom--card">
                <div class="profile-settings-wrapper">
                    <div class="preview-thumb profile-wallpaper">
                        <div class="avatar-preview">
                            <div class="profilePicPreview bg_img" data-background="{{ getImage(getFilePath('userBgImage').'/'.$user->bg_image, getFileSize('userBgImage')) }}"></div>
                        </div>
                        <div class="avatar-edit">
                            <input type='file' class="profilePicUpload" name="bg_image" id="profilePicUpload1" accept=".png, .jpg, .jpeg" />
                            <label for="profilePicUpload1"><i class="las la-cloud-upload-alt me-1"></i> @lang('Update')</label>
                        </div>
                    </div>
                    <div class="profile-thumb-content">
                        <div class="preview-thumb profile-thumb">
                            <div class="avatar-preview">
                                <div class="profilePicPreview bg_img" data-background="{{ getImage(getFilePath('userProfile').'/'.$user->image, getFileSize('userProfile')) }}">
                                </div>
                            </div>
                            <div class="avatar-edit">
                                <input type='file' class="profilePicUpload" name="image" id="profilePicUpload2"
                                    accept=".png, .jpg, .jpeg" />
                                <label for="profilePicUpload2"><i class="las la-pen"></i></label>
                            </div>
                        </div>
                        <div class="profile-content">
                            <h6 class="username">{{__($user->username)}}</h6>
                            <ul class="user-info-list mt-md-2">
                                <li><i class="las la-envelope"></i> {{$user->email}}</li>
                                <li><i class="las la-phone"></i> {{$user->mobile}}</li>
                                <li><i class="las la-map-marked-alt"></i> {{__(@$user->address->country)}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-form-wrapper">
                        <div class="row justify-content-center">
                            <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                <label>@lang('First Name')</label>
                                <input type="text" name="firstname" value="{{__($user->firstname)}}" class="form-control" required>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                <label>@lang('Last Name')</label>
                                <input type="text" name="lastname" value="{{__($user->lastname)}}" class="form-control" required>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                <label>@lang('Designation')</label>
                                <input type="text" name="designation" value="{{__(@$user->designation)}}" class="form-control" required>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                <label>@lang('Address')</label>
                                <input type="text" name="address" value="{{__(@$user->address->address)}}" class="form-control" required>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 form-group">
                                <label>@lang('State')</label>
                                <input type="text" name="state" class="form-control" value="{{__(@$user->address->state)}}" required>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 form-group">
                                <label>@lang('Zip Code')</label>
                                <input type="text" name="zip" class="form-control" value="{{__(@$user->address->zip)}}" required>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 form-group">
                                <label>@lang('City')</label>
                                <input type="text" name="city" class="form-control" value="{{__(@$user->address->city)}}" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('About Me')</label>
                                <textarea class="form-control" name="about_me" rows="5" required>{{__(@$user->about_me)}}</textarea>
                            </div>
                            <div class="col-xl-12">
                                <button type="submit" class="submit-btn mt-20 w-100">@lang('Update Profile')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
    <script>
        "use strict";

        function proPicURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var preview = $(input).parents('.preview-thumb').find('.profilePicPreview');
                    $(preview).css('background-image', 'url(' + e.target.result + ')');
                    $(preview).addClass('has-image');
                    $(preview).hide();
                    $(preview).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".profilePicUpload").on('change', function () {
            proPicURL(this);
        });

        $(".remove-image").on('click', function () {
            $(".profilePicPreview").css('background-image', 'none');
            $(".profilePicPreview").removeClass('has-image');
        })
    </script>
@endpush
