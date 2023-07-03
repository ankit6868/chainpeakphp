<div class="widget">
    <div class="profile-widget">
        <div class="profile-widget-header">
            <div class="profile-widget-thumb">
                <img src="{{ getImage(getFilePath('userBgImage').'/'.$productDetails->user->bg_image, getFileSize('userBgImage')) }}" alt="@lang('User image')">
            </div>
            <div class="profile-widget-author">
                <div class="thumb">
                    <img src="{{ getImage(getFilePath('userProfile').'/'.$productDetails->user->image, getFileSize('userProfile')) }}" alt="{{__($productDetails->user->username)}}">
                </div>
                <div class="content">
                    <h4 class="name">
                        <a href="{{route('public.profile', $productDetails->user->username)}}">{{__($productDetails->user->username)}}</a>
                    </h4>
                    <span class="designation">{{__(@$productDetails->user->designation)}}</span>
                </div>
            </div>
            <div class="profile-widget-author-meta mb-10-none">
                <div class="location mb-10">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{__(@$productDetails->user->address->country)}}</span>
                </div>
                <div class="btn-area mb-10">
                    <a href="{{route('public.profile', $productDetails->user->username)}}" class="btn--base">@lang('View Profile')</a>
                </div>
            </div>
        </div>
        <div class="profile-list-area">
            <ul class="details-list">
                <li><span>@lang('Total Service')</span> <span>{{$productDetails->user->services()->active()->count()}}</span></li>
                <li><span>@lang('Total Software')</span> <span>{{$productDetails->user->softwares()->active()->count()}}</span></li>
                <li><span>@lang('Inprogress Job(s)')</span> <span>{{__($productDetails->user->jobBids()->inprogress()->count())}}</span></li>
                <li>
                    <span>@lang('Rating')</span>
                    <span>
                        <span class="ratings">@php echo starRating($productDetails->user->total_review, $productDetails->user->total_rating) @endphp</span>
                        ({{$productDetails->user->total_review}})
                    </span>
                </li>
                <li><span>@lang('Member Since')</span> <span>{{showDateTime($productDetails->user->created_at, 'd M Y')}}</span></li>
                <li><span>@lang('Level')</span> <span class="text--base">{{__($productDetails->user->level->name)}}</span></li>
                <li><span>@lang('User Verified')</span>
                    @if($productDetails->user->kv == Status::KYC_VERIFIED)
                        <span class="badge badge--success">@lang('Yes')</span>
                    @else
                        <span class="badge badge--danger">@lang('No')</span>
                    @endif
                </li>
                <li><span>@lang('Mobile Verified')</span>
                    @if($productDetails->user->sv)
                        <span class="badge badge--success">@lang('Yes')</span>
                    @else
                        <span class="badge badge--danger">@lang('No')</span>
                    @endif
                </li>
                <li><span>@lang('Email Verified')</span>
                    @if($productDetails->user->ev)
                        <span class="badge badge--success">@lang('Yes')</span>
                    @else
                        <span class="badge badge--danger">@lang('No')</span>
                    @endif
                </li>
            </ul>
            <div class="widget-btn mt-20">
                <a href="{{route('public.profile', $productDetails->user->username)}}" class="btn btn--base w-100 h-45">@lang('Hire Me')</a>
            </div>
        </div>
    </div>
</div>



