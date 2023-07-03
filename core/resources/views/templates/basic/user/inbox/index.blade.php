@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="table-section">
            <div class="table-area">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th class="text-start">@lang('Sender')</th>
                            <th>@lang('Subject')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($inboxes as $inbox)
                            @php
                                $user = $inbox->sender_id == auth()->id() ? $inbox->receiver : $inbox->sender;
                            @endphp
                            <tr>
                                <td class="text-start">
                                    <div class="author-info">
                                        <div class="thumb">
                                            <img src="{{ getImage(getFilePath('userProfile').'/'.$user->image, getFileSize('userProfile')) }}" alt="@lang('Service Image')">
                                        </div>
                                        <div class="content">{{$user->username}}</div>
                                    </div>
                                </td>
                                <td> {{strLimit($inbox->subject , 20)}}</td>
                                <td>
                                    <a href="{{route('user.inbox.messages', $inbox->unique_id)}}" class="btn btn--primary btn--sm" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Messages')"><i class="las la-comments"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{paginateLinks($inboxes)}}
            </div>
        </div>
    </div>
</div>
@endsection
