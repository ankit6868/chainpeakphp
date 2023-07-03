@if ($workFiles->count())
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <h5 class="card-header bg--primary">@lang('Work File(s)')</h5>
                <div class="card b-radius--10">
                    <div class="card-body p-0">
                        <div class="table-responsive--sm">
                            <table class="table table-hover">
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
                                            <td><span class="fw-bold">{{ $loop->iteration }}</span></td>
                                            <td>
                                                <span class="fw-bold">{{ $file->sender->fullname }}</span>
                                                <br>
                                                <span class="small">
                                                    <a href="{{ route('admin.users.detail', $file->sender->id) }}"><span>@</span>{{ $file->sender->username }}</a>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{ $file->receiver->fullname }}</span>
                                                <br>
                                                <span class="small">
                                                    <a href="{{ route('admin.users.detail', $file->receiver->id) }}"><span>@</span>{{ $file->receiver->username }}</a>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{route('file.download', [encrypt($file->file), 'workFile'])}}" class="btn btn-sm btn-outline--primary">
                                                    <i class="la la-download"></i>@lang('Download')
                                                </a>
                                                <button class="btn btn-sm btn-outline--primary detailsBtn" data-details="{{$file->details}}">
                                                    <i class="la la-info-circle"></i>@lang('Details')
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
