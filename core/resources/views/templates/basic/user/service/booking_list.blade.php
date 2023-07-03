@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="table-section">
            <div class="table-area">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>@lang('Service')</th>
                            <th>@lang('Order Number')</th>
                            @if (request()->routeIs('user.seller.booking.service.list'))
                                <th>@lang('Buyer')</th>
                            @else
                                <th>@lang('Seller')</th>
                            @endif
                            <th>@lang('Amount')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Working Status')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookedServices as $booking)
                            <tr>
                                <td class="text-start">
                                    <div class="author-info">
                                        <div class="thumb">
                                            <a href="{{ route('service.details',['slug' => slug($booking->service->name),'id' => $booking->service->id]) }}"></a>
                                            <img src="{{ getImage(getFilePath('service').'/'.$booking->service->image, getFileSize('service')) }}" alt="@lang('Service Image')">
                                        </div>
                                        <div class="content">
                                            <span>{{strLimit(__($booking->service->name))}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{__($booking->order_number)}}</td>
                                @if (request()->routeIs('user.seller.booking.service.list'))
                                    <td>
                                       <div>
                                        <span class="fw-bold">{{__($booking->buyer->fullname)}}</span>
                                        <br>
                                        <span class="text--info">
                                            <a href="{{route('public.profile', $booking->buyer->username)}}"><span>@</span>{{ $booking->buyer->username }}</a>
                                        </span>
                                       </div>
                                    </td>
                                @else
                                    <td>
                                        <div>
                                            <span class="fw-bold">{{__($booking->seller->fullname)}}</span>
                                            <br>
                                            <span class="text--info">
                                                <a href="{{route('public.profile', $booking->seller->username)}}"><span>@</span>{{ $booking->seller->username }}</a>
                                            </span>
                                        </div>
                                    </td>
                                @endif
                                <td>{{showAmount($booking->price)}} {{__($general->cur_text)}}</td>
                                <td> <div>@php echo $booking->bookingStatusBadge @endphp</div> </td>
                                <td> <div>@php echo $booking->workingStatusBadge @endphp</div> </td>
                                <td>
                                    @if($booking->status == Status::BOOKING_PENDING && request()->routeIs('user.seller.booking.service.list'))

                                        <button class="btn btn--success text-white btn-sm confirmationBtn ms-1" type="button" data-question="@lang('Are you sure to approved this booking?')" data-action="{{route('user.seller.booking.service.confirm', $booking->order_number)}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Approve Service')">
                                            <i class="las la-check"></i>
                                        </button>

                                        <button class="btn btn--danger text-white btn-sm confirmationBtn ms-1" type="button" data-question="@lang('Are you sure to cancel this booking?')" data-action="{{route('user.seller.booking.service.cancel', $booking->order_number)}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Cancel Service')">
                                            <i class="las la-ban"></i>
                                        </button>

                                    @elseif($booking->working_status == Status::WORKING_INPROGRESS || $booking->working_status == Status::WORKING_DELIVERED)

                                        @if (request()->routeIs('user.buyer.booked.services'))
                                            <button class="btn btn--success text-white btn-sm ms-1 confirmationBtn" type="button" data-question="@lang('Are you sure to make this booking completed?')" data-action="{{route('user.buyer.booked.completed', $booking->order_number)}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Complete')">
                                                <i class="las la-check-circle"></i>
                                            </button>
                                        @endif

                                        <button class="btn btn--warning text-white btn-sm ms-1 disputeBtn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Dispute')" data-type="service" data-route="{{route('user.dispute', $booking->order_number)}}">
                                            <i class="las la-bug"></i>
                                        </button>

                                        <button class="btn btn--info text-white btn-sm ms-1 workUploadBtn" type="button" data-route="{{route('user.work.upload', $booking->order_number)}}" data-worktype="service" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Work File')">
                                            <i class="las la-truck-loading"></i>
                                        </button>

                                    @endif

                                    @if (request()->routeIs('user.seller.booking.service.list'))
                                        <a href="{{route('user.seller.booking.service.details', $booking->order_number)}}" class="btn btn--primary text-white btn-sm ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Details')"><i class="las la-desktop"></i></a>
                                    @else
                                        <a href="{{route('user.buyer.booked.details', $booking->order_number)}}" class="btn btn--primary text-white btn-sm ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Details')"><i class="las la-desktop"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{paginateLinks($bookedServices)}}

            </div>
        </div>
    </div>
</div>
<x-confirmation-modal class="frontend" />
@include($activeTemplate . 'partials.dispute_reason_modal')
@include($activeTemplate . 'partials.dispute_modal')
@include($activeTemplate . 'partials.work_delivery_modal')
@endsection

