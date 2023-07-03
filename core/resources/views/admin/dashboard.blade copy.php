@extends('admin.layouts.app')
@section('panel')

@if(@json_decode($general->system_info)->version > systemDetails()['version'])
<div class="row">
    <div class="col-md-12">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">
                <h3 class="card-title"> @lang('New Version Available') <button  class="btn btn--dark float-end">@lang('Version') {{json_decode($general->system_info)->version}}</button> </h3>
            </div>
            <div class="card-body">
                <h5 class="card-title text-dark">@lang('What is the Update ?')</h5>
                <p>
                <pre class="f-size--24">{{json_decode($general->system_info)->details}}</pre>
                </p>
            </div>
        </div>
    </div>
</div>
@endif
@if(@json_decode($general->system_info)->message)
<div class="row">
    @foreach(json_decode($general->system_info)->message as $msg)
    <div class="col-md-12">
        <div class="alert border border--primary" role="alert">
            <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
            <p class="alert__message">@php echo $msg; @endphp</p>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
    @endforeach
</div>
@endif

<div class="row gy-4">
    <div class="col-xxl-3 col-sm-6">
        <x-widget link="{{route('admin.users.all')}}" icon="las la-users f-size--56" title="Total Users" value="{{$widget['total_users']}}" bg="primary" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget link="{{route('admin.users.active')}}" icon="las la-user-check f-size--56" title="Active Users" value="{{$widget['verified_users']}}" bg="success" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget link="{{route('admin.users.email.unverified')}}" icon="lar la-envelope f-size--56" title="Email Unverified Users" value="{{$widget['email_unverified_users']}}" bg="danger" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget link="{{route('admin.users.mobile.unverified')}}" icon="las la-comment-slash f-size--56" title="Mobile Unverified Users" value="{{$widget['mobile_unverified_users']}}" bg="red" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.deposit.list')}}" icon="fas fa-hand-holding-usd" icon_style="false" title="Total Deposited" value="{{ $general->cur_sym }}{{showAmount($deposit['total_deposit_amount'])}}" color="success" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.deposit.pending')}}" icon="fas fa-spinner" icon_style="false" title="Pending Deposits" value="{{$deposit['total_deposit_pending']}}" color="warning" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.deposit.rejected')}}" icon="fas fa-ban" icon_style="false" title="Rejected Deposits" value="{{$deposit['total_deposit_rejected']}}" color="warning" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.deposit.list')}}" icon="fas fa-percentage" icon_style="false" title="Deposited Charge" value="{{ $general->cur_sym }}{{showAmount($deposit['total_deposit_charge'])}}" color="primary" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.withdraw.log')}}" icon="lar la-credit-card" title="Total Withdrawn" value="{{ $general->cur_sym }}{{showAmount($withdrawals['total_withdraw_amount'])}}" color="success" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.withdraw.pending')}}" icon="las la-sync" title="Pending Withdrawals"  value="{{$withdrawals['total_withdraw_pending']}}" color="warning" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.withdraw.rejected')}}" icon="las la-times-circle" title="Rejected Withdrawals" value="{{$withdrawals['total_withdraw_rejected']}}" color="danger" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.withdraw.log')}}" icon="las la-percent" title="Withdrawal Charge" value="{{ $general->cur_sym }}{{showAmount($withdrawals['total_withdraw_charge'])}}" color="primary" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="3" link="{{route('admin.service.pending')}}" icon="las la-taxi" title="Total Pending Service" value="{{$widget['totalPendingServiceCount']}}" bg="primary" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="3" link="{{route('admin.software.pending')}}" icon="las la-laptop-code" title="Total Pending Software" value="{{$widget['totalPendingSoftwareCount']}}" bg="1" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="3" link="{{route('admin.job.pending')}}" icon="las la-user-secret" title="Total Pending Job" value="{{$widget['totalPendingJobCount']}}" bg="14" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="3" link="{{route('admin.category.index')}}" icon="las la-user-secret" title="Total Category" value="{{$widget['totalCategoryCount']}}" bg="19" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.subcategory.index')}}" icon="las la-list" title="Total Subcategory" value="{{$widget['totalSubcategoryCount']}}" color="success" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.feature.index')}}" icon="las la-bolt" title="Total Feature"  value="{{$widget['totalFeatureCount']}}" color="warning" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.advertisement.index')}}" icon="las la-ad" title="Total Advertisement" value="{{$widget['totalAdCount']}}" color="info" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.coupon.index')}}" icon="las la-percentage" title="Total Coupon" value="{{$widget['totalCouponCount']}}" color="primary" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.booking.service.disputed')}}" icon="las la-taxi" title="Reported Service Booking" value="{{$widget['reportedServiceBookingCount']}}" color="danger" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.hiring.job.disputed')}}" icon="las la-taxi" title="Reported Job Bidding" value="{{$widget['reportedJobHiringCount']}}" color="danger" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.sales.software.log')}}" icon="las la-laptop-code" title="Total Software Sale" value="{{$widget['totalSoftwareSaleCount']}}" color="success" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.level.index')}}" icon="lab la-hackerrank" title="Total Level" value="{{$widget['totalLevelCount']}}" color="success" />
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">@lang('Monthly Deposit & Withdraw Report') (@lang('Last 12 Month'))</h5>
                <div id="apex-bar-chart"> </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">@lang('Transactions Report') (@lang('Last 30 Days'))</h5>
                <div id="apex-line"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6">
        <div class="card overflow-hidden">
            <div class="card-body">
                <h5 class="card-title">@lang('Login By Browser') (@lang('Last 30 days'))</h5>
                <canvas id="userBrowserChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">@lang('Login By OS') (@lang('Last 30 days'))</h5>
                <canvas id="userOsChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">@lang('Login By Country') (@lang('Last 30 days'))</h5>
                <canvas id="userCountryChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Cron Modal --}}
<div id="cronModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Cron Job Setting Instruction')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <p class="cron mb-2 text-justify">@lang('To automate mark already expired service booking and job
                    hiring, you need to set the cron job. Set The cron time as minimum as possible.')</p>
                <label class="w-100 fw-bold">@lang('Service Cron Command')</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control copyText" value="curl -s {{ route('cron.service.expired') }}" readonly>
                    <button class="input-group-text btn btn--primary copyBtn" data-clipboard-text="curl -s {{ route('cron.service.expired') }}" type="button"><i class="la la-copy"></i></button>
                </div>
                <label class="w-100 fw-bold">@lang('Job Cron Command')</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control copyText" value="curl -s {{ route('cron.job.expired') }}"  readonly>
                    <button class="input-group-text btn btn--primary copyBtn" data-clipboard-text="curl -s {{ route('cron.job.expired') }}" type="button"><i  class="la la-copy"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
@php
$serviceCondition = Carbon\Carbon::parse($general->service_cron)->diffInSeconds() >= 900;
$jobCondition = Carbon\Carbon::parse($general->job_cron)->diffInSeconds() >= 900;
@endphp

@if ($serviceCondition || $jobCondition )
<div class="d-flex flex-column justify-content-end align-items-end">
    @if($serviceCondition)
    <span class="text--warning">@lang('Last Service Cron
        Executed:')<strong>{{diffForHumans($general->service_cron)}}</strong></span>
    @endif
    @if($jobCondition)
    <span class="text--warning">@lang('Last Job Cron
        Runs:')<strong>{{diffForHumans($general->jobCondition)}}</strong></span>
    @endif
</div>
@endif

@endpush

@push('script')

<script src="{{asset('assets/admin/js/vendor/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/admin/js/vendor/chart.js.2.8.0.js')}}"></script>

<script>
    "use strict";

    @if ($serviceCondition || $jobCondition)
        (function ($) {
            var cronModal = new bootstrap.Modal(document.getElementById('cronModal'));
            cronModal.show();

            $('.copyBtn').on('click', function () {
                var copyText = $(this).siblings('.copyText')[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                copyText.blur();
                $(this).addClass('copied');
                setTimeout(() => {
                    $(this).removeClass('copied');
                }, 1500);
            });
        })(jQuery);
    @endif

    $('.copy-address').on('click', function () {
        var clipboard = new ClipboardJS('.copy-address');
        notify('success', 'Copied : ' + $(this).data('clipboard-text'));
    });

    var options = {
        series: [{
            name: 'Total Deposit',
            data: [
                @foreach($months as $month)
                    {{ getAmount(@$depositsMonth-> where('months', $month) -> first() -> depositAmount) }},
    @endforeach
                ]
            }, {
        name: 'Total Withdraw',
            data: [
                @foreach($months as $month)
                    {{ getAmount(@$withdrawalMonth-> where('months', $month) -> first() -> withdrawAmount) }},
    @endforeach
                ]
            }],
    chart: {
        type: 'bar',
            height: 450,
                toolbar: {
            show: false
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
                columnWidth: '50%',
                    endingShape: 'rounded'
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
            width: 2,
                colors: ['transparent']
    },
    xaxis: {
        categories: @json($months),
    },
    yaxis: {
        title: {
            text: "{{$general->cur_sym}}",
                style: {
                color: '#7c97bb'
            }
        }
    },
    grid: {
        xaxis: {
            lines: {
                show: false
            }
        },
        yaxis: {
            lines: {
                show: false
            }
        },
    },
    fill: {
        opacity: 1
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "{{$general->cur_sym}}" + val + " "
            }
        }
    }
        };
    var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
    chart.render();

    var ctx = document.getElementById('userBrowserChart');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($chart['user_browser_counter'] -> keys()),
            datasets: [{
                data: {{ $chart['user_browser_counter']-> flatten() }},
        backgroundColor: [
            '#ff7675',
            '#6c5ce7',
            '#ffa62b',
            '#ffeaa7',
            '#D980FA',
            '#fccbcb',
            '#45aaf2',
            '#05dfd7',
            '#FF00F6',
            '#1e90ff',
            '#2ed573',
            '#eccc68',
            '#ff5200',
            '#cd84f1',
            '#7efff5',
            '#7158e2',
            '#fff200',
            '#ff9ff3',
            '#08ffc8',
            '#3742fa',
            '#1089ff',
            '#70FF61',
            '#bf9fee',
            '#574b90'
        ],
        borderColor: [
            'rgba(231, 80, 90, 0.75)'
        ],
        borderWidth: 0,

    }]
            },
    options: {
        aspectRatio: 1,
            responsive: true,
                maintainAspectRatio: true,
                    elements: {
            line: {
                tension: 0 // disables bezier curves
            }
        },
        scales: {
            xAxes: [{
                display: false
            }],
                yAxes: [{
                    display: false
                }]
        },
        legend: {
            display: false,
                }
    }
        });



    var ctx = document.getElementById('userOsChart');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($chart['user_os_counter'] -> keys()),
            datasets: [{
                data: {{ $chart['user_os_counter']-> flatten() }},
        backgroundColor: [
            '#ff7675',
            '#6c5ce7',
            '#ffa62b',
            '#ffeaa7',
            '#D980FA',
            '#fccbcb',
            '#45aaf2',
            '#05dfd7',
            '#FF00F6',
            '#1e90ff',
            '#2ed573',
            '#eccc68',
            '#ff5200',
            '#cd84f1',
            '#7efff5',
            '#7158e2',
            '#fff200',
            '#ff9ff3',
            '#08ffc8',
            '#3742fa',
            '#1089ff',
            '#70FF61',
            '#bf9fee',
            '#574b90'
        ],
        borderColor: [
            'rgba(0, 0, 0, 0.05)'
        ],
        borderWidth: 0,

    }]
            },
    options: {
        aspectRatio: 1,
            responsive: true,
                elements: {
            line: {
                tension: 0 // disables bezier curves
            }
        },
        scales: {
            xAxes: [{
                display: false
            }],
                yAxes: [{
                    display: false
                }]
        },
        legend: {
            display: false,
                }
    },
        });


    // Donut chart
    var ctx = document.getElementById('userCountryChart');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($chart['user_country_counter'] -> keys()),
            datasets: [{
                data: {{ $chart['user_country_counter']-> flatten() }},
        backgroundColor: [
            '#ff7675',
            '#6c5ce7',
            '#ffa62b',
            '#ffeaa7',
            '#D980FA',
            '#fccbcb',
            '#45aaf2',
            '#05dfd7',
            '#FF00F6',
            '#1e90ff',
            '#2ed573',
            '#eccc68',
            '#ff5200',
            '#cd84f1',
            '#7efff5',
            '#7158e2',
            '#fff200',
            '#ff9ff3',
            '#08ffc8',
            '#3742fa',
            '#1089ff',
            '#70FF61',
            '#bf9fee',
            '#574b90'
        ],
        borderColor: [
            'rgba(231, 80, 90, 0.75)'
        ],
        borderWidth: 0,

    }]
            },
    options: {
        aspectRatio: 1,
            responsive: true,
                elements: {
            line: {
                tension: 0 // disables bezier curves
            }
        },
        scales: {
            xAxes: [{
                display: false
            }],
                yAxes: [{
                    display: false
                }]
        },
        legend: {
            display: false,
                }
    }
        });

    // apex-line chart
    var options = {
        chart: {
            height: 450,
            type: "area",
            toolbar: {
                show: false
            },
            dropShadow: {
                enabled: true,
                enabledSeries: [0],
                top: -2,
                left: 0,
                blur: 10,
                opacity: 0.08
            },
            animations: {
                enabled: true,
                easing: 'linear',
                dynamicAnimation: {
                    speed: 1000
                }
            },
        },
        dataLabels: {
            enabled: false
        },
        series: [
            {
                name: "Plus Transactions",
                data: [
                    @foreach($trxReport['date'] as $trxDate)
                    {{ @$plusTrx -> where('date', $trxDate) -> first() -> amount ?? 0 }},
    @endforeach
            ]
            },
    {
        name: "Minus Transactions",
            data: [
                @foreach($trxReport['date'] as $trxDate)
                        {{ @$minusTrx -> where('date', $trxDate) -> first() -> amount ?? 0 }},
    @endforeach
                ]
            }
        ],
    fill: {
        type: "gradient",
            gradient: {
            shadeIntensity: 1,
                opacityFrom: 0.7,
                    opacityTo: 0.9,
                        stops: [0, 90, 100]
        }
    },
    xaxis: {
        categories: [
            @foreach($trxReport['date'] as $trxDate)
                    "{{ $trxDate }}",
            @endforeach
        ]
    },
    grid: {
        padding: {
            left: 5,
                right: 5
        },
        xaxis: {
            lines: {
                show: false
            }
        },
        yaxis: {
            lines: {
                show: false
            }
        },
    },
        };

    var chart = new ApexCharts(document.querySelector("#apex-line"), options);

    chart.render();


</script>
@endpush
