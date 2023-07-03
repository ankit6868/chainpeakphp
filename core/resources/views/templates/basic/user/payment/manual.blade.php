@extends($activeTemplate.'layouts.master')
@section('content')
<div class="card custom--card">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
        <h4 class="card-title mb-0">
            {{__($pageTitle)}}
        </h4>
    </div>
    <div class="card-body">
        <form action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="text-center">@lang('You have requested') <b class="text--success">{{ getAmount($data['amount'])  }} {{__($general->cur_text)}}</b> , @lang('Please pay')
                        <b class="text--success">{{getAmount($data['final_amo']) .' '.$data['method_currency'] }} </b> @lang('for successful payment')
                    </p>
                    <h4 class="text-center mb-4">@lang('Please follow the instruction below')</h4>
                    <p class="my-2 text-center">@php echo  $data->gateway->description @endphp</p>
                </div>
                <x-viser-form class="frontend" identifier="id" identifierValue="{{ $gateway->form_id }}" />
                <div class="col-lg-12">
                    <button type="submit" class="btn btn--base w-100 h-45">@lang('Pay Now')</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
