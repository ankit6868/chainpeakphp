<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title> {{ $general->siteName(__($pageTitle)) }}</title>
        @include('partials.seo')

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/global/css/all.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}">

        <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/swiper.min.css')}}">
        <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/chosen.css')}}">
        <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/animate.css')}}">
        <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/style.css')}}">
        <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
        <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php') }}?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}">

        @stack('style-lib')

        @stack('style')
    </head>

    <body>
        @stack('fbComment')

        <div class="preloader">
            <div class="box-loader">
                <div class="loader animate">
                    <svg class="circular" viewBox="50 50 100 100">
                        <circle class="path" cx="75" cy="75" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
                        <line class="line" x1="127" x2="150" y1="0" y2="0" stroke="black" stroke-width="3" stroke-linecap="round" />
                    </svg>
                </div>
            </div>
        </div>

        @include($activeTemplate.'partials.header')
        @yield('content')
        @include($activeTemplate.'partials.footer')

        @php
            $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
        @endphp

        @if(($cookie->data_values->status == Status::ENABLE) && !\Cookie::get('gdpr_cookie'))
            <div class="cookies-card text-center hide">
                <div class="cookies-card__icon bg--base">
                    <i class="las la-cookie-bite"></i>
                </div>
                <p class="mt-4 cookies-card__content">{{ $cookie->data_values->short_desc }} <a href="{{ route('cookie.policy') }}" class="text--base" target="_blank">@lang('learn more')</a></p>
                <div class="cookies-card__btn mt-4">
                    <a href="javascript:void(0)" class="btn btn--base w-100 policy h-45">@lang('Allow')</a>
                </div>
            </div>
        @endif

        <script src="{{asset('assets/global/js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>

        <script src="{{asset($activeTemplateTrue.'js/swiper-bundle.min.js')}}"></script>
        <script src="{{asset($activeTemplateTrue.'js/jquery-ui.min.js')}}"></script>
        <script src="{{asset($activeTemplateTrue.'js/chosen.jquery.js')}}"></script>
        <script src="{{asset($activeTemplateTrue.'js/wow.min.js')}}"></script>
        <script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>

        @stack('script-lib')
        @stack('script')
        @include('partials.plugins')
        @include('partials.notify')

        <script>
            (function ($) {
                "use strict";

                $(document).on('click', '.make-favorite', function(){
                    @auth
                        var productId = $(this).data('id');
                        var type      = $(this).data('type');
                        var csrf      = '{{csrf_token()}}';
                        var $this     = $(this);

                        $.ajax({
                            type: 'post',
                            url: '{{ route('user.buyer.favorite.store') }}',
                            data: {
                                    product_id : productId,
                                    type : type,
                                    _token : csrf
                                },
                            dataType: "json",

                            success: function (response) {
                                if(response.success){
                                    notify('success', response.success);
                                    $($this).find('.favorite-count').text(response.favoriteCount);
                                }else{
                                    notify('error', response.error);
                                }
                            }
                        });
                    @else
                        notify('error', 'Login required to make favorite items');
                    @endauth
                });

                $(".langSel").on("change", function() {
                    window.location.href = "{{route('home')}}/change/"+$(this).val() ;
                });

                $('.policy').on('click',function(){
                    $.get('{{route('cookie.accept')}}', function(response){
                        $('.cookies-card').addClass('d-none');
                    });
                });

                setTimeout(function(){
                    $('.cookies-card').removeClass('hide')
                },2000);

                $.each($('input, select, textarea'), function (i, element) {
                    var elementType = $(element);
                    if(elementType.attr('type') != 'checkbox'){
                        if (element.hasAttribute('required') && element.type != 'file') {
                            $(element).closest('.form-group').find('label').addClass('required');
                        }
                    }
                });

                Array.from(document.querySelectorAll('table')).forEach(table => {
                        let heading = table.querySelectorAll('thead tr th');
                        Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                            Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                                colum.setAttribute('data-label', heading[i].innerText)
                        });
                    });
                });

                $('.showFilterBtn').on('click',function(){
                    $('.responsive-filter-card').slideToggle();
                });

                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });
            })(jQuery);
        </script>
    </body>
</html>
