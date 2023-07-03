
@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="all-sections pt-60">
        <div class="container-fluid p-max-sm-0">
            <div class="sections-wrapper d-flex flex-wrap justify-content-center">
                <article class="main-section">
                    <div class="section-inner">
                        <div class="item-section">
                            <div class="container">
                                @include($activeTemplate.'partials.top_filter')
                                <div class="item-bottom-area">
                                    <div class="row justify-content-center mb-30-none">
                                        <div class="col-xl-9 col-lg-9 mb-30">
                                            <div class="item-card-wrapper list-view">
                                                @forelse($products as $product)
                                                    <div class="item-card">
                                                        <div class="item-card-thumb">
                                                            <img src="{{ getImage(getFilePath($type).'/'.$product->image, getFileSize($type)) }}" alt="@lang('Service Image')">
                                                            @if($product->featured)
                                                                <div class="item-level">@lang('Featured')</div>
                                                            @endif
                                                        </div>
                                                        <div class="item-card-content">
                                                            <div class="item-card-content-top">
                                                                <div class="left">
                                                                    <div class="author-thumb">
                                                                        <img src="{{ getImage(getFilePath('userProfile').'/'.$product->user->image, getFileSize('userProfile')) }}" alt="@lang('User Image')">
                                                                    </div>
                                                                    <div class="author-content">
                                                                        <h5 class="name">
                                                                            <a href="{{route('public.profile', $product->user->username)}}">{{__($product->user->username)}}</a>
                                                                            <span class="level-text"> {{__($product->user->level->name)}}</span>
                                                                        </h5>
                                                                        @if (request()->routeIs('home') || request()->routeIs('service') || $type == 'software')
                                                                            <div class="ratings">
                                                                                @php echo starRating($product->total_review, $product->total_rating) @endphp
                                                                                <span class="rating me-2">
                                                                                    ({{$product->total_review}})
                                                                                </span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="right">
                                                                    <div class="item-amount">
                                                                        {{$general->cur_sym}}{{showAmount($product->price)}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if ($type == 'job')
                                                                <div class="item-tags order-3">
                                                                    @foreach($product->skill as $skill)
                                                                        <a href="{{route('job')}}?skill={{$skill}}">{{__($skill)}}</a>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                            <h3 class="item-card-title">
                                                                <a href="{{route("$type.details", [slug($product->name), $product->id])}}">{{__($product->name)}}</a>
                                                            </h3>
                                                        </div>
                                                        <div class="item-card-footer">
                                                            <div class="left">
                                                                @if (request()->routeIs('home') || request()->routeIs('service') || $type == 'software')
                                                                    <button type="button" class="item-love me-2 make-favorite" data-id="{{$product->id}}" data-type="@if ($type == 'service') service @else software @endif">
                                                                        <i class="fas fa-heart"></i>
                                                                        <span class="favorite-count">({{__($product->favorite)}})</span>
                                                                    </button>
                                                                    <span class="item-like">
                                                                        <i class="las la-thumbs-up"></i> ({{$product->likes}})
                                                                    </span>
                                                                @endif
                                                                @if ($type == 'software')
                                                                    <a href="{{route('user.software.confirm.booking', [slug($product->name), $product->id])}}" class="btn--base active buy-btn"><i class="las la-shopping-cart"></i> @lang('Buy Now')</a>
                                                                @endif
                                                                @if ($type == 'job')
                                                                    <span class="btn--base active date-btn">{{$product->delivery_time}} @lang('Days')</span>
                                                                    <span class="btn--base bid-btn">@lang('Total Bids')({{$product->total_bid}})</span>
                                                                @endif
                                                            </div>
                                                            <div class="right">
                                                                <div class="order-btn">
                                                                    @if ($type == 'service')
                                                                        <a href="{{route('user.service.booking.form', [slug($product->name), $product->id])}}" class="btn--base"><i class="las la-shopping-cart"></i> @lang('Order Now')</a>
                                                                    @elseif ($type == 'software')
                                                                        <a href="{{$product->demo_url}}" target="__blank" class="btn--base"><i class="las la-desktop"></i> @lang('Preview')</a>
                                                                    @elseif ($type == 'job')
                                                                        <a href="{{route('job.details', [slug($product->name), $product->id])}}" class="btn--base"><i class="las la-shopping-cart"></i> @lang('Bid Now')</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    @include($activeTemplate.'partials.empty_data')
                                                @endforelse
                                            </div>
                                            <nav>
                                                {{ paginateLinks($products)}}
                                            </nav>
                                        </div>
                                       @include($activeTemplate.'partials.filter')
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
@endsection

