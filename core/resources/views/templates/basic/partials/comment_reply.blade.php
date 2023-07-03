<div class="tab-pane fade" id="comment" role="tabpanel" aria-labelledby="comment-tab">
    <div class="product-reviews-content product-comment-content">
        <div class="comment-form-area mb-40">
            @auth
                <form class="comment-form" method="POST" action="{{route('user.comment.store')}}">
                    @csrf

                    <input type="hidden" name="product_id" value="{{$productDetails->id}}">

                    @if (request()->routeIs('service.details'))
                        <input type="hidden" name="type" value="service">
                    @elseif (request()->routeIs('software.details'))
                        <input type="hidden" name="type" value="software">
                    @elseif (request()->routeIs('job.details'))
                        <input type="hidden" name="type" value="job">
                    @endif

                    <textarea class="form-control h-auto" name="comment" placeholder="@lang('Your Comment')" rows="5" required></textarea>
                    <button type="submit" class="submit-btn mt-20">@lang('Post Comment')</button>
                </form>
            @else
                <div class="comment-form">
                    <a href="{{route('user.login')}}" class="submit-btn mt-20">@lang('Login to comment')</a>
                </div>
            @endauth
        </div>

        <div class="row">
            <div class="col-xl-12">
                <h3 class="reviews-title">{{count($comments)}} @lang('comments')</h3>
                <ul class="comment-list load-comments">
                    @forelse($comments->take(5) as $comment)
                        @include($activeTemplate.'partials.basic_comment_reply')
                    @empty
                        @include($activeTemplate.'partials.empty_data')
                    @endforelse
                </ul>
            </div>

            @if(count($comments) > 5)
                <div class="view-more-btn text-center mt-4">
                    <button class="btn--base loadMoreComments" data-type="@if(request()->routeIs('service.details')) service @elseif(request()->routeIs('software.details')) software @else job @endif"> @lang('Load More')</button>
                </div>
            @endif
        </div>
    </div>
</div>

@push('script')
    <script>
        (function ($) {
            "use strict";

            var showComments = 5;

            $('.loadMoreComments').on('click', function(e) {
                e.preventDefault();
                $(this).addClass('btn-disabled').attr("disabled", true);

                var type = $(this).data('type');
                var skip = showComments;

                $.ajax({
                    type: 'get',
                    url: '{{ route('fetch.comments', $productDetails->id) }}',
                    data: {
                            type : type,
                            skip : skip
                        },
                    dataType: "json",

                    success: function (response) {
                        if(response.success){
                            $('.load-comments').append(response.html);
                            showComments += 5;
                            $('.loadMoreComments').removeClass('btn-disabled').attr("disabled", false);
                        }else{
                            notify('error', response.error);
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush



