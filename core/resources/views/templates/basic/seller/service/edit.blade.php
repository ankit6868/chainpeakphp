@extends($activeTemplate.'layouts.master')
@section('content')
<form class="row gy-4" action="{{route('user.seller.service.store', $service->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="col-12">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <h4 class="card-title">
                {{__($pageTitle)}}
            </h4>
            <a href="{{ route('user.seller.service.index') }}" class="btn btn--base"><i class="las la-list"></i> @lang('All Service')</a>
        </div>
    </div>
    <div class="col-12">
        <div class="card custom--card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h5 class="card-title">@lang('Basic Information')</h5>
            </div>
            <div class="card-body row pt-2">
                <div class="col-12 form-group">
                    <label>@lang('Name')</label>
                    <input type="text" name="name" maxlength="255" value="{{$service->name}}" class="form-control" required>
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
                        <input type="number" step="any" min="0" class="form-control" name="price" value="{{getAmount($service->price)}}" placeholder="@lang('Enter Price')" required>
                        <span class="input-group-text">{{__($general->cur_text)}}</span>
                    </div>
                </div>
                <div class="col-lg-6 form-group">
                    <label>@lang('Max Order Quantity')</label>
                    <div class="input-group">
                        <input type="number" min="1" class="form-control" name="max_order_qty" value="{{$service->max_order_qty}}" placeholder="@lang('Enter Quantity')" required>
                        <span class="input-group-text">@lang('Unit(s)')</span>
                    </div>
                </div>
                <div class="col-lg-6 form-group">
                    <label>@lang('Delivery Time')</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="delivery_time" value="{{$service->delivery_time}}" placeholder="@lang('Delivery Time')" required>
                        <span class="input-group-text">@lang('Day(s)')</span>
                    </div>
                </div>
                <div class="col-lg-6 form-group select2Tag">
                    <label>@lang('Tag')</label>
                    <select class="form-control select2" name="tag[]" multiple="multiple" required>
                        @foreach($service->tag as $tag)
                            <option value="{{$tag}}" selected="true">{{$tag}}</option>
                        @endforeach
                    </select>
                    <small>@lang('Minimum 3 & maximum 5 tag.')</small>
                </div>
                <div class="col-lg-12 form-group">
                    <label>@lang('Include Feature')</label>
                    <div class="d-flex gap-3 flex-wrap">
                        @foreach($features as $feature)
                        <div class="form-group custom-check-group">
                            <input type="checkbox" name="features[]" id="features_{{$feature->id}}" value="{{$feature->id}}"
                            @checked( $service->features && in_array($feature->id, $service->features))>
                            <label for="features_{{$feature->id}}">{{__($feature->name)}}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 form-group">
                    <label class="required">@lang('Description')</label>
                    <textarea class="form-control bg--gray nicEdit" name="description">{{ $service->description }}</textarea>
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
            <div class="card-body row pt-2">
                <div class="col-lg-6">
                    <div class="image-upload">
                        <div class="thumb">
                            <div class="avatar-preview">
                                <div class="profilePicPreview bg_img" data-background="{{getImage(getFilePath('service').'/'.$service->image, getFileSize('service')) }}">
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
                    <div class="addImage p-2 shadow rounded">
                        @if(!empty($service->extra_image))
                            <div class="row">
                                @foreach($service->extra_image as $extraImage)
                                    <div class="col-xl-4 col-lg-4 col-sm-4 col-4 form-group">
                                        <span class="remove-image-two confirmationBtn" type="button" data-question="@lang('Are you sure to remove this image?')" data-action="{{ route('user.image.remove', [$service->id, $extraImage, 'service']) }}">
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
    <div class="col-12">
        <div class="card custom--card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="card-title"> @lang('Extra Service')</h4>
                <div class="card-btn">
                    <button type="button" class="btn btn--base btn--sm addExtra"><i class="las la-plus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-center addExtraService">
                    @if (count($service->extraServices))
                        @foreach ($service->extraServices as $extraService)
                            <div class="col-lg-12 extraServiceRemove">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="{{$extraService->name}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" value="{{getAmount($extraService->price)}}" readonly>
                                            <span class="input-group-text">{{__($general->cur_text)}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="button" class="btn btn--primary h-45  updateBtn" data-name="{{$extraService->name}}" data-price="{{getAmount($extraService->price)}}" data-id="{{$extraService->id}}">
                                            @lang('Edit')
                                        </button>
                                        @if ($extraService->status == Status::DISABLE)
                                            <button type="button" class="btn btn--success h-45 confirmationBtn w-50" data-question="@lang('Are you sure to enable this')?" data-action="{{ route('user.seller.service.extra.service.status', [$service->id, $extraService->id]) }}">
                                                @lang('Enable')
                                            </button>
                                        @else
                                            <button type="button" class="btn btn--danger h-45 confirmationBtn w-50" data-question="@lang('Are you sure to disable this')?" data-action="{{ route('user.seller.service.extra.service.status', [$service->id, $extraService->id]) }}">
                                                @lang('Disable')
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn--base w-100 h-45">@lang('Update')</button>
    </div>
</form>

    <x-confirmation-modal class="frontend" />

    <div id="updateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Update Extra Service')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="POST" class="extra-servicee-update">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <input type="text" name="extra_name" maxlength="255" class="form-control" placeholder="@lang("Enter service name")" required>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" name="extra_price" placeholder="@lang('Enter Price')" required>
                                    <span class="input-group-text">{{__($general->cur_text)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

        $('select[name="category_id"]').val('{{ $service->category_id }}');

        $('#category').on('change', function() {
            var subcategories = $(this).find('option:selected').data('subcategories');
            var html = `<option value="">@lang('Select One')</option>`;

            if (subcategories && subcategories.length > 0) {
                $.each(subcategories, function(i, v) {
                    html += `<option value="${v.id}" ${v.id == `{{ $service->sub_category_id }}` ? 'selected': '' }>@lang('${v.name}')</option>`;
                });
            }
            $('.subcategory').html(html);
        }).change();

        $('.updateBtn').on('click', function () {
            var modal     = $('#updateModal');
            var name      = $(this).data('name');
            var price     = $(this).data('price');
            var serviceId = $(this).data('id');

            modal.find('[name=extra_name]').val(name);
            modal.find('[name=extra_price]').val(price);
            modal.find('.extra-servicee-update').attr('action', `{{route('user.seller.service.extra.service.update', [$service->id, ''])}}/${serviceId}`);
            modal.modal('show');
        });
    </script>
@endpush
