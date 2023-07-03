@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="table-area">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Category')</th>
                        <th>@lang('Price')</th>
                        <th>@lang('Delivery Time')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($favServices as $service)
                        <tr>
                            <td class="text-start">
                                <div class="author-info">
                                    <div class="thumb">
                                        <img src="{{getImage(getFilePath('service').'/'.$service->service->image,getFileSize('service')) }}" alt="@lang('Service Image')">
                                    </div>
                                    <div class="content">{{__(strLimit($service->service->name, 30))}}</div>
                                </div>
                            </td>
                            <td>{{__($service->service->category->name)}}</td>
                            <td>{{showAmount($service->service->price)}} {{__($general->cur_text)}}</td>
                            <td>{{$service->service->delivery_time}} @lang('Days')</td>
                            <td>
                                <a href="{{route('service.details', [slug($service->service->name), $service->service->id])}}" class="btn btn--primary btn-sm text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Details')"><i class="las la-info-circle"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{paginateLinks($favServices)}}
        </div>
    </div>
</div>
@endsection
