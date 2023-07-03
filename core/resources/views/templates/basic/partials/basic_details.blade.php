@php
    $forLoadMoreReviewId = $productDetails->id;
    if (request()->routeIs('service.details')) {
        $type      = "service";
        $imagePath = getImage(getFilePath('service').'/'.$productDetails->image, getFileSize('service'));
    }elseif(request()->routeIs('software.details')){
        $type      = "software";
        $imagePath = getImage(getFilePath('software').'/'.$productDetails->image, getFileSize('software'));
    }else{
        $type      = "job";
        $imagePath = getImage(getFilePath('job').'/'.$productDetails->image, getFileSize('job'));
    }
@endphp
<div class="item-details-box">
    <div class="item-details-thumb-area">
        <div class="item-details-slider-area">
            <div class="item-details-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="item-details-thumb">
                            <img src="{{$imagePath}}">
                        </div>
                    </div>
                    @foreach($productDetails->extra_image ?? [] as $singleImage)
                        <div class="swiper-slide">
                            <div class="item-details-thumb">
                                <img src="{{ getImage(getFilePath('extraImage').'/'.$singleImage, getFileSize('extraImage')) }}">
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="slider-prev">
                    <i class="las la-angle-left"></i>
                </div>
                <div class="slider-next">
                    <i class="las la-angle-right"></i>
                </div>
            </div>
        </div>

        <div thumbsSlider="" class="item-small-slider mt-20">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="item-small-thumb">
                        <img src="{{$imagePath}}">
                    </div>
                </div>
                @foreach($productDetails->extra_image ?? [] as $singleImage)
                    <div class="swiper-slide">
                        <div class="item-small-thumb">
                            <img src="{{ getImage(getFilePath('extraImage').'/'.$singleImage, getFileSize('extraImage')) }}">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="item-details-content border-top mt-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h2 class="title">{{__($productDetails->name)}}</h2>
                <span class="item-ratings">
                    @php echo starRating($productDetails->total_review, $productDetails->total_rating) @endphp
                    <span class="rating me-2">({{$productDetails->total_review}})</span>
                </span>
            </div>
            <div class="item-details-footer mb-20-none">
                <div class="left mb-20">
                    <button class="item-love me-2 make-favorite" data-id="{{$productDetails->id}}" data-type="@if (request()->routeIs('service.details')) service @else software @endif">
                        <i class="fas fa-heart"></i> <span class="favorite-count">({{__($productDetails->favorite)}})</span>
                    </button>
                    <span class="item-like me-2">
                        <i class="las la-thumbs-up"></i> ({{__($productDetails->likes)}})
                    </span>
                    @if (request()->routeIs('software.details'))
                        <a href="{{$productDetails->demo_url}}" target="__blank" class="item-love bg--base mt-2"><i class="las la-desktop"></i> @lang('Preview')</a>
                    @endif
                </div>
                <div class="right mb-20">
                    <div class="social-area">
                        <ul class="footer-social">
                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Facebook')">
                                <a href="http://www.facebook.com/sharer.php?u={{urlencode(url()->current())}}&p[title]={{slug($productDetails->name)}}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Linkedin')">
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{urlencode(url()->current()) }}&title={{slug($productDetails->name)}}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            </li>
                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Twitter')">
                                <a href="http://twitter.com/share?text={{slug($productDetails->name)}}&url={{urlencode(url()->current()) }}" target="_blank"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Pinterest')">
                                <a href="http://pinterest.com/pin/create/button/?url={{urlencode(url()->current()) }}&description={{slug($productDetails->name)}}" target="_blank"><i class="fab fa-pinterest-p"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-tab mt-40">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="des-tab" data-bs-toggle="tab" data-bs-target="#des" type="button" role="tab" aria-controls="des" aria-selected="true">@lang('Description')</button>
            <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false">@lang('Reviews') ({{$productDetails->total_review}})</button>
            <button class="nav-link" id="comment-tab" data-bs-toggle="tab" data-bs-target="#comment" type="button" role="tab" aria-controls="comment" aria-selected="false">@lang('Comments')</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">

        <div class="tab-pane fade show active" id="des" role="tabpanel" aria-labelledby="des-tab">
            <div class="product-desc-content">
                @php echo $productDetails->description @endphp
            </div>
            <div class="item-details-tag">
                <h4 class="caption">@lang('Tags')</h4>
                <ul class="tags-wrapper">
                    @foreach($productDetails->tag as $tag)
                        <li><a href="{{route($type)}}?tag={{ $tag }}">
                            {{__($tag)}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
            <div class="product-reviews-content">
                <div class="item-review-widget-wrapper">
                    <div class="left">
                        <h2 class="title text-white">
                            @if ($productDetails->total_review) {{showAmount($productDetails->total_rating / $productDetails->total_review)}} @else 0.00 @endif
                        </h2>
                        <div class="ratings">
                            @php echo starRating($productDetails->total_review, $productDetails->total_rating) @endphp
                        </div>
                        <span class="sub-title text-white">{{$productDetails->total_review}} @lang('review(s)')</span>
                    </div>
                    <div class="right">
                        <ul class="list">
                            <li>
                                <span class="caption">
                                    <i class="fas fa-thumbs-up text--success"></i> @lang('Total Likes')
                                </span>
                                <span class="value">{{__($productDetails->likes)}}</span>
                            </li>
                            <li>
                                <span class="caption">
                                    <i class="fas fa-thumbs-down text--danger"></i> @lang('Total Dislikes')
                                </span>
                                <span class="value">{{__($productDetails->dislike)}}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                @if($reviewPermission)
                    <div class="comment-form-area mb-40">
                        <form class="comment-form" action="{{route('user.review.store')}}" method="POST">
                            @csrf

                            @if (request()->routeIs('service.details'))
                                <input type="hidden" name="type" value="service">
                            @elseif (request()->routeIs('software.details'))
                                <input type="hidden" name="type" value="software">
                            @endif

                            <input type="hidden" name="booking_id" value="{{encrypt($reviewPermission->id)}}">
                            <input type="hidden" name="product_id" value="{{$productDetails->id}}">

                            <div class="comment-ratings-area d-flex flex-wrap align-items-center justify-content-between">
                                <div class="rating">
                                    <input type="radio" id="star1" name="rating" value="5" /><label for="star1" title="@lang('Rocks')!">&nbsp;</label>
                                    <input type="radio" id="star2" name="rating" value="4" /><label for="star2" title="@lang('Pretty good')">&nbsp;</label>
                                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="@lang('Meh')">&nbsp;</label>
                                    <input type="radio" id="star4" name="rating" value="2" /><label for="star4" title="@lang('Kinda bad')">&nbsp;</label>
                                    <input type="radio" id="star5" name="rating" value="1" /><label for="star5" title="@lang('Sucks big time')">&nbsp;</label>
                                </div>

                                <div class="like-dislike">
                                    <div class="d-flex flex-wrap align-items-center justify-content-sm-end">
                                        <div class="like-dislike me-4">
                                            <input type="radio" name="like" value="1" id="review-like">
                                            <label for="review-like" class="mb-0"><i class="fas fa-thumbs-up"></i></label>
                                        </div>
                                        <div class="like-dislike">
                                            <input type="radio" name="like" value="0" id="review-dislike">
                                            <label for="review-dislike" class="mb-0"><i class="fas fa-thumbs-down"></i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <textarea class="form-control h-auto" placeholder="@lang('Write Review')" name="review" rows="8" required=""></textarea>
                            <button type="submit" class="submit-btn mt-20">@lang('Post Your Review')</button>
                        </form>
                    </div>
                @endif

                <div class="row">
                    <div class="col-xl-12">
                        <h3 class="reviews-title">{{$productDetails->total_review}} @lang('reviews')</h3>
                        @include($activeTemplate.'partials.reviews')
                    </div>
                </div>
            </div>
        </div>

        @include($activeTemplate.'partials.comment_reply')
    </div>
</div>

@push('script')
    <script>
        (function($){
            "use strict";

            var swiper = new Swiper(".item-small-slider", {
                spaceBetween: 30,
                slidesPerView: 4,
                freeMode: true,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
            });

            var swiper2 = new Swiper(".item-details-slider", {
                slidesPerView: 1,
                spaceBetween: 10,
                navigation: {
                    nextEl: '.slider-next',
                    prevEl: '.slider-prev',
                },
                thumbs: {
                    swiper: swiper,
                },
            });
        })(jQuery);
    </script>
@endpush
