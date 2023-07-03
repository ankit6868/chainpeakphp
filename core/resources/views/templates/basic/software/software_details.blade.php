@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="all-sections pt-60">
        <div class="container-fluid p-max-sm-0">
            <div class="sections-wrapper d-flex flex-wrap justify-content-center">
                <article class="main-section">
                    <div class="section-inner">
                        <div class="item-section item-details-section">
                            <div class="container">
                                <div class="row justify-content-center mb-30-none">
                                    <div class="col-xl-9 col-lg-9 mb-30">
                                        <div class="item-details-area">
                                            @include($activeTemplate.'partials.basic_details')
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3">
                                        <div class="sidebar">
                                            <div class="widget custom-widget mb-30">
                                                <h3 class="widget-title">@lang('Short Details')</h3>
                                                <ul class="details-list">
                                                    <li><span>@lang('Software Price')</span> <span>{{showAmount($productDetails->price)}} {{__($general->cur_text)}}</span></li>
                                                </ul>
                                                <div class="widget-btn mt-20">
                                                    <a href="{{route('user.software.confirm.booking', [slug($productDetails->name), $productDetails->id])}}" class="btn btn--base w-100 h-45">@lang('Buy Now') ({{$general->cur_sym}}{{showAmount($productDetails->price)}})</a>
                                                </div>
                                            </div>

                                            <div class="widget custom-widget text-center mb-30">
                                                <h3><i class="fas fa-shopping-cart"></i> {{__($productDetails->total_sale)}} @lang('Sales')</h3>
                                            </div>

                                            <div class="widget custom-widget mb-30">
                                                <h3 class="widget-title">@lang('Product Details')</h3>
                                                <ul class="details-list">
                                                    <li><span>@lang('First release')</span> <span>{{showDateTime($productDetails->created_at, 'd M Y')}}</span></li>
                                                    <li><span>@lang('Last update')</span> <span>{{showDateTime($productDetails->updated_at, 'd M Y')}}</span></li>
                                                    <li><span>@lang('Documentation')</span> <span>@lang('Well Documented')</span></li>
                                                    <li>
                                                        <span>@lang('Files Included')</span>
                                                        <span>
                                                            @foreach($productDetails->file_include as $fileName)
                                                            <span class="badge badge--secondary">{{__(ucfirst($fileName))}}</span>
                                                            @endforeach
                                                        </span>
                                                    </li>
                                                </ul>
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
@endsection
