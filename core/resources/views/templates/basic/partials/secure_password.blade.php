@if($general->secure_password)
    <div class="input-popup">
    <p class="error lower">@lang('1 small letter minimum')</p>
    <p class="error capital">@lang('1 capital letter minimum')</p>
    <p class="error number">@lang('1 number minimum')</p>
    <p class="error special">@lang('1 special character minimum')</p>
    <p class="error minimum">@lang('6 character password')</p>
    </div>
@endif

@if($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
