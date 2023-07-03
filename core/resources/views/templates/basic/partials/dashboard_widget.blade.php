<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
    <div class="dashboard-item bg--primary">
        <a href="{{route('user.transactions')}}" class="dash-btn">@lang('View all')</a>
        <div class="dashboard-icon">
            <i class="las la-wallet"></i>
        </div>
        <div class="dashboard-content">
            <div class="num text-white">{{ $general->cur_sym }}{{showAmount(auth()->user()->balance)}}</div>
            <h3 class="title text-white">@lang('Current Balance')</h3>
        </div>
    </div>
</div>
