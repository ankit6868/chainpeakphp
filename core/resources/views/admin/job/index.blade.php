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
                                @forelse ($jobs as $job)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb"><img src="{{getImage(getFilePath('job').'/'.$job->image,getFileSize('job')) }}" alt="@lang('image')"></div>
                                                <span>&nbsp{{ strLimit(__($job->name), 20) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ @$job->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $job->user->id) }}"><span>@</span>{{ $job->user->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            {{strLimit(__(@$job->category->name), 20)}} <br>
                                            {{strLimit(__(@$job->subCategory->name), 20)}}
                                        </td>
                                        <td><span class="fw-bold">{{showAmount($job->price)}} {{__($general->cur_text)}}</span></td>
                                        <td><span class="fw-bold">{{$job->delivery_time}} @lang('Day(s)')</span></td>
                                        <td> @php echo $job->customStatusBadge @endphp </td>
                                        <td>
                                           <div class="button--group">

                                            @if ($job->status != Status::PENDING)
                                                <a href="{{route('admin.job.bidding.list', $job->id)}}" class="btn btn-sm btn-outline--info">
                                                    <i class="la la-list"></i>@lang('Bidding List')
                                                </a>
                                            @endif

                                            <a href="{{route('admin.job.details', $job->id)}}" class="btn btn-sm btn-outline--primary">
                                                <i class="la la-info-circle"></i>@lang('Details')
                                            </a>
                                           </div>
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

                @if ($jobs->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($jobs) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
 
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex justify-content-end align-items-center flex-wrap gap-2">
        <x-search-form placeholder="Search..." />
    </div>
@endpush
