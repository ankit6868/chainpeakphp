@extends($activeTemplate.'layouts.master')
@section('content')
<div class="table-section">
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="table-area">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>@lang('Software')</th>
                            <th>@lang('Order Number')</th>
                            @if (request()->routeIs('user.buyer.software.log'))
                                <th>@lang('Seller')</th>
                            @else
                                <th>@lang('Buyer')</th>
                            @endif
                            <th>@lang('Price')</th>
                            <th>@lang('Discount')</th>
                            <th>@lang('Status')</th>
                            @if (request()->routeIs('user.buyer.software.log'))
                                <th>@lang('Software')</th>
                                <th>@lang('Documentation')</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($softwareLog as $log)
                            <tr>
                                <td class="text-start">
                                    <div class="author-info">
                                        <div class="thumb">
                                            <img src="{{ getImage(getFilePath('software').'/'.$log->software->image, getFileSize('software')) }}" alt="@lang('Software Image')">
                                        </div>
                                        <div class="content">
                                            <span>{{__(strLimit($log->software->name))}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{__($log->order_number)}}</td>

                                @if (request()->routeIs('user.buyer.software.log'))
                                    <td>
                                       <div>
                                        <span class="fw-bold">{{__($log->seller->fullname)}}</span>
                                        <br>
                                        <span class="text--info">
                                            <a href="{{route('public.profile', $log->seller->username)}}"><span>@</span>{{ $log->seller->username }}</a>
                                        </span>
                                       </div>
                                    </td>
                                @else
                                    <td>
                                        <div>
                                        <span class="fw-bold">{{__($log->buyer->fullname)}}</span>
                                        <br>
                                        <span class="text--info">
                                            <a href="{{route('public.profile', $log->buyer->username)}}"><span>@</span>{{ $log->buyer->username }}</a>
                                        </span>
                                        </div>
                                    </td>
                                @endif
                                <td>{{showAmount($log->price)}} {{__($general->cur_text)}}</td>
                                <td>{{showAmount($log->discount)}} {{__($general->cur_text)}}</td>
                                <td>
                                    @if($log->status == Status::BOOKING_PAID)
                                      <div>
                                            <span class="badge badge--success">@lang('Paid')</span>
                                            <br>
                                            <span>{{diffforhumans($log->updated_at)}}</span>
                                      </div>
                                    @else
                                        <span class="badge badge--warning">@lang('N/A')</span>
                                    @endif
                                </td>

                                @if (request()->routeIs('user.buyer.software.log'))
                                    @if ($log->status == Status::BOOKING_PAID)
                                        <td>

                                            <a href="{{route('file.download', [encrypt(@$log->software->software_file), 'file'])}}" class="btn btn--primary btn--sm " data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Software File')"><i class="las la-download"></i></a>
                                        </td>
                                        <td>
                                            <a href="{{route('file.download', [encrypt($log->document_file), 'documentation'])}}" class="btn btn--primary btn--sm " data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Document File')"><i class="las la-download"></i></a>
                                        </td>
                                    @else
                                        <td><span class="badge badge--warning">@lang('N/A')</span></td>
                                        <td><span class="badge badge--warning">@lang('N/A')</span></td>
                                    @endif
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{paginateLinks($softwareLog)}}
            </div>
        </div>
    </div>
</div>
@endsection
