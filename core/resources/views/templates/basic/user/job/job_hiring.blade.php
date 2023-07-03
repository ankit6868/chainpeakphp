@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="table-section">
            <div class="table-area">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>@lang('Job')</th>
                            @if (request()->routeIs('user.buyer.job.bidding.list') || request()->routeIs('user.buyer.hiring.list'))
                            <th>@lang('Bidder')</th>
                            <th>@lang('Title')</th>
                            @else
                                <th>@lang('Buyer')</th>
                            @endif
                            <th>@lang('Budget')</th>
                            <th>@lang('Delivery Date')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Working Status')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($biddingList as $bid)
                        <tr>
                                <td class="text-start">
                                    <div class="author-info">
                                        <div class="thumb">
                                            <img src="{{ getImage(getFilePath('job').'/'.$bid->job->image, getFileSize('job')) }}" alt="@lang('Job Image')">
                                        </div>
                                        <div class="content">
                                            <span>{{__(strLimit($bid->job->name))}}</span>
                                        </div>
                                    </div>
                                </td>
                                @if (request()->routeIs('user.buyer.job.bidding.list') || request()->routeIs('user.buyer.hiring.list'))
                                    <td>
                                        <div>
                                            <span class="fw-bold">{{__($bid->user->fullname)}}</span>
                                            <br>
                                            <span class="text--info">
                                                <a href="{{route('public.profile', $bid->user->username)}}"><span>@</span>{{ $bid->user->username }}</a>
                                            </span>
                                        </div>
                                    </td>
                                    <td>{{strLimit(__($bid->title))}}</td>
                                @else
                                    <td>
                                       <div>
                                        <span class="fw-bold">{{__($bid->buyer->fullname)}}</span>
                                        <br>
                                        <span class="text--info">
                                            <a href="{{route('public.profile', $bid->buyer->username)}}"><span>@</span>{{ $bid->buyer->username }}</a>
                                        </span>
                                       </div>
                                    </td>
                                    @endif

                                <td>{{showAmount($bid->price)}} {{__($general->cur_text)}}</td>
                                <td>{{showDateTime($bid->job->created_at->addDays($bid->job->delivery_time) , 'M, d - Y')}}</td>
                                <td> <div>@php echo $bid->customStatusBadge @endphp</div> </td>
                                <td> <div>@php echo $bid->workingStatusBadge @endphp </div> </td>
                                <td>
                                  <div class="button-group">
                                    @if ($bid->status == Status::PENDING && request()->routeIs('user.buyer.job.bidding.list'))
                                    <button class="btn btn--success btn--sm confirmationBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Approve')" data-question="@lang('Are you sure to approved this bid?')" data-action="{{route('user.buyer.job.bid.approve', $bid->id)}}">
                                        <i class="las la-check-double"></i>
                                    </button>

                                    <button class="btn btn--warning btn--sm confirmationBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Cancel')" data-question="@lang('Are you sure to cancel this bid?')" data-action="{{route('user.buyer.job.bid.cancel', $bid->id)}}">
                                        <i class="las la-ban"></i>
                                    </button>
                                    @endif

                                    @if (($bid->status == Status::APPROVED && $bid->working_status == Status::WORKING_INPROGRESS) || ($bid->status == Status::APPROVED && $bid->working_status == Status::WORKING_DELIVERED))

                                    @if (request()->routeIs('user.buyer.hiring.list'))
                                            <button class="btn btn--success ms-1 confirmationBtn" type="button" data-question="@lang('Are you sure to make this bid completed?')" data-action="{{route('user.buyer.hiring.completed', $bid->id)}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Complete')">
                                                <i class="las la-check-circle"></i>
                                            </button>
                                        @endif

                                        <button class="btn btn--warning text-white btn--sm ms-1 disputeBtn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Dispute')" data-type="job" data-route="{{route('user.dispute', $bid->id)}}">
                                            <i class="las la-bug"></i>
                                        </button>

                                        <button class="btn btn--info  btn--sm workUploadBtn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Work File')" data-route="{{route('user.work.upload', $bid->id)}}" data-worktype="job">
                                            <i class="las la-truck-loading"></i>
                                        </button>
                                    @endif
                                    @if (request()->routeIs('user.buyer.job.bidding.list') || request()->routeIs('user.buyer.hiring.list'))
                                        <a href="{{route('user.buyer.hiring.details', $bid->id)}}" class="btn btn--primary  btn--sm " type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Details')">
                                            <i class="las la-desktop"></i>
                                        </a>
                                    @else
                                    <a href="{{route('user.seller.job.details', $bid->id)}}" class="btn btn--primary  btn--sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Details')">
                                        <i class="las la-desktop"></i>
                                        </a>
                                    @endif
                                  </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                {{paginateLinks($biddingList)}}
            </div>
        </div>
    </div>
</div>

    <x-confirmation-modal class="frontend" />
    @include($activeTemplate . 'partials.work_delivery_modal')
    @include($activeTemplate . 'partials.dispute_modal')
    @include($activeTemplate . 'partials.dispute_reason_modal')
@endsection
