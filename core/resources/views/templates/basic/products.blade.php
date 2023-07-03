@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="all-sections pt-60 pb-60">
        <div class="container-fluid p-max-sm-0">
            <div class="sections-wrapper d-flex flex-wrap justify-content-center">
                <article class="main-section">
                    <div class="section-inner">
                        <div class="item-section">
                            <div class="container">
                                @if (request()->routeIs('by.category'))
                                    <div class="item-category-area border-bottom">
                                        <div class="category-slider mb-4">
                                            <div class="swiper-wrapper">
                                                @foreach($category->subcategories as $subcategory)
                                                    <div class="swiper-slide">
                                                        <div class="category-item-box">
                                                            <a href="{{route('by.subcategory', [slug($subcategory->name), $subcategory->id])}}">
                                                                <img src="{{ getImage(getFilePath('subcategory').'/'.$subcategory->image, getFileSize('subcategory')) }}" alt="@lang('Subcategory Image')">
                                                                <div class="category-item-content">
                                                                    <h4 class="title text-white">{{__($subcategory->name)}}</h4>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="slider-prev">
                                                <i class="las la-angle-left"></i>
                                            </div>
                                            <div class="slider-next">
                                                <i class="las la-angle-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="item-details-area">
                                    @include($activeTemplate.'partials.basic_card')
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection
