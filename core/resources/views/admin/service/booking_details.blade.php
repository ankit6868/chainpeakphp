@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-xl-3 col-lg-5 col-md-5 col-sm-12">
            <div class="card ">
                <div class="card-body p-3">
                    <img src="{{ getImage(getFilePath('service').'/'.$details->service->image, getFileSize('service')) }}" alt="@lang('Service image')" class=" b-radius--10 w-100">
                    <h4 class="mt-2"><a href="{{route('admin.service.details', $details->service->id)}}">{{__($details->service->name)}}</a></h4>
                </div>
            </div>
            <div class="card  mt-4">
                <div class="card-body p-3">
                    <div class="card-header">
                        <h5>@lang('Buyer Information')</h5>
                    </div>
                   <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="fw-bold"><a href="{{ route('admin.users.detail', $details->buyer->id) }}">{{$details->buyer->username}}</a></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @if($details->buyer->status)
                                <span class="badge badge--success">@lang('Active')</span>
                            @else
                                <span class="badge badge--danger">@lang('Banned')</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Balance')
                            <span class="fw-bold">{{showAmount($details->buyer->balance)}}  {{__($general->cur_text)}}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card  mt-4">
                <div class="card-body p-3">
                    <div class="card-header">
                        <h5>@lang('Seller Information')</h5>
                    </div>
                   <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="fw-bold">
                                <a href="{{ route('admin.users.detail', $details->seller->id) }}">{{$details->seller->username}}</a>
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @if($details->seller->status)
                                <span class="badge badge--success">@lang('Active')</span>
                            @else
                                <span class="badge badge--danger">@lang('Banned')</span>
                            @endif
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Balance')
                            <span class="fw-bold">{{showAmount($details->seller->balance)}}  {{__($general->cur_text)}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-lg-7 col-md-7 col-sm-12">
            <div class="card">
                <h5 class="card-header">@lang('Other Information')</h5>
                <div class="card ">
                    <div class="card-body p-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Order Number')
                                <span class="fw-bold">{{$details->order_number}}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Service Quantity')
                                <span class="fw-bold">{{$details->quantity}}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Service Price')
                                <span class="fw-bold">{{showAmount($details->service_price)}} {{__($general->cur_text)}}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Extra Services Price')
                                <span class="fw-bold">{{showAmount($details->extra_price)}} {{__($general->cur_text)}}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Total Price')
                                <span class="fw-bold">{{showAmount($details->price)}} {{__($general->cur_text)}}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Discount')
                                <span class="fw-bold">{{showAmount($details->discount)}} {{__($general->cur_text)}}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Grand Total')
                                <span class="fw-bold">{{showAmount($details->final_price)}} {{__($general->cur_text)}}</span>
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
                                            <a href="{{ route('admin.users.detail', $details->disputer->username) }}"><span>@</span>{{ $details->disputer->username }}</a>
                                        </span>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            @if ($extraServices)
                <div class="card border--primary mt-4">
                    <h5 class="card-header bg--primary">@lang('Extra Service(s)')</h5>
                    <div class="card ">
                        <div class="card-body p-3">
                            <div class="table-responsive--sm">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>@lang('S.N.')</th>
                                            <th>@lang('Name')</th>
                                            <th>@lang('Price')</th>
                                            <th>@lang('Status')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($extraServices as $extraService)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{__($extraService->name)}}</td>
                                                <td>{{showAmount($extraService->price)}} {{__($general->cur_text)}}</td>
                                                <td> @php echo $extraService->statusBadge @endphp </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('admin.partials.work_file')
    @include('admin.partials.conversation')

    <x-confirmation-modal />


    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Details')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="details"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="disputeReasonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Dispute Reason')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="dispute-detail"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('breadcrumb-plugins')
    <x-back route="{{route('admin.booking.service.pending')}}" />
@endpush


@push('script')
    <script>
        'use strict';

        (function($){
            $('.detailsBtn').on('click', function () {
                var modal   = $('#detailsModal');
                var details = $(this).data('details');

                modal.find('.details').html(`<p> ${details} </p>`);
                modal.modal('show');
            });

            $('.disputeShow').on('click', function () {
                var modal = $('#disputeReasonModal');
                var feedback = $(this).data('dispute');
                modal.find('.dispute-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush

