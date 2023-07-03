@extends($activeTemplate.'layouts.frontend')
@section('content')

    @include($activeTemplate.'partials.authentication')
                        <div class="account-header text-center mb-0">
                            <h3 class="title">@lang('Verify Your Email')</h3>
                            <p>@lang('A 6 digit verification code sent to your email address') :  {{ showEmailAddress(auth()->user()->email) }}</p>
                        </div>

                        <form class="account-form submit-form" method="POST" action="{{ route('user.verify.email') }}">
                            @csrf

                            <div class="row ml-b-20">
                                <div class="d-flex justify-content-center">
                                    <div class="verification-code-wrapper">
                                        <div class="verification-area">
                                            @include($activeTemplate.'partials.verification_code')
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="submit-btn w-100">@lang('Submit')</button>
                                </div>

                                <div class="form-group">
                                    @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                    <a href="{{route('user.send.verify.code', 'email')}}" class="text--base">@lang('Try to send again')</a>

                                    @if($errors->has('resend'))
                                        <br><small class="text--danger d-block">{{ $errors->first('resend') }}</small>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


