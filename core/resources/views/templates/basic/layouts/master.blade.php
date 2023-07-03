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

        <section class="all-sections ptb-60">
            <div class="container-fluid">
                <div class="section-wrapper">
                    <div class="row justify-content-center ">
                        @if (request()->routeIs("user.buyer.*"))
                        @include($activeTemplate . 'partials.buyer_sidebar')
                        @else
                        @include($activeTemplate . 'partials.seller_sidebar')
                        @endif
                        <div class="col-xl-9 col-lg-12">
                            <div class="dashboard-sidebar-open"><i class="las la-bars"></i> @lang('Menu')</div>
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include($activeTemplate.'partials.footer')


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

                $(".langSel").on("change", function() {
                    window.location.href = "{{route('home')}}/change/"+$(this).val() ;
                });

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
