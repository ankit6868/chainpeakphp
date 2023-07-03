@extends($activeTemplate.'layouts.master')
@section('content')
<div class="card custom--card">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
        <h4 class="card-title mb-0">
            {{__($pageTitle)}}
        </h4>
    </div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @lang('Title')
                <span>{{__($details->title)}}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @lang('Budget')
                <span>{{showAmount($details->price)}} {{__($general->cur_text)}}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @lang('Delivery Date')
                <span>{{showDateTime($details->job->created_at->addDays($details->job->delivery_time) , 'M, d - Y')}}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @lang('Status')
                <div class="text-end">@php echo $details->customStatusBadge @endphp</div>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @lang('Working Status')
                <div class="text-end">
                    @php echo $details->workingStatusBadge @endphp
                </div>
            </li>
            @if ($details->disputer_id)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @lang('Disputer')
                    <div class="text-center">
                        <span class="fw-bold">{{__($details->disputer->fullname)}}</span>
                        <br>
                        <span class="text--info">
                            <a href="{{route('public.profile', $details->disputer->username)}}"><span>@</span>{{ $details->disputer->username }}</a>
                        </span>
                    </div>
                </li>
            @endif
            <li class="list-group-item d-flex flex-column flex-wrap">
                <span>@lang('Description')</span>
                <div class="text-start">
                    {{$details->description}}
                </div>
            </li>
        </ul>
    </div>
</div>


@include($activeTemplate . 'partials.work_file')
@include($activeTemplate . 'partials.conversation')

@include($activeTemplate . 'partials.dispute_reason_modal')
@include($activeTemplate . 'partials.details_modal')
@endsection
