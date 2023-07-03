@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row gy-3">
    <div class="col-12">
        <div class="show-filter  text-end">
            <button type="button" class="btn btn--base showFilterBtn btn-sm"><i class="las la-filter"></i> @lang('Filter')</button>
        </div>
        <div class="card responsive-filter-card custom--card">
            <div class="card-body p-3">
                <form action="">
                    <div class="d-flex flex-wrap align-items-center gap-4">
                        <div class="flex-grow-1">
                            <label>@lang('Transaction Number')</label>
                            <input type="text" name="search" value="{{ request()->search }}" class="form-control">
                        </div>
                        <div class="flex-grow-1">
                            <label>@lang('Type')</label>
                            <select name="trx_type" class="form-control">
                                <option value="">@lang('All')</option>
                                <option value="+" @selected(request()->trx_type == '+')>@lang('Plus')</option>
                                <option value="-" @selected(request()->trx_type == '-')>@lang('Minus')</option>
                            </select>
                        </div>
                        <div class="flex-grow-1">
                            <label>@lang('Remark')</label>
                            <select class="form-control" name="remark">
                                <option value="">@lang('Any')</option>
                                @foreach($remarks as $remark)
                                    <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>{{ __(keyToTitle($remark->remark)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-grow-1 align-self-end">
                            <button class="btn btn--base w-100 h-100"><i class="las la-filter"></i> @lang('Filter')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12">
        @include($activeTemplate.'partials.transaction')
    </div>
</div>
@endsection
