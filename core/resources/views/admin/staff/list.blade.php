@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Username')</th>
                                <th>@lang('Joined At')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($staffs as $staff)
                            <tr>
                                <td>{{ $staff->name }}</td>
                                <td>{{ $staff->email }}</td>
                                <td>{{ $staff->username }}</td>
                                <td>
                                    <div>
                                        <span class="d-block">{{ showDateTime($staff->created_at) }}</span>
                                        <span>{{ diffForHumans($staff->created_at) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn--group">
                                        <button type="button" class="btn btn-sm btn-outline--primary editBtn" data-edit='@json($staff)'>
                                            <i class="la la-pencil"></i>@lang('Edit')
                                        </button>
                                        @if ($staff->id!=1)
                                        <button type="button" class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.staff.remove',$staff->id) }}" data-question="@lang('Are you sure to remove this staff')?">
                                            <i class="la la-trash"></i>@lang('Remove')
                                        </button>
                                        @endif
                                    </button>
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
                @if ($staffs->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($staffs) }}
                </div>
                @endif
            </div>
        </div>
    </div>

<div id="modal" class="modal fade" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('New Admin')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.staff.save') }}" >
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">@lang('Name')</label>
                        <input type="text" required class="form-control" autocomplete="off" name="name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Email')</label>
                        <input type="text" required class="form-control" autocomplete="off" name="email">
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Username')</label>
                        <input type="text" required class="form-control" autocomplete="off" name="username">
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Password')</label>
                        <input type="password"  class="form-control" autocomplete="off" name="password">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            @foreach ($permissions as  $permission)
                                <div class="col-lg-3">
                                    <label for="p_{{ $loop->index }}">
                                        <input value="{{titleToKey($permission)}}" name="permissions[]" id="p_{{$loop->index}}" type="checkbox">
                                        {{ $permission }}
                                    </label>
                                </div>
                            @endforeach
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
    <x-search-form placeholder="Username / Email" />
    <a class="btn btn-sm btn-outline--primary addBtn"><i class="las la-plus"></i>@lang('Add New')</a>
@endpush

@push('script')
    <script>
        "use strict";
        (function ($) {
            let modal=$("#modal");
            $('.addBtn').on('click',function(e){
                let action="{{ route('admin.staff.save') }}";
                modal.find('form').trigger('reset')
                modal.find(`input[name=password]`).closest('.form-group').removeClass('d-none')
                modal.find('form').attr('action',action);
                $(`input[type=checkbox]`).attr('checked',false);
                $(modal).find('.modal-title').text('New Staff');
                $(modal).modal('show')
            });
            $('.editBtn').on('click',function(e){

                let action = "{{ route('admin.staff.save',':id') }}";
                let edit   = $(this).data('edit');

                $(`input[type=checkbox]`).attr('checked',false);

                $.each(edit.access_permissions || [], function (i, permission) {
                    $(`input[value=${permission.toLowerCase().replace(/\s+/g, '_')}]`).attr('checked',true);
                });

                modal.find(`input[name=password]`).closest('.form-group').addClass('d-none');
                modal.find(`input[name=name]`).val(edit.name);
                modal.find(`input[name=email]`).val(edit.email);
                modal.find(`input[name=username]`).val(edit.username);

                modal.find('form').attr('action',action.replace(':id',edit.id));
                $(modal).find('.modal-title').text('Update Staff');
                $(modal).modal('show');
            });
        })(jQuery);

    </script>
@endpush
