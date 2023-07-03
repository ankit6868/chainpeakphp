@php
    $kycContent = getContent('kyc_instructions.content', true);
@endphp

@if( (auth()->user()->kv == Status::KYC_UNVERIFIED) || (auth()->user()->kv == Status::KYC_PENDING) )
<div class="col-xl-12">
    @if(auth()->user()->kv == Status::KYC_UNVERIFIED)
        <div class="alert alert-info mb-0" role="alert">
            <h4 class="alert-heading">@lang('KYC Verification required')</h4>
            <hr>
            <p class="mb-0">{{__(@$kycContent->data_values->for_verification)}}</p>
            <br>
            <a href="{{ route('user.kyc.form') }}" class="btn--base">@lang('Click here to verify')</a>
        </div>
    @elseif(auth()->user()->kv == Status::KYC_PENDING)
        <div class="alert alert-warning mb-0" role="alert">
            <h4 class="alert-heading">@lang('KYC Verification pending')</h4>
            <hr>
            <p class="mb-0">{{__(@$kycContent->data_values->for_pending)}}</p>
            <br>
            <a href="{{ route('user.kyc.data') }}" class="btn--base">@lang('See KYC data')</a>
        </div>
    @endif
</div>
@endif
