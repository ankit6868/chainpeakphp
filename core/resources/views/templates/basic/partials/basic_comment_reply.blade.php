<li class="comment-container d-flex flex-wrap">
    <div class="comment-avatar">
        <img src="{{ getImage(getFilePath('userProfile').'/'.@$comment->user->image, getFileSize('userProfile')) }}" alt="@lang('Image')">
    </div>
    <div class="comment-box">
        <div class="comment-top-wrapper d-flex flex-wrap align-items-center justify-content-between">
            <div class="left">
                <div class="comment-info">
                    <h4 class="avatar-name">{{__($comment->user->username)}}</h4> - <span class="comment-date">{{showDateTime($comment->created_at, 'd M Y')}}</span>
                </div>
            </div>
        </div>
        <div class="comment-text">
            <p>{{__($comment->comment)}}</p>
        </div>
        @auth
            <button class="reply-btn mt-20">
                <i class="fas fa-reply"></i>
                <span>@lang('Reply')</span>
            </button>
            <div class="reply-form-area mt-30 mb-40">
                <form class="comment-form" method="POST" action="{{route('user.comment.reply.store')}}">
                    @csrf
                    <input type="hidden" value="{{encrypt($comment->id)}}" name="comment_id">
                    <textarea class="form-control h-auto" placeholder="@lang('Your Reply')" rows="5" name="reply"></textarea>
                    <button type="submit" class="btn btn--base mt-3">@lang('Post Reply')</button>
                </form>
            </div>
        @endauth
    </div>
</li>

@foreach($comment->replies as $reply)
    <li class="comment-container reply-container d-flex flex-wrap">
        <div class="comment-avatar">
            <img src="{{ getImage(getFilePath('userProfile').'/'.@$reply->user->image, getFileSize('userProfile')) }}" alt="@lang('client')">
        </div>
        <div class="comment-box">
            <div class="comment-top-wrapper d-flex flex-wrap align-items-center justify-content-between">
                <div class="left">
                    <div class="comment-info">
                        <h4 class="avatar-name">{{__($reply->user->username)}}</h4> - <span class="comment-date">{{showDateTime($reply->created_at, 'd M Y')}}</span>
                    </div>
                </div>
            </div>
            <div class="comment-text">
                <p>{{__($reply->reply)}}</p>
            </div>
        </div>
    </li>
@endforeach
