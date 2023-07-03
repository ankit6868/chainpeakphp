@extends($activeTemplate.'layouts.master')
@section('content')
<form class="row gy-4" action="{{route('user.seller.software.store', $software->id)}}" method="POST" enctype="multipart/form-data">
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
                <h4 class="card-title">@lang('Basic Information')</h4>
            </div>
            <div class="card-body pt-2">
                <div class="row justify-content-center">
                    <div class="col-12 form-group">
                        <label>@lang('Name')</label>
                        <input type="text" name="name" maxlength="255" value="{{__($software->name)}}" class="form-control" placeholder="@lang("Enter Name")" required>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>@lang('Category')</label>
                        <select class="form-control bg--gray" name="category_id" id="category" required>
                            <option selected value="">@lang('Select Category')</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" data-subcategories="{{@$category->subcategories}}">{{__($category->name)}}</option>
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
                            <input type="number" step="any" min="0" class="form-control" name="price" value="{{getAmount($software->price)}}" placeholder="@lang('Enter Price')" required>
                          <span class="input-group-text">{{__($general->cur_text)}}</span>
                        </div>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>@lang('Demo Url')</label>
                        <input type="url"  class="form-control" name="demo_url" value="{{$software->demo_url}}" placeholder="@lang('https://example.com/')" required>
                    </div>
                    <div class="col-lg-6 form-group select2Tag">
                        <label>@lang('Tag')</label>
                        <select class="form-control select2" name="tag[]" multiple="multiple" required>
                            @foreach($software->tag as $tag)
                                <option value="{{$tag}}" selected="true">{{$tag}}</option>
                            @endforeach
                        </select>
                        <small>@lang('Tag and enter press')</small>
                    </div>
                    <div class="col-lg-6 form-group select2Tag">
                        <label>@lang('File Include')</label>
                        <select class="form-control select2" name="file_include[]" multiple="multiple" required>
                            @foreach($software->file_include as $fileInclude)
                                <option value="{{$fileInclude}}" selected="true">{{$fileInclude}}</option>
                            @endforeach
                        </select>
                        <small>@lang('File name and enter press')</small>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label>@lang('Include Feature')</label>
                        <div class="d-flex gap-3 ">
                            @foreach($features as $feature)
                            <div class="form-group custom-check-group">
                                <input type="checkbox" name="features[]" id="{{$feature->id}}" value="{{$feature->id}}"
                                @if(in_array($feature->id, $software->features)) checked @endif>
                                <label for="{{$feature->id}}">{{__($feature->name)}}</label>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <label>@lang('Description')</label>
                        <textarea class="form-control bg--gray nicEdit" name="description">
                            @php echo $software->description @endphp
                        </textarea>
                    </div>

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
            <div class="card-body row pt-2">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="image-upload">
                            <div class="thumb">
                                <div class="avatar-preview">
                                    <div class="profilePicPreview bg_img" data-background="{{ getImage(getFilePath('software').'/'.$software->image, getFileSize('software')) }}">
                                        <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="avatar-edit">
                                    <input type="file" class="profilePicUpload" name="image" id="profilePicUpload2" accept=".png, .jpg, .jpeg">
                                    <label for="profilePicUpload2" class="text-light">@lang('Image')</label>
                                    <small>@lang('Supported files'): @lang('jpeg'), @lang('jpg'), @lang('png'). @lang('Image will be resized into') <b>{{getFileSize('software')}}</b> @lang('px')</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="mb-0">@lang('Documentation File')</label>
                            <div class="custom-file-wrapper">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="document_file" id="customFile" accept=".pdf">
                                    <label class="custom-file-label" for="customFile">@lang('Choose file')</label>
                                </div>
                                <small>@lang('Supported file: only .pdf file')</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">@lang('Software File')</label>
                            <div class="custom-file-wrapper">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="software_file" id="customFile" accept=".zip">
                                    <label class="custom-file-label" for="customFile">@lang('Choose file')</label>
                                </div>
                                <small>@lang('Supported file: only .zip file')</small>
                            </div>
                        </div>
                        <div class="addImage">
                            @if(!empty($software->extra_image))
                                <div class="row">
                                    @foreach($software->extra_image as $extraImage)
                                        <div class="col-xl-4 col-lg-4 col-sm-6 form-group">
                                            <span class="remove-image-two confirmationBtn" type="button" data-question="@lang('Are you sure to remove this image?')" data-action="{{ route('user.image.remove', [$software->id, $extraImage, 'software']) }}">
                                                <i class="las la-times"></i>
                                            </span>
                                            <img class="optional_img" src="{{ getImage(getFilePath('extraImage').'/'.$extraImage, getFileSize('extraImage')) }}">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <button type="submit" class="submit-btn  w-100 h-45">@lang('Update')</button>
    </div>
</form>

<x-confirmation-modal class="frontend" />
@endsection

@include($activeTemplate . 'partials.basic_script')

@push('style')
    <style>
        .remove-image-two {
            position: absolute;
            width: 20px;
            height: 20px;
            right: 12px;
            top: 2px;
            font-size: 14px;
            color: #fff;
            background: #FF0000;
            display: grid;
            place-items: center;
            border-radius: 20px;
            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            -ms-border-radius: 20px;
            -o-border-radius: 20px;
            cursor: pointer;
        }
    </style>
@endpush

@push('script')
    <script>
        "use strict";

        $('select[name="category_id"]').val('{{ $software->category_id }}');

        $('#category').on('change', function() {
            var subcategories = $(this).find('option:selected').data('subcategories');
            var html = `<option value="">@lang('Select One')</option>`;

            if (subcategories && subcategories.length > 0) {
                $.each(subcategories, function(i, v) {
                    html += `<option value="${v.id}" ${v.id == `{{ $software->sub_category_id }}` ? 'selected': '' }>@lang('${v.name}')</option>`;
                });
            }

            $('.subcategory').html(html);
        }).change();
    </script>
@endpush
