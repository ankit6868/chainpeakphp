@extends($activeTemplate.'layouts.master')
@section('content')
<div class="dashboard-section">
    <div class="row justify-content-center gy-3">

        @include($activeTemplate . 'partials.referral')
        @include($activeTemplate . 'partials.kyc_instructions')
        @include($activeTemplate . 'partials.dashboard_widget')

        <div class="col-lg-4 col-md-6 ">
            <div class="dashboard-item bg--danger">
                <a href="{{route('user.transactions')}}" class="dash-btn">@lang('View all')</a>
                <div class="dashboard-icon">
                    <i class="las la-wallet"></i>
                </div>
                <div class="dashboard-content">
                    <div class="num text-white">{{$totalTrxCount}}</div>
                    <h3 class="title text-white">@lang('Total Transactions')</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 ">
            <div class="dashboard-item bg--info">
                <a href="{{route('user.buyer.job.index')}}" class="dash-btn">@lang('View all')</a>
                <div class="dashboard-icon">
                    <i class="las la-user-secret"></i>
                </div>
                <div class="dashboard-content">
                    <div class="num text-white">{{$totalJobCount}}</div>
                    <h3 class="title text-white">@lang('Total Job')</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 ">
            <div class="dashboard-item bg--warning">
                <a href="{{route('user.buyer.booked.services')}}" class="dash-btn">@lang('View all')</a>
                <div class="dashboard-icon">
                <i class="las la-shopping-bag"></i>
                </div>
                <div class="dashboard-content">
                    <div class="num text-white">{{$totalBookedService}}</div>
                    <h3 class="title text-white">@lang('Total Service Booked')</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 ">
            <div class="dashboard-item bg--success">
                <a href="{{route('user.buyer.software.log')}}" class="dash-btn">@lang('View all')</a>
                <div class="dashboard-icon">
                    <i class="las la-cart-arrow-down"></i>
                </div>
                <div class="dashboard-content">
                    <div class="num text-white">{{$totalPurchasedSoftware}}</div>
                    <h3 class="title text-white">@lang('Total Purchase Software')</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 ">
            <div class="dashboard-item section--bg">
                <a href="{{route('user.buyer.hiring.list')}}" class="dash-btn">@lang('View all')</a>
                <div class="dashboard-icon">
                <i class="lab la-hire-a-helper"></i>
                </div>
                <div class="dashboard-content">
                    <div class="num text-white">{{$totalHiredEmployee}}</div>
                    <h3 class="title text-white">@lang('Total Hire Employees')</h3>
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
