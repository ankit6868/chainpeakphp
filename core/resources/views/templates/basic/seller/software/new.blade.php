@extends($activeTemplate.'layouts.master')
@section('content')
<form method="POST" enctype="multipart/form-data" class="row gy-4" action="{{route('user.seller.software.store')}}">
    @csrf
    <div class="col-12">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <h4 class="card-title">{{__($pageTitle)}}</h4>
            <a href="{{route('user.seller.software.index')}}" class="btn btn--base"><i class="las la-list"></i>@lang('Software List')</a>
        </div>
    </div>
    <div class="col-12">
        <div class="card custom--card">
            <div class="card-header">
                <h5 class="card-title">@lang('Basic Information')</h5>
            </div>
            <div class="card-body pt-2 row">
                <div class="col-lg-12 form-group">
                    <label>@lang('Name')</label>
                    <input type="text" name="name" maxlength="255" value="{{old('name')}}" class="form-control" placeholder="@lang("Enter Name")" required>
                </div>
                <div class="col-lg-6 form-group">
                    <label>@lang('Category')</label>
                    <select class="form-control bg--gray" name="category_id" id="category" required>
                        <option selected value="">@lang('Select Category')</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" @selected(old('category_id') == $category->id) data-subcategories="{{@$category->subcategories}}">{{__($category->name)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 form-group">
                    <label>@lang('Subcategory')</label>
                    <select class="form-control bg--gray subcategory" name="sub_category_id" required></select>
                </div>
                <div class="col-lg-6 form-group">
                    <label>@lang('Price')</label>
                    <div class="input-group">
                        <input type="number" step="any" min="0" class="form-control" name="price" value="{{old('price')}}" placeholder="@lang('Enter Price')" required>
                      <span class="input-group-text">{{__($general->cur_text)}}</span>
                    </div>
                </div>
                <div class="col-lg-6 form-group">
                    <label>@lang('Demo Url')</label>
                    <input type="url"  class="form-control" name="demo_url" value="{{old('demo_url')}}" placeholder="@lang('https://example.com/')" required>
                </div>
                <div class="col-lg-6 form-group select2Tag">
                    <label>@lang('Tag')</label>
                    <select class="form-control select2" name="tag[]" multiple="multiple" required>
                        @foreach (old('tag') ?? [] as $tag)
                            <option value="{{ $tag }}" selected>{{ __($tag) }}</option>
                        @endforeach
                    </select>
                    <small>@lang('Tag and enter press')</small>
                </div>
                <div class="col-lg-6 form-group select2Tag">
                    <label>@lang('File Include')</label>
                    <select class="form-control select2" name="file_include[]" multiple="multiple" required>
                        @foreach (old('file_include') ?? [] as $oldIncludeFile)
                            <option value="{{ $oldIncludeFile }}" selected>{{ __($oldIncludeFile) }}</option>
                        @endforeach
                    </select>
                    <small>@lang('File name and enter press')</small>
                </div>
                <div class="col-12 form-group">
                    <label>@lang('Include Feature')</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach($features as $feature)
                        <div class="form-group custom-check-group">
                            <input type="checkbox" name="features[]" id="{{$feature->id}}" value="{{$feature->id}}" @checked(in_array($feature->id,old('features') ?? []))>
                            <label for="{{$feature->id}}">{{__($feature->name)}}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 form-group">
                    <label>@lang('Description')</label>
                    <textarea class="form-control bg--gray nicEdit" name="description">{{old('description')}}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card custom--card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="card-title mb-0">
                    @lang('Image & Document')
                </h4>
                <button type="button" class="btn btn--base btn--sm addExtraImage"><i class="las la-plus"></i>@lang('More Image')</button>
            </div>
            <div class="card-body row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview bg_img" data-background="{{ getImage('', getFileSize('software')) }}">
                                            <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" class="profilePicUpload" name="image" id="profilePicUpload2" accept=".png, .jpg, .jpeg">
                                        <label for="profilePicUpload2" class="text-light">@lang('Image')</label>
                                        <small>@lang('Supported files'): @lang('jpeg'), @lang('jpg'), @lang('png'). @lang('Image will be resized into ') <b>{{getFileSize('software')}}</b> @lang('px')</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="mb-0">@lang('Documentation File')</label>
                                <div class="custom-file-wrapper">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="document_file" id="customFile" accept=".pdf" required>
                                        <label class="custom-file-label" for="customFile">@lang('Choose file')</label>
                                    </div>
                                    <small>@lang('Only .pdf file is supported')</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">@lang('Software File')</label>
                                <div class="custom-file-wrapper">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="software_file" id="customFile" accept=".zip" required>
                                        <label class="custom-file-label" for="customFile">@lang('Choose file')</label>
                                    </div>
                                    <small>@lang('Only .zip file is supported')</small>
                                </div>
                            </div>
                            <div class="addImage"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn--base w-100 h-45">@lang('Submit')</button>
    </div>
</form>
@endsection
@include($activeTemplate . 'partials.basic_script')

@push('script')
    <script>
        "use strict";

        $('#category').on('change', function() {
            var subcategories = $(this).find('option:selected').data('subcategories');
            var html = `<option value="">@lang('Select One')</option>`;

            if (subcategories && subcategories.length > 0) {
                $.each(subcategories, function(i, v) {
                    html += `<option value="${v.id}">@lang('${v.name}')</option>`;
                });
            }
            $('.subcategory').html(html);
        }).change();

    </script>
@endpush
