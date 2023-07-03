@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-xl-3 col-lg-5 col-md-5 col-sm-12">
            <div class="row gy-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>@lang('Job Information')</h5>
                        </div>
                        <div class="card-body">
                            <img src="{{ getImage(getFilePath('job').'/'.$details->job->image, getFileSize('job')) }}" class="b-radius--10 w-100">
                            <h4><a href="{{route('admin.job.details', $details->job->id)}}">{{__($details->job->name)}}</a></h4>
                        </div>
                    </div>
                </div>
                <div class="co-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>@lang('Buyer Information')</h5>
                        </div>
                        <div class="card-body">
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
                                    <span class="fw-bold">{{getAmount($details->buyer->balance)}}  {{__($general->cur_text)}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>@lang('Bidder Information')</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Username')
                                    <span class="fw-bold"><a href="{{ route('admin.users.detail', $details->user->id) }}">{{$details->user->username}}</a></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Status')
                                    @if($details->user->status)
                                        <span class="badge badge--success">@lang('Active')</span>
                                    @else
                                        <span class="badge badge--danger">@lang('Banned')</span>
                                    @endif
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Balance')
                                    <span class="fw-bold">{{getAmount($details->user->balance)}}  {{__($general->cur_text)}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-7 col-md-7 col-sm-12">
            <div class="card mb-4">
                <h5 class="card-header">@lang('Other Information')</h5>
                <div class="card ">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Title')
                                <span class="fw-bold">{{__($details->title)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Budget')
                                <span class="fw-bold">{{showAmount($details->price)}} {{__($general->cur_text)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Status')
                                @php echo $details->customStatusBadge @endphp
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
                            <li class="list-group-item d-flex flex-column">
                                @lang('Description')
                                <div class="text-start">
                                    {{$details->description}}
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            @include('admin.partials.work_file')

        </div>
    </div>

    @include('admin.partials.conversation')

    <x-confirmation-modal />


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

            $('.detailsBtn').on('click', function () {
                var modal   = $('#detailsModal');
                var details = $(this).data('details');

                modal.find('.details').html(`<p> ${details} </p>`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

