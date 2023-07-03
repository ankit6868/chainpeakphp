@php
    $activeLevels = \App\Models\Level::active()->get();

    if ($type == 'service' || $type == 'software') {
        $activeFeatures = \App\Models\Feature::active()->orderBy('name')->get();
    }
@endphp

<div class="col-xl-3 col-lg-3 mb-30">
    <div class="sidebar">

        <div class="widget mb-30">
            <h3 class="widget-title">@lang('Categories')</h3>
            <ul class="category-list">
                @foreach($categories as $category)
                    <li><a href="{{route('by.category', [slug($category->name), $category->id])}}">{{__($category->name)}}</a></li>
                @endforeach
            </ul>
        </div>

        <form action="{{route('filter')}}" method="GET">
            <input type="hidden" name="type" value="{{ $type }}">
            <div class="widget mb-30">
                <h3 class="widget-title">@lang('Filter By Level')</h3>
                @foreach($activeLevels as $level)
                    <div class="form-group custom-check-group">
                        <input type="checkbox" id="{{$level->id}}.'level'" name="level[]" value="{{$level->id}}"
                            @if(!empty($levels))
                                @if (in_array($level->id, $levels))
                                    checked
                                @endif
                            @endif
                        >
                        <label for="{{$level->id}}.'level'">{{__($level->name)}}</label>
                    </div>
                @endforeach
            </div>
            @if ($type == 'service' || $type == 'software')
                <div class="widget mb-30">
                    <h3 class="widget-title">@lang('Features')</h3>
                    @foreach($activeFeatures as $feature)
                        <div class="form-group custom-check-group">
                            <input type="checkbox" id="{{$feature->id}}.'feature'" name="feature[]" value="{{$feature->id}}"
                                @if(!empty($features))
                                    @if (in_array($feature->id, $features))
                                        checked
                                    @endif
                                @endif
                            >
                            <label for="{{$feature->id}}.'feature'">{{__($feature->name)}} {{$feature->id}}</label>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="widget mb-30">
                <h3 class="widget-title">@lang('Filter By Price')</h3>
                <div class="widget-range-area">
                    <div id="slider-range"></div>
                    <div class="price-range">
                        <div class="filter-btn">
                            <button type="submit" class="btn--base active">@lang('Filter Now')</button>
                        </div>
                        <input type="text" id="amount" name="price" readonly>
                    </div>
                </div>
            </div>
        </form>

        @include($activeTemplate.'partials.sidebar_ad')
        @include($activeTemplate.'partials.featured_service')

    </div>
</div>

@push('script')
    <script>
        (function ($) {
            "use strict";

            $("#slider-range").slider({
                range: true,
                min: {{$priceRange[0]}},
                max: {{$priceRange[1]}},
                values: [parseInt({{$priceRange[0]}}), parseInt({{$priceRange[1]}})],
                slide: function (event, ui) {
                    $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                    $('input[name=min_price]').val(ui.values[0]);
                    $('input[name=max_price]').val(ui.values[1]);
                }
            });

            $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));
        })(jQuery);
    </script>
@endpush
