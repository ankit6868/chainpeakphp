@if($workFiles->count())
<h4 class="mb-0 mt-4">@lang('Working Files')</h4>
<div class="card custom--card mt-2">
    <div class="card-body p-0">
        <div class="table-area">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>@lang('S.N.')</th>
                        <th>@lang('Sender')</th>
                        <th>@lang('Receiver')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($workFiles as $file)
                        <tr>
                            <td><span class="fw-bold">{{$loop->index+$workFiles->firstItem() }}</span></td>
                            <td>
                                <div>
                                    <span class="fw-bold">{{__($file->sender->fullname)}}</span>
                                    <br>
                                    <span class="text--info">
                                        <a href="{{route('public.profile', $file->sender->username)}}"><span>@</span>{{ $file->sender->username }}</a>
                                    </span>
                                </div>
                            </td>
                            <td>
                               <div>
                                <span class="fw-bold">{{__($file->receiver->fullname)}}</span>
                                <br>
                                <span class="text--info">
                                    <a href="{{route('public.profile', $file->receiver->username)}}"><span>@</span>{{ $file->receiver->username }}</a>
                                </span>
                               </div>
                            </td>
                            <td>
                               <div class="button-group">
                                <button type="button" class="btn btn--success detailsBtn btn--sm" data-details="{{$file->details}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Details')">
                                    <i class="las la-desktop"></i>
                                </button>
                                <a href="{{route('file.download', [encrypt($file->file), 'workFile'])}}" class="btn btn--primary btn--sm" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Download File')">
                                    <i class="las la-download"></i>
                                </a>
                               </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{paginateLinks($workFiles)}}

        </div>
    </div>
</div>
@endif
