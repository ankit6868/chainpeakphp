@extends($activeTemplate.'layouts.master')
@section('content')
<div class="card-area">
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="card custom--card">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                    <h4 class="card-title mb-0">@lang('Razorpay')</h4>
                </div>
                <div class="card-body">
                    <div class="card-form-wrapper">
                        <ul class="list-group text-center list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('You have to pay '):
                                <strong>{{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('You will get '):
                                <strong>{{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</strong>
                            </li>
                        </ul>
                        <form action="{{$data->url}}" method="{{$data->method}}">
                            <input type="hidden" custom="{{$data->custom}}" name="hidden">
                            <script src="{{$data->checkout_js}}"
                                    @foreach($data->val as $key=>$value)
                                    data-{{$key}}="{{$value}}"
                                @endforeach >
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            $('input[type="submit"]').addClass("mt-3 btn btn--base w-100 h-45");
        })(jQuery);
    </script>
@endpush
