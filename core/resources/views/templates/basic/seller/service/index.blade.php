@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row justify-content-end gy-3">
    <div class="col-lg-8  text-end">
       <form class="d-flex gap-3 align-items-center justify-content-end">
        <div class="input-group w-50">
            <input type="text" class="form-control" name="search" value="{{ request()->search ?? '' }}" placeholder="@lang('Search') ...">
            <button type="submit" class="btn btn--base input-group-text">@lang('Search')</button>
        </div>
        <a href="{{ route('user.seller.service.new') }}" class="btn btn--base p-2-5">@lang('New Service')</a>
       </form>
    </div>
    <div class="col-12">
        <div class="table-section">
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
                                    <th>@lang('Status')</th>
                                    <th>@lang('Last Update')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $service)
                                    <tr>
                                        <td>
                                            <div class="author-info">
                                                <div class="thumb">
                                                    <img src="{{getImage(getFilePath('service').'/'.$service->image,getFileSize('service')) }}" alt="@lang('Service Image')">
                                                </div>
                                                <div class="content text-start">{{__(strLimit($service->name, 30))}}</div>
                                            </div>
                                        </td>
                                        <td>{{__($service->category->name)}}</td>
                                        <td>{{showAmount($service->price)}} {{$general->cur_text}}</td>
                                        <td>{{$service->delivery_time}} @lang('Days')</td>
                                        <td>
                                            <div>@php echo $service->customStatusBadge @endphp </div>
                                        </td>
                                        <td>
                                            {{showDateTime($service->updated_at)}}
                                            <br>
                                            {{diffforhumans($service->updated_at)}}
                                        </td>
                                        <td>
                                            <a href="{{route('user.seller.service.edit', [slug($service->name), $service->id])}}" class="btn btn--primary btn--sm"  title="@lang('Edit')"><i class="las la-pencil-alt"></i></a>
                                        </td>
                                    </tr>
                                @empty

                                    <tr>
                                        <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{paginateLinks($services)}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
