<li class="comment-container review-comment d-flex align-items-center justify-content-between">
     <div class="comment-inner d-flex flex-wrap">
        <div class="comment-avatar">
            <img src="{{ getImage(getFilePath('userProfile').'/'.@$review->user->image, getFileSize('userProfile')) }}" alt="@lang('client')">
        </div>
        <div class="comment-box">
            <div class="ratings-container">
                <div class="product-ratings">
                    @for ($i = 0; $i < intval($review->rating); $i++)
                        <i class="las la-star"></i>
                    @endfor
                </div>
            </div>
            <div class="comment-info mb-1">
                <h4 class="avatar-name">{{@$review->user->username}}</h4> - <span class="comment-date">{{showDateTime($review->created_at, 'd M Y')}}</span>
            </div>
            <div class="comment-text">
                <p>{{__($review->review)}}</p>
            </div>
        </div>
     </div>
     <ul class="list comment-performance">
        <li>
            <span class="caption">
                @if ($review->like_dislike)
                    <i class="fas fa-thumbs-up text--success"></i>
                @else
                    <i class="fas fa-thumbs-down text--danger"></i>
                @endif
            </span>
        </li>
    </ul>
</li>
