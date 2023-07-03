@extends($activeTemplate.'layouts.frontend')
@section('content')
    @include($activeTemplate.'partials.authentication')
                        <div class="account-header text-center">
                            <h3 class="title">@lang('Sign in to') {{__($general->site_name)}}</h3>
                        </div>
                        <form class="account-form verify-gcaptcha" method="POST" action="{{ route('user.login')}}">
                            @csrf
                            <div class="row ml-b-20">
                                <div class="form-group">
                                    <label>@lang('Username or email')</label>
                                    <input type="text" class="form-control form--control" name="username" value="{{old('username')}}" required>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Password')</label>
                                    <input type="password" class="form-control form--control" name="password" required>
                                </div>

                                <x-captcha />

                                <div class="form-group d-flex flex-warp justify-content-between">
                                    <div class="form-group custom-check-group">
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label for="remember">@lang('Remember Me')</label>
                                    </div>
                                    <div class="forgot-item">
                                        <label>
                                            <a href="{{route('user.password.request')}}" class="text--base">@lang('Forgot Password')?</a>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="submit-btn w-100">@lang('Login Now')</button>
                                </div>
                                <div class="text-center">
                                    <div class="account-item mt-10">
                                        <label>@lang('Already Have An Account')? <a href="{{ route('user.register') }}" class="text--base">@lang('Register Now')</a></label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
