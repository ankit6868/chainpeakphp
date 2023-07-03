@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="all-sections pt-60">
        <div class="container-fluid p-max-sm-0">
            <div class="sections-wrapper d-flex flex-wrap justify-content-center">
                <article class="main-section">
                    <div class="section-inner">
                        <div class="blog-details-section blog-section">
                            <div class="container">
                                <div class="row justify-content-start mb-30-none">
                                    <div class="col-xl-9 col-lg-9 mb-30">
                                        <div class="blog-item-area">
                                            <div class="blog-item">
                                                <div class="blog-thumb">
                                                    <img src="{{ getImage('assets/images/frontend/blog/'.$blog->data_values->image,'966x560') }}" alt="blog">
                                                    <div class="blog-date text-center">
                                                        <h3 class="title">{{showDateTime($blog->created_at, 'd')}}</h3>
                                                        <span class="sub-title">{{showDateTime($blog->created_at, 'M')}}</span>
                                                    </div>
                                                </div>
                                                <div class="blog-content">
                                                    <div class="blog-content-inner">
                                                        <h3 class="title">{{__($blog->data_values->title)}}</h3>
                                                        @php echo $blog->data_values->description @endphp
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="blog-social-area d-flex flex-wrap justify-content-between align-items-center">
                                                <h3 class="title">@lang('Share This Post')</h3>
                                                <ul class="blog-social">
                                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Facebook')">
                                                        <a href="http://www.facebook.com/sharer.php?u={{urlencode(url()->current())}}&p[title]={{slug(@$blog->data_values->title)}}" target="_blank"><i class="lab la-facebook-f"></i></a>
                                                    </li>
                                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Linkedin')">
                                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{urlencode(url()->current()) }}&title={{slug(@$blog->data_values->title)}}" target="_blank"><i class="lab la-linkedin-in"></i></a>
                                                    </li>
                                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Twitter')">
                                                        <a href="http://twitter.com/share?text={{slug(@$blog->data_values->title)}}&url={{urlencode(url()->current()) }}" target="_blank"><i class="lab la-twitter"></i></a>
                                                    </li>
                                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Pinterest')">
                                                        <a href="http://pinterest.com/pin/create/button/?url={{urlencode(url()->current()) }}&description={{slug(@$blog->data_values->title)}}" target="_blank"><i class="lab la-pinterest-p"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="fb-comments" data-href="{{ route('blog.details',[slug($blog->data_values->title), $blog->id]) }}" data-numposts="5"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    @include($activeTemplate.'partials.down_ad')
@endsection

@push('fbComment')
	@php echo loadExtension('fb-comment') @endphp
@endpush
