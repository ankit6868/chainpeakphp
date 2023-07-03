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
                                    <th>@lang('Image')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($subcategories as $subcategory)
                                    <tr>
                                        <td>{{ $loop->index+$subcategories->firstItem() }}</td>
                                        <td>{{ __($subcategory->name) }}</td>
                                        <td>
                                            <div class="user justify-content-center">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('subcategory') . '/' . $subcategory->image, getFileSize('subcategory')) }}" alt="@lang('image')">
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ __(@$subcategory->category->name) }}</td>
                                        <td>
                                            @php echo $subcategory->statusBadge @endphp
                                        </td>
                                        <td>
                                            @php
                                                $subcategory->image_with_path = getImage(getFilePath('subcategory') . '/' . $subcategory->image, getFileSize('subcategory'));
                                            @endphp
                                            <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-resource="{{ $subcategory }}" data-modal_title="@lang('Edit Subcategory')" data-has_status="1">
                                                <i class="la la-pencil"></i>@lang('Edit')
                                            </button>
                                            @if ($subcategory->status == Status::DISABLE)
                                            <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn" data-action="{{ route('admin.subcategory.status',$subcategory->id) }}" data-question="@lang('Are you sure to enable this subcategory?')" type="button">
                                                <i class="la la-eye"></i> @lang('Enable')
                                            </button>
                                            @else
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.subcategory.status',$subcategory->id) }}" data-question="@lang('Are you sure to disable this subcategory?')" type="button">
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

                @if ($subcategories->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($subcategories) }}
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
                <form action="{{ route('admin.subcategory.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>@lang('Name')</label>
                                    <input type="text" class="form-control" name="name" placeholder="" value="{{ old('name') }}" required />
                                </div>
                                <div class="form-group">
                                    <label>@lang('Category')</label>
                                    <select class="form-control" name="category_id">
                                        <option value="" selected disabled>@lang('Select One')</option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{ __($category->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Image')</label>
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage('', getFileSize('subcategory')) }})">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg" required>
                                                <label for="profilePicUpload1" class="bg--primary">@lang('Upload Image')</label>
                                                <small class="mt-2">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg'), @lang('png').</b> @lang('Image will be resized into ') <span>{{ __(getFileSize('subcategory')) }}</span> @lang('px')</small>
                                            </div>
                                        </div>
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
    <x-confirmation-modal />

@endsection

@push('breadcrumb-plugins')
    <x-search-form />
    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-image_path="{{getImage(null, getFileSize('subcategory')) }}" data-modal_title="@lang('Add New Subcategory')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/cu-modal.js') }}"></script>
@endpush
