@extends($activeTemplate.'layouts.frontend')
@section('content')

    @include($activeTemplate.'partials.authentication')
                        <div class="account-header text-center">
                            <h3 class="title text--danger">@lang('You are banned')</h3>
                            <p>@lang('Reason')</p>
                        </div>

                        <div class="row ml-b-20">
                            <p class="text-center">{{ $user->ban_reason }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
