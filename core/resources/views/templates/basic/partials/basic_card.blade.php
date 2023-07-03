<div class="product-tab">
    <nav class="d-flex flex-wrap justify-content-between align-items-center">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="service-tab" data-bs-toggle="tab" data-bs-target="#service" type="button" role="tab" aria-controls="service" aria-selected="true">@lang('Services')</button>
            <button class="nav-link" id="software-tab" data-bs-toggle="tab" data-bs-target="#software" type="button" role="tab" aria-controls="software" aria-selected="false">@lang('Software')</button>
            <button class="nav-link" id="job-tab" data-bs-toggle="tab" data-bs-target="#job" type="button" role="tab" aria-controls="job" aria-selected="false">@lang('Job')</button>
        </div>

        <div class="item-wrapper-right float-end mt-sm-3">
            <form class="search-from mt-3 mt-md-0" action="{{route('search')}}" method="GET">
                <input type="search" name="search" class="form-control" value="{{@$search}}" placeholder="@lang('Search here')...">
                <button type="submit"><i class="las la-search"></i></button>
            </form>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="service" role="tabpanel" aria-labelledby="service-tab">
            <div class="item-card-wrapper border-0 p-0 grid-view mt-30 load-products">
                @forelse($services->take(9) as $service)
                    @include($activeTemplate.'partials.basic_service')
                @empty
                    @include($activeTemplate.'partials.empty_data')
                @endforelse
            </div>

            @if($services->count() > 9)
                <div class="widget-btn text-center mt-4">
                    <button class="btn--base loadMoreProduct" data-type="service">@lang('More')</button>
                </div>
            @endif
        </div>

        <div class="tab-pane fade" id="software" role="tabpanel" aria-labelledby="software-tab">
            <div class="item-card-wrapper border-0 p-0 grid-view mt-30 load-products">
                @forelse($softwares->take(9) as $software)
                    @include($activeTemplate.'partials.basic_software')
                @empty
                    @include($activeTemplate.'partials.empty_data')
                @endforelse
            </div>

            <div class="widget-btn text-center mt-4">
                @if($softwares->count() > 9)
                    <button class="btn--base loadMoreProduct" data-type="software">@lang('More')</button>
                @endif
            </div>
        </div>
        <div class="tab-pane fade" id="job" role="tabpanel" aria-labelledby="job-tab">
            <div class="item-card-wrapper border-0 p-0 grid-view mt-30 load-products" id="viewMoreJob">
                @forelse($jobs->take(9) as $job)
                    @include($activeTemplate.'partials.basic_job')
                @empty
                    @include($activeTemplate.'partials.empty_data')
                @endforelse
            </div>

            <div class="widget-btn text-center mt-4">
                @if($jobs->count() > 9)
                    <button class="btn--base loadMoreProduct" data-type="job">@lang('More')</button>
                @endif
            </div>
        </div>
    </div>
</div>


@push('script')
    <script>
        (function ($) {
            "use strict";

            var showProducts = 9;

            $('.loadMoreProduct').on('click', function(e) {
                e.preventDefault();
                $(this).addClass('btn-disabled').attr("disabled", true);

                var type          = $(this).data('type');
                var search        = '{{@$search}}';
                var userId        = '{{@$user->id}}';
                var categoryId    = '{{@$category->id}}';
                var subcategoryId = '{{@$subcategory->id}}';
                var skip          = showProducts;
                var $this         = $(this);

                $.ajax({
                    type: 'get',
                    url: '{{ route('fetch.products') }}',
                    data: {
                            skip : skip,
                            type : type,
                            search : search,
                            user_id : userId,
                            category_id : categoryId,
                            subcategory_id : subcategoryId,
                        },
                    dataType: "json",

                    success: function (response) {
                        if(response.success){
                            $($this).closest('.tab-pane').find('.load-products').append(response.html);
                            showProducts += 9;
                            $('.loadMoreProduct').removeClass('btn-disabled').attr("disabled", false);
                        }else{
                            notify('error', response.error);
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
