<div class="col-xl-3 col-lg-3 mb-30">
    <div class="dashboard-sidebar">
        <button type="button" class="dashboard-sidebar-close"><i class="fas fa-times"></i></button>
        <div class="dashboard-sidebar-inner">
            <div class="dashboard-sidebar-wrapper-inner">
                <h5 class="menu-header-title">@lang('Seller Account')</h5>
                <ul id="sidebar-main-menu" class="sidebar-main-menu">
                    <li class="sidebar-single-menu nav-item {{menuActive('user.seller.home',4)}}">
                        <a href="{{route('user.seller.home')}}">
                            <i class="lab la-buffer"></i> <span class="title">@lang('Seller Dashboard')</span>
                        </a>
                    </li>
                    <li class="sidebar-single-menu nav-item {{menuActive('user.seller.service.new',4)}}">
                        <a href="{{route('user.seller.service.new')}}">
                            <i class="las la-plus-circle"></i> <span class="title">@lang('Create Service')</span>
                        </a>
                    </li>
                    <li class="sidebar-single-menu nav-item {{menuActive('user.seller.service.index',4)}}">
                        <a href="{{route('user.seller.service.index')}}">
                            <i class="las la-taxi"></i> <span class="title">@lang('Manage Services')</span>
                        </a>
                    </li>
                    <li class="sidebar-single-menu nav-item {{menuActive('user.seller.software.index',4)}}">
                        <a href="{{route('user.seller.software.index')}}">
                            <i class="las la-laptop-code"></i> <span class="title">@lang('Manage Software')</span>
                        </a>
                    </li>
                    <li class="sidebar-single-menu nav-item {{menuActive('user.seller.software.new',4)}}">
                        <a href="{{route('user.seller.software.new')}}">
                            <i class="las la-plus-circle"></i> <span class="title">@lang('Upload Software')</span>
                        </a>
                    </li>
                </ul>
                <h5 class="menu-header-title">@lang('Sales')</h5>
                <ul id="sidebar-main-menu" class="sidebar-main-menu">
                    <li class="sidebar-single-menu nav-item {{menuActive('user.seller.booking.service*',4)}}">
                        <a href="{{route('user.seller.booking.service.list')}}">
                            <i class="las la-taxi"></i> <span class="title">@lang('Service Booking')</span>
                        </a>
                    </li>
                    <li class="sidebar-single-menu nav-item {{menuActive('user.seller.sale.software.log',4)}}">
                        <a href="{{route('user.seller.sale.software.log')}}">
                            <i class="las la-laptop-code"></i> <span class="title">@lang('Software Sales')</span>
                        </a>
                    </li>
                    <li class="sidebar-single-menu nav-item {{menuActive('user.seller.job.*',4)}}">
                        <a href="{{route('user.seller.job.list')}}">
                            <i class="las la-user-secret"></i> <span class="title">@lang('Job List')</span>
                        </a>
                    </li>
                </ul>

                @include($activeTemplate . 'partials.basic_sidebar')
            </div>
        </div>
    </div>
</div>
