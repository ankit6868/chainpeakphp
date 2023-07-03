@extends($activeTemplate.'layouts.frontend')
@section('content')

    @include($activeTemplate.'partials.authentication')
                        <div class="account-header text-center">
                            <h3 class="title">{{ __($pageTitle) }}</h3>
                        </div>
                        <form class="account-form" method="POST" action="{{ route('user.password.email') }}">
                            @csrf
                            <div class="row ml-b-20">
                                <div class="form-group">
                                    <label>@lang('Username or email')</label>
                                    <input type="text" class="form-control form--control" name="value" value="{{ old('value') }}" required autofocus="off">
                                </div>

                                <x-captcha />

                                <button type="submit" class="submit-btn w-100">@lang('Submit')</button>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
