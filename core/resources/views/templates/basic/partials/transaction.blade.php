<div class="table-section">
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="table-area">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>@lang('Trx')</th>
                            <th>@lang('Transacted')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Post Balance')</th>
                            <th>@lang('Detail')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($transactions as $trx)
                            <tr>
                                <td>
                                    <strong>{{ $trx->trx }}</strong>
                                </td>

                                <td>
                                    {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                </td>

                                <td class="budget">
                                    <span class="fw-bold @if($trx->trx_type == '+')text--success @else text--danger @endif">
                                        {{ $trx->trx_type }} {{showAmount($trx->amount)}} {{__($general->cur_text)}}
                                    </span>
                                </td>

                                <td class="budget">
                                    {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                                </td>


                                <td>{{ __($trx->details) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if (request()->routeIs('user.transactions'))
                    {{paginateLinks($transactions)}}
                @endif
            </div>
        </div>
    </div>
</div>
