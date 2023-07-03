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
                                    <th>@lang('Type')</th>
                                    <th>@lang('Value')</th>
                                    <th>@lang('Size')</th>
                                    <th>@lang('Impression')</th>
                                    <th>@lang('Click')</th>
                                    <th>@lang('Redirect')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($advertisements as $advertisement)
                                    <tr id={{ 'row_' . $advertisement->id }}>
                                        <td>{{ __(@$advertisement->type) }}</td>
                                        <td>
                                            @if (@$advertisement->type == 'image')
                                                <div class="user justify-content-center">
                                                    <div class="thumb">
                                                        <img id="image__{{ $advertisement->id }}" src="{{ getImage(getFilePath('advertisement'). '/' . @$advertisement->value) }}" alt="@lang('image')">
                                                    </div>
                                                </div>
                                            @else
                                                <span class="badge badge--primary">@lang('Script')</span>
                                            @endif
                                        </td>
                                        <td>{{ __(@$advertisement->size) }}</td>
                                        <td>{{ @$advertisement->impression }}</td>
                                        <td>{{ @$advertisement->click }}</td>
                                        <td>
                                            <a target="_blank" href="{{ @$advertisement->redirect_url }}" title="{{ @$advertisement->redirect_url }}">
                                                <i class="las la-external-link-alt"></i>
                                            </a>
                                        </td>
                                        <td> @php echo $advertisement->statusBadge @endphp </td>
                                        <td>
                                            <div class="button--group">
                                                <button data-advertisement='@json($advertisement)'
                                                    class="btn btn-sm btn-outline--primary editBtn">
                                                    <i class="la la-pen"></i>@lang('Edit')
                                                </button>
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{route('admin.advertisement.remove', $advertisement->id)}}" data-question="@lang('Are you sure to remove this ad')?">
                                                    <i class="la la-trash"></i>@lang('Remove')
                                                </button>
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
                @if ($advertisements->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($advertisements) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{--Create Modal--}}
    <div class="modal   fade " id="modal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel"> @lang('Add Advertisement')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>

                <form class="form-horizontal" method="post" action="{{ route('admin.advertisement.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Advertisement Type')</label>
                                    <select class="form-control" name="type" required>
                                        <option value="image">@lang('Image')</option>
                                        <option value="script">@lang('Script')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 d-none" id="image-ad">
                                <div class="form-group">
                                    <label class="fw-bold required">@lang('Size')</label>
                                    <select class="form-control" name="size">
                                        <option value="300x250">@lang('300x250')</option>
                                        <option value="728x90">@lang('728x90')</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="fw-bold required">@lang('Image')</label>
                                    <input type="file" class="form-control" accept=".png, .jpg, .jpeg, .gif" name="image">
                                    <small>
                                        @lang('Supported files'): <b>@lang('jpeg'), @lang('jpg'), @lang('png'), @lang('gif').</b>
                                        @lang('Image size must be ') <span class="image-size text--dark">@lang('300x250')</span> @lang('px')
                                    </small>
                                </div>
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Redirect Url') <strong class="text-danger">*</strong> </label>
                                    <input type="url" class="form-control" name="redirect_url" placeholder="@lang('Redirect Url')">
                                </div>
                            </div>
                            <div class="col-lg-12 d-none" id="script-ad">
                                <div class="form-group">
                                    <label class="fw-bold">@lang('Script') <strong class="text-danger">*</strong></label>
                                    <textarea name="script" class="form-control" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45" id="btn-save" value="add">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-sm btn-outline--primary new-ad"><i  class="las la-plus"></i>@lang('New Advertisement')</button>
@endpush

@push('script')
    <script>
        (function($) {
            let modal=$("#modal");

            $('.new-ad').on('click',function (e) {
                let action="{{ route('admin.advertisement.store') }}";
                $(modal).find('.modal-title').text("@lang('Add Advertisement')");
                $(modal).find('form').attr("action",action);
                changeType()
                changeType();
                modal.modal('show')
             });

             $('select[name=type]').on('change',function(e){
                changeType();
             });

             function changeType(){
                let value=$("select[name=type]").val();
                if(value=='image'){
                    $(modal).find(`#image-ad`).removeClass('d-none');
                    $(modal).find(`#script-ad`).addClass('d-none');
                }else{
                    $(modal).find(`#image-ad`).addClass('d-none');
                    $(modal).find(`#script-ad`).removeClass('d-none');
                }
             }

             function changeSize(){
                let size=$("select[name=size]").val();
                $('.image-size').text(size);
             }

             $('select[name=size]').on('change',function(){
                changeSize();
             });

             $('.editBtn').on('click',function(e){

                let advertisement = $(this).data('advertisement');
                let action        = "{{ route('admin.advertisement.store',':id') }}";

                $(modal).find('.modal-title').text("@lang('Edit Advertisement')");
                $(modal).find('form').attr("action",action.replace(":id",advertisement.id));

                $(modal).find('select[name=type]').val(advertisement.type);
                $(modal).find('select[name=size]').val(advertisement.size);
                $(modal).find('input[name=redirect_url]').val(advertisement.redirect_url);
                changeType();
                changeSize();
                $(modal).modal('show');
             });
        })(jQuery);
    </script>
@endpush
