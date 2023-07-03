@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row gy-3 justify-content-end">
    <div class="col-lg-8  text-end">
        <form class="d-flex gap-3 align-items-center justify-content-end">
         <div class="input-group w-50">
            <input type="text" name="search" class="form-control" value="{{ request()->search }}" placeholder="@lang('Search by transactions')">
            <button type="submit" class="btn btn--base input-group-text">@lang('Search')</button>
         </div>
         <a href="{{ route('user.withdraw') }}" class="btn btn--base p-2-5">@lang('Withdraw Now')</a>
        </form>
     </div>
     <div class="col-12">
        <div class="table-section">
            <div class="row justify-content-center">
                <div class="col-xl-12">
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
                                @forelse($withdraws as $withdraw)
                                    <tr>
                                        <td>
                                            <span class="fw-bold"><span class="text--primary"> {{ __(@$withdraw->method->name) }}</span></span>
                                            <br>
                                            <small>{{ $withdraw->trx }}</small>
                                        </td>
                                        <td class="text-center">
                                            {{ showDateTime($withdraw->created_at) }} <br>  {{ diffForHumans($withdraw->created_at) }}
                                        </td>
                                        <td class="text-center">
                                            {{ $general->cur_sym }}{{ showAmount($withdraw->amount ) }} - <span class="text--danger" title="@lang('charge')">{{ showAmount($withdraw->charge)}} </span>
                                            <br>
                                            <strong title="@lang('Amount after charge')">
                                            {{ showAmount($withdraw->amount-$withdraw->charge) }} {{ __($general->cur_text) }}
                                            </strong>

                                        </td>
                                        <td class="text-center">
                                            1 {{ __($general->cur_text) }} =  {{ showAmount($withdraw->rate) }} {{ __($withdraw->currency) }}
                                            <br>
                                            <strong>{{ showAmount($withdraw->final_amount) }} {{ __($withdraw->currency) }}</strong>
                                        </td>
                                        <td class="text-center">
                                            @php echo $withdraw->statusBadge @endphp
                                        </td>
                                        <td>
                                            <button class="btn btn--primary btn--sm detailBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Details')"
                                            data-user_data="{{ json_encode($withdraw->withdraw_information) }}"
                                            @if ($withdraw->status == Status::PAYMENT_REJECT)
                                            data-admin_feedback="{{ $withdraw->admin_feedback }}"
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
                        {{paginateLinks($withdraws)}}
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>

    {{-- APPROVE MODAL --}}
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
                    <ul class="list-group userData list-group-flush">

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
                var userData = $(this).data('user_data');
                var html = ``;
                userData.forEach(element => {
                    if(element.type != 'file'){
                        html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>${element.name}</span>
                            <span">${element.value}</span>
                        </li>`;
                    }
                });

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
