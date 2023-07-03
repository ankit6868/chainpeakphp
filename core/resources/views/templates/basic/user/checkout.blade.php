@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="payment-section payment-preview-section">
        <div class="container ptb-60">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card custom--card">
                        <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                            <h4 class="card-title mb-0">{{__($gateway->name)}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="payment-item align-items-center">
                                <div class="payment-content">
                                    <ul class="list-group list-group-flush payment-list">
                                        <li  class="list-group-item">
                                            <span> @lang('Amount'): </span>
                                            <span>
                                                <strong class="text--primary">{{showAmount($amount)}} </strong> {{__($general->cur_text)}}
                                            </span>
                                        </li>
                                        <li class="list-group-item">
                                            <span> @lang('Charge'): </span>
                                            <span>
                                                <strong class="text--danger">{{showAmount($charge)}}</strong> {{__($general->cur_text)}}
                                            </span>
                                        </li>
                                        <li class="list-group-item">
                                            <span> @lang('Payable'): </span>
                                            <span>
                                                <strong class="text--info">{{showAmount($payable)}}</strong> {{__($general->cur_text)}}
                                            </span>
                                        </li>

                                        @if ($gateway->currency != $general->cur_text)
                                            <li class="list-group-item">
                                                <span> @lang('Conversion Rate'): </span>
                                                <span>
                                                    <strong class="text--info">1 {{__($general->cur_text)}} = {{showAmount($gateway->rate)}}  {{__($gateway->currency)}}</strong>
                                                </span>
                                            </li>

                                            <li class="list-group-item">
                                                <span> @lang('In') {{__($gateway->currency)}}: </span>
                                                <span>
                                                    <strong class="text--info">{{showAmount( ($amount + $charge) * $gateway->rate , 8)}}</strong>
                                                </span>
                                            </li>
                                        @endif

                                        @if($gateway->method->crypto)
                                            <li class="list-group-item">
                                                <span>@lang('Conversion with')
                                                    <b> {{ __($gateway->currency) }}</b> @lang('and final value will Show on next step')
                                                </span>
                                            </li>
                                        @endif
                                    </ul>
                                    <div class="payment-btn">
                                        <form action="{{route('user.deposit.insert', $orderDetails['orderNumber'])}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="amount" value="{{$amount}}">
                                            <input type="hidden" name="gateway" value="{{$gateway->method_code}}">
                                            <input type="hidden" name="currency" value="{{$gateway->currency}}">
                                            <button type="submit" class="btn btn--base w-100 h-45">@lang('Pay Now')</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        @media only screen and (max-width: 767px) {
            .payment-preview-section .payment-item {
                display: block !important;
                text-align: center !important;
            }
        }

        .payment-item .payment-content .payment-list li {
            padding-bottom: 10px;
            margin-bottom: 10px;
            border-bottom: 1px solid rgba(222, 229, 234, 0.5);
            font-size: 14px;
            display: flex;
            justify-content: space-between;
        }

        .payment-item .payment-content .payment-list li span {
            font-weight: 600;
        }
    </style>
@endpush
