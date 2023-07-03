<div class="col-xl-3 col-lg-3 mb-30">
    <div class="dashboard-sidebar">
        <button type="button" class="dashboard-sidebar-close"><i class="fas fa-times"></i></button>
        <div class="dashboard-sidebar-inner">
            <div class="dashboard-sidebar-wrapper-inner">
                <h5 class="menu-header-title">@lang('Buyer Account')</h5>
                <ul id="sidebar-main-menu" class="sidebar-main-menu">
                    <li class="sidebar-single-menu nav-item {{menuActive('user.buyer.home',4)}}">
                        <a href="{{route('user.buyer.home')}}">
                            <i class="lab la-buffer"></i> <span class="title">@lang('Buyer Dashboard')</span>
                        </a>
                    </li>
                    <li class="sidebar-single-menu nav-item {{menuActive('user.buyer.job.index',4)}}">
                        <a href="{{route('user.buyer.job.index')}}">
                            <i class="las la-user-secret"></i> <span class="title">@lang('Manage Job')</span>
                        </a>
                    </li>
                    <li class="sidebar-single-menu nav-item {{menuActive('user.buyer.job.new',4)}}">
                        <a href="{{route('user.buyer.job.new')}}">
                            <i class="las la-plus-circle"></i>  <span class="title">@lang('Create Job')</span>
                        </a>
                    </li>
                    <li class="sidebar-single-menu nav-item {{menuActive('user.buyer.favorite.service',4)}}">
                        <a href="{{route('user.buyer.favorite.service')}}">
                            <i class="lab la-gratipay"></i> <span class="title">@lang('Favorite Service')</span>
                        </a>
                    </li>
                    <li class="sidebar-single-menu nav-item {{menuActive('user.buyer.favorite.software',4)}}">
                        <a href="{{route('user.buyer.favorite.software')}}">
                            <i class="las la-heart"></i> <span class="title">@lang('Favorite Software')</span>
                        </a>
                    </li>
                </ul>

                <h5 class="menu-header-title">@lang('Purchase')</h5>
                <ul id="sidebar-main-menu" class="sidebar-main-menu">
                    <li class="sidebar-single-menu nav-item {{menuActive('user.buyer.hiring*',4)}}">
                        <a href="{{route('user.buyer.hiring.list')}}">
                            <i class="las la-user-secret"></i> <span class="title">@lang('Hiring List')</span>
                        </a>
                    </li>
                    <li class="sidebar-single-menu nav-item {{menuActive('user.buyer.booked.*',4)}}">
                        <a href="{{route('user.buyer.booked.services')}}">
                            <i class="las la-taxi"></i> <span class="title">@lang('Bokked Services')</span>
                        </a>
                    </li>
                    <li class="sidebar-single-menu nav-item {{menuActive('user.buyer.software.*',4)}}">
                        <a href="{{route('user.buyer.software.log')}}">
                            <i class="las la-laptop-code"></i> <span class="title">@lang('Software Purchase')</span>
                        </a>
                    </li>
                </ul>

                @include($activeTemplate . 'partials.basic_sidebar')
            </div>
        </div>
    </div>
</div>
