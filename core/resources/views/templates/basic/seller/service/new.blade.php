@extends($activeTemplate.'layouts.master')
@section('content')
<form class="row gy-3"  action="{{route('user.seller.service.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="col-12">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <h4> {{__($pageTitle)}} </h4>
            <a href="{{ route('user.seller.service.index') }}" class="btn btn--base"><i class="las la-list"></i> @lang('All Service')</a>
        </div>
    </div>
    <div class="col-12">
        <div class="card custom--card">
            <div class="card-header">
                <h5 class="card-title">@lang('Basic Information')</h5>
            </div>
            <div class="card-body row  pt-3">
                <div class="form-group col-12">
                    <label>@lang('Name')</label>
                    <input type="text" name="name" maxlength="255" value="{{old('name')}}" class="form-control"  required>
                </div>
                <div class="form-group col-lg-6">
                    <label>@lang('Category')</label>
                    <select class="form-control" name="category_id" id="category" required>
                        <option selected value="">@lang('Select Category')</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" @selected($category->id == old('category_id')) data-subcategories="{{@$category->subcategories}}">{{__($category->name)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label>@lang('Subcategory')</label>
                    <select class="form-control bg--gray subcategory" name="sub_category_id" required></select>
                </div>
                <div class="form-group col-lg-6">
                    <label>@lang('Price')</label>
                    <div class="input-group">
                        <input type="number" step="any" min="0" class="form-control" name="price" value="{{old('price')}}" required>
                      <span class="input-group-text">{{__($general->cur_text)}}</span>
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <label>@lang('Max Order Quantity')</label>
                    <div class="input-group">
                        <input type="number" min="1" class="form-control" name="max_order_qty" value="{{old('max_order_qty')}}"  required>
                        <span class="input-group-text">@lang('Unit(s)')</span>
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <label>@lang('Delivery Time')</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="delivery_time" value="{{old('delivery_time')}}" required>
                        <span class="input-group-text">@lang('Day(s)')</span>
                    </div>
                </div>
                <div class="form-group col-lg-6  select2Tag">
                    <label>@lang('Tag')</label>
                    <select class="form-control select2" name="tag[]" multiple="multiple" required>
                        @foreach (old('tag',[]) as $oldTag)
                            <option value="{{ $tag }}">{{ __($tag) }}</option>
                        @endforeach
                    </select>
                    <small>@lang('Minimum 3 & maximum 5 tag.')</small>
                </div>
                <div class="form-group col-lg-12">
                    <label>@lang('Include Feature')</label>
                    <div class="d-flex gap-3 flex-wrap">
                        @foreach($features as $feature)
                        <div class="form-group custom-check-group">
                            <input type="checkbox" @checked(in_array($feature->id,old('features') ?? [] ))  name="features[]" id="{{$feature->id}}" value="{{$feature->id}}">
                            <label for="{{$feature->id}}">{{__($feature->name)}}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group col-xl-12 col-lg-12 form-group">
                    <label class="required">@lang('Description')</label>
                    <textarea class="form-control bg--gray nicEdit" name="description">{{old('description')}}</textarea>
                </div>
            </div>

        </div>
    </div>
    <div class="col-12">
        <div class="card custom--card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="card-title"> @lang('Image')</h4>
                <button type="button" class="btn btn--base btn--sm addExtraImage"><i class="las la-plus"></i></button>
            </div>
            <div class="card-body row">
                <div class="col-lg-6">
                    <div class="image-upload">
                        <div class="thumb">
                            <div class="avatar-preview">
                                <div class="profilePicPreview bg_img" data-background="{{ getImage('', getFileSize('service')) }}">
                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="avatar-edit">
                                <input type="file" class="profilePicUpload" name="image" id="profilePicUpload2" accept=".png, .jpg, .jpeg">
                                <label for="profilePicUpload2" class="text-light">@lang('Image')</label>
                                <small>@lang('Supported files'): @lang('jpeg'), @lang('jpg'), @lang('png'). @lang('Image will be resized into ') <b>{{getFileSize('service')}}</b> @lang('px')</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="addImage"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card custom--card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h5 class="card-title"> @lang('Extra Service') </h5>
                <button type="button" class="btn btn--base btn--sm addExtra"><i class="las la-plus"></i></button>
            </div>
            <div class="card-body addExtraService">

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
