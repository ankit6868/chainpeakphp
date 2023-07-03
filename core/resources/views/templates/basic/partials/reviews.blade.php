<ul class="comment-list load-reviews">
    @forelse($reviews->take(5) as $review)
        @include($activeTemplate.'partials.basic_review')
    @empty
        @include($activeTemplate.'partials.empty_data')
    @endforelse
</ul>

@if(count($reviews) > 5)
    <div class="view-more-btn text-center mt-4">
        <button class="btn--base loadMoreReviews" data-type="@if(request()->routeIs('service.details')) service @elseif(request()->routeIs('software.details')) software @else profile @endif"> @lang('Load More')</button>
    </div>
@endif

@push('script')
    <script>
        (function ($) {
            "use strict";

            var showReviews = 5;

            $('.loadMoreReviews').on('click', function(e) {
                e.preventDefault();
                $(this).addClass('btn-disabled').attr("disabled", true);

                var type = $(this).data('type');
                var skip = showReviews;

                $.ajax({
                    type: 'get',
                    url: '{{ route('fetch.reviews', $forLoadMoreReviewId) }}',
                    data: {
                            type : type,
                            skip : skip
                        },
                    dataType: "json",

                    success: function (response) {
                        if(response.success){
                            $('.load-reviews').append(response.html);
                            showReviews += 5;
                            $('.loadMoreReviews').removeClass('btn-disabled').attr("disabled", false);
                        }else{
                            notify('error', response.error);
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush


