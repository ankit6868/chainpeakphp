<h5 class="menu-header-title">@lang('Basic')</h5>
<ul id="sidebar-main-menu" class="sidebar-main-menu">
    <li class="sidebar-single-menu nav-item {{menuActive('user.inbox*',4)}}">
        <a href="{{ route('user.inbox.list') }}">
            <i class="las la-inbox"></i> <span class="title">@lang('Inbox')</span>
        </a>
    </li>
    <li class="sidebar-single-menu nav-item {{menuActive('user.deposit.index',4)}}">
        <a href="{{ route('user.deposit.index') }}">
            <i class="las la-coins"></i> <span class="title">@lang('Deposit Money')</span>
        </a>
    </li>
    <li class="sidebar-single-menu nav-item {{menuActive('user.deposit.history',4)}}">
        <a href="{{ route('user.deposit.history') }}">
            <i class="las la-arrow-alt-circle-down"></i> <span class="title">@lang('Deposit History')</span>
        </a>
    </li>
    <li class="sidebar-single-menu nav-item {{menuActive('user.withdraw',4)}}">
        <a href="{{ route('user.withdraw') }}">
            <i class="las la-money-check-alt"></i> <span class="title">@lang('Withdraw Money')</span>
        </a>
    </li>
    <li class="sidebar-single-menu nav-item {{menuActive('user.withdraw.history',4)}}">
        <a href="{{ route('user.withdraw.history') }}">
            <i class="las la-arrow-alt-circle-up"></i> <span class="title">@lang('Withdraw History')</span>
        </a>
    </li>
    <li class="sidebar-single-menu nav-item {{menuActive('ticket.open',4)}}">
        <a href="{{ route('ticket.open') }}">
            <i class="las la-plus-circle"></i> <span class="title">@lang('New Ticket')</span>
        </a>
    </li>
    <li class="sidebar-single-menu nav-item {{menuActive('ticket.index',4)}}">
        <a href="{{ route('ticket.index') }}">
            <i class="las la-ticket-alt"></i> <span class="title">@lang('My Tickets')</span>
        </a>
    </li>
    <li class="sidebar-single-menu nav-item {{menuActive('user.transactions',4)}}">
        <a href="{{ route('user.transactions') }}">
            <i class="las la-history"></i> <span class="title">@lang('Transaction History')</span>
        </a>
    </li>
</ul>
