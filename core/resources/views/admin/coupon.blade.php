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
                                    <th>@lang('Code')</th>
                                    <th>@lang('Value')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($coupons as $coupon)
                                    <tr>
                                        <td>{{$loop->index+$coupons->firstItem() }}</td>
                                        <td>{{ __($coupon->name) }}</td>
                                        <td>{{ $coupon->code }}</td>
                                        <td>
                                            @php echo $coupon->valueData @endphp
                                        </td>
                                        <td>
                                            @php echo $coupon->typeBadge @endphp
                                        </td>
                                        <td>
                                            @php echo $coupon->statusBadge @endphp
                                        </td>
                                        <td>
                                           <div class="button--group">
                                            <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn editBtn" data-resource="{{ $coupon }}" data-modal_title="@lang('Edit Coupon')" data-has_status="1">
                                                <i class="la la-pencil"></i>@lang('Edit')
                                            </button>
                                            @if ($coupon->status == Status::DISABLE)
                                            <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn" data-action="{{ route('admin.coupon.status',$coupon->id) }}" data-question="@lang('Are you sure to enable this coupon')?" type="button">
                                                <i class="la la-eye"></i> @lang('Enable')
                                            </button>
                                            @else
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.coupon.status',$coupon->id) }}" data-question="@lang('Are you sure to disable this coupon')?" type="button">
                                                    <i class="la la-eye-slash"></i> @lang('Disable')
                                                </button>
                                            @endif
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
                @if ($coupons->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($coupons) }}
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
                <form action="{{ route('admin.coupon.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>@lang('Name')</label>
                                    <input type="text" class="form-control" name="name" placeholder="@lang('Enter Coupon Name')" value="{{ old('name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Code')</label>
                                    <input type="text" class="form-control" name="code" placeholder="@lang('Enter Code')" value="{{ old('code') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Type')</label>
                                    <select name="type" class="form-control" required>
                                        <option value="1">@lang('Fixed')</option>
                                        <option value="2">@lang('Percentage')</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Discount Value')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="value" min="0" placeholder="@lang('Enter Discount Value')" value="{{ old('value') }}" required>
                                        <span class="input-group-text fixed-percentage">{{__($general->cur_text)}}</span>
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
<x-search-form placeholder="Name / Code" />
<button type="button" class="btn btn-sm btn-outline--primary me-2 cuModalBtn" data-modal_title="@lang('Add New Coupon')">
    <i class="las la-plus"></i>@lang('Add New')
</button>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/cu-modal.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('[name=type]').on('change', function() {
                var value = $(this).val();

                if (value == 1) {
                    $('#cuModal').find('.fixed-percentage').text(`{{__($general->cur_text)}}`);
                } else {
                    $('#cuModal').find('.fixed-percentage').text('%');
                }
            });

            $('.cuModalBtn').on('click', function() {
                $('#cuModal').find('.fixed-percentage').text(`{{__($general->cur_text)}}`);
            });

            $('.editBtn').on('click', function() {
                var resource = $(this).data('resource');

                if (resource.type == 1) {
                    $('#cuModal').find('.fixed-percentage').text(`{{__($general->cur_text)}}`);
                } else {
                    $('#cuModal').find('.fixed-percentage').text('%');
                }
            });

            $('#cuModal').find('[name=code]').on('keyup', function(e) {
                var keyCode = e.keyCode || e.which;
                var regex = /^[A-Za-z0-9]+$/;
                var isValid = regex.test(String.fromCharCode(keyCode));
                if (e.keyCode == 32) {
                    $(this).val($(this).val().replace(/\s+/g, '-'));
                }
            });
        })(jQuery);
    </script>
@endpush
