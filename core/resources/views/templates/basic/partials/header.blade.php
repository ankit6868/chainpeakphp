<header class="header-section">
    <div class="header">
        <div class="header-bottom-area">
            <div class="container-fluid">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-lg p-0">
                        <a class="site-logo site-title" href="{{route('home')}}"><img src="{{ getImage('assets/images/logoIcon/logo.png') }}"></a>
                        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>
                        <button type="button" class="short-menu-open-btn"><i class="fas fa-align-center"></i></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu ms-auto me-auto">
                                <li><a href="{{route('home')}}" class="{{menuActive('home')}}">@lang('HOME')</a></li>
                                <li><a href="{{route('service')}}" class="{{menuActive('service')}}">@lang('SERVICE')</a></li>
                                <li><a href="{{route('software')}}" class="{{menuActive('software')}}">@lang('SOFTWARE')</a></li>
                                <li><a href="{{route('job')}}" class="{{menuActive('job')}}">@lang('JOB')</a></li>

                                @if (request()->routeIs('user*') && auth()->check() || request()->routeIs('ticket*') && auth()->check())
                                    <li><a href="{{route('user.seller.home')}}" class="{{menuActive('user.seller*')}}">@lang('SELLER')</a></li>
                                    <li><a href="{{route('user.buyer.home')}}" class="{{menuActive('user.buyer*')}}">@lang('BUYER')</a></li>
                                    <li><a href="{{ route('user.inbox.list') }}" class="{{menuActive('user.inbox*')}}">@lang('INBOX')</a></li>
                                    <li><a href="{{route('ticket.index')}}" class="{{menuActive('ticket*')}}">@lang('SUPPORT')</a></li>

                                @else
                                    <li><a href="{{route('blogs')}}">@lang('BLOGS')</a></li>
                                    <li><a href="{{route('contact')}}" class="{{menuActive('contact')}}">@lang('CONTACT')</a></li>
                                @endif
                            </ul>
                            @if ($general->multi_language)

                            <div class="language-select-area">
                                <select class="language-select langSel">
                                    @foreach ($language as $item)
                                        <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>
                                            {{ __($item->name) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @if (request()->routeIs('user*') && auth()->check() || request()->routeIs('ticket*') && auth()->check())
                                <div class="header-right dropdown">
                                    <button type="button" data-bs-toggle="dropdown" data-display="static" aria-haspopup="true"
                                        aria-expanded="false">
                                        <div class="header-user-area d-flex flex-wrap align-items-center justify-content-between">
                                            <div class="header-user-thumb">
                                                <a href="JavaScript:Void(0);"><img src="{{getImage(getFilePath('userProfile').'/'.auth()->user()->image,getFileSize('userProfile'))}}" alt="client"></a>
                                            </div>
                                            <div class="header-user-content">
                                                <span>@lang('Account')</span>
                                            </div>
                                            <span class="header-user-icon"><i class="las la-chevron-circle-down"></i></span>
                                        </div>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu--sm p-0 border-0 dropdown-menu-right">
                                        <a href="{{route('user.seller.home')}}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                            <i class="dropdown-menu__icon lab la-buffer"></i>
                                            <span class="dropdown-menu__caption">@lang('Dashboard')</span>
                                        </a>
                                        <a href="{{route('user.change.password')}}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                            <i class="dropdown-menu__icon las la-key"></i>
                                            <span class="dropdown-menu__caption">@lang('Change Password')</span>
                                        </a>
                                        <a href="{{route('user.profile.setting')}}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                            <i class="dropdown-menu__icon las la-user-circle"></i>
                                            <span class="dropdown-menu__caption">@lang('Profile Settings')</span>
                                        </a>
                                        <a href="{{route('user.twofactor')}}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                            <i class="dropdown-menu__icon las la-shield-alt"></i>
                                            <span class="dropdown-menu__caption">@lang('2FA Security')</span>
                                        </a>
                                        <a href="{{route('user.logout')}}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                            <i class="dropdown-menu__icon las la-sign-out-alt"></i>
                                            <span class="dropdown-menu__caption">@lang('Logout')</span>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="header-action">
                                    @auth
                                        <a href="{{route('user.home')}}" class="btn btn--base">@lang('Dashboard')</a>
                                        <a href="{{route('user.logout')}}" class="btn btn--base">@lang('Logout')</a>
                                    @else
                                        <a href="{{route('user.login')}}" class="btn btn--base">@lang('Sign In')</a>
                                        <a href="{{route('user.register')}}" class="btn btn--base">@lang('Sign Up')</a>
                                    @endauth
                                </div>
                            @endif
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="header-short-menu">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="short-menu">
                            <li class="short-menu-close-btn-area"> <button type="button" class="short-menu-close-btn">@lang('Close')</button></li>
                            @foreach ($categories as $category)
                                <li><a href="{{route('by.category', [slug($category->name), $category->id])}}">{{__($category->name)}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
