@php
    $footerContent  = getContent('footer.content', true);
    $footerElements = getContent('footer.element', false, null, true);
@endphp
<section class="footer-section section--bg pt-60">
    <div class="container-fluid">
        <div class="footer-wrapper">
            <div class="footer-toggle"><span class="right-icon"></span><span class="title">@lang('Quick Links') </span></div>
            <div class="footer-bottom-area">
                <div class="row mb-30-none">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-30">
                        <div class="footer-widget">
                            <h3 class="title">{{__(@$footerContent->data_values->heading)}}</h3>
                            <p>{{__(@$footerContent->data_values->description)}}</p>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 mb-30">
                        <div class="footer-widget">
                            <h3 class="title">@lang('Our Info')</h3>
                            <ul class="footer-links">
                                <li><a href="{{route('user.login')}}">@lang('Sign In')</a></li>
                                <li><a href="{{route('user.register')}}">@lang('Join With Us')</a></li>
                                <li><a href="{{route('contact')}}">@lang('Contact Us')</a></li>
                                <li><a href="{{route('service')}}">@lang('Service')</a></li>
                                <li><a href="{{route('software')}}">@lang('Software')</a></li>
                                <li><a href="{{route('job')}}">@lang('Job')</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 mb-30">
                        <div class="footer-widget">
                            <h3 class="title">@lang('Service Category')</h3>
                            <ul class="footer-links">
                                @foreach($categories->take(6) as $category)
                                    <li><a href="{{route('by.category', [slug($category->name), $category->id])}}">{{__($category->name)}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 mb-30">
                        <div class="footer-widget">
                            <h3 class="title">@lang('Short Links')</h3>
                            <ul class="footer-links">
                                <li><a href="{{ route('blogs') }}">@lang('Blogs')</a></li>
                                @foreach($policyPages as $policy)
                                    <li>
                                        <a href="{{ route('policy.pages',[slug($policy->data_values->title),$policy->id]) }}">{{ __($policy->data_values->title) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-30">
                        <div class="footer-widget">
                            <h3 class="title">{{__(@$footerContent->data_values->subscribe_heading)}}</h3>
                            <p>{{__(@$footerContent->data_values->subscribe_description)}}</p>
                            <form class="subscribe-form">
                                <input type="email" name="email" id="subscriber" placeholder="@lang('Email Address')..">
                                <button type="button" class="subscribe-btn"><i class="fas fa-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright-area d-flex flex-wrap justify-content-between align-items-center">
                <div class="copyright">
                    <p>{{__(@$footerContent->data_values->copyright_text)}}</p>
                </div>
                <div class="social-area">
                    <ul class="footer-social">
                        @foreach($footerElements as $footer)
                            <li>
                                <a href="{{@$footer->data_values->url}}" target="__blank">@php echo @$footer->data_values->social_icon @endphp</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@push('script')
    <script>
        'use strict';
        (function ($) {
            $('.subscribe-btn').on('click',function () {
                var email = $('#subscriber').val();
                var csrf  = '{{csrf_token()}}';
                $.ajax({
                    type: 'post',
                    url: '{{ route('subscriber.store') }}',
                    data: {
                            email : email,
                            _token : csrf
                        },
                    dataType: "json",
                    success: function (response) {
                        if(response.success){
                            notify('success', response.success);
                            $('#subscriber').val('');
                        }else{
                            notify('error', response.error);
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush


