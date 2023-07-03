@extends($activeTemplate.'layouts.frontend')
@section('content')
    @php
        $contactContent = getContent('contact.content', true);
        $contactElements = getContent('contact.element', false, null, true);
    @endphp
    <section class="contact-section pt-60 ptb-60">
        <div class="container">
            <div class="contact-wrapper">
                <div class="contact-area">
                    <div class="row justify-content-center m-0">
                        <div class="col-xl-5 col-lg-6 p-0">
                            <div class="contact-info-item-area">
                                <div class="contact-info-item-inner mb-30-none">
                                    <div class="contact-info-header mb-30">
                                        <h3 class="header-title">{{__(@$contactContent->data_values->heading)}}</h3>
                                        <p>{{__(@$contactContent->data_values->sub_heading)}}</p>
                                    </div>

                                    @foreach ($contactElements as $contact)
                                        <div class="contact-info-item d-flex flex-wrap align-items-center mb-40">
                                            <div class="contact-info-icon">
                                                @php echo @$contact->data_values->icon @endphp
                                            </div>
                                            <div class="contact-info-content">
                                                <h3 class="title">{{__(@$contact->data_values->title)}}</h3>
                                                <p>{{__(@$contact->data_values->details)}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6 p-0">
                            <div class="contact-form-area">
                                <h3 class="title">{{__(@$contactContent->data_values->form_heading)}}</h3>
                                <p>{{__(@$contactContent->data_values->form_sub_heading)}}</p>

                                <form class="contact-form verify-gcaptcha" method="POST" action="">
                                    @csrf
                                    @php
                                        $user=auth()->user();
                                    @endphp
                                    <div class="row justify-content-center mb-10-none">
                                        <div class="col-lg-6 col-md-6 form-group">
                                            <input type="text" class="form--control" name="name" placeholder="@lang('Your name')" value="{{ old('name',@$user->fullName) }}" @readonly(@$user) required>
                                        </div>
                                        <div class="col-lg-6 col-md-6 form-group">
                                            <input type="email" class="form--control" name="email" placeholder="@lang('Your email')" value="{{  old('email',@$user->email) }}" @readonly(@$user) required>
                                        </div>
                                        <div class="col-lg-12 form-group">
                                            <input type="text" class="form--control" name="subject" placeholder="@lang('Your subject')" value="{{old('subject')}}" required="">
                                        </div>
                                        <div class="form-group">
                                            <textarea wrap="off" class="form--control" name="message" placeholder="@lang("Your message")" required="">{{old('message')}}</textarea>
                                        </div>
                                        <x-captcha isCustom="true" />
                                        <button type="submit" class="submit-btn">@lang('Send Message')</button>
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
