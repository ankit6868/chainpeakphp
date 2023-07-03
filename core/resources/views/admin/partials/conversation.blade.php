@if ($details->disputer)
    <div class="row mt-4">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5>@lang('Conversations')</h5>
                </div>
                <div class="card-body">
                    <div class="chat-box">
                        <div class="chat-box__body">
                            <div class="chat-main position-relative">
                                <div class="bg-el position-absolute" style="background-image: url({{ getImage($activeTemplateTrue . 'images/chat-pattern.png', '1380x930') }});"></div>

                                @foreach ($chats as $chat)

                                    @php
                                        if ($chat->user_id == $details->seller_id) {
                                            $senderName = request()->routeIs('admin.booking.service.details') ? $details->seller->username : $details->user->username;
                                        } elseif ($chat->user_id == $details->buyer_id) {
                                            $senderName = $details->buyer->username;
                                        } else {
                                            $senderName = 'System';
                                        }
                                    @endphp

                                    <div class="single-chat @if ($senderName == 'System') chat--right @else chat--left @endif">
                                        <div class="content">
                                            <div class="message">
                                                <h6 class="mb-2 fs--16px">{{ $senderName }}</h6>
                                                <p>{{ $chat->message }}</p>
                                                <div class="chat-attachment">
                                                    @if ($chat->file)
                                                        <a href="{{route('file.download', [encrypt($chat->file), 'chatFile'])}}" class="single-attachment"><i class="fas fa-download"></i> {{ $chat->file }} </a>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="chat-time"><i class="far fa-clock"></i> {{ $chat->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if ($details->working_status == Status::WORKING_DISPUTED)
                            <div class="chat-box__footer position-relative">
                                <div class="bg-el position-absolute" style="background-image: url({{ getImage($activeTemplateTrue . 'images/chat-pattern.png', '1380x930') }});"></div>
                                <div class="chat-form">
                                    <form action="{{route('admin.chat.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" name="id" value="{{encrypt($details->id)}}">
                                        <input type="hidden" name="type" value="{{request()->routeIs('admin.booking.service.details') ? 'service' : 'job'}}">

                                        <textarea name="message" class="form--control" placeholder="@lang('Write message')" required></textarea>

                                        <div class="bottom d-flex flex-wrap">
                                            <div class="left">
                                                <div class="attach-file-upload">
                                                    <input type="file" name="file" id="file" class="attach-file" accept=".jpg , .png, ,.jpeg ,.pdf">
                                                    <button type="button" class="attach-file-remove"><i class="las la-times"></i></button>
                                                    <label for="file">@lang('Attach file') <i class="las la-paperclip"></i></label>
                                                </div>
                                            </div>
                                            <div class="right">
                                                <button type="submit" class="btn btn-sm btn--primary">@lang('Send') <i class="lab la-telegram-plane"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        @if ($details->working_status == Status::WORKING_DISPUTED)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>@lang('Disputed By') {{$details->disputer->username}}</h5>
                    </div>
                    <div class="card-body">
                         <h6><i class="las la-info-circle"></i> @lang('Make Decision')</h6>
                         @php
                    $firstRoute  = request()->routeIs('admin.booking.service.details') ? route('admin.service.win.seller', $details->id) : route('admin.job.win.bidder', $details->id);
                    $secondRoute = request()->routeIs('admin.booking.service.details') ? route('admin.service.win.buyer', $details->id) : route('admin.job.win.buyer', $details->id);
                @endphp

                <div class="d-flex flex-wrap gap-2 style--two text-center pt-3">
                    <button class="btn btn-md btn--primary confirmationBtn flex-fill" type="button" data-question="@lang('Are you sure to give the amount to the ') {{request()->routeIs('admin.booking.service.details') ? trans("seller") : trans("bidder")}}?" data-action="{{$firstRoute}}"> <i class="las la-undo"></i> @lang('In Favor of ') {{request()->routeIs('admin.booking.service.details') ? trans("Seller") : trans("Bidder")}}</button>

                    <button class="btn btn-md btn--success confirmationBtn flex-fill" type="button" data-question="@lang('Are you sure to return the amount to the buyer')?" data-action="{{$secondRoute}}"> <i class="la la-check-circle" aria-hidden="true"></i> @lang('In Favor of Buyer')</button>
                </div>
                    </div>
                </div>



            </div>
        @endif
    </div>

    @push('style-lib')
        <link rel="stylesheet" href="{{ asset('assets/admin/css/chat.css') }}">
    @endpush

    @push('script')
        <script>
            (function($) {
                "use strict";

                $("#file").on("change", function(e) {
                    if ($("#file").val() !== "") {
                        $('.attach-file-upload').addClass('has-file');
                    }
                });

                $('.attach-file-remove').on('click', function() {
                    $("#file").val('');
                    $('.attach-file-upload').removeClass('has-file');
                });

                document.querySelector('.chat-box__body').scrollTop = document.querySelector('.chat-box__body').scrollHeight;
            })(jQuery);
        </script>
    @endpush
@endif
