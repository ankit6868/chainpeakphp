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
                                    <th>@lang('Order Number')</th>
                                    <th>@lang('Software')</th>
                                    <th>@lang('Buyer')</th>
                                    <th>@lang('Seller')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Discount')</th>
                                    <th>@lang('Grand Final')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($salesLog as $log)
                                <tr>
                                    <td class="fw-bold">{{$log->order_number}}</td>
                                    <td>
                                        <a href="{{route('admin.software.details', $log->software_id)}}">{{strLimit(__($log->software->name), 20)}}</a>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $log->buyer->fullname }}</span>
                                        <br>
                                        <span class="small">
                                            <a href="{{ route('admin.users.detail', $log->buyer->id) }}"><span>@</span>{{ $log->buyer->username }}</a>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $log->seller->fullname }}</span>
                                        <br>
                                        <span class="small">
                                            <a href="{{ route('admin.users.detail', $log->seller->id) }}"><span>@</span>{{ $log->seller->username }}</a>
                                        </span>
                                    </td>
                                    <td>{{showAmount($log->price)}} {{__($general->cur_text)}}</td>
                                    <td>{{showAmount($log->discount)}} {{__($general->cur_text)}}</td>
                                    <td>{{showAmount($log->final_price)}} {{__($general->cur_text)}}</td>
                                    <td>
                                        @if($log->status == Status::BOOKING_PAID)
                                            <span class="badge badge--success">@lang('Paid')</span>
                                                <br>
                                            <span>{{diffforhumans($log->updated_at)}}</span>
                                        @else
                                            <span class="badge badge--warning">@lang('N/A')</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('admin.software.details', $log->software_id)}}" class="btn btn-sm btn-outline--primary">
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
