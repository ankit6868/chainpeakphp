@if($coupon)
    <div class="coupon-div">
        @if (session('couponDiscount'))
            <code class="text--warning coupon-remove" role="button">@lang('Wanna remove coupon?')
        @else
            <code class="text--base coupon-apply" role="button">@lang('Wanna use coupon?')</code>
        @endif
    </div>
@endif

<div class="widget-btn mt-20">
    <button type="button" data-bs-toggle="modal" data-bs-target="#paymentModal" class="btn btn--base w-100 h-45">
        <i class="las la-sign-in-alt"></i> @lang('Checkout')
    </button>
</div>
