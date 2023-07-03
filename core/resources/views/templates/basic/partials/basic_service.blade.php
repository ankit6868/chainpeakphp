<div class="item-card">
    <div class="item-card-thumb">
        <img src="{{ getImage(getFilePath('service').'/'.$service->image, getFileSize('service')) }}" alt="@lang('Service Image')">
        @if($service->featured)
            <div class="item-level">@lang('Featured')</div>
        @endif
    </div>
    <div class="item-card-content">
        <div class="item-card-content-top">
            <div class="left">
                <div class="author-thumb">
                    <img src="{{ getImage(getFilePath('userProfile').'/'.$service->user->image, getFileSize('userProfile')) }}" alt="{{__($service->user->username)}}">
                </div>
                <div class="author-content">
                    <h5 class="name"><a href="{{route('public.profile', $service->user->username)}}">{{__($service->user->username)}}</a> <span class="level-text">
                        {{__($service->user->level->name)}}</span>
                    </h5>
                    <div class="ratings">
                        @php echo starRating($service->total_review, $service->total_rating) @endphp
                        <span class="rating me-2">({{$service->total_review}})</span>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="item-amount">{{$general->cur_sym}}{{showAmount($service->price)}}</div>
            </div>
        </div>
        <h3 class="item-card-title">
            <a href="{{route('service.details', [slug($service->name), $service->id])}}">{{__($service->name)}}</a>
        </h3>
    </div>
    <div class="item-card-footer">
        <div class="left">
            <button class="item-love me-2 make-favorite" data-id="{{$service->id}}" data-type="service">
                <i class="fas fa-heart"></i>
                <span class="favorite-count">({{__($service->favorite)}})</span>
            </button>

            <button class="item-like"><i class="las la-thumbs-up"></i> ({{$service->likes}})</button>
        </div>
        <div class="right">
            <div class="order-btn">
                <a href="{{route('user.service.booking.form', [slug($service->name), $service->id])}}" class="btn--base"><i class="las la-shopping-cart"></i> @lang('Order Now')</a>
            </div>
        </div>
    </div>
</div>
