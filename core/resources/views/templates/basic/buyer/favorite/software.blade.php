@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="table-area">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Category')</th>
                        <th>@lang('Price')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($favSoftwares as $software)
                        <tr>
                            <td class="text-start">
                                <div class="author-info">
                                    <div class="thumb">
                                        <img src="{{getImage(getFilePath('software').'/'.$software->software->image,getFileSize('software')) }}" alt="@lang('Software Image')">
                                    </div>
                                    <div class="content">{{__(strLimit($software->software->name, 30))}}</div>
                                </div>
                            </td>
                            <td>{{__($software->software->category->name)}}</td>
                            <td>{{showAmount($software->software->price)}} {{$general->cur_text}}</td>
                            <td>
                                <a href="{{route('software.details', [slug($software->software->name), $software->software->id])}}" class="btn btn--primary btn-sm text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Details')"><i class="las la-info-circle"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ paginateLinks($favSoftwares)}}
        </div>
    </div>
</div>
@endsection
