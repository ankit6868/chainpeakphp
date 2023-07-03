<div class="modal fade" id="couponAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">@lang('Use Coupon Code')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="fw-bold">@lang('Coupon Code')</label>
                    <input type="text" class="form-control" name="coupon_code" placeholder="@lang('Enter Coupon Code')" maxlength="40" required>
                </div>
                <div class="form-group">
                    <button class="btn btn--base w-100 coupon-code-apply h-45">@lang('Submit')</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="couponRemoveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">@lang('Confirmation!')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>@lang('Are your sure to remove coupon?')</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--danger text-white border--rounded btn-sm" data-bs-dismiss="modal">
                    @lang('No')
                </button>
                <button type="button" class="btn btn--base btn-sm coupon-remove-apply">
                    @lang('Yes')
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ModalLabel">@lang('Paymentof Your Order')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            @if (request()->routeIs('user.service.confirm.booking'))
                <form action="{{route('user.service.payment.booking')}}" method="POST">
            @elseif (request()->routeIs('user.software.confirm.booking'))
                <form action="{{route('user.software.payment.booking')}}" method="POST">
            @endif
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <h5>@lang('How you want to pay')</h5>
                        <select class="form-control" name="payment_method">
                            <option value="0" @if($orderDetails['grandTotal'] > auth()->user()->balance) disabled @endif>
                                {{__($general->site_name)}} @lang('wallet') {{$general->cur_sym}}{{showAmount(auth()->user()->balance)}}
                            </option>

                            @foreach($gatewayCurrency as $currency)
                                <option value="{{$currency->method_code}}">{{__($currency->name)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--base w-100 h-45">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
