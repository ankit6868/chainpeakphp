<div class="item-card">
    <div class="item-card-thumb">
        <img src="{{getImage('assets/images/job/'.$job->image,getFileSize('job')) }}" alt="@lang('Job Image')">
    </div>
    <div class="item-card-content">
        <div class="item-card-content-top">
            <div class="left">
                <div class="author-thumb">
                    <img src="{{ getImage(getFilePath('userProfile').'/'.$job->user->image, getFileSize('userProfile')) }}" alt="@lang('Job Image')">
                </div>
                <div class="author-content">
                    <h5 class="name">
                        <a href="{{route('public.profile', $job->user->username)}}">{{$job->user->username}}</a> <span class="level-text">{{__($job->user->level->name)}}</span>
                    </h5>
                </div>
            </div>
            <div class="right">
                <div class="item-amount">{{$general->cur_sym}}{{showAmount($job->price)}}</div>
            </div>
        </div>
        <div class="item-tags order-3">
            @foreach($job->skill as $skill)
                <a href="javascript:void(0)">{{__($skill)}}</a>
            @endforeach
        </div>
        <h3 class="item-card-title">
            <a href="{{route('job.details', [slug($job->name), $job->id])}}">{{__($job->name)}}</a>
        </h3>
    </div>
    <div class="item-card-footer">
        <div class="left">
            <button class="btn--base active date-btn">{{__($job->delivery_time)}} @lang('Days')</button>
            <span class="btn--base bid-btn">@lang('Total Bids')({{$job->total_bid}})</span>
        </div>
        <div class="right">
            <div class="order-btn">
                <a href="{{route('job.details', [slug($job->name), $job->id])}}" class="btn--base"><i class="las la-shopping-cart"></i> @lang('Bid Now')</a>
            </div>
        </div>
    </div>
</div>
