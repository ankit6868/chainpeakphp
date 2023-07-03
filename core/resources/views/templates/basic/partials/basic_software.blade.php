<div class="item-card">
    <div class="item-card-thumb">
        <img src="{{getImage('assets/images/software/'.$software->image,getFileSize('software')) }}" alt="@lang('item-software')">
    </div>
    <div class="item-card-content">
        <div class="item-card-content-top">
            <div class="left">
                <div class="author-thumb">
                    <img src="{{ getImage(getFilePath('userProfile').'/'.$software->user->image, getFileSize('userProfile')) }}" alt="@lang('Software Image')">
                </div>
                <div class="author-content">
                    <h5 class="name"><a href="{{route('public.profile', $software->user->username)}}">{{__($software->user->username)}}</a> <span class="level-text">{{__($software->user->level->name)}}</span></h5>
                    <div class="ratings">
                        @php echo starRating($software->total_review, $software->total_rating) @endphp
                        <span class="rating me-2">({{$software->total_review}})</span>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="item-amount">{{$general->cur_sym}}{{showAmount($software->price)}}</div>
            </div>
        </div>
        <h3 class="item-card-title">
            <a href="{{route('software.details', [slug($software->name), $software->id])}}">{{__($software->name)}}</a>
        </h3>
    </div>
    <div class="item-card-footer">
        <div class="left">
            <button class="item-love me-2 make-favorite" data-id="{{$software->id}}" data-type="software">
                <i class="fas fa-heart"></i>
                <span class="favorite-count">({{__($software->favorite)}})</span>
            </button>
            <button class="item-like"><i class="las la-thumbs-up"></i> ({{__($software->likes)}})</button>
            <a href="{{route('user.software.confirm.booking', [slug($software->name), $software->id])}}" class="btn--base active buy-btn"><i class="las la-shopping-cart"></i> @lang('Buy Now')</a>
        </div>
        <div class="right">
            <div class="order-btn">
                <a href="{{$software->demo_url}}" target="__blank" class="btn--base"><i class="las la-desktop"></i> @lang('Preview')</a>
            </div>
        </div>
    </div>
</div>
