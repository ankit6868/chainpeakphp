@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('Order Number')</th>
                                    <th>@lang('Service')</th>
                                    <th>@lang('Buyer')</th>
                                    <th>@lang('Seller')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Working Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookings as $booking)
                                <tr>
                                    <td><span class="fw-bold">{{$booking->order_number}}</span></td>
                                    <td>
                                        <a href="{{route('admin.service.details', $booking->service->id)}}">{{strLimit(__($booking->service->name), 20)}}</a>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $booking->buyer->fullname }}</span>
                                        <br>
                                        <span class="small">
                                            <a href="{{ route('admin.users.detail', $booking->buyer->id) }}"><span>@</span>{{ $booking->buyer->username }}</a>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $booking->seller->fullname }}</span>
                                        <br>
                                        <span class="small">
                                            <a href="{{ route('admin.users.detail', $booking->seller->id) }}"><span>@</span>{{ $booking->seller->username }}</a>
                                        </span>
                                    </td>
                                    <td>{{showAmount($booking->final_price)}} {{__($general->cur_text)}}</td>
                                    <td> @php echo $booking->bookingStatusBadge @endphp </td>
                                    <td> @php echo $booking->workingStatusBadge @endphp </td>
                                    <td>
                                        <a href="{{route('admin.booking.service.details', $booking->id)}}" class="btn btn-sm btn-outline--primary">
                                            <i class="la la-info-circle"></i>@lang('Details')
                                        </a>
                                    </td>
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

@push('script')
    <script>
        'use strict';

        (function($){
            $('.disputeShow').on('click', function () {
                var modal = $('#disputeReasonModal');
                var feedback = $(this).data('dispute');
                modal.find('.dispute-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
