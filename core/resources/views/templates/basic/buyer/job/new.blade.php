@extends($activeTemplate.'layouts.master')
@section('content')
<form class="user-profile-form" action="{{route('user.buyer.job.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card custom--card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
            <h4 class="card-title mb-0">{{__($pageTitle)}} </h4>
        </div>
        <div class="card-body">
            <div class="card-form-wrapper">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-6 form-group">
                        <div class="image-upload">
                            <div class="thumb">
                                <div class="avatar-preview">
                                    <div class="profilePicPreview bg_img" data-background="{{getImage('', getFileSize('job')) }}">
                                        <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="avatar-edit">
                                    <input type="file" class="profilePicUpload" name="image" id="profilePicUpload2" accept=".png, .jpg, .jpeg">
                                    <label for="profilePicUpload2" class="text-light">@lang('Image')</label>
                                    <small>@lang('Supported files'): @lang('jpeg'), @lang('jpg'), @lang('png'). @lang('Image will be resized into ') <b>{{getFileSize('job')}}</b> @lang('px')</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 form-group">
                                <label>@lang('Name')</label>
                                <input type="text" name="name" maxlength="255" value="{{old('name')}}" class="form-control" placeholder="@lang("Enter Name")" required>
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                <label>@lang('Category')</label>
                                <select class="form-control bg--gray" name="category_id" id="category" required>
                                    <option selected value="">@lang('Select Category')</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" @selected(@$category->id == old('category_id')) data-subcategories="{{@$category->subcategories}}">{{__($category->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                <label>@lang('Subcategory')</label>
                                <select class="form-control bg--gray subcategory" name="sub_category_id" required></select>
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group select2Tag">
                                <label>@lang('Skill')</label>
                                <select class="form-control select2" name="skill[]" multiple="multiple" required>
                                    @foreach (old('skill',[]) as $oldSkill)
                                        <option value="{{ $oldSkill }}" selected>{{ __($oldSkill) }}</option>
                                    @endforeach
                                </select>
                                <small>@lang('Skill and enter press')</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        <label>@lang('Budget')</label>
                        <div class="input-group mb-3">
                            <input type="number" step="any" min="0" class="form-control" name="price" value="{{old('price')}}" placeholder="@lang('Enter Your Budget')" required>
                          <span class="input-group-text">{{__($general->cur_text)}}</span>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        <label>@lang('Delivery Time')</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" min="1" name="delivery_time" value="{{old('delivery_time')}}" placeholder="@lang('Delivery Time')" required>
                            <span class="input-group-text">@lang('Day(s)')</span>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <label>@lang('Description')</label>
                        <textarea class="form-control bg--gray nicEdit" name="description">{{old('description')}}</textarea>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <label>@lang('Requirement')</label>
                        <textarea class="form-control bg--gray nicEdit" name="requirements">{{old('requirements')}}</textarea>
                    </div>
                    <div class="col-xl-12">
                        <button type="submit" class="submit-btn mt-20 w-100">@lang('Create')</button>
                    </div>
                </div>
            </div>
        </div>
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

