@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="all-sections ptb-60">
    <div class="container-fluid">
        <div class="section-wrapper">
            <div class="row justify-content-center mb-30-none">
                @if (request()->routeIs('user.seller.booking.service.details'))
                    @include($activeTemplate . 'partials.seller_sidebar')
                @else
                    @include($activeTemplate . 'partials.buyer_sidebar')
                @endif
                <div class="col-xl-9 col-lg-12 mb-30">
                    <div class="card custom--card">
                        <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                            <h4 class="card-title mb-0">
                                {{__($pageTitle)}}
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('user.kyc.submit')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <x-viser-form class="frontend" identifier="act" identifierValue="kyc" />
                                <div class="col-lg-12">
                                    <button type="submit" class="submit-btn w-100">@lang('Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
