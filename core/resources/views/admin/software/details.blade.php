@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-xl-3 col-lg-5 col-md-5 col-sm-12">
            <div class="row gy-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <img src="{{ getImage(getFilePath('software').'/'.$software->image, getFileSize('software')) }}"  class=" b-radius--10 w-100">
                            <h5>{{__($software->name)}}</h5>
                        </div>
                        <div class="card-footer">
                            <p>
                                <span class="fw-bold">@lang('Demo Url'):</span>
                                <a href="{{$software->demo_url}}" target="_blank">{{$software->demo_url}}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="caol-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>@lang('User Information')</h5>
                        </div>
                        <div class="card-body">
                           <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Name')
                                <span class="fw-bold">{{@$software->user->fullname}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Username')
                                <span class="fw-bold"><a href="{{ route('admin.users.detail', $software->user->id) }}">{{@$software->user->username}}</a></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Status')
                                @if($software->user->status)
                                    <span class="badge badge--success">@lang('Active')</span>
                                @else
                                    <span class="badge badge--danger">@lang('Banned')</span>
                                @endif
                            </li>
                             <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Balance')
                                <span class="fw-bold">{{showAmount($software->user->balance)}}  {{__($general->cur_text)}}</span>
                            </li>
                          </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-7 col-md-7 col-sm-12">
            <div class="row gy-4">
                @if($software->extra_image)
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>@lang('Extra Images')</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($software->extra_image as $extraImage)
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <a href="{{ getImage(getFilePath('extraImage').'/'.$extraImage)}}" target="_blank">
                                            <img src="{{getImage(getFilePath('extraImage').'/'.$extraImage, getFileSize('extraImage')) }}" class=" w-80 ml-2 my-3">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5>@lang('Software Information')</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Category')
                                    <span class="fw-bold">{{__($software->category->name)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Subcategory')
                                    <span class="fw-bold">{{__($software->subCategory->name)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Price')
                                    <span class="fw-bold">{{showAmount($software->price)}} {{__($general->cur_text)}}</span>
                                </li>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Last Update')
                                    <span class="fw-bold">{{diffforhumans($software->updated_at)}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card h-100 ">
                        <div class="card-header"><h5>@lang('Other Information')</h5></div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center text-end">
                                    @lang('Status')
                                    <span class="fw-bold">@php echo $software->customStatusBadge @endphp</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Reviews')
                                    <span class="fw-bold">{{getAmount($software->total_review)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Like(s)')
                                    <span class="fw-bold">{{$software->likes}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Disike(s)')
                                    <span class="fw-bold">{{$software->dislike}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card  h-100">
                        <div class="card-header"><h5>@lang('Features')</h5></div>
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
                <div class="col-lg-4 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>@lang('Tags')</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach ($software->tag as $tag)
                                    <li class="list-group-item">
                                        <span class="fw-bold">{{__($tag)}}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card">
                        <h5 class="card-header">@lang('Included Files')</h5>
                       <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($software->file_include as $file)
                                <li class="list-group-item">
                                    <span class="fw-bold">{{__($file)}}</span>
                                </li>
                            @endforeach
                        </ul>
                       </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">@lang('Description')</h5>
                        <div class="card ">
                            <div class="card-body">
                                @php echo $software->description @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
@if ($software->status == Status::PENDING)
<button class="btn btn-sm btn-outline--success confirmationBtn" data-action="{{route('admin.software.status.change', [$software->id, 'approve'])}}" data-question="@lang('Are you sure to Approve this software')?">
    <i class="las la-check-circle"></i>@lang('Approve')
</button>
<button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{route('admin.software.status.change', [$software->id, 'cancel'])}}" data-question="@lang('Are you sure to cancel this software')?">
    <i class="lar la-times-circle"></i>@lang('Cancel')
</button>
@endif
<a href="{{route('file.download', [encrypt($software->software_file), 'file'])}}" class="btn btn-sm btn-outline--info">
    <i class="las la-download"></i>@lang('Software')
</a>
<a href="{{route('file.download', [encrypt($software->document_file), 'documentation'])}}" class="btn btn-sm btn-outline--dark">
    <i class="las la-download"></i>@lang('Documentation')
</a>

<x-back route="{{ route('admin.software.all') }}" />
@endpush
