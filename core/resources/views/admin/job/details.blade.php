@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-xl-3 col-lg-5 col-md-5 col-sm-12">
            <div class="row gy-4">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-body">
                            <img src="{{ getImage(getFilePath('job').'/'.$job->image, getFileSize('job')) }}" alt="@lang('job image')" class=" b-radius--10 w-100">
                            <h5 class="mt-3">{{__($job->name)}}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card ">
                        <div class="card-header">
                            <h5>@lang('User Information')</h5>
                        </div>
                        <div class="card-body">
                           <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Name')
                                    <span class="fw-bold">{{$job->user->fullname}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Username')
                                    <span class="fw-bold"><a href="{{ route('admin.users.detail', $job->user->id) }}">{{$job->user->username}}</a></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Status')
                                    @if($job->user->status)
                                        <span class="badge badge--success">@lang('Active')</span>
                                    @else
                                        <span class="badge badge--danger">@lang('Banned')</span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Balance')
                                    <span class="fw-bold">{{getAmount($job->user->balance)}}  {{__($general->cur_text)}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-7 col-md-7 col-sm-12">
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5>@lang('Job Information')</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Category')
                                    <span class="fw-bold">{{__(@$job->category->name)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Subcategory')
                                    <span class="fw-bold">{{__(@$job->subCategory->name)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Price')
                                    <span class="fw-bold">{{showAmount($job->price)}} {{__($general->cur_text)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Delivery Time')
                                    <span class="fw-bold">{{$job->delivery_time}} @lang('Day(s)')</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Total Bid(s)')
                                    <span class="fw-bold">{{$job->total_bid}} @lang('Day(s)')</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Status')
                                    <span class="fw-bold">@php echo $job->customStatusBadge @endphp</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Last Update')
                                    <span class="fw-bold">{{diffforhumans($job->updated_at)}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5>@lang('Tags')</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach ($job->skill as $skill)
                                    <li class="list-group-item">
                                        <span class="fw-bold">{{__($skill)}}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>@lang('Description')</h5>
                        </div>
                        <div class="card-body">
                            @php echo $job->description @endphp
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <h5 class="card-header">@lang('Requirements')</h5>
                        <div class="card ">
                            <div class="card-body p-3">
                                @php echo $job->requirements @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal/>
@endsection

@push('breadcrumb-plugins')
@if ($job->status == Status::PENDING)
<button class="btn btn-sm btn-outline--success confirmationBtn" data-action="{{route('admin.job.status.change', [$job->id, 'approve'])}}" data-question="@lang('Are you sure to Approve this job')?">
    <i class="las la-check-circle"></i>@lang('Approve')
</button>
<button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{route('admin.job.status.change', [$job->id, 'cancel'])}}" data-question="@lang('Are you sure to cancel this job')?">
    <i class="lar la-times-circle"></i>@lang('Cancel')
</button>
@endif
<x-back route="{{ route('admin.job.all') }}" />
@endpush
