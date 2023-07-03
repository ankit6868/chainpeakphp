@extends($activeTemplate.'layouts.frontend')
@section('content')
    @php
        $bgImageContent = getContent('bg_image.content', true);
    @endphp

    <section class="account-section ptb-80 bg-overlay-white bg_img" data-background="{{ getImage('assets/images/frontend/bg_image/'.@$bgImageContent->data_values->image,'1920x1200') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12">
                    <div class="account-form-area">
                        <div class="account-logo-area text-center">
                            <div class="account-logo">
                                <a href="{{route('home')}}"><img src="{{ getImage('assets/images/logoIcon/logo.png') }}" alt="{{__($general->sitename)}}"></a>
                            </div>
                        </div>
                        <div class="account-header text-center">
                            <h3 class="title">{{ __($pageTitle) }}</h3>
                        </div>
                        <div class="row ml-b-20">
                            @php echo $maintenance->data_values->description @endphp
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
