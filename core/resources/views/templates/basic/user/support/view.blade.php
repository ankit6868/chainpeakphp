@extends($activeTemplate.'layouts.frontend')

@section('content')
    <section class="all-sections ptb-60">
        <div class="container-fluid">
            <div class="section-wrapper">
                <div class="row justify-content-center mb-30-none">
                    @auth
                    @include($activeTemplate . 'partials.seller_sidebar')
                    @endauth
                    <div class="col-xl-9 col-lg-12 mb-30">
                        <div class="dashboard-sidebar-open"><i class="las la-bars"></i> @lang('Menu')</div>
                        <div class="table-section">
                            <div class="row justify-content-center">
                                <div class="col-xl-12">
                                    <div class="card custom--card">
                                        <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                                            <h4 class="card-title text-lowercase mb-0">
                                                @php echo $myTicket->statusBadge; @endphp
                                                [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
                                            </h4>

                                            @if($myTicket->status != Status::TICKET_CLOSE && $myTicket->user)
                                                <div class="card-btn">
                                                    <button class="btn btn--danger text-white border--rounded confirmationBtn" type="button" data-question="@lang('Are you sure to close this ticket?')" data-action="{{ route('ticket.close', $myTicket->id) }}"><i class="fa fa-lg fa-times-circle"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="card-form-wrapper">
                                                <form action="{{ route('ticket.reply', $myTicket->id) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="replayTicket" value="1">
                                                    <div class="row justify-content-center mb-20-none">
                                                        <div class="col-xl-12 col-lg-12 form-group">
                                                            <textarea class="form-control bg--gray" name="message" rows="6" placeholder="@lang('Your Reply')..." required=""></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-between mt-30">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="text-end">
                                                                    <button type="button" class="btn btn--base btn-sm addFile">
                                                                        <i class="fa fa-plus"></i> @lang('Add New')
                                                                    </button>
                                                                </div>
                                                                <div class="file-upload">
                                                                    <label>@lang('Attachments')</label>
                                                                    <small class="text--danger mb-2">@lang('Max 5 files can be uploaded'). @lang('Maximum upload size is') {{ ini_get('upload_max_filesize') }}</small>
                                                                    <div class="input-group ticket-input-group">
                                                                        <span class="input-group-text text-white">@lang('Upload')</span>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="attachments[]">
                                                                            <label class="custom-file-label">@lang('Choose file')</label>
                                                                        </div>
                                                                    </div>
                                                                    <div id="fileUploadsContainer"></div>
                                                                    <p class="ticket-attachments-message text-muted">
                                                                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <button class="submit-btn w-100" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;@lang('Reply')</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                                @foreach($messages as $message)
                                                    @if($message->admin_id == 0)
                                                        <div class="row border--success border--rounded my-3 py-3 mx-2">
                                                            <div class="col-md-3 border-end text-end">
                                                                <h5 class="my-3">{{ $message->ticket->name }}</h5>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <p class="fw-bold my-2">
                                                                    @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                                                <p>{{$message->message}}</p>
                                                                @if($message->attachments()->count() > 0)
                                                                    <div class="mt-2">
                                                                        @foreach($message->attachments as $k=> $image)
                                                                            <a href="{{route('ticket.download',encrypt($image->id))}}" class="me-3 text--base"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="row border--success border--rounded my-3 py-3 mx-2">
                                                            <div class="col-md-3 border-end text-end">
                                                                <h5 class="my-3">{{ $message->admin->name }}</h5>
                                                                <p class="lead text-muted">@lang('Staff')</p>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <p class="fw-bold my-2">
                                                                    @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                                                <p>{{$message->message}}</p>
                                                                @if($message->attachments()->count() > 0)
                                                                    <div class="mt-2">
                                                                        @foreach($message->attachments as $k=> $image)
                                                                            <a href="{{route('ticket.download',encrypt($image->id))}}" class="me-3 text--base"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
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

    <x-confirmation-modal class="frontend" />
@endsection

@push('style')
    <style>
        .input-group-text:focus{
            box-shadow: none !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";

            var fileAdded = 0;

            $('.addFile').on('click',function(){
                if (fileAdded >= 4) {
                    notify('error','You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(
                    `<div class="input-group ticket-input-group">
                        <span class="input-group-text text-white">@lang('Upload')</span>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="attachments[]" required>
                            <label class="custom-file-label">@lang('Choose file')</label>
                        </div>
                        <button type="button" class="input-group-text remove-btn text-white"><i class="las la-times"></i></button>
                    </div>`);
            });

            $(document).on('click','.remove-btn',function(){
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
