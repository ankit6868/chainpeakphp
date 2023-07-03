@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30 justify-content-center">
        <div class="col-xl-4 col-md-6 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Deposit Via') {{ __(@$deposit->gateway->name) }}</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Date')
                            <span class="fw-bold">{{ showDateTime($deposit->created_at) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Transaction Number')
                            <span class="fw-bold">{{ $deposit->trx }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="fw-bold">
                                <a href="{{ route('admin.users.detail', $deposit->user_id) }}">{{ @$deposit->user->username }}</a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Method')
                            <span class="fw-bold">{{ __(@$deposit->gateway->name) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Amount')
                            <span class="fw-bold">{{ showAmount($deposit->amount ) }} {{ __($general->cur_text) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Charge')
                            <span class="fw-bold">{{ showAmount($deposit->charge ) }} {{ __($general->cur_text) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('After Charge')
                            <span class="fw-bold">{{ showAmount($deposit->amount+$deposit->charge ) }} {{ __($general->cur_text) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Rate')
                            <span class="fw-bold">1 {{__($general->cur_text)}}
                                = {{ showAmount($deposit->rate) }} {{__($deposit->baseCurrency())}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Payable')
                            <span class="fw-bold">{{ showAmount($deposit->final_amo ) }} {{__($deposit->method_currency)}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @php echo $deposit->statusBadge @endphp
                        </li>
                        @if($deposit->admin_feedback)
                            <li class="list-group-item">
                                <strong>@lang('Admin Response')</strong>
                                <br>
                                <p>{{__($deposit->admin_feedback)}}</p>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            @if ($deposit->order_number && ($deposit->booking->service || $deposit->booking->software))
                <div class="card b-radius--10 mt-4">
                    <div class="card-body p-3">
                        <h5 class="mb-4">
                            @if ($deposit->booking->service)
                                @lang('Service Sale Information')
                            @else
                                @lang('Software Sale Information')
                            @endif
                        </h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Order Number')
                                <span class="fw-bold">{{$deposit->order_number}}</span>
                            </li>

                            @if ($deposit->booking->service)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Service')
                                    <a href="{{route('admin.service.details', $deposit->booking->service->id)}}">
                                        {{strLimit(__($deposit->booking->service->name), 20)}}
                                    </a>
                                </li>
                            @else
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Software')
                                    <a href="{{route('admin.software.details', $deposit->booking->software->id)}}">
                                        {{strLimit(__($deposit->booking->software->name), 20)}}
                                    </a>
                                </li>
                            @endif

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Buyer')
                                <a href="{{ route('admin.users.detail', $deposit->booking->buyer->id) }}">{{$deposit->booking->buyer->username}}</a>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Seller')
                                <a href="{{ route('admin.users.detail', $deposit->booking->seller->id) }}">{{$deposit->booking->seller->username}}</a>
                            </li>

                            @if ($deposit->booking->service)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Service Quantity')
                                    <span class="fw-bold">{{__($deposit->booking->quantity)}}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Service Price')
                                    <span class="fw-bold">{{showAmount($deposit->booking->service_price)}} {{__($general->cur_text)}}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Extra Services Price')
                                    <span class="fw-bold">{{showAmount($deposit->booking->extra_price)}} {{__($general->cur_text)}}</span>
                                </li>
                            @endif

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Total Price')
                                <span class="fw-bold">{{showAmount($deposit->booking->price)}} {{__($general->cur_text)}}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Discount')
                                <span class="fw-bold">{{showAmount($deposit->booking->discount)}} {{__($general->cur_text)}}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Grand Final')
                                <span class="fw-bold">{{showAmount($deposit->booking->final_price)}} {{__($general->cur_text)}}</span>
                            </li>

                            @if ($deposit->booking->service)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Booking Date')
                                    <span class="fw-bold">{{showDateTime($deposit->booking->created_at, 'M, d - Y')}}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Delivery Date')
                                    <span class="fw-bold">{{showDateTime($deposit->booking->created_at->addDays($deposit->booking->service->delivery_time), ('M, d - Y'))}}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        @if($details || $deposit->status == Status::PAYMENT_PENDING)
        <div class="col-xl-8 col-md-6 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">@lang('User Deposit Information')</h5>
                    @if($details != null)
                        @foreach(json_decode($details) as $val)
                            @if($deposit->method_code >= 1000)
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h6>{{__($val->name)}}</h6>
                                    @if($val->type == 'checkbox')
                                        {{ implode(',',$val->value) }}
                                    @elseif($val->type == 'file')
                                        @if($val->value)
                                            <a href="{{ route('admin.download.attachment',encrypt(getFilePath('verify').'/'.$val->value)) }}" class="me-3"><i class="fa fa-file"></i>  @lang('Attachment') </a>
                                        @else
                                            @lang('No File')
                                        @endif
                                    @else
                                    <p>{{__($val->value)}}</p>
                                    @endif
                                </div>
                            </div>
                            @endif
                        @endforeach
                        @if($deposit->method_code < 1000)
                            @include('admin.deposit.gateway_data',['details'=>json_decode($details)])
                        @endif
                    @endif

                    @if($deposit->status == Status::PAYMENT_PENDING)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button class="btn btn-outline--success btn-sm ms-1 confirmationBtn"
                                data-action="{{ route('admin.deposit.approve', $deposit->id) }}"
                                data-question="@lang('Are you sure to approve this transaction?')"
                                ><i class="las la-check-double"></i>
                                    @lang('Approve')
                                </button>

                                <button class="btn btn-outline--danger btn-sm ms-1 rejectBtn"
                                        data-id="{{ $deposit->id }}"
                                        data-info="{{$details}}"
                                        data-amount="{{ showAmount($deposit->amount)}} {{ __($general->cur_text) }}"
                                        data-username="{{ @$deposit->user->username }}"><i class="las la-ban"></i> @lang('Reject')
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- REJECT MODAL --}}
    <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Reject Deposit Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.deposit.reject')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to') <span class="fw-bold">@lang('reject')</span> <span class="fw-bold withdraw-amount text-success"></span> @lang('deposit of') <span class="fw-bold withdraw-user"></span>?</p>

                        <div class="form-group">
                            <label class="mt-2">@lang('Reason for Rejection')</label>
                            <textarea name="message" maxlength="255" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";

            $('.rejectBtn').on('click', function () {
                var modal = $('#rejectModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('.withdraw-amount').text($(this).data('amount'));
                modal.find('.withdraw-user').text($(this).data('username'));
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
