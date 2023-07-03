@php
    $featuredServices = \App\Models\Service::active()->featured()->userActiveCheck()->checkData()->latest()->with('user')->limit(6)->get();
@endphp

@if (count($featuredServices))
    <div class="widget mb-30">
        <h3 class="widget-title">@lang('Featured Services')</h3>
        <ul class="small-item-list load-more-featured-services">
            @foreach($featuredServices->take(5) as $fService)
                @include($activeTemplate.'partials.basic_featured_service')
            @endforeach
        </ul>
    </div>

    <div class="widget-btn text-center mb-30">
        @if(count($featuredServices) > 5)
            <button class="btn--base loadMoreFeaturedServices">@lang('Show More')</button>
        @endif
    </div>
@endif


@if (count($featuredServices) > 5)
    @push('script')
        <script>
            (function ($) {
                "use strict";

                var showServices = 5;

                $('.loadMoreFeaturedServices').on('click', function(e) {
                    e.preventDefault();
                    $(this).addClass('btn-disabled').attr("disabled", true);

                    var type = $(this).data('type');
                    var skip = showServices;

                    $.ajax({
                        type: 'get',
                        url: '{{ route('fetch.featured.services') }}',
                        data: {
                                type : type,
                                skip : skip
                            },
                        dataType: "json",

                        success: function (response) {
                            if(response.success){
                                $('.load-more-featured-services').append(response.html);
                                showServices += 5;
                                $('.loadMoreFeaturedServices').removeClass('btn-disabled').attr("disabled", false);
                            }else{
                                notify('error', response.error);
                            }
                        }
                    });
                });
            })(jQuery);
        </script>
    @endpush
@endif
