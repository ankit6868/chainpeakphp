@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-xl-3 col-lg-5 col-md-5 col-sm-12">
            <div class="row gy-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <img src="{{ getImage(getFilePath('service').'/'.$service->image, getFileSize('service')) }}" class="b-radius--10 w-100">
                            <h5 class="mt-4">{{__($service->name)}}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>@lang('User Information')</h5>
                        </div>
                        <div class="card-body">
                           <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Name')
                                    <span class="fw-bold">{{$service->user->fullname}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Username')
                                    <span class="fw-bold"><a href="{{ route('admin.users.detail', $service->user->id) }}">{{$service->user->username}}</a></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Balance')
                                    <span class="fw-bold">{{getAmount($service->user->balance)}}  {{__($general->cur_text)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Status')
                                    @if($service->user->status)
                                        <span class="badge badge--success">@lang('Active')</span>
                                    @else
                                        <span class="badge badge--danger">@lang('Banned')</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-7 col-md-7 col-sm-12">
            <div class="row gy-4">
                @if ($service->extra_image)
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header"><h5>@lang('Extra Images')</h5></div>
                        <div class="card-body">
                            <div class="row">
                                @forelse($service->extra_image  as $extraImage)
                                    <div class="col-lg-3 col-sm-6">
                                        <a href="{{ getImage(getFilePath('extraImage').'/'.$extraImage)}}" target="_blank">
                                            <img src="{{ getImage(getFilePath('extraImage').'/'.$extraImage, getFileSize('extraImage')) }}" class="b-radius--10 w-80 ml-2 my-3" alt="@lang('Extra Image')">
                                        </a>
                                    </div>
                                 @empty
                                 <div class="col-12 text-center">@lang('No extra image found')</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                @endif
               <div class="col-lg-6">
                    <div class="card  h-100">
                        <div class="card-header">
                            <h5>@lang('Service Information')</h5>
                        </div>
                       <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Category')
                                <span class="fw-bold">{{__(@$service->category->name)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Subcategory')
                                <span class="fw-bold">{{__(@$service->subCategory->name)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Price')
                                <span class="fw-bold">{{showAmount($service->price)}} {{__($general->cur_text)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Delivery Time')
                                <span class="fw-bold">{{$service->delivery_time}} @lang('Day(s)')</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Last Update')
                                <span class="fw-bold">{{diffforhumans($service->updated_at)}}</span>
                            </li>
                        </ul>
                       </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card  h-100">
                        <div class="card-header">
                            <h5>@lang('Other Information')</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Status')
                                    <span class="fw-bold">@php echo $service->customStatusBadge @endphp</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Featured')
                                    @if($service->featured)
                                        <span class="badge badge--success">@lang('Yes')</span>
                                    @else
                                        <span class="badge badge--warning">@lang('No')</span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Reviews')
                                    <span class="fw-bold">{{getAmount($service->total_review)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Like(s)')
                                    <span class="fw-bold">{{$service->likes}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Disike(s)')
                                    <span class="fw-bold">{{$service->dislike}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card  h-100">
                        <div class="card-header">
                            <h5>@lang('Features')</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @if ($features)
                                    @foreach ($features as $feature)
                                        <li class="list-group-item">
                                            <span class="fw-bold">{{__($feature->name)}}</span>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="list-group-item text-center">
                                        <span class="fw-bold">@lang('No features found')</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card  h-100">
                        <div class="card-header">
                            <h5>@lang('Tags')</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @forelse ($service->tag as $tag)
                                    <li class="list-group-item">
                                        <span class="fw-bold">{{__($tag)}}</span>
                                    </li>
                                    @empty
                                    <li class="list-group-item text-center">
                                        <span class="fw-bold">@lang('No tag found')</span>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <h5 class="card-header">@lang('Description')</h5>
                        <div class="card b-radius--10">
                            <div class="card-body">
                                @php echo $service->description @endphp
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header bg--primary">
                            <h5 class="text-white">@lang('Extra Service(s)')</h5>
                        </div>
                        <div class="card b-radius--10">
                            <div class="card-body p-0">
                                <div class="table-responsive--md  table-responsive">
                                    <table class="table style--two">
                                        <thead>
                                            <tr>
                                                <th>@lang('S.N.')</th>
                                                <th>@lang('Name')</th>
                                                <th>@lang('Price')</th>
                                                <th>@lang('Status')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($service->extraServices as $extraService)
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
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal/>
@endsection

@push('breadcrumb-plugins')
@if ($service->status == Status::PENDING)
    <button class="btn btn-sm btn-outline--success confirmationBtn" data-action="{{route('admin.service.status.change', [$service->id, 'approve'])}}" data-question="@lang('Are you sure to approve this service')?">
        <i class="las la-check-circle"></i>@lang('Approve')
    </button>
    <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{route('admin.service.status.change', [$service->id, 'cancel'])}}" data-question="@lang('Are you sure to cancel this service')?">
        <i class="lar la-times-circle"></i>@lang('Cancel')
    </button>
@endif
@if ($service->status == Status::APPROVED)
    @if ($service->featured)
    <button type="button" class="btn btn-sm btn-outline--warning confirmationBtn"
            data-action="{{route('admin.service.featured.status.change', [$service->id,  'unfeatured'])}}"
            data-question="@lang('Are you sure to make unfeatured this service')?">
            <i class="las la-star-half-alt"></i>@lang('Unfeatured')
    </button>
    @else
    <button type="button" class="btn btn-sm btn-outline--dark confirmationBtn"
            data-action="{{route('admin.service.featured.status.change', [$service->id,  'featured'])}}"
            data-question="@lang('Are you sure to make featured this service')?">
            <i class="las la-star"></i>@lang('Featured')
    </button>
    @endif
@endif
    <x-back route="{{ route('admin.service.all') }}" />
@endpush
