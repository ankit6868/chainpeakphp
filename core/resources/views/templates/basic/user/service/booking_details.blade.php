@extends($activeTemplate.'layouts.master')
@section('content')

<div class="card custom--card">
                            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                                <h4 class="card-title mb-0">
                                    {{__($pageTitle)}}
                                </h4>
                            </div>

                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        @lang('Order Number')
                                        <span class="fw-bold">{{__($details->order_number)}}</span>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        @lang('Service Quantity')
                                        <span class="fw-bold">{{__($details->quantity)}}</span>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        @lang('Service Price')
                                        <span class="fw-bold">{{$general->cur_sym}}{{showAmount($details->service_price)}}</span>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        @lang('Extra Services Price')
                                        <span class="fw-bold">{{$general->cur_sym}}{{showAmount($details->extra_price)}}</span>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        @lang('Total Price')
                                        <span class="fw-bold">{{$general->cur_sym}}{{showAmount($details->price)}}</span>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        @lang('Discount')
                                        <span class="fw-bold">{{$general->cur_sym}}{{showAmount($details->discount)}}</span>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        @lang('Grand Total')
                                        <span class="fw-bold">{{$general->cur_sym}}{{showAmount($details->final_price)}}</span>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        @lang('Booking Date')
                                        <span class="fw-bold">{{showDateTime($details->created_at, 'M, d - Y')}}</span>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        @lang('Delivery Date')
                                        <span class="fw-bold">{{showDateTime($details->created_at->addDays($details->service->delivery_time), ('M, d - Y'))}}</span>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        @lang('Status')
                                        <div class="text-center">
                                            @php echo $details->bookingStatusBadge @endphp
                                        </div>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        @lang('Working Status')
                                        <div class="text-center">
                                            @php echo $details->workingStatusBadge @endphp
                                        </div>
                                    </li>

                                    @if ($details->disputer)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            @lang('Disputer')
                                            <div class="text-center">
                                                <span class="fw-bold">{{__($details->disputer->fullname)}}</span>
                                                <br>
                                                <span class="text--info">
                                                    <a href="{{route('public.profile', $details->disputer->username)}}"><span>@</span>{{ $details->disputer->username }}</a>
                                                </span>
                                            </div>
                                        </li>
                                    @endif
                                </ul>

                                @if ($extraServices)
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
                                                            <span class="value fw-bold">{{$general->cur_sym}}{{showAmount($extraService->price)}}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @include($activeTemplate . 'partials.work_file')
                                @include($activeTemplate . 'partials.conversation')
                            </div>
                        </div>
    @include($activeTemplate . 'partials.dispute_reason_modal')
    @include($activeTemplate . 'partials.details_modal')
@endsection

