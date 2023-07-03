@php $admin=auth()->guard('admin')->user(); @endphp
<div class="sidebar bg--dark">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{route('admin.dashboard')}}" class="sidebar__main-logo"><img src="{{getImage(getFilePath('logoIcon') .'/logo_dark.png')}}" alt="@lang('image')"></a>
        </div>
        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                @if ($admin->access('Manage Dashboard'))
                <li class="sidebar-menu-item {{menuActive('admin.dashboard')}}">
                    <a href="{{route('admin.dashboard')}}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('Dashboard')</span>
                    </a>
                </li>
                @endif

                @if ($admin->access('Manage Service Booking'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.booking.service*',3)}}">
                        <i class="menu-icon las la-taxi"></i>
                        <span class="menu-title">@lang('Service Booking')</span>

                        @if(($pendingServiceBookingCount || $disputedServiceBookingCount) > 0)
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.booking.service*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.booking.service.pending')}} ">
                                <a href="{{route('admin.booking.service.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending')</span>

                                    @if($pendingServiceBookingCount > 0)
                                        <span class="menu-badge pill bg--danger ms-auto">{{$pendingServiceBookingCount}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.booking.service.completed')}} ">
                                <a href="{{route('admin.booking.service.completed')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Completed')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.booking.service.delivered')}} ">
                                <a href="{{route('admin.booking.service.delivered')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Delivered')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.booking.service.inprogress')}} ">
                                <a href="{{route('admin.booking.service.inprogress')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Inprogress')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.booking.service.disputed')}} ">
                                <a href="{{route('admin.booking.service.disputed')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Reported')</span>

                                    @if($disputedServiceBookingCount > 0)
                                        <span class="menu-badge pill bg--danger ms-auto">{{$disputedServiceBookingCount}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.booking.service.refunded')}} ">
                                <a href="{{route('admin.booking.service.refunded')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Refunded')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.booking.service.expired')}} ">
                                <a href="{{route('admin.booking.service.expired')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Expired')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                @if ($admin->access('Manage Job Bidding'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.hiring.job*',3)}}">
                        <i class="menu-icon las la-user-secret"></i>
                        <span class="menu-title">@lang('Job Bidding')</span>

                        @if(($disputedJobBookingCount) > 0)
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>

                    <div class="sidebar-submenu {{menuActive('admin.hiring.job*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.hiring.job.completed')}} ">
                                <a href="{{route('admin.hiring.job.completed')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Completed')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.hiring.job.delivered')}} ">
                                <a href="{{route('admin.hiring.job.delivered')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Delivered')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.hiring.job.inprogress')}} ">
                                <a href="{{route('admin.hiring.job.inprogress')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Inprogress')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.hiring.job.disputed')}} ">
                                <a href="{{route('admin.hiring.job.disputed')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Reported')</span>

                                    @if($disputedJobBookingCount > 0)
                                        <span class="menu-badge pill bg--danger ms-auto">{{$disputedJobBookingCount}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.hiring.job.canceled')}} ">
                                <a href="{{route('admin.hiring.job.canceled')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Canceled')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.hiring.job.expired')}} ">
                                <a href="{{route('admin.hiring.job.expired')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Expired')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                @if ($admin->access('Manage Software Sales'))
                <li class="sidebar-menu-item {{menuActive('admin.sales.software.log')}}">
                    <a href="{{route('admin.sales.software.log')}}" class="nav-link">
                        <i class="menu-icon las la-laptop-code"></i>
                        <span class="menu-title">@lang('Software Sales')</span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage Users'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.users*',3)}}">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title">@lang('Manage Users')</span>

                        @if($bannedUsersCount > 0 || $emailUnverifiedUsersCount > 0 || $mobileUnverifiedUsersCount > 0 || $kycUnverifiedUsersCount > 0 || $kycPendingUsersCount > 0)
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.users*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.users.active')}} ">
                                <a href="{{route('admin.users.active')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Active Users')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.users.banned')}} ">
                                <a href="{{route('admin.users.banned')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Banned Users')</span>
                                    @if($bannedUsersCount)
                                        <span class="menu-badge pill bg--danger ms-auto">{{$bannedUsersCount}}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item  {{menuActive('admin.users.email.unverified')}}">
                                <a href="{{route('admin.users.email.unverified')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email Unverified')</span>

                                    @if($emailUnverifiedUsersCount)
                                        <span class="menu-badge pill bg--danger ms-auto">{{$emailUnverifiedUsersCount}}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.users.mobile.unverified')}}">
                                <a href="{{route('admin.users.mobile.unverified')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Mobile Unverified')</span>
                                    @if($mobileUnverifiedUsersCount)
                                        <span
                                            class="menu-badge pill bg--danger ms-auto">{{$mobileUnverifiedUsersCount}}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.users.kyc.unverified')}}">
                                <a href="{{route('admin.users.kyc.unverified')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('KYC Unverified')</span>
                                    @if($kycUnverifiedUsersCount)
                                        <span class="menu-badge pill bg--danger ms-auto">{{$kycUnverifiedUsersCount}}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.users.kyc.pending')}}">
                                <a href="{{route('admin.users.kyc.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('KYC Pending')</span>
                                    @if($kycPendingUsersCount)
                                        <span class="menu-badge pill bg--danger ms-auto">{{$kycPendingUsersCount}}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.users.with.balance')}}">
                                <a href="{{route('admin.users.with.balance')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('With Balance')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.users.all')}} ">
                                <a href="{{route('admin.users.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Users')</span>
                                </a>
                            </li>


                            <li class="sidebar-menu-item {{menuActive('admin.users.notification.all')}}">
                                <a href="{{route('admin.users.notification.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Notification to All')</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                @endif
                @if ($admin->access('Manage Service'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.service*',3)}}">
                        <i class="menu-icon las la-taxi"></i>
                        <span class="menu-title">@lang('Manage Service')</span>
                        @if($pendingServiceCount > 0)
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.service*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.service.pending')}} ">
                                <a href="{{route('admin.service.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending')</span>

                                    @if($pendingServiceCount > 0)
                                        <span class="menu-badge pill bg--danger ms-auto">{{$pendingServiceCount}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.service.approved')}} ">
                                <a href="{{route('admin.service.approved')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Approved')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.service.canceled')}} ">
                                <a href="{{route('admin.service.canceled')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Canceled')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.service.closed')}} ">
                                <a href="{{route('admin.service.closed')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Closed')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.service.all')}} ">
                                <a href="{{route('admin.service.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                @if ($admin->access('Manage Job'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.job*',3)}}">
                        <i class="menu-icon las la-user-secret"></i>
                        <span class="menu-title">@lang('Manage Job')</span>

                        @if($pendingJobCount > 0)
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.job*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.job.pending')}} ">
                                <a href="{{route('admin.job.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending')</span>

                                    @if($pendingJobCount > 0)
                                        <span class="menu-badge pill bg--danger ms-auto">{{$pendingJobCount}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.job.approved')}} ">
                                <a href="{{route('admin.job.approved')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Approved')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.job.canceled')}} ">
                                <a href="{{route('admin.job.canceled')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Canceled')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.job.closed')}} ">
                                <a href="{{route('admin.job.closed')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Closed')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.job.all')}} ">
                                <a href="{{route('admin.job.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                @if ($admin->access('Manage Software'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.software*',3)}}">
                        <i class="menu-icon las la-laptop-code"></i>
                        <span class="menu-title">@lang('Manage Software')</span>

                        @if($pendingSoftwareCount > 0)
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.software*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.software.pending')}} ">
                                <a href="{{route('admin.software.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending')</span>

                                    @if($pendingSoftwareCount > 0)
                                        <span class="menu-badge pill bg--danger ms-auto">{{$pendingSoftwareCount}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.software.approved')}} ">
                                <a href="{{route('admin.software.approved')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Approved')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.software.canceled')}} ">
                                <a href="{{route('admin.software.canceled')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Canceled')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.software.closed')}} ">
                                <a href="{{route('admin.software.closed')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Closed')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.software.all')}} ">
                                <a href="{{route('admin.software.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                @if ($admin->access('Manage Gateway'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.gateway*',3)}}">
                        <i class="menu-icon las la-credit-card"></i>
                        <span class="menu-title">@lang('Payment Gateways')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.gateway*',2)}} ">
                        <ul>

                            <li class="sidebar-menu-item {{menuActive('admin.gateway.automatic.*')}} ">
                                <a href="{{route('admin.gateway.automatic.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Automatic Gateways')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.gateway.manual.*')}} ">
                                <a href="{{route('admin.gateway.manual.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Manual Gateways')</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                @endif
                @if ($admin->access('Manage Deposit'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.deposit*',3)}}">
                        <i class="menu-icon las la-file-invoice-dollar"></i>
                        <span class="menu-title">@lang('Deposits')</span>
                        @if(0 < $pendingDepositsCount)
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.deposit*',2)}} ">
                        <ul>

                            <li class="sidebar-menu-item {{menuActive('admin.deposit.pending')}} ">
                                <a href="{{route('admin.deposit.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending Deposits')</span>
                                    @if($pendingDepositsCount)
                                        <span class="menu-badge pill bg--danger ms-auto">{{$pendingDepositsCount}}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.deposit.approved')}} ">
                                <a href="{{route('admin.deposit.approved')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Approved Deposits')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.deposit.successful')}} ">
                                <a href="{{route('admin.deposit.successful')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Successful Deposits')</span>
                                </a>
                            </li>


                            <li class="sidebar-menu-item {{menuActive('admin.deposit.rejected')}} ">
                                <a href="{{route('admin.deposit.rejected')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Rejected Deposits')</span>
                                </a>
                            </li>


                            <li class="sidebar-menu-item {{menuActive('admin.deposit.initiated')}} ">

                                <a href="{{route('admin.deposit.initiated')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Initiated Deposits')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.deposit.list')}} ">
                                <a href="{{route('admin.deposit.list')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Deposits')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                @if ($admin->access('Manage Payment'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.payment*',3)}}">
                        <i class="menu-icon las la-user-secret"></i>
                        <span class="menu-title">@lang('Payment Pending')</span>
                        @if(($paymentPendingServiceCount || $paymentPendingSoftwareCount) > 0)
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.payment.pending*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.payment.pending.service')}} ">
                                <a href="{{route('admin.payment.pending.service')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Service')</span>

                                    @if($paymentPendingServiceCount > 0)
                                        <span class="menu-badge pill bg--danger ms-auto">{{$paymentPendingServiceCount}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.payment.pending.software')}} ">
                                <a href="{{route('admin.payment.pending.software')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Software')</span>

                                    @if($paymentPendingSoftwareCount > 0)
                                        <span class="menu-badge pill bg--danger ms-auto">{{$paymentPendingSoftwareCount}}</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                @if ($admin->access('Manage Withdraw'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.withdraw*',3)}}">
                        <i class="menu-icon la la-bank"></i>
                        <span class="menu-title">@lang('Withdrawals') </span>
                        @if(0 < $pendingWithdrawCount)
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.withdraw*',2)}} ">
                        <ul>

                            <li class="sidebar-menu-item {{menuActive('admin.withdraw.method.*')}}">
                                <a href="{{route('admin.withdraw.method.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Withdrawal Methods')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.withdraw.pending')}} ">
                                <a href="{{route('admin.withdraw.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending Withdrawals')</span>

                                    @if($pendingWithdrawCount)
                                        <span class="menu-badge pill bg--danger ms-auto">{{$pendingWithdrawCount}}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.withdraw.approved')}} ">
                                <a href="{{route('admin.withdraw.approved')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Approved Withdrawals')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.withdraw.rejected')}} ">
                                <a href="{{route('admin.withdraw.rejected')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Rejected Withdrawals')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.withdraw.log')}} ">
                                <a href="{{route('admin.withdraw.log')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Withdrawals')</span>
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>
                @endif
                @if ($admin->access('Manage Support Ticket'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.ticket*',3)}}">
                        <i class="menu-icon la la-ticket"></i>
                        <span class="menu-title">@lang('Support Ticket') </span>
                        @if(0 < $pendingTicketCount)
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.ticket*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.ticket.pending')}} ">
                                <a href="{{route('admin.ticket.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending Ticket')</span>
                                    @if($pendingTicketCount)
                                    <span
                                    class="menu-badge pill bg--danger ms-auto">{{$pendingTicketCount}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.ticket.closed')}} ">
                                <a href="{{route('admin.ticket.closed')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Closed Ticket')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.ticket.answered')}} ">
                                <a href="{{route('admin.ticket.answered')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Answered Ticket')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.ticket.index')}} ">
                                <a href="{{route('admin.ticket.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Ticket')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                @if ($admin->access('Manage Report'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.report*',3)}}">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title">@lang('Report') </span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.report*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive(['admin.report.transaction','admin.report.transaction.search'])}}">
                                <a href="{{route('admin.report.transaction')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Transaction Log')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive(['admin.report.login.history','admin.report.login.ipHistory'])}}">
                                <a href="{{route('admin.report.login.history')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Login History')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.report.notification.history')}}">
                                <a href="{{route('admin.report.notification.history')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Notification History')</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                @endif
                @if ($admin->access('Manage Subscriber'))
                <li class="sidebar-menu-item  {{menuActive('admin.subscriber.*')}}">
                    <a href="{{route('admin.subscriber.index')}}" class="nav-link"
                       data-default-url="{{ route('admin.subscriber.index') }}">
                        <i class="menu-icon las la-thumbs-up"></i>
                        <span class="menu-title">@lang('Subscribers') </span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage Staff'))
                <li class="sidebar-menu-item  {{menuActive('admin.staff.*')}}">
                    <a href="{{route('admin.staff.index')}}" class="nav-link"
                       data-default-url="{{ route('admin.staff.index') }}">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title">@lang('Manage Staff') </span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage Category') || $admin->access('Manage Subcategory') || $admin->access('Manage Feature') || $admin->access('Manage Advertisement') || $admin->access('Manage Level') || $admin->access('Manage Coupon') )
                <li class="sidebar__menu-header">@lang('BASIC')</li>
                @endif
                @if ($admin->access('Manage Category'))
                <li class="sidebar-menu-item {{menuActive('admin.category*')}}">
                    <a href="{{route('admin.category.index')}}" class="nav-link ">
                        <i class="menu-icon las la-list"></i>
                        <span class="menu-title">@lang('Manage Categories')</span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage Subcategory'))
                <li class="sidebar-menu-item {{menuActive('admin.subcategory*')}}">
                    <a href="{{route('admin.subcategory.index')}}" class="nav-link ">
                        <i class="menu-icon las la-list"></i>
                        <span class="menu-title">@lang('Manage Subcategories')</span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage Feature'))
                <li class="sidebar-menu-item {{menuActive('admin.feature*')}}">
                    <a href="{{route('admin.feature.index')}}" class="nav-link ">
                        <i class="menu-icon las la-bolt"></i>
                        <span class="menu-title">@lang('Manage Features')</span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage Advertisement'))
                <li class="sidebar-menu-item {{menuActive('admin.advertisement*')}}">
                    <a href="{{route('admin.advertisement.index')}}" class="nav-link ">
                        <i class="menu-icon las la-ad"></i>
                        <span class="menu-title">@lang('Manage Advertisement')</span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage Level'))
                <li class="sidebar-menu-item {{menuActive('admin.level*')}}">
                    <a href="{{route('admin.level.index')}}" class="nav-link ">
                        <i class="menu-icon lab la-hackerrank"></i>
                        <span class="menu-title">@lang('Manage Level')</span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage Coupon'))
                <li class="sidebar-menu-item {{menuActive('admin.coupon*')}}">
                    <a href="{{route('admin.coupon.index')}}" class="nav-link ">
                        <i class="menu-icon las la-percentage"></i>
                        <span class="menu-title">@lang('Manage Coupon')</span>
                    </a>
                </li>
                @endif

                @if ($admin->access('Manage General Setting') || $admin->access('Manage System Configuration') || $admin->access('Manage Logo And Favicon') || $admin->access('Manage Extension') || $admin->access("Manage SEO Manager" || $admin->access("Manage KYC Setting") || $admin->access("Manage Notification Setting") || $admin->access("Manage Template") || $admin->access('Manage Frontend Section')))
                <li class="sidebar__menu-header">@lang('Settings')</li>
                @endif

                @if ($admin->access('Manage General Setting'))
                <li class="sidebar-menu-item {{menuActive('admin.setting.index')}}">
                    <a href="{{route('admin.setting.index')}}" class="nav-link">
                        <i class="menu-icon las la-life-ring"></i>
                        <span class="menu-title">@lang('General Setting')</span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage System Configuration'))
                <li class="sidebar-menu-item {{menuActive('admin.setting.system.configuration')}}">
                    <a href="{{route('admin.setting.system.configuration')}}" class="nav-link">
                        <i class="menu-icon las la-cog"></i>
                        <span class="menu-title">@lang('System Configuration')</span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage Logo And Favicon'))
                <li class="sidebar-menu-item {{menuActive('admin.setting.logo.icon')}}">
                    <a href="{{route('admin.setting.logo.icon')}}" class="nav-link">
                        <i class="menu-icon las la-images"></i>
                        <span class="menu-title">@lang('Logo & Favicon')</span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage Extension'))
                <li class="sidebar-menu-item {{menuActive('admin.extensions.index')}}">
                    <a href="{{route('admin.extensions.index')}}" class="nav-link">
                        <i class="menu-icon las la-cogs"></i>
                        <span class="menu-title">@lang('Extensions')</span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage Language'))
                <li class="sidebar-menu-item  {{menuActive(['admin.language.manage','admin.language.key'])}}">
                    <a href="{{route('admin.language.manage')}}" class="nav-link"
                       data-default-url="{{ route('admin.language.manage') }}">
                        <i class="menu-icon las la-language"></i>
                        <span class="menu-title">@lang('Language') </span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage SEO Manager'))
                <li class="sidebar-menu-item {{menuActive('admin.seo')}}">
                    <a href="{{route('admin.seo')}}" class="nav-link">
                        <i class="menu-icon las la-globe"></i>
                        <span class="menu-title">@lang('SEO Manager')</span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage KYC Setting'))
                <li class="sidebar-menu-item {{menuActive('admin.kyc.setting')}}">
                    <a href="{{route('admin.kyc.setting')}}" class="nav-link">
                        <i class="menu-icon las la-user-check"></i>
                        <span class="menu-title">@lang('KYC Setting')</span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage Notification Setting'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.setting.notification*',3)}}">
                        <i class="menu-icon las la-bell"></i>
                        <span class="menu-title">@lang('Notification Setting')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.setting.notification*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.setting.notification.global')}} ">
                                <a href="{{route('admin.setting.notification.global')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Global Template')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.setting.notification.email')}} ">
                                <a href="{{route('admin.setting.notification.email')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email Setting')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.setting.notification.sms')}} ">
                                <a href="{{route('admin.setting.notification.sms')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('SMS Setting')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.setting.notification.templates')}} ">
                                <a href="{{route('admin.setting.notification.templates')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Notification Templates')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                @if ($admin->access('Manage Frontend Section') || $admin->access('Manage Template') || $admin->access('Manage Maintenance Mode') || $admin->access('Manage GDPR Cookie'))
                <li class="sidebar__menu-header">@lang('Frontend Manager')</li>
                @endif

                @if ($admin->access('Manage Template'))
                <li class="sidebar-menu-item {{menuActive('admin.frontend.templates')}}">
                    <a href="{{route('admin.frontend.templates')}}" class="nav-link ">
                        <i class="menu-icon la la-html5"></i>
                        <span class="menu-title">@lang('Manage Templates')</span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage Frontend Section'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.frontend.sections*',3)}}">
                        <i class="menu-icon la la-puzzle-piece"></i>
                        <span class="menu-title">@lang('Manage Section')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.frontend.sections*',2)}} ">
                        <ul>
                            @php
                               $lastSegment =  collect(request()->segments())->last();
                            @endphp
                            @foreach(getPageSections(true) as $k => $secs)
                                @if($secs['builder'])
                                    <li class="sidebar-menu-item  @if($lastSegment == $k) active @endif ">
                                        <a href="{{ route('admin.frontend.sections',$k) }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">{{__($secs['name'])}}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </li>
                @endif

                @if ($admin->access("Others") || $admin->access('Manage Maintenance Mode') ||  $admin->access('Manage GDPR Cookie'))
                <li class="sidebar__menu-header">@lang('Extra')</li>
                @endif
                @if ($admin->access('Manage Maintenance Mode'))
                <li class="sidebar-menu-item {{menuActive('admin.maintenance.mode')}}">
                    <a href="{{route('admin.maintenance.mode')}}" class="nav-link">
                        <i class="menu-icon las la-robot"></i>
                        <span class="menu-title">@lang('Maintenance Mode')</span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Manage GDPR Cookie'))
                <li class="sidebar-menu-item {{menuActive('admin.setting.cookie')}}">
                    <a href="{{route('admin.setting.cookie')}}" class="nav-link">
                        <i class="menu-icon las la-cookie-bite"></i>
                        <span class="menu-title">@lang('GDPR Cookie')</span>
                    </a>
                </li>
                @endif
                @if ($admin->access('Others'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.system*',3)}}">
                        <i class="menu-icon la la-server"></i>
                        <span class="menu-title">@lang('System')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.system*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.system.info')}} ">
                                <a href="{{route('admin.system.info')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Application')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.system.server.info')}} ">
                                <a href="{{route('admin.system.server.info')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Server')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.system.optimize')}} ">
                                <a href="{{route('admin.system.optimize')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Cache')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-menu-item {{menuActive('admin.setting.custom.css')}}">
                    <a href="{{route('admin.setting.custom.css')}}" class="nav-link">
                        <i class="menu-icon lab la-css3-alt"></i>
                        <span class="menu-title">@lang('Custom CSS')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item  {{menuActive('admin.request.report')}}">
                    <a href="{{route('admin.request.report')}}" class="nav-link"
                       data-default-url="{{ route('admin.request.report') }}">
                        <i class="menu-icon las la-bug"></i>
                        <span class="menu-title">@lang('Report & Request') </span>
                    </a>
                </li>
                @endif
            </ul>
            <div class="text-center mb-3 text-uppercase">
                <span class="text--primary">{{__(systemDetails()['name'])}}</span>
                <span class="text--success">@lang('V'){{systemDetails()['version']}} </span>
            </div>
        </div>
    </div>
</div>
<!-- sidebar end -->

@push('script')
    <script>
        if($('li').hasClass('active')){
            $('#sidebar__menuWrapper').animate({
                scrollTop: eval($(".active").offset().top - 320)
            },500);
        }
    </script>
@endpush
