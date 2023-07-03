@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row justify-content-end gy-3">
    <div class="col-lg-8  text-end">
        <form class="d-flex gap-3 align-items-center justify-content-end">
            <div class="input-group w-50">
                <input type="text" name="search" class="form-control" value="{{ request()->search }}" placeholder="@lang('Search by transactions')">
                <button class="input-group-text bg-primary text-white">
                    <i class="las la-search"></i>
                </button>
            </div>
            <a href="{{ route('user.deposit.index') }}" class="btn btn--base p-2-5">@lang('New Service')</a>
        </form>
    </div>
    <div class="col-12">
        <div class="table-area">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>@lang('Gateway | Transaction')</th>
                        <th>@lang('Initiated')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Conversion')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Details')</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($deposits as $deposit)
                        <tr>
                            <td class="text-end text-lg-start">
                                <div>
                                    <span class="fw-bold"> <span class="text--primary">{{ __($deposit->gateway?->name) }}</span> </span>
                                <br>
                                <small> {{ $deposit->trx }} </small>
                                </div>
                            </td>

                            <td class="text-center">
                                {{ showDateTime($deposit->created_at) }}<br>{{ diffForHumans($deposit->created_at) }}
                            </td>

                            <td class="text-center">
                                <div>
                                    {{ $general->cur_sym }}{{ showAmount($deposit->amount ) }} + <span class="text--danger" title="@lang('charge')">{{ showAmount($deposit->charge)}} </span>
                                <br>
                                <strong title="@lang('Amount with charge')">
                                {{ showAmount($deposit->amount+$deposit->charge) }} {{ __($general->cur_text) }}
                                </strong>
                                </div>
                            </td>

                            <td class="text-center">
                                <div>
                                    1 {{ __($general->cur_text) }} =  {{ showAmount($deposit->rate) }} {{__($deposit->method_currency)}}
                                <br>
                                <strong>{{ showAmount($deposit->final_amo) }} {{__($deposit->method_currency)}}</strong>
                                </div>
                            </td>

                            <td class="text-center">
                                @php echo $deposit->statusBadge @endphp
                            </td>

                            @php
                                $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;
                            @endphp

                            <td>
                                <button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Details')" class="btn btn--primary btn--sm  @if($deposit->method_code >= 1000) detailBtn @else disabled @endif"
                                    @if($deposit->method_code >= 1000)
                                        data-info="{{ $details }}"
                                    @endif

                                    @if ($deposit->status == Status::PAYMENT_REJECT)
                                        data-admin_feedback="{{ $deposit->admin_feedback }}"
                                    @endif
                                    >
                                    <i class="las la-desktop"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{paginateLinks($deposits)}}

        </div>
    </div>
</div>
{{-- Detail Modal --}}
<div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Details')</h5>
                <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <ul class="list-group userData mb-2">
                </ul>
                <div class="feedback"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.detailBtn').on('click', function () {
                var modal = $('#detailModal');
                var userData = $(this).data('info');
                var html = '';
                if(userData){
                    userData.forEach(element => {
                        if(element.type != 'file'){
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                        }
                    });
                }

                modal.find('.userData').html(html);

                if($(this).data('admin_feedback') != undefined){
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                }else{
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
