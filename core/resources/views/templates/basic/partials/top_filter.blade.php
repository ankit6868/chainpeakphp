<div class="item-top-area d-flex flex-wrap justify-content-between align-items-center">
    <div class="item-wrapper d-flex flex-wrap justify-content-between align-items-center">
        <div class="item-wrapper-left d-flex flex-wrap align-items-center">
            <div class="item-sorting">
                <form  method="GET">
                    <div class="input-group item-widget-select mb-0">
                        <select class="chosen-select" name="sorting">
                            <option value="default" selected>@lang('Sort By') (@lang('Default'))</option>
                            <option value="high" @selected(request()->sorting=='high')>  @lang('High to low')</option>
                            <option value="low" @selected(request()->sorting=='low')>@lang('Low to high')</option>
                        </select>
                        <button type="button" class="btn btn-toggle"><i class="fas fa-caret-down"></i></button>
                    </div>
                </form>
            </div>
            <div class="item-value">
                <span>@lang('Showing ') {{ $products->firstItem() }} @lang('to') {{ $products->lastItem() }} @lang('of') {{ $products->total() }} @lang('result')
                </span>
            </div>
        </div>
        <ul class="view-btn-list">
            <li><button type="button" class="grid-view-btn list-btn"><i class="lab la-buromobelexperte"></i></button></li>
            <li class="active"><button type="button" class="list-view-btn list-btn"><i class="las la-list"></i></button></li>
        </ul>
    </div>

    <div class="item-wrapper-right">
        <form class="search-from" action="{{route('search')}}" method="GET">
            <input type="search" name="search" class="form-control" value="{{@$search}}" required placeholder="@lang('Search here')...">
            <button type="submit"><i class="las la-search"></i></button>
        </form>
    </div>
</div>

@push('script')
    <script>
        "use strict";
        (function ($) {
            $('.chosen-select').on('change',function(e){
                $(this).closest('form').submit();
            });
        })(jQuery);

    </script>
@endpush
