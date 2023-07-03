@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="all-sections pt-60">
        <div class="container-fluid p-max-sm-0">
            <div class="sections-wrapper d-flex flex-wrap justify-content-center">
                <article class="main-section">
                    <div class="section-inner">
                        <div class="item-section">
                            <div class="container">
                                <div class="row justify-content-center mb-30-none">
                                    <div class="col-xl-9 col-lg-8 mb-30">
                                        <div class="item-details-area">
                                            <div class="item-card-wrapper border-0 p-0 list-view">
                                                <div class="item-card">
                                                    <div class="item-card-thumb">
                                                        <img src="{{ getImage(getFilePath('software').'/'.$software->image, getFileSize('software')) }}" alt="@lang('software Image')">
                                                        @if($software->featured)
                                                            <div class="item-level">@lang('Featured')</div>
                                                        @endif
                                                    </div>
                                                    <div class="item-card-content">
                                                        <div class="item-card-content-top">
                                                            <div class="left">
                                                                <div class="author-thumb">
                                                                    <img src="{{ getImage(getFilePath('userProfile').'/'.$software->user->image, getFileSize('userProfile')) }}" alt="@lang('User Image')">
                                                                </div>
                                                                <div class="author-content">
                                                                    <h5 class="name">
                                                                        <a href="{{route('public.profile', $software->user->username)}}">{{__($software->user->username)}}</a> <span class="level-text"> {{__($software->user->level->name)}}</span>
                                                                    </h5>
                                                                    <div class="ratings">
                                                                        @php echo starRating($software->total_review, $software->total_rating) @endphp
                                                                        <span class="rating me-2">({{$software->total_review}})</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="right d-flex flex-wrap align-items-center">
                                                                <div class="item-amount">
                                                                    {{$general->cur_sym}}{{showAmount($software->price)}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h3 class="item-card-title"><span>{{__($software->name)}}</span></h3>
                                                    </div>
                                                    <div class="item-card-footer">
                                                        <div class="left">
                                                            <button class="item-love me-2 make-favorite" data-id="{{$software->id}}" data-type="software">
                                                                <i class="fas fa-heart"></i>
                                                                <span class="favorite-count">({{$software->favorite}})</span>
                                                            </button>
                                                            <button class="item-like">
                                                                <i class="las la-thumbs-up"></i> ({{$software->likes}})
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="product-desc mt-80">
                                                <div class="section-header">
                                                    <h2 class="section-title">@lang('Software Description')</h2>
                                                </div>
                                                <div class="product-desc-content pt-0">
                                                    @php echo $software->description @endphp
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-4 mb-30">
                                        <div class="sidebar">
                                            <div class="widget custom-widget mb-30">
                                                <h3 class="widget-title">@lang('Your Order Details')</h3>
                                                <ul class="details-list">
                                                    <li><span>@lang('Software Price') :</span>
                                                        <div class="order-price-tags">
                                                            <span>{{$general->cur_sym}}</span><span id="softwarePrice">{{showAmount($software->price)}}</span>
                                                        </div>
                                                    </li>
                                                    <li><span>@lang('Total Price') :</span>
                                                        <div class="order-price-tags">
                                                            <span>{{$general->cur_sym}}</span><span>{{showAmount($software->price)}}</span>
                                                        </div>
                                                    </li>
                                                    <li><span>@lang('Discount') :</span>
                                                        <div class="order-price-tags">
                                                            <span>{{$general->cur_sym}}</span><span id="discount">{{showAmount($orderDetails['discount'])}}</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="total-price-area d-flex flex-wrap align-items-center justify-content-between">
                                                    <div class="left">
                                                        <h4 class="title">@lang('Grand Total') :</h4>
                                                    </div>
                                                    <div class="right">
                                                        <h4 class="title">
                                                            {{$general->cur_sym}}<span id="grandTotal">{{showAmount($orderDetails['grandTotal'])}}</span>
                                                        </h4>
                                                    </div>
                                                </div>

                                                @include($activeTemplate.'partials.coupon')

                                            </div>
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
    @include($activeTemplate.'partials.coupon_modal')
@endsection

@push('script')
    <script>
        (function($){
            "use strict";

            var couponAddModal = $('#couponAddModal');
            var couponRemoveModal = $('#couponRemoveModal');

            $(document).on('click', '.coupon-apply', function () {
                couponAddModal.find('[name=coupon_code]').val('');
                couponAddModal.modal('show');
            });

            $(document).on('click', '.coupon-code-apply', function () {
                var couponCode = $('[name=coupon_code]').val();
                couponAddModal.modal('hide');

                if (couponCode) {
                    $.ajax({
                        type: "get",
                        url: "{{route('user.software.coupon.apply')}}",
                        data: {
                            software_id : "{{$software->id}}",
                            coupon_code : couponCode
                        },

                        success: function (response) {
                            if(response.grandTotal && response.discount){
                                $('#grandTotal').text(response.grandTotal);
                                $('#discount').text(response.discount);
                                $('.coupon-div').html(`<code class="text--warning coupon-remove" role="button">@lang('Wanna remove coupon?')</code>`);
                            } else {
                                notify('error', response.error);
                            }
                        }
                    });
                } else {
                    notify('error', 'Please user a code to apply coupon');
                }
            });

            $(document).on('click','.coupon-remove', function () {
                couponRemoveModal.modal('show');
            });

            $('.coupon-remove-apply').on('click', function () {
                couponRemoveModal.modal('hide');
                $.ajax({
                    type: "get",
                    url: "{{route('user.software.coupon.remove')}}",

                    success: function (response) {
                        if(response.grandTotal){
                            $('#grandTotal').text(response.grandTotal);
                            $('#discount').text(response.discount.toFixed(2));
                            $('.coupon-div').html(`<code class="text--base coupon-apply" role="button">@lang('Wanna use coupon?')</code>`);
                        } else {
                            notify('error', response.error);
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
