@extends('layouts.dashboard.app')
@section('header__title', __('home.Dashboard'))
@section('header__icon', 'fa-solid fa-house')

@section('main')
    <div class="content-wrapper">
        <!-- Content -->


        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-12 mb-3 order-0">
                    <div class="card p-3 pb-4">
                        <div class="col-md-8">
                            <h3 class="card-header m-0 px-0 pb-4">{{ __("home.statistics") }}</h3>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap align-items-center gap-3 ">
                            <div class="box__dashboard p-3 bg-label-info" >
                                <div class="icon-circle bg-info">
                                    <span class="badge bg-info p-2">
                                        <i class="bx bx-wallet text-white"></i>
                                    </span>
                                </div>
                                <div class="number">{{ number_format($totalBalance, 2) }} </div>
                                <span>{{ __('home.total_balance') }}</span>
                            </div>
                            <div class="box__dashboard p-3" style="background: #F3E8FF;">
                                <img src="{{ asset('asset/img/dashboard/Icon (2).png') }}" alt="">
                                <div class="number">{{ $statistics['users'] }}</div>
                                <span>{{ __('home.users') }}</span>
                            </div>

                            <div class="box__dashboard p-3" style="background: #DCFCE7;">
                                <img src="{{ asset('asset/img/dashboard/Icon (3).png') }}" alt="">
                                <div class="number">{{ $statistics['products'] }}</div>
                                <span>{{ __('home.products') }}</span>
                            </div>
                            <div class="box__dashboard p-3 bg-label-info" >
                                <div class="icon-circle bg-info">

                                <i class="fa fa-box"></i>
                                </div>
                                <div class="number">{{ $statistics['orders'] }}</div>
                                <span>{{ __('home.orders') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

            <div class="row">

                <div class="col-lg-7 status__comp mb-4">
                    <div class="card">
                        <h5 class="card-header">حالات الدفع</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('models.bill_no') }}</th>
                                        <th>{{ __('models.price') }}</th>
                                        <th>{{ __('models.category') }}</th>
                                        <th>{{ __('models.payment_tool') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($paymentLogs as $log)
                                    <tr>
                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>{{ $log->bill_no }}</td>
                                        <td>{{ $log->amount }}</td>
                                        <td><span class="badge bg-label-info me-0">{{ __("home.".$log->type) }}</span></td>
                                        <td>{{ $log->payment_tool }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--/ Total Revenue -->
                <div class="col-md-6 col-lg-5 col-xl-5 order-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between pb-0">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">Last Orders</h5>
                                <small class="text-muted">{{ number_format($totalSales, 2) }} Total Sales</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <h2 class="mb-2">{{ number_format($totalOrders) }}</h2>
                                    <span>Total Orders</span>
                                </div>
                            </div>
                            <ul class="p-0 m-0">
                                @foreach ($categories as $category)
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-primary">
                                            <i class="fa fa-box"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">{{ $category['name'] }}</h6>
                                            <small class="text-muted">{{ $category['details'] }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ number_format($category['amount']) }}</small>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-7 order-1 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">{{__('home.Income')}}</h5>
                            <small class="text-muted">Last 7 Days</small>
                        </div>
                        <div class="card-body px-0">
                            <div class="tab-content p-0">
                                <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                                    <div class="d-flex p-4 pt-3">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <img src="{{ asset('asset/img/icons/unicons/wallet.png') }}" alt="User" />
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">{{ __('home.total_balance') }}</small>
                                            <div class="d-flex align-items-center">
                                                <h6 class="mb-0 me-1">${{ number_format($totalBalance, 2) }}</h6>
                                                <small class="{{ $percentageChange >= 0 ? 'text-success' : 'text-danger' }} fw-semibold">
                                                    <i class="bx {{ $percentageChange >= 0 ? 'bx-chevron-up' : 'bx-chevron-down' }}"></i>
                                                    {{ number_format(abs($percentageChange), 1) }}%
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="income_Chart"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- / Content -->

        <!-- Footer -->
        <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                    ©
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    , made with ❤️ by
                    <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                </div>
                <div>
                    <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                    <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                    <a href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                        target="_blank" class="footer-link me-4">Documentation</a>

                    <a href="https://github.com/themeselection/sneat-html-admin-template-free/issues" target="_blank"
                        class="footer-link me-4">Support</a>
                </div>
            </div>
        </footer>
        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>
@endsection

@section('scripts-dashboard')

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const incomeData = @json($incomeData);
            const incomeChartEl = document.querySelector('#income_Chart');
            const labels = Object.keys(incomeData);
            const data = Object.values(incomeData);

            const incomeChartConfig = {
            series: [{
                data: data
            }],
            chart: {
                height: 215,
                parentHeightOffset: 0,
                parentWidthOffset: 0,
                toolbar: {
                show: false
                },
                type: 'area'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2,
                curve: 'smooth'
            },
            legend: {
                show: false
            },
            markers: {
                size: 6,
                colors: 'transparent',
                strokeColors: 'transparent',
                strokeWidth: 4,
                discrete: [
                {
                    fillColor: '#fff',
                    seriesIndex: 0,
                    dataPointIndex: data.length - 1,
                    strokeColor: '#7367f0',
                    strokeWidth: 2,
                    size: 6,
                    radius: 8
                }
                ],
                hover: {
                size: 7
                }
            },
            colors: ['#7367f0'],
            fill: {
                type: 'gradient',
                gradient: {
                shade: 'light',
                shadeIntensity: 0.6,
                opacityFrom: 0.5,
                opacityTo: 0.25,
                stops: [0, 95, 100]
                }
            },
            grid: {
                borderColor: '#e7e7e7',
                strokeDashArray: 3,
                padding: {
                top: -20,
                bottom: -8,
                left: -10,
                right: 8
                }
            },
            xaxis: {
                categories: labels,
                axisBorder: {
                show: false
                },
                axisTicks: {
                show: false
                },
                labels: {
                show: true,
                style: {
                    fontSize: '13px',
                    colors: '#9e9e9e'
                }
                }
            },
            yaxis: {
                labels: {
                show: false
                },
                min: Math.min(...data) - 10,
                max: Math.max(...data) + 10,
                tickAmount: 4
            }
            };

            if (typeof incomeChartEl !== 'undefined' && incomeChartEl !== null) {
                const incomeChart = new ApexCharts(incomeChartEl, incomeChartConfig);
                incomeChart.render();
            }
        });
    </script>

@endsection
