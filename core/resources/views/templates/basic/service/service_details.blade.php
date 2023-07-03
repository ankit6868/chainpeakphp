@extends($activeTemplate.'layouts.frontend')
@section('content')
    @php
        $user = $productDetails->user;
    @endphp
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
                                            @if ($extraServices->count())
                                                <div class="service-card mt-40">
                                                    <div class="service-card-header bg--gray text-center">
                                                        <h4 class="title">@lang('Extra Services')</h4>
                                                    </div>
                                                    <div class="service-card-body">
                                                        <div class="service-card-form">
                                                            @foreach($extraServices as $extraService)
                                                                <div class="form-row">
                                                                    <div class="left">
                                                                        <div class="form-group">
                                                                            <span>{{__($extraService->name)}}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="right">
                                                                        <span class="value">{{$general->cur_sym}}{{showAmount($extraService->price)}}</span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 mb-30">
                                        <div class="sidebar">
                                            <div class="widget custom-widget mb-30">
                                                <h3 class="widget-title">@lang('Short Details')</h3>
                                                <ul class="details-list">
                                                    <li><span>@lang('Delivery Time')</span> <span>{{__($productDetails->delivery_time)}} @lang('Days')</span></li>
                                                    <li><span>@lang('Service Price')</span> <span>{{showAmount($productDetails->price)}} {{__($general->cur_text)}}</span></li>
                                                </ul>
                                                <div class="widget-btn mt-20">
                                                    <a href="{{route('user.service.booking.form', [slug($productDetails->name), $productDetails->id])}}" class="btn--base w-100">@lang('Order Now') ({{$general->cur_sym}}{{showAmount($productDetails->price)}})</a>
                                                </div>
                                            </div>

                                            <div class="widget custom-widget text-center mb-30">
                                                <h3 class="widget-title">@lang('Do you have any special requirements')?</h3>
                                                <div class="widget-btn mt-20">
                                                    @auth
                                                        <button data-bs-toggle="modal" data-bs-target="#contactModal" class="btn--base w-100">@lang('Contact Now')</button>
                                                    @else
                                                        <a href="{{ route('user.login') }}" class="btn--base w-100">@lang('Contact Now')</a>
                                                    @endauth
                                                </div>
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
    @include($activeTemplate.'partials.contact_modal')
@endsection
