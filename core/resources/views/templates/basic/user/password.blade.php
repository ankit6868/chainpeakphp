@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-area">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="card custom--card">
                        <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                            <h4 class="card-title mb-0">@lang('Change Password')</h4>
                        </div>
                        <div class="card-body">
                            <div class="card-form-wrapper">
                                <form action="" method="POST">
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="form-group">
                                            <input type="password" name="current_password" class="form-control" placeholder="@lang('Current Password')" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control" placeholder="@lang('New Password')" required>
                                            @include($activeTemplate.'partials.secure_password')
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="@lang('Confirm Password')" required>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="submit-btn w-100">@lang('Change Password')</button>
                                        </div>
                                    </div>
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
