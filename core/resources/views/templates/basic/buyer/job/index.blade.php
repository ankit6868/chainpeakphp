@extends($activeTemplate.'layouts.master')
@section('content')
<div class="table-area">
    <table class="custom-table">
        <thead>
            <tr>
                <th class="text-start">@lang('Name')</th>
                <th>@lang('Category')</th>
                <th>@lang('Budget')</th>
                <th>@lang('Delivery Time')</th>
                <th>@lang('Status')</th>
                <th>@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jobs as $job)
                <tr>
                    <td class="text-start">
                        <div class="author-info">
                            <div class="thumb">
                                <img src="{{getImage(getFilePath('job').'/'.$job->image,getFileSize('job')) }}" alt="@lang('Job Image')">
                            </div>
                            <div class="content">{{__(strLimit($job->name, 30))}}</div>
                        </div>
                    </td>
                    <td>{{__($job->category->name)}}</td>
                    <td>{{showAmount($job->price)}} {{__($general->cur_text)}}</td>
                    <td>{{$job->delivery_time}} @lang('Days')</td>
                    <td> @php echo $job->customStatusBadge @endphp </td>
                    <td>
                        <a href="{{route('user.buyer.job.edit', [slug($job->name), $job->id])}}" class="btn btn--primary btn--sm" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Edt')"><i class="las la-pencil-alt"></i></a>
                        <a href="{{route('user.buyer.job.bidding.list', [slug($job->name), $job->id])}}" class="btn btn--success btn--sm " data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Bidding List')">
                            <i class="las la-list"></i>
                        </a>
                        @if ($job->status == Status::APPROVED)
                            <button class="btn btn--danger btn--sm confirmationBtn" type="button" data-question="@lang('Are you sure to close this job?')" data-action="{{route('user.buyer.job.close', $job->id)}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Close')">
                                <i class="las la-times"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="100%">{{ __($emptyMessage) }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{paginateLinks($jobs)}}
</div>
    <x-confirmation-modal class="frontend" />
@endsection
