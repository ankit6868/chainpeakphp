@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="all-sections pt-60 pb-60">
        <div class="container-fluid p-max-sm-0">
            <div class="sections-wrapper d-flex flex-wrap justify-content-center">
                <article class="main-section">
                    <div class="section-inner">
                        <div class="item-section item-details-section">
                            <div class="container">
                                <div class="row justify-content-center mb-30-none">
                                    <div class="col-xl-9 col-lg-9 mb-30">
                                        <div class="item-details-area">
                                            <div class="item-details-box">
                                                <div class="item-details-thumb-area">
                                                    <div class="item-details-slider-area">
                                                        <div class="item-details-slider">
                                                            <div class="swiper-wrapper">
                                                                <div class="swiper-slide">
                                                                    <div class="item-details-thumb">
                                                                        <img src="{{ getImage(getFilePath('job').'/'.$productDetails->image, getFileSize('job')) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="item-details-content">
                                                            <h2 class="title">{{__($productDetails->name)}}</h2>
                                                            <div class="item-details-footer">
                                                                <div class="left">
                                                                    <div class="item-details-tag p-0 m-0 border-0">
                                                                        <ul class="tags-wrapper">
                                                                            <li class="caption">@lang('Skill')</li>
                                                                            @foreach($productDetails->skill as $skill)
                                                                                <li>
                                                                                    <a href="{{route('job')}}?skill={{$skill}}">{{__($skill)}}</a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="right">
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
                                            </div>

                                            <div class="product-tab mt-40">
                                                <nav>
                                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                        <button class="nav-link active" id="des-tab" data-bs-toggle="tab" data-bs-target="#des" type="button"role="tab" aria-controls="des" aria-selected="true">@lang('Description')</button>
                                                        <button class="nav-link" id="req-tab" data-bs-toggle="tab" data-bs-target="#req" type="button" role="tab" aria-controls="req" aria-selected="false">@lang('Requirements')</button>
                                                        <button class="nav-link" id="bids-tab" data-bs-toggle="tab" data-bs-target="#bids" type="button" role="tab" aria-controls="bids" aria-selected="false">@lang('Bids') ({{$productDetails->total_bid}})</button>
                                                        <button class="nav-link" id="comment-tab" data-bs-toggle="tab" data-bs-target="#comment" type="button" role="tab" aria-controls="comment" aria-selected="false">@lang('Comments')</button>
                                                    </div>
                                                </nav>

                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="des" role="tabpanel" aria-labelledby="des-tab">
                                                        <div class="product-desc-content">
                                                            @php echo $productDetails->description @endphp
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade show" id="req" role="tabpanel" aria-labelledby="req-tab">
                                                        <div class="product-desc-content">
                                                            @php echo $productDetails->requirements @endphp
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="bids" role="tabpanel" aria-labelledby="bids-tab">
                                                        @if(count($productDetails->jobBidings))
                                                            <div class="item-card-wrapper item-card-wrapper--style border-0 p-0 list-view justify-content-center mt-30">
                                                                @foreach($productDetails->jobBidings as $biding)
                                                                    <div class="item-card">
                                                                        <div class="item-card-content">
                                                                            <div class="item-card-content-top">
                                                                                <div class="item-top-wrapper d-flex flex-wrap align-items-center justify-content-between">
                                                                                    <h3 class="item-card-title">{{__($biding->title)}}</h3>
                                                                                    <div class="right">
                                                                                        <div class="item-amount">{{$general->cur_sym}}{{showAmount($biding->price)}}</div>
                                                                                    </div>
                                                                                </div>
                                                                                <p>{{__($biding->description)}}</p>
                                                                                <div class="item-footer-wrapper d-flex flex-wrap align-items-center justify-content-between">
                                                                                    <div class="left">
                                                                                        <div class="author-thumb">
                                                                                            <img src="{{ getImage(getFilePath('userProfile').'/'.$biding->user->image, getFileSize('userProfile')) }}" alt="@lang('bidder')">
                                                                                        </div>
                                                                                        <div class="author-content">
                                                                                            <h5 class="name">
                                                                                                <a href="{{route('public.profile', $biding->user->username)}}">{{$biding->user->username}}</a>
                                                                                                <span class="level-text">{{$biding->user->level->name}}</span>
                                                                                            </h5>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            @if(count($productDetails->jobBidings) > 5)
                                                                <div class="view-more-btn text-center mt-4">
                                                                    <button type="button" class="btn--base"> @lang('View More')</button>
                                                                </div>
                                                            @endif
                                                        @else
                                                            @include($activeTemplate.'partials.empty_data')
                                                        @endif
                                                    </div>

                                                    @include($activeTemplate.'partials.comment_reply')
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 mb-30">
                                        <div class="sidebar">
                                            <div class="widget custom-widget mb-30">
                                                <h3 class="widget-title">@lang('SHORT DETAILS')</h3>
                                                <ul class="details-list">
                                                    <li><span>@lang('Delivery Time')</span> <span>{{$productDetails->delivery_time}} @lang('Days')</span></li>
                                                    <li><span>@lang('Budget')</span> <span>{{showAmount($productDetails->price)}} {{__($general->cur_text)}}</span></li>
                                                </ul>
                                                @auth
                                                    @if (auth()->id() != $productDetails->user_id)
                                                        <div class="widget-btn mt-20">
                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#bidModal" class="btn btn--base w-100 h-45" @disabled(@$existingJobBidCheck)>@lang('Bid Now')</button>
                                                        </div>
                                                    @endif
                                                @endauth
                                            </div>
                                            @include($activeTemplate.'partials.short_profile')
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

    @include($activeTemplate.'partials.down_ad')

    @auth
        @if (auth()->id() != $productDetails->user_id)
            <div class="modal fade" id="bidModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="ModalLabel">@lang('Bid Now')</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <form action="{{route('user.job.bidding.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="job_id" value="{{$productDetails->id}}">
                            <div class="modal-body">
                                <div class="row justify-content-center">
                                    <div class="col-xl-12 form-group">
                                        <label>@lang('Title')</label>
                                        <input type="text" name="title" class="form-control"  value="{{old('title')}}" required>
                                    </div>
                                    <div class="col-xl-12 form-group">
                                        <label>@lang('Price')</label>
                                        <div class="input-group mb-3">
                                            <input type="number" step="any" class="form-control" name="price" value="{{old('price')}}" required>
                                            <span class="input-group-text">{{__($general->cur_text)}}</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 form-group">
                                        <label>@lang('Description')</label>
                                        <textarea class="form-control bg--gray" name="description" rows="5" required>{{old('description')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn--base w-100 h-45">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endauth
@endsection
