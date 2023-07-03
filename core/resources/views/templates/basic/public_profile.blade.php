@extends($activeTemplate.'layouts.frontend')
@section('content')
    @php
        $forLoadMoreReviewId = $user->id;
    @endphp
    <section class="all-sections pt-60 pb-60">
        <div class="container-fluid p-max-sm-0">
            <div class="sections-wrapper d-flex flex-wrap justify-content-center">
                <article class="main-section">
                    <div class="section-inner">
                        <div class="item-section item-overview-section">
                            <div class="container">
                                <div class="row justify-content-center mb-30-none">
                                    <div class="col-xl-3 col-lg-3 mb-30">
                                        <div class="sidebar">
                                            <div class="widget mb-30">
                                                <div class="profile-widget">
                                                    <div class="profile-widget-header">
                                                        <div class="profile-widget-thumb">
                                                            <img src="{{ getImage(getFilePath('userBgImage').'/'.$user->bg_image, getFileSize('userBgImage')) }}" alt="item-banner">
                                                            <a href="#0">
                                                                <span class="badge-follow bg--success">@lang('Follow to work')</span>
                                                            </a>
                                                        </div>
                                                        <div class="profile-widget-author">
                                                            <div class="thumb">
                                                                <img src="{{ getImage(getFilePath('userProfile').'/'.$user->image, getFileSize('userProfile')) }}" alt="{{__($user->username)}}">
                                                            </div>
                                                            <div class="content">
                                                                <h4 class="name"><span>{{__($user->username)}}</span></h4>
                                                                <span class="designation">{{@$user->designation}}</span>
                                                                <div class="ratings">
                                                                    <span>
                                                                        @php echo starRating($user->total_review, $user->total_rating) @endphp
                                                                        {{$user->total_review}} ({{$user->total_review}} @lang('reviews'))
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="profile-list-area">
                                                        <ul class="details-list">
                                                            <li><span>@lang('Total Service')</span> <span>{{$user->services()->active()->count()}}</span></li>
                                                            <li><span>@lang('Total Software')</span> <span>{{$user->softwares()->active()->count()}}</span></li>
                                                            <li><span>@lang('Inprogress Job(s)')</span> <span>{{__($user->jobBids()->inprogress()->count())}}</span></li>
                                                            <li><span>@lang('Completed Job(s)')</span> <span>{{__($user->jobBids()->completed()->count())}}</span></li>
                                                            <li><span>@lang('Pending Job(s)')</span> <span>{{__($user->jobBids->where('status', Status::BOOKING_PENDING)->count())}}</span></li>
                                                            <li><span>@lang('Country')</span> <span>{{@$user->address->country}}</span></li>
                                                            <li><span>@lang('Member since')</span> <span>{{showDateTime($user->created_at, 'd M Y')}}</span></li>
                                                            <li>
                                                                <span>@lang('Level')</span>
                                                                <span class="text--base">{{__($user->level->name)}}</span>
                                                            </li>
                                                            <li>
                                                                <span>@lang('User Verified')</span>
                                                                @if($user->kv == 1)
                                                                    <span class="badge badge--success">@lang('Yes')</span>
                                                                @else
                                                                    <span class="badge badge--danger">@lang('No')</span>
                                                                @endif
                                                            </li>
                                                            <li>
                                                                <span>@lang('Mobile Verified')</span>
                                                                @if($user->sv)
                                                                    <span class="badge badge--success">@lang('Yes')</span>
                                                                @else
                                                                    <span class="badge badge--danger">@lang('No')</span>
                                                                @endif
                                                            </li>
                                                            <li>
                                                                <span>@lang('Email Verified')</span>
                                                                @if($user->ev)
                                                                    <span class="badge badge--success">@lang('Yes')</span>
                                                                @else
                                                                    <span class="badge badge--danger">@lang('No')</span>
                                                                @endif
                                                            </li>
                                                        </ul>
                                                        <div class="widget-btn mt-20">
                                                            @auth
                                                                <button data-bs-toggle="modal" data-bs-target="#contactModal" class="btn--base w-100">@lang('Contact Now')</button>
                                                            @else
                                                                <a href="{{route('user.login')}}" class="btn--base w-100">@lang('Contact Now')</a>
                                                            @endguest
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget custom-widget mb-30">
                                                <h3 class="widget-title">@lang('About Me')</h3>
                                                <p>{{__(@$user->about_me)}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-9 col-lg-9 mb-30">
                                        <div class="item-details-area">
                                            @include($activeTemplate.'partials.basic_card')

                                            <div class="product-reviews-content mt-40">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="section-header">
                                                            <h2 class="section-title">@lang('Reviews')</h2>
                                                        </div>
                                                        @include($activeTemplate.'partials.reviews')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    @include($activeTemplate.'partials.contact_modal')
@endsection
