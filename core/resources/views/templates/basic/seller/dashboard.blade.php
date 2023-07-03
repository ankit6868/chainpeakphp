@extends($activeTemplate.'layouts.master')
@section('content')
<div class="dashboard-section">
    <div class="row justify-content-center gy-4 ">
        <div class="col-12">
            <label>@lang('Referral Link')</label>
            <div class="input-group mb-0">
                <input type="text" value="{{ route('user.register', [auth()->user()->username]) }}" class="form-control value-to-copy" readonly>
                <span class="input-group-text" type="button" id="copyBoard"> <i class="fa fa-copy"></i> </span>
            </div>
        </div>

        @include($activeTemplate . 'partials.kyc_instructions')

        @include($activeTemplate . 'partials.dashboard_widget')

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="dashboard-item bg--danger">
                <a href="{{route('user.seller.service.index')}}" class="dash-btn">@lang('View all')</a>
                <div class="dashboard-icon">
                    <i class="las la-ticket-alt"></i>
                </div>
                <div class="dashboard-content">
                    <div class="num text-white">{{$totalServiceCount}}</div>
                    <h3 class="title text-white">@lang('Total Service')</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="dashboard-item bg--info">
                <a href="{{route('user.seller.software.index')}}" class="dash-btn">@lang('View all')</a>
                <div class="dashboard-icon">
                    <i class="las la-compass"></i>
                </div>
                <div class="dashboard-content">
                    <div class="num text-white">{{$totalSoftwareCount}}</div>
                    <h3 class="title text-white">@lang('Total Software')</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="dashboard-item section--bg">
                <a href="{{route('user.seller.booking.service.list')}}" class="dash-btn">@lang('View all')</a>
                <div class="dashboard-icon">
                    <i class="las la-cart-arrow-down"></i>
                </div>
                <div class="dashboard-content">
                    <div class="num text-white">{{$totalServiceBooking}}</div>
                    <h3 class="title text-white">@lang('Total Service Booking')</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="dashboard-item bg--warning">
                <a href="{{route('user.seller.sale.software.log')}}" class="dash-btn">@lang('View all')</a>
                <div class="dashboard-icon">
                    <i class="las la-shopping-bag"></i>
                </div>
                <div class="dashboard-content">
                    <div class="num text-white">{{$totalSoftwareSales}}</div>
                    <h3 class="title text-white">@lang('Total Software Sales')</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="dashboard-item bg--success">
                <a href="{{route('user.withdraw.history')}}" class="dash-btn">@lang('View all')</a>
                <div class="dashboard-icon">
                    <i class="las la-ticket-alt"></i>
                </div>
                <div class="dashboard-content">
                    <div class="num text-white">{{$general->cur_sym}}{{showAmount($totalWithdrawalAmount)}}</div>
                    <h3 class="title text-white">@lang('Total Withdrawal')</h3>
                </div>
            </div>
        </div>
        <div class="col-12">
            @include($activeTemplate.'partials.transaction')
        </div>
    </div>
</div>
@endsection
@include($activeTemplate . 'partials.copy')
