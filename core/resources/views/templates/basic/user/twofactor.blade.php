@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-area">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-6 mb-30">
                    <div class="card custom--card">
                        <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                            <h4 class="card-title mb-0">@lang('Two Factor Authenticator')</h4>
                        </div>
                        <div class="card-body">
                            <p>@lang('Use the QR code or setup key on your Google Authenticator app to add your account.')</p>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="key" value="{{$secret}}" class="form-control value-to-copy" readonly>
                                    <span class="input-group-text" type="button" id="copyBoard"> <i
                                            class="fa fa-copy"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group mx-auto text-center">
                                <img class="mx-auto" src="{{$qrCodeUrl}}">
                            </div>

                            <label><i class="fa fa-info-circle"></i> @lang('Help')</label>
                            <p>@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.') <a class="text--base" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('Download')</a></p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 mb-30">
                    <div class="card custom--card">
                        @if(auth()->user()->ts)
                            <div class="card-header">
                                <h5 class="card-title">@lang('Disable 2FA Security')</h5>
                            </div>
                            <form action="{{route('user.twofactor.disable')}}" method="POST">
                                @csrf
                        @else
                            <div class="card-header">
                                <h5 class="card-title">@lang('Enable 2FA Security')</h5>
                            </div>
                            <form action="{{ route('user.twofactor.enable') }}" method="POST">
                                @csrf
                        @endif
                            <div class="card-body">
                                <input type="hidden" name="key" value="{{$secret}}">
                                <div class="form-group">
                                    <label>@lang('Google Authenticatior OTP')</label>
                                    <input type="text" class="form-control" name="code" required>
                                </div>
                                <button type="submit" class="submit-btn w-100">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include($activeTemplate . 'partials.copy')
