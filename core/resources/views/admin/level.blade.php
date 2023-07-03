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
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($levels as $level)
                                    <tr>
                                        <td>{{ $loop->index+$levels->firstItem() }}</td>
                                        <td>{{ __($level->name) }}</td>
                                        <td>{{ showAmount($level->amount) }} {{ __($general->cur_text) }}</td>
                                        <td>
                                            @php echo $level->statusBadge @endphp
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-resource="{{ $level }}" data-modal_title="@lang('Edit Level')" data-has_status="1">
                                                <i class="la la-pencil"></i>@lang('Edit')
                                            </button>
                                            @if ($level->status == Status::DISABLE)
                                            <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn" data-action="{{ route('admin.level.status',$level->id) }}" data-question="@lang('Are you sure to enable this level')?" type="button">
                                                <i class="la la-eye"></i> @lang('Enable')
                                            </button>
                                            @else
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.level.status',$level->id) }}" data-question="@lang('Are you sure to disable this level')?" type="button">
                                                    <i class="la la-eye-slash"></i> @lang('Disable')
                                                </button>
                                            @endif
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
                @if ($levels->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($levels) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Create or Update Modal --}}
    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.level.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>@lang('Name')</label>
                                    <input type="text" class="form-control" name="name" placeholder="@lang('Level-1')" value="{{ old('name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Amount')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" min="0" class="form-control" placeholder="@lang('Enter Amount')" name="amount" value="{{ old('amount') }}" required>
                                        <span class="input-group-text">{{__($general->cur_text)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal/>
@endsection

@push('breadcrumb-plugins')
<button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Level')">
    <i class="las la-plus"></i>@lang('Add New')
</button>
@endpush
@push('script-lib')
    <script src="{{ asset('assets/admin/js/cu-modal.js') }}"></script>
@endpush
