@extends('layouts.master')
@section('title')
    لوحة التحكم - برنامج الفواتير
@endsection
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
              <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">مرحباً بك مرة أخرى!</h2>
              <p class="mg-b-0">لوحة تحكم إدارة الفواتير الخاصة بك.</p>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">إجمالي الفواتير</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                    {{ number_format($stats['total_sum'], 2) }}
                                </h4>
                                <p class="mb-0 tx-12 text-white op-7">عدد الفواتير الكلي: {{ $stats['total_count'] }}</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7"> 100%</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير غير المدفوعة</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                    {{ number_format($stats['unpaid_sum'], 2) }}
                                </h4>
                                <p class="mb-0 tx-12 text-white op-7">عدد الفواتير: {{ $stats['unpaid_count'] }}</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-down text-white"></i>
                                <span class="text-white op-7"> {{ $stats['unpaid_percent'] }}%</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                    {{ number_format($stats['paid_sum'], 2) }}
                                </h4>
                                <p class="mb-0 tx-12 text-white op-7">عدد الفواتير: {{ $stats['paid_count'] }}</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7"> {{ $stats['paid_percent'] }}%</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة جزئياً</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                    {{ number_format($stats['partial_sum'], 2) }}
                                </h4>
                                <p class="mb-0 tx-12 text-white op-7">عدد الفواتير: {{ $stats['partial_count'] }}</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-down text-white"></i>
                                <span class="text-white op-7"> {{ $stats['partial_percent'] }}%</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
    </div>
    <!-- row closed -->

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-md-12 col-lg-12 col-xl-7">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">إحصائية حالات الفواتير</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 text-muted mb-0">نظرة عامة على نسب الفواتير المدفوعة وغير المدفوعة والمدفوعة جزئياً.</p>
                </div>
                <div class="card-body" style="width: 100%; height: 350px;">
                    <canvas id="invoiceStatusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-5 col-md-12 col-lg-12">
            <div class="card card-table-two">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mb-1">أحدث الفواتير المضافة</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <span class="tx-12 tx-muted mb-3 ">تستعرض هذه القائمة أحدث 5 فواتير تم إضافتها للنظام.</span>
                <div class="table-responsive country-table">
                    <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                        <thead>
                            <tr>
                                <th class="wd-lg-25p">رقم الفاتورة</th>
                                <th class="wd-lg-25p tx-right">تاريخ الإصدار</th>
                                <th class="wd-lg-25p tx-right">الإجمالي</th>
                                <th class="wd-lg-25p tx-right">الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stats['recent_invoices'] as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td class="tx-right tx-medium tx-inverse">{{ $invoice->invoice_date }}</td>
                                <td class="tx-right tx-medium tx-inverse">{{ number_format($invoice->total, 2) }}</td>
                                <td class="tx-right tx-medium">
                                    @if ($invoice->value_status == 1)
                                        <span class="text-success">{{ $invoice->status }}</span>
                                    @elseif($invoice->value_status == 2)
                                        <span class="text-danger">{{ $invoice->status }}</span>
                                    @else
                                        <span class="text-warning">{{ $invoice->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @if(count($stats['recent_invoices']) == 0)
                            <tr>
                                <td colspan="4" class="text-center">لا توجد فواتير مضافة حتى الآن</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

    </div>
    </div>
    <!-- Container closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Moment js -->
    <script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <!--Internal  Flot js-->
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ URL::asset('assets/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ URL::asset('assets/js/chart.flot.sampledata.js') }}"></script>
    <!--Internal Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!-- Internal Map -->
    <script src="{{ URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal-popup.js') }}"></script>
    <!--Internal  index js -->
    <script src="{{ URL::asset('assets/js/index.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.vmap.sampledata.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('invoiceStatusChart').getContext('2d');
            var invoiceStatusChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['الفواتير غير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئياً'],
                    datasets: [{
                        data: [
                            {{ $stats['unpaid_percent'] }}, 
                            {{ $stats['paid_percent'] }}, 
                            {{ $stats['partial_percent'] }}
                        ],
                        backgroundColor: [
                            '#f93a5a', // danger
                            '#22c03c', // success
                            '#ffb822'  // warning
                        ],
                        hoverBackgroundColor: [
                            '#f93a5a',
                            '#22c03c',
                            '#ffb822'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'bottom',
                        labels: {
                            fontColor: '#77778e',
                            fontFamily: 'Tajawal, sans-serif'
                        }
                    },
                    cutoutPercentage: 70,
                }
            });
        });
    </script>
@endsection
