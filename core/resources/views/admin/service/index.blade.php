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
                                    <th>@lang('Name')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Category / SubCategory')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Delivery Time')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($services as $service)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb"><img src="{{getImage(getFilePath('service').'/'.$service->image,getFileSize('service')) }}" alt="@lang('image')"></div>
                                                <span>&nbsp{{ strLimit(__($service->name), 20) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $service->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $service->user->id) }}"><span>@</span>{{ $service->user->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            {{strLimit(__(@$service->category->name), 20)}} <br>
                                            {{strLimit(__(@$service->subCategory->name), 20)}}
                                        </td>
                                        <td><span class="fw-bold">{{showAmount($service->price)}} {{__($general->cur_text)}}</span></td>
                                        <td><span class="fw-bold">{{$service->delivery_time}} @lang('Day(s)')</span></td>
                                        <td> @php echo $service->customStatusBadge @endphp </td>
                                        <td>
                                            <a href="{{route('admin.service.details', $service->id)}}" class="btn btn-sm btn-outline--primary">
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
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($services->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($services) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
<x-search-form placeholder="Search..." />

@endpush
