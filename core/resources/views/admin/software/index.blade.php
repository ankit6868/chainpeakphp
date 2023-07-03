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
                                    <th>@lang('Name')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Category / SubCategory')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Software')</th>
                                    <th>@lang('Documentation')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($softwares as $software)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb"><img src="{{getImage(getFilePath('software').'/'.$software->image,getFileSize('software')) }}" alt="@lang('image')"></div>
                                                <span>&nbsp{{ strLimit(__($software->name), 20) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $software->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $software->user->id) }}"><span>@</span>{{ $software->user->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            {{strLimit(__($software->category->name), 20)}} <br>
                                            {{strLimit(__($software->subCategory->name), 20)}}
                                        </td>
                                        <td><span class="fw-bold">{{showAmount($software->price)}} {{__($general->cur_text)}}</span></td>
                                        <td> @php echo $software->customStatusBadge @endphp </td>
                                        <td>
                                            <a href="{{route('file.download', [encrypt($software->software_file), 'file'])}}" class="btn btn-sm btn-outline--primary"data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Software File')">
                                                <i class="las la-download ms-1"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{route('file.download', [encrypt($software->document_file), 'documentation'])}}" class="btn btn-sm btn-outline--primary" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Document File')">
                                                <i class="las la-download ms-1"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <a href="{{route('admin.software.details', $software->id)}}" class="btn btn-sm btn-outline--primary">
                                                    <i class="la la-info-circle"></i>@lang('Details')
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($softwares->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($softwares) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
<x-search-form placeholder="Search..." />
@endpush
