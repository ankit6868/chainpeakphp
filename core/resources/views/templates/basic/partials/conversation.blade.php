@if ($details->disputer)
<div class="card custom--card mt-4">
    <div class="card-header">
        <h5 class="card-title">@lang('Conversation')</h5>
    </div>
    <div class="card-body p-0">
        <div class="chat-box ">
            <div class="chat-box__thread">
                @foreach ($chats as $chat)
                    @php
                        $senderName = null;
                        $idToCheck  = null;

                        if (request()->routeIs('user.seller.booking.service.details') || request()->routeIs('user.buyer.booked.details')) {
                            $idToCheck = $details->seller_id;
                            $image     = $details->seller->image;
                        } elseif (request()->routeIs('user.seller.job.details') || request()->routeIs('user.buyer.hiring.details')) {
                            $idToCheck = $details->user_id;
                            $image     = $details->user->image;
                        }

                        if ($chat->user_id == $idToCheck) {
                            $senderImage = getImage(getFilePath('userProfile') . '/' . @$image, getFileSize('userProfile'));
                        } elseif ($chat->user_id == $details->buyer_id) {
                            $senderImage = getImage(getFilePath('userProfile') . '/' . @$details->buyer->image, getFileSize('userProfile'));
                        } else {
                            $senderName = 'System';
                            $senderImage = getImage(getFilePath('logoIcon') . '/favicon.png');
                        }
                    @endphp

                    <div class="single-message @if ($chat->user_id == auth()->id()) message--right @else message--left @endif  @if ($senderName == 'System') admin-message @endif">
                        <div class="message-content-outer">
                            <div class="message-content">
                                <h6 class="name">{{ $senderName }}</h6>
                                <p class="message-text">{{ $chat->message }}.</p>

                                @if ($chat->file)
                                    <div class="messgae-attachment">
                                        <b class="text-sm d-block"> @lang('Attachment') </b>
                                        <a href="{{route('file.download', [encrypt($chat->file), 'chatFile'])}}" class="file-demo-btn">
                                            {{ $chat->file }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <span class="message-time d-block text-end mt-2">{{ showDateTime($chat->created_at) }}</span>
                        </div>
                        <div class="message-author">
                            <img src="{{ $senderImage }}" alt="image" class="thumb">
                        </div>
                    </div><!-- single-message end -->
                @endforeach
            </div>

            @if ($details->working_status == Status::WORKING_DISPUTED)
                <div class="chat-box__footer">
                    <form action="{{route('user.chat.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{encrypt($details->id)}}">

                        @if (request()->routeIs('user.seller.booking.service.details') || request()->routeIs('user.buyer.booked.details'))
                            <input type="hidden" name="type" value="service">
                        @else
                            <input type="hidden" name="type" value="job">
                        @endif

                        <div class="chat-send-area">
                            <div class="chat-send-field">
                                <textarea name="message" id="chat-message-field" placeholder="@lang('Type here')" class="form-control"></textarea>
                            </div>
                            <div class="d-flex flex-wrap justify-content-between align-items-center w-100">
                                <div class="chat-send-file">
                                    <div class="position-relative trade-chat-file-upload">
                                        <input type="file" id="file" name="file" class="custom-file" accept=".jpg , .png, ,.jpeg ,.pdf">
                                    </div>
                                </div>
                                <div class="chat-send-btn">
                                    <button type="sbumit" class="btn--base btn-sm">@lang('Send')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
    </div>

    </div>
</div>

@push('style-lib')
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/chat.css')}}">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.refresh').on('click', function() {
                location.reload();
            });

            document.querySelector('.chat-box__thread').scrollTop = document.querySelector('.chat-box__thread').scrollHeight;
        })(jQuery);
    </script>
@endpush
@endif
