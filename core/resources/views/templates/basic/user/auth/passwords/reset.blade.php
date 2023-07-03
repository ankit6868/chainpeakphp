@extends($activeTemplate.'layouts.frontend')
@section('content')

    @include($activeTemplate.'partials.authentication')
                        <div class="account-header text-center">
                            <h3 class="title">@lang('Reset Password')</h3>
                            <p>@lang('Your account is verified successfully. Now you can change your password.')</p>
                        </div>

                        <form class="account-form" method="POST" action="{{ route('user.password.update') }}">
                            @csrf

                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="row ml-b-20">
                                <div class="form-group">
                                    <label>@lang('Password')</label>
                                    <input type="password" class="form-control form--control" name="password" required>
                                    @include($activeTemplate.'partials.secure_password')
                                </div>

                                <div class="form-group">
                                    <label>@lang('Confirm Password')</label>
                                    <input type="password" class="form-control form--control" name="password_confirmation" required>
                                </div>
                                <button type="submit" class="submit-btn w-100">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
