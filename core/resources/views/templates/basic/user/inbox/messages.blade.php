@extends($activeTemplate.'layouts.frontend')
@section('content')
    @php
        $user = $inbox->sender_id == auth()->id() ? $inbox->receiver : $inbox->sender;
    @endphp
    <section class="all-sections ptb-60">
        <div class="container-fluid">
            <div class="section-wrapper">
                <div class="row justify-content-center mb-30-none">
                    @include($activeTemplate . 'partials.seller_sidebar')
                    <div class="col-xl-9 col-lg-12 mb-30">
                        <div class="dashboard-sidebar-open"><i class="las la-bars"></i> @lang('Menu')</div>
                        <div class="card-area">
                            <div class="row justify-content-center">
                                <div class="col-xl-12">
                                    <div class="card custom--card">
                                        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="chat-author align-items-center">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('userProfile').'/'.@$user->image, getFileSize('userProfile')) }}" alt="image">
                                                </div>
                                                <h6 class="text--base">{{$user->username}}</h6>
                                            </div>
                                            <div class="trade-status flex-shrink-0">
                                                <button type="button" class="btn btn--primary text-white refresh" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Click here to load new chat and trade current status')"><i class="las la-sync-alt"></i> @lang('Refresh')</button>
                                            </div>
                                        </div>

                                        <div class="card-body p-0">
                                            <div class="chat-box__thread">
                                                @foreach ($messages as $message)

                                                    <div class="single-message @if ($message->receiver_id == auth()->id()) message--right @else message--left @endif">
                                                        <div class="message-content-outer">
                                                            <div class="message-content">
                                                                <p class="message-text">{{ $message->message }}.</p>
                                                                @if ($message->file)
                                                                    <div class="messgae-attachment">
                                                                        <b class="text-sm d-block"> @lang('Attachment') </b>
                                                                        <a href="{{route('file.download', [encrypt($message->file), 'messageFile'])}}" class="file-demo-btn">
                                                                            {{ $message->file }}
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <span class="message-time d-block text-end mt-2">{{ showDateTime($message->created_at) }}</span>
                                                        </div>
                                                        <div class="message-author">
                                                            <img src="{{ getImage(getFilePath('userProfile').'/'.$message->sender->image, getFileSize('userProfile')) }}" class="thumb">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="chat-box__footer">
                                                <form action="{{route('user.inbox.message.store')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <input type="hidden" name="unique_id" value="{{$inbox->unique_id}}">
                                                    <input type="hidden" name="receiver_id" value="{{encrypt($user->id)}}">

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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

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
