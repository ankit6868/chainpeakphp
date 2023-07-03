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
                            <div class="card-body ">
                                @if($user->kyc_data)
                                    <ul class="list-group list-group-flush">
                                        @foreach($user->kyc_data as $val)
                                            @continue(!$val->value)

                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{__($val->name)}}

                                                <span class="fw-bold">
                                                    @if($val->type == 'checkbox')
                                                        {{ implode(',',$val->value) }}
                                                    @elseif($val->type == 'file')
                                                        <a href="{{ route('user.attachment.download',encrypt(getFilePath('verify').'/'.$val->value)) }}" class="text--base"><i class="fa fa-file"></i>  @lang('Attachment') </a>
                                                    @else
                                                        <p>{{__($val->value)}}</p>
                                                    @endif
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <h5 class="text-center">@lang('KYC data not found')</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
