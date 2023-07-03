@php
    $bgImageContent = getContent('bg_image.content', true);
@endphp

<section class="account-section ptb-80 bg-overlay-white bg_img" data-background="{{ getImage('assets/images/frontend/bg_image/'.@$bgImageContent->data_values->image,'1920x1200') }}">
    <div class="container">
        <div class="row justify-content-center">
            @if (request()->routeIs('user.register')|| request()->routeIs('user.data'))
                <div class="col-lg-6 col-md-12">
            @elseif (request()->routeIs('user.password.code.verify') || request()->routeIs('user.authorization'))
                <div class="col-md-8 col-lg-7 col-xl-5">
            @else
                <div class="col-lg-4 col-md-6">
            @endif
                    <div class="account-form-area">
                        <div class="account-logo-area text-center">
                            <div class="account-logo">
                                <a href="{{route('home')}}"><img src="{{ getImage('assets/images/logoIcon/logo.png') }}" alt="{{__($general->sitename)}}"></a>
                            </div>
                        </div>
