@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row gy-3">
    <div class="col-12">
        <div class="text-end">
            <a href="{{route('ticket.open') }}" class="btn btn--base btn--sm"> <i class="las la-plus"></i> @lang('New Ticket')</a>
        </div>
    </div>
    <div class="col-12">
        <div class="table-section">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="table-area">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Priority')</th>
                                    <th>@lang('Last Reply')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($supports as $support)
                                    <tr>
                                        <td> <a href="{{ route('ticket.view', $support->ticket) }}" class="fw-bold"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                                        <td>
                                            @php echo $support->statusBadge; @endphp
                                        </td>
                                        <td>
                                            @if($support->priority == Status::PRIORITY_LOW)
                                                <span class="badge badge--dark">@lang('Low')</span>
                                            @elseif($support->priority == Status::PRIORITY_MEDIUM)
                                                <span class="badge  badge--warning">@lang('Medium')</span>
                                            @elseif($support->priority == Status::PRIORITY_HIGH)
                                                <span class="badge badge--danger">@lang('High')</span>
                                            @endif
                                        </td>
                                        <td> {{ diffForHumans($support->last_reply)}} </td>

                                        <td>
                                            <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn--primary btn--sm" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Details')">
                                                <i class="las la-desktop"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{paginateLinks($supports)}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
