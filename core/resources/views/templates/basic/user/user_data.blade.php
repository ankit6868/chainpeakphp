@extends($activeTemplate.'layouts.frontend')
@section('content')

@include($activeTemplate.'partials.authentication')
<div class="account-header text-center">
    <h3 class="title">{{ __($pageTitle) }}</h3>
</div>
<form class="account-form" method="POST" action="{{ route('user.data.submit')}}">
    @csrf
    <div class="row ml-b-20">
        <div class="col-lg-6 form-group">
            <label>@lang('First Name')</label>
            <input type="text" class="form-control form--control" name="firstname" value="{{old('firstname')}}"
                required>
        </div>

        <div class="col-lg-6 form-group">
            <label>@lang('Last Name')</label>
            <input type="text" class="form-control form--control" name="lastname" value="{{old('lastname')}}" required>
        </div>

        <div class="col-lg-6 form-group">
            <label>@lang('Address')</label>
            <input type="text" class="form-control form--control" name="address" value="{{ old('address') }}">
        </div>

        <div class="col-lg-6 form-group">
            <label>@lang('State')</label>
            <input type="text" class="form-control form--control" name="state" value="{{ old('state') }}">
        </div>

        <div class="col-lg-6 form-group">
            <label>@lang('Zip Code')</label>
            <input type="text" class="form-control form--control" name="zip" value="{{ old('zip') }}">
        </div>

        <div class="col-lg-6 form-group">
            <label>@lang('City')</label>
            <input type="text" class="form-control form--control" name="city" value="{{ old('city') }}">
        </div>
        <div class="col-lg-12 form-group">
            <label>@lang('About Me')</label>
            <textarea class="form-control form--control" name="about_me" rows="5" required>{{ old('about_me') }}</textarea>
        </div>
        <button type="submit" class="submit-btn w-100">@lang('Submit')</button>
    </div>
</form>
</div>
</div>
</div>
</div>
</section>
@endsection
