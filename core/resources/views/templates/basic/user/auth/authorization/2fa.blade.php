@extends($activeTemplate.'layouts.frontend')
@section('content')

    @include($activeTemplate.'partials.authentication')
                        <div class="account-header text-center mb-0">
                            <h3 class="title">@lang('2FA Verification')</h3>
                        </div>

                        <form class="account-form submit-form" method="POST" action="{{route('user.go2fa.verify')}}">
                            @csrf
                            <div class="row ml-b-20">
                                <div class="d-flex justify-content-center">
                                    <div class="verification-code-wrapper">
                                        <div class="verification-area">
                                            @include($activeTemplate.'partials.verification_code')
                                        </div>
                                    </div>
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
