@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="all-sections pt-60">
        <div class="container-fluid p-max-sm-0">
            <div class="sections-wrapper d-flex flex-wrap justify-content-center">
                <article class="main-section">
                    <div class="section-inner">
                        <div class="item-section">
                            <div class="container">
                                <form class="row justify-content-center mb-30-none" action="{{route('user.service.add.booking', $service->id)}}" method="POST">
                                    @csrf
                                    <div class="col-xl-9 col-lg-9 mb-30">
                                        <div class="item-details-area">
                                            <div class="item-card-wrapper border-0 p-0 list-view">
                                                <div class="item-card">
                                                    <div class="item-card-thumb">
                                                        <img src="{{ getImage(getFilePath('service').'/'.$service->image, getFileSize('service')) }}" alt="@lang('Service Image')">
                                                        @if($service->featured)
                                                            <div class="item-level">@lang('Featured')</div>
                                                        @endif
                                                    </div>
                                                    <div class="item-card-content">
                                                        <div class="item-card-content-top">
                                                            <div class="left">
                                                                <div class="author-thumb">
                                                                    <img src="{{ getImage(getFilePath('userProfile').'/'.$service->user->image, getFileSize('userProfile')) }}" alt="@lang('User Image')">
                                                                </div>
                                                                <div class="author-content">
                                                                    <h5 class="name">
                                                                        <a href="{{route('public.profile', $service->user->username)}}">{{__($service->user->username)}}</a> <span class="level-text"> {{__($service->user->level->name)}}<span>
                                                                    </h5>
                                                                    <div class="ratings">
                                                                        @php echo starRating($service->total_review, $service->total_rating) @endphp
                                                                        <span class="rating me-2">({{$service->total_review}})</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="right d-flex flex-wrap align-items-center">
                                                                <select class="select me-3" name="service_qty" required>
                                                                    @for($i = 1; $i <= ($service->max_order_qty ?: 1); $i++)
                                                                        <option value="{{$i}}">{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                                <div class="item-amount">
                                                                    {{$general->cur_sym}}{{showAmount($service->price)}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h3 class="item-card-title"><span>{{__($service->name)}}</span></h3>
                                                    </div>
                                                    <div class="item-card-footer">
                                                        <div class="left">
                                                            <button class="item-love me-2 make-favorite" data-id="{{$service->id}}" data-type="service">
                                                                <i class="fas fa-heart"></i>
                                                                <span class="favorite-count">({{$service->favorite}})</span>
                                                            </button>
                                                            <button class="item-like">
                                                                <i class="las la-thumbs-up"></i> ({{$service->likes}})
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($extraServices->count())
                                                <div class="service-card mt-40">
                                                    <div class="service-card-header bg--gray text-center">
                                                        <h4 class="title">@lang('Extra Services')</h4>
                                                    </div>
                                                    <div class="service-card-body">
                                                        <div class="service-card-form">
                                                            @foreach($extraServices as $key => $extraService)
                                                                <div class="form-row">
                                                                    <div class="left">
                                                                        <div class="form-group custom-check-group">
                                                                            <input class="extraServices" type="checkbox" name="extra_services[]" id="{{$key}}" data-id="{{$extraService->id}}" data-key="{{$key}}" data-price="{{getAmount($extraService->price)}}" value="{{$extraService->id}}" class="extraService">
                                                                            <label for="{{$key}}">{{__($extraService->name)}}</label>
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

                                            <div class="product-desc mt-80">
                                                <div class="section-header">
                                                    <h2 class="section-title">@lang('Service Description')</h2>
                                                </div>
                                                <div class="product-desc-content pt-0">
                                                    @php echo $service->description @endphp
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 mb-30">
                                        <div class="sidebar">
                                            <div class="widget custom-widget mb-30">
                                                <h3 class="widget-title">@lang('Your Order Details')</h3>
                                                <ul class="details-list">
                                                    <li><span>@lang('Service Price'):</span>
                                                        <div class="order-price-tags">
                                                            <span>{{$general->cur_sym}}</span><span id="servicePrice">{{showAmount($service->price)}}</span>
                                                        </div>
                                                    </li>
                                                    <li><span>@lang('Extras Service'):</span>
                                                        <div class="order-price-tags">
                                                            <span>{{$general->cur_sym}}</span><span id="extraServicePrice">0.00</span>
                                                        </div>
                                                    </li>
                                                    <li><span>@lang('Quantity'):</span>
                                                        <span id="quantity">1</span>
                                                    </li>
                                                </ul>
                                                <div class="total-price-area d-flex flex-wrap align-items-center justify-content-between">
                                                    <div class="left">
                                                        <h4 class="title">@lang('Total Price') :</h4>
                                                    </div>
                                                    <div class="right">
                                                        <h4 class="title">
                                                            {{$general->cur_sym}}<span id="totalPrice">{{showAmount($service->price)}}</span>
                                                        </h4>
                                                    </div>
                                                </div>

                                                <div class="widget-btn mt-20">
                                                    <button  type="submit" class="btn--base w-100">
                                                        <i class="las la-sign-in-alt"></i> @lang('Proceed')
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    @include($activeTemplate.'partials.down_ad')

@endsection

@push('script')
    <script>
        (function($){
            "use strict";

            var totalPrice     = '{{getAmount($service->price)}}';
            var servicePrice   = parseFloat('{{getAmount($service->price)}}');
            var extraService   = 0;

            $('[name=service_qty]').on('change', function() {
                var quantity = $(this).val();
                servicePrice = parseFloat(parseFloat ('{{getAmount($service->price)}}' * quantity));
                $('#quantity').text(quantity);
                $('#servicePrice').text(parseFloat(servicePrice).toFixed(2));

                totalPriceCalculation(servicePrice, extraService);
            });

            $('.extraServices').on('change', function () {
                var key   = $(this).data('key');
                var price = $(this).data('price');

                if ($(`#${key}`).is(":checked")) {
                    extraService += price;
                } else {
                    extraService -= price;
                }

                $('#extraServicePrice').text(parseFloat(extraService).toFixed(2));
                totalPriceCalculation(servicePrice, extraService);
            });

            function totalPriceCalculation(servicePrice, extraService) {
                totalPrice = parseFloat(servicePrice + extraService).toFixed(2);
                $('#totalPrice').text(`${totalPrice}`);
            }
        })(jQuery);
    </script>
@endpush
