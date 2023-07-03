@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row">
 <div class="col-12">
    <div class="card custom--card">
        <div class="card-header">
            <div class="card-title"> @lang('Current Balance') {{ getAmount(auth()->user()->balance)}}  {{ __($general->cur_text) }}</div>
        </div>
        <div class="withdraw-form-area">
            <form class="panel-form" action="{{route('user.withdraw.submit')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center">
                    <div class="mb-2">
                        @php echo $withdraw->method->description; @endphp
                    </div>

                    <x-viser-form class="frontend" identifier="id" identifierValue="{{ $withdraw->method->form_id }}" />

                    @if(auth()->user()->ts)
                        <div class="form-group">
                            <label>@lang('Google Authenticator Code')</label>
                            <input type="text" name="authenticator_code" class="form-control" required>
                        </div>
                    @endif
                    <div class="col-lg-12">
                        <button type="submit" class="submit-btn w-100">@lang('Confirm')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
 </div>
</div>
@endsection
