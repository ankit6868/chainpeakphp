@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row justify-content-end gy-3">
    <div class="col-lg-8  text-end">
        <form class="d-flex gap-3 align-items-center justify-content-end">
         <div class="input-group w-50">
             <input type="text" class="form-control" name="search" value="{{ request()->search ?? '' }}" placeholder="@lang('Search') ...">
             <button type="submit" class="btn btn--base input-group-text">@lang('Search')</button>
         </div>
         <a href="{{ route('user.seller.software.new') }}" class="btn btn--base p-2-5">@lang('Upload Software')</a>
        </form>
     </div>
    <div class="col-12">
        <div class="table-section">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="table-area">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Last Update')</th>
                                    <th>@lang('Software')</th>
                                    <th>@lang('Documentation')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($softwares as $software)
                                    <tr>
                                        <td class="text-start">
                                            <div class="author-info">
                                                <div class="thumb">
                                                    <img src="{{getImage(getFilePath('software').'/'.$software->image,getFileSize('software')) }}" alt="@lang('Software Image')">
                                                </div>
                                                <div class="content">{{__(strLimit($software->name, 30))}}</div>
                                            </div>
                                        </td>
                                        <td>{{__($software->category->name)}}</td>
                                        <td>{{showAmount($software->price)}} {{__($general->cur_text)}}</td>
                                        <td> <div>@php echo $software->customStatusBadge @endphp</div> </td>
                                        <td>
                                            {{showDateTime($software->updated_at)}}
                                            <br>
                                            {{diffforhumans($software->updated_at)}}
                                        </td>
                                        <td>
                                            <a href="{{route('file.download', [encrypt($software->software_file), 'file'])}}" class="btn btn--primary btn--sm" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Software File')"><i class="las la-download"></i></a>
                                        </td>
                                        <td>
                                            <a href="{{route('file.download', [encrypt($software->document_file), 'documentation'])}}" class="btn btn--primary btn--sm" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Document File')"><i class="las la-download"></i></a>
                                        </td>
                                        <td>
                                            <a href="{{route('user.seller.software.edit', [slug($software->name), $software->id])}}" class="btn btn--primary btn--sm" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Edit')"><i class="las la-pencil-alt"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{paginateLinks($softwares)}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
