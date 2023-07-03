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
                                    @if (request()->routeIs('admin.hiring.job.*'))
                                        <th>@lang('Job')</th>
                                        <th>@lang('Buyer')</th>
                                    @endif
                                    <th>@lang('Bidder')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Budget')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Working Status')</th>
                                    <th>@lang('Delivery Date')</th>
                                    @if (request()->routeIs('admin.hiring.job.*'))
                                        <th>@lang('Action')</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($biddingList as $bid)
                                    <tr>
                                        @if (request()->routeIs('admin.hiring.job.*'))
                                            <td>{{__(strLimit($bid->job->name, 20))}}</td>
                                            <td>
                                                <span class="fw-bold">{{ $bid->buyer->fullname }}</span>
                                                <br>
                                                <span class="small">
                                                    <a href="{{ route('admin.users.detail', $bid->buyer->id) }}"><span>@</span>{{ $bid->buyer->username }}</a>
                                                </span>
                                            </td>
                                        @endif
                                        <td>
                                            <span class="fw-bold">{{ $bid->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $bid->user->id) }}"><span>@</span>{{ $bid->user->username }}</a>
                                            </span>
                                        </td>
                                        <td>{{strLimit($bid->title)}}</td>
                                        <td>{{showAmount($bid->price)}} {{__($general->cur_text)}}</td>
                                        <td> @php echo $bid->customStatusBadge @endphp </td>
                                        <td> @php echo $bid->workingStatusBadge @endphp </td>
                                        <td>{{showDateTime($bid->job->created_at->addDays($bid->job->delivery_time) , 'M, d - Y')}}</td>
                                        @if (request()->routeIs('admin.hiring.job.*'))
                                            <td>
                                                <a href="{{route('admin.hiring.job.details', $bid->id)}}" class="btn btn-sm btn-outline--primary">
                                                    <i class="la la-info-circle"></i>@lang('Details')
                                                </a>
                                            </td>
                                        @endif
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
                @if ($biddingList->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($biddingList) }}
                    </div>
                @endif
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
    <x-back route="{{ route('admin.job.all') }}" />
@endpush


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
