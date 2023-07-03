@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="all-sections ptb-60">
        <div class="container-fluid">
            <div class="section-wrapper">
                <div class="row justify-content-center mb-30-none">
                    @include($activeTemplate . 'partials.buyer_sidebar')
                    <div class="col-xl-9 col-lg-12 mb-30">
                        <div class="dashboard-sidebar-open"><i class="las la-bars"></i> @lang('Menu')</div>
                        <form class="user-profile-form" action="{{route('user.buyer.job.store', $job->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card custom--card">
                                <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                                    <h4 class="card-title mb-0">
                                        {{__($pageTitle)}}
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="card-form-wrapper">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-6 col-lg-6 form-group">
                                                <div class="image-upload">
                                                    <div class="thumb">
                                                        <div class="avatar-preview">
                                                            <div class="profilePicPreview bg_img" data-background="{{ getImage(getFilePath('job').'/'.$job->image, getFileSize('job')) }}">
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
                                                        <input type="text" name="name" maxlength="255" value="{{$job->name}}" class="form-control" placeholder="@lang("Enter Name")" required>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 form-group">
                                                        <label>@lang('Category')</label>
                                                        <select class="form-control bg--gray" name="category_id" id="category" required>
                                                            <option selected value="">@lang('Select Category')</option>
                                                            @foreach($categories as $category)
                                                                <option value="{{$category->id}}" data-subcategories="{{@$category->subcategories}}">{{__($category->name)}}</option>
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
                                                            @foreach($job->skill as $skill)
                                                                <option value="{{$skill}}" selected="true">{{$skill}}</option>
                                                            @endforeach
                                                        </select>
                                                        <small>@lang('Skill and enter press')</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 form-group">
                                                <label>@lang('Budget')</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" step="any" min="0" class="form-control" name="price" value="{{getAmount($job->price)}}" placeholder="@lang('Enter Your Budget')" required>
                                                  <span class="input-group-text">{{__($general->cur_text)}}</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 form-group">
                                                <label>@lang('Delivery Time')</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control" name="delivery_time" value="{{$job->delivery_time}}" placeholder="@lang('Delivery Time')" required>
                                                    <span class="input-group-text">@lang('Day(s)')</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 form-group">
                                                <label>@lang('Description')</label>
                                                <textarea class="form-control bg--gray nicEdit" name="description">{{ $job->description }}</textarea>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 form-group">
                                                <label>@lang('Requirement')</label>
                                                <textarea class="form-control bg--gray nicEdit" name="requirements">{{ $job->requirements }}</textarea>
                                            </div>
                                            <div class="col-xl-12">
                                                <button type="submit" class="submit-btn w-100">@lang('Update')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@include($activeTemplate . 'partials.basic_script')

@push('script')
    <script>
        "use strict";

        $('select[name="category_id"]').val('{{ $job->category_id }}');

        $('#category').on('change', function() {
            var subcategories = $(this).find('option:selected').data('subcategories');
            var html = `<option value="">@lang('Select One')</option>`;

            if (subcategories && subcategories.length > 0) {
                $.each(subcategories, function(i, v) {
                    html += `<option value="${v.id}" ${v.id == `{{ $job->sub_category_id }}` ? 'selected': '' }>@lang('${v.name}')</option>`;
                });
            }

            $('.subcategory').html(html);
        }).change();
    </script>
@endpush

