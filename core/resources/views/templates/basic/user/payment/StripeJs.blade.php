@extends($activeTemplate.'layouts.master')
@section('content')
<div class="card-area">
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="card custom--card">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                    <h4 class="card-title mb-0">@lang('Stripe Storefront')</h4>
                </div>
                <div class="card-body">
                    <div class="card-form-wrapper">
                        <form action="{{$data->url}}" method="{{$data->method}}">
                            <ul class="list-group text-center">
                                <li class="list-group-item d-flex justify-content-between">
                                    @lang('You have to pay '):
                                    <strong>{{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    @lang('You will get '):
                                    <strong>{{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</strong>
                                </li>
                            </ul>
                            <script src="{{$data->src}}"
                                class="stripe-button"
                                @foreach($data->val as $key=> $value)
                                data-{{$key}}="{{$value}}"
                                @endforeach
                            >
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-lib')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function ($) {
            "use strict";
            $('button[type="submit"]').addClass("btn btn--base w-100 h-45 mt-3");
            $('button[type="submit"]').text("Pay Now");
        })(jQuery);
    </script>
@endpush
