@extends('layouts.master')
@section('title')
    تقارير العملاء
@endsection

@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <style>
        /* ── Card shell ───────────────────────────────────── */
        .report-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 2px 18px rgba(0,0,0,.07);
            overflow: hidden;
        }

        /* ── Card header ──────────────────────────────────── */
        .report-card .rcard-header {
            background: #fff;
            border-bottom: 1px solid #f0f4f8;
            padding: 16px 22px;
        }

        .report-card .rcard-title {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        /* ── Filter panel (collapse) ──────────────────────── */
        .filter-panel {
            background: #f8fafc;
            border-top: 1px solid #e8edf3;
            border-bottom: 1px solid #e8edf3;
            padding: 20px 22px 16px;
        }

        .filter-panel label {
            font-size: 12px;
            font-weight: 700;
            color: #475569;
            margin-bottom: 5px;
            display: block;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .filter-panel .form-control {
            border-radius: 8px;
            border: 1.5px solid #e2e8f0;
            font-size: 13px;
            padding: 8px 11px;
            color: #374151;
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            height: auto;
        }

        .filter-panel .form-control:focus {
            border-color: #0162e8;
            box-shadow: 0 0 0 3px rgba(1,98,232,.1);
            outline: none;
        }

        .filter-panel .filter-footer {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px solid #e8edf3;
        }

        /* ── Toolbar buttons ──────────────────────────────── */
        .tbtn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 15px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all .22s;
            text-decoration: none;
            white-space: nowrap;
        }

        .tbtn-filter {
            background: #fff;
            color: #475569;
            border: 1.5px solid #e2e8f0;
        }

        .tbtn-filter:hover,
        .tbtn-filter[aria-expanded="true"] {
            background: #eff6ff;
            border-color: #93c5fd;
            color: #0162e8;
        }

        .tbtn-filter .filter-dot {
            width: 6px; height: 6px;
            background: #f93a5a;
            border-radius: 50%;
            display: inline-block;
        }

        .tbtn-apply {
            background: linear-gradient(135deg, #0162e8, #0148b3);
            color: #fff !important;
            border: none;
            padding: 8px 20px;
        }

        .tbtn-apply:hover {
            box-shadow: 0 4px 14px rgba(1,98,232,.35);
            transform: translateY(-1px);
            color: #fff;
        }

        .tbtn-reset {
            background: #fff;
            color: #64748b;
            border: 1.5px solid #e2e8f0;
            text-decoration: none;
        }

        .tbtn-reset:hover { background: #f1f5f9; color: #1e293b; }

        .tbtn-excel {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff !important;
            box-shadow: 0 3px 10px rgba(16,185,129,.2);
        }

        .tbtn-excel:hover {
            box-shadow: 0 5px 16px rgba(16,185,129,.35);
            transform: translateY(-1px);
            color: #fff;
        }

        .tbtn-print {
            background: #fff;
            color: #475569;
            border: 1.5px solid #e2e8f0;
        }

        .tbtn-print:hover { background: #f1f5f9; color: #1e293b; }

        .tbtn-divider {
            width: 1px; height: 26px;
            background: #e2e8f0;
            display: inline-block;
            margin: 0 4px;
        }

        /* ── Count badge ──────────────────────────────────── */
        .count-badge {
            background: #f1f5f9;
            color: #64748b;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            padding: 3px 10px;
        }

        .active-filter-badge {
            background: #eff6ff;
            color: #0162e8;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 700;
            padding: 3px 10px;
        }

        /* ── Table ────────────────────────────────────────── */
        #invoicesReportTable thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-top: none;
            border-bottom: 2px solid #e8edf3;
            padding: 12px 14px;
            white-space: nowrap;
        }

        #invoicesReportTable tbody td {
            padding: 12px 14px;
            font-size: 13.5px;
            color: #374151;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        #invoicesReportTable tbody tr:hover td { background: #f8fbff; }

        #invoicesReportTable tfoot td {
            background: #f8fafc;
            font-weight: 700;
            font-size: 13px;
            color: #1e293b;
            border-top: 2px solid #e8edf3;
            padding: 12px 14px;
        }

        .inv-link {
            color: #0162e8;
            font-weight: 600;
            text-decoration: none;
        }
        .inv-link:hover { text-decoration: underline; }

        /* ── Status badges ────────────────────────────────── */
        .bs {
            padding: 4px 11px;
            border-radius: 30px;
            font-size: 11.5px;
            font-weight: 700;
            display: inline-block;
        }
        .bs-paid    { background: rgba(34,197,94,.13);  color: #16a34a; }
        .bs-unpaid  { background: rgba(249,58,90,.11);  color: #dc2626; }
        .bs-partial { background: rgba(251,146,60,.13); color: #ea580c; }

        /* ── DT overrides ─────────────────────────────────── */
        div.dataTables_wrapper div.dataTables_filter input {
            border-radius: 8px;
            border: 1.5px solid #e2e8f0;
            padding: 6px 11px;
            font-size: 13px;
            margin-right: 6px;
        }
        div.dataTables_wrapper div.dataTables_length select {
            border-radius: 8px;
            border: 1.5px solid #e2e8f0;
            padding: 5px 8px;
            font-size: 13px;
        }
        div.dataTables_wrapper div.dataTables_info { font-size: 12.5px; color: #94a3b8; }

        /* ── Empty state ──────────────────────────────────── */
        .empty-td { padding: 44px 20px !important; text-align: center; color: #94a3b8; }
        .empty-td i { font-size: 36px; display: block; margin-bottom: 10px; color: #cbd5e1; }

        /* ── Chart card ───────────────────────────────────── */
        .chart-empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #94a3b8;
        }
        .chart-empty-state i { font-size: 40px; display: block; margin-bottom: 10px; color: #cbd5e1; }
    </style>
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">تقارير العملاء</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ التقارير</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a class="btn ripple btn-primary" href="{{ route('invoices.index') }}">
                <i class="fa fa-list ml-1"></i> قائمة الفواتير
            </a>
        </div>
    </div>
@endsection

@section('content')

{{-- ══════════════════ TABLE CARD ══════════════════ --}}
<div class="row">
    <div class="col-12">
        <div class="report-card card">

            {{-- ─── Card Header: title + toolbar ─── --}}
            <div class="rcard-header d-flex align-items-center justify-content-between flex-wrap" style="gap:10px; padding:16px 22px; background:#fff; border-bottom:1px solid #f0f4f8;">

                {{-- Left: title + badges --}}
                <div class="d-flex align-items-center flex-wrap" style="gap:8px;">
                    <h5 class="rcard-title">
                        <i class="fas fa-users text-primary ml-1"></i>
                        تقارير فواتير العملاء
                    </h5>
                    <span class="count-badge">{{ collect($invoices)->count() }} فاتورة</span>
                    @if(array_filter($filters))
                        <span class="active-filter-badge">
                            <i class="fas fa-circle" style="font-size:6px; vertical-align:middle; color:#f93a5a;"></i>
                            مفلتر
                        </span>
                    @endif
                </div>

                {{-- Right: toolbar --}}
                <div class="d-flex align-items-center flex-wrap" style="gap:8px;">

                    {{-- Filter toggle (Bootstrap Collapse) --}}
                    <button class="tbtn tbtn-filter"
                            type="button"
                            data-toggle="collapse"
                            data-target="#filterPanel"
                            aria-expanded="{{ array_filter($filters) ? 'true' : 'false' }}"
                            aria-controls="filterPanel"
                            id="filterToggleBtn">
                        <i class="fas fa-sliders-h"></i>
                        تصفية (بحث العملاء)
                        @if(array_filter($filters))
                            <span class="filter-dot"></span>
                        @endif
                    </button>

                    <span class="tbtn-divider"></span>

                    {{-- Excel --}}
                    <button id="btnExcel" class="tbtn tbtn-excel" type="button">
                        <i class="fas fa-file-excel"></i> Excel
                    </button>

                    {{-- Print --}}
                    <button id="btnPrint" class="tbtn tbtn-print" type="button">
                        <i class="fas fa-print"></i> طباعة
                    </button>

                </div>
            </div>

            {{-- ─── Collapse Filter Panel ─── --}}
            <div class="collapse {{ array_filter($filters) ? 'show' : 'show' }}" id="filterPanel">
                <div class="filter-panel">
                    <form method="GET" action="{{ route('reports.customers') }}" id="filterForm">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label for="section_id">القسم (مطلوب)</label>
                                <select id="section_id" name="section_id" class="form-control" required>
                                    <option value="" disabled selected>حدد القسم</option>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}"
                                            {{ ($filters['section_id'] ?? '') == $section->id ? 'selected' : '' }}>
                                            {{ $section->section_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label for="product">المنتج (العميل)</label>
                                <select id="product" name="product" class="form-control">
                                    <option value="">جميع المنتجات</option>
                                    @if(isset($filters['product']) && $filters['product'] != '')
                                        <option value="{{ $filters['product'] }}" selected>{{ $filters['product'] }}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label for="date_from">من تاريخ</label>
                                <input type="date" id="date_from" name="date_from"
                                       class="form-control"
                                       value="{{ $filters['date_from'] ?? '' }}">
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label for="date_to">إلى تاريخ</label>
                                <input type="date" id="date_to" name="date_to"
                                       class="form-control"
                                       value="{{ $filters['date_to'] ?? '' }}">
                            </div>
                        </div>
                        <div class="filter-footer">
                            <button type="submit" class="tbtn tbtn-apply">
                                <i class="fas fa-search"></i> بحث
                            </button>
                            <a href="{{ route('reports.customers') }}" class="tbtn tbtn-reset">
                                <i class="fas fa-redo"></i> إعادة تعيين
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ─── Table ─── --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="invoicesReportTable" class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم الفاتورة</th>
                                <th>تاريخ الإصدار</th>
                                <th>تاريخ الاستحقاق</th>
                                <th>المنتج</th>
                                <th>القسم</th>
                                <th>الخصم</th>
                                <th>نسبة الضريبة</th>
                                <th>قيمة الضريبة</th>
                                <th>الإجمالي</th>
                                <th>الحالة</th>
                                <th>ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                                <tr>
                                    <td class="text-muted" style="font-size:12px;">{{ $loop->iteration }}</td>
                                    <td>
                                        <a class="inv-link" href="{{ route('invoices.details', $invoice->id) }}">
                                            {{ $invoice->invoice_number }}
                                        </a>
                                    </td>
                                    <td>{{ $invoice->invoice_date }}</td>
                                    <td>{{ $invoice->due_date }}</td>
                                    <td>{{ $invoice->product }}</td>
                                    <td>{{ $invoice->section->section_name ?? '—' }}</td>
                                    <td>{{ number_format($invoice->discount, 2) }}</td>
                                    <td>{{ $invoice->rate_vat }}%</td>
                                    <td>{{ number_format($invoice->value_vat, 2) }}</td>
                                    <td style="font-weight:700;">{{ number_format($invoice->total, 2) }}</td>
                                    <td>
                                        @if($invoice->value_status == 1)
                                            <span class="bs bs-paid">مدفوعة</span>
                                        @elseif($invoice->value_status == 2)
                                            <span class="bs bs-unpaid">غير مدفوعة</span>
                                        @else
                                            <span class="bs bs-partial">جزئي</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">{{ $invoice->note ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="empty-td">
                                        <i class="fas fa-search-minus"></i>
                                        @if(empty($filters['section_id']))
                                            يرجى اختيار القسم لعرض الفواتير
                                        @else
                                            لا توجد فواتير تطابق معايير التصفية
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if(collect($invoices)->count() > 0)
                            <tfoot>
                                <tr>
                                    <td colspan="6" style="color:#94a3b8; font-size:11.5px; text-transform:uppercase; letter-spacing:.4px;">الإجمالي</td>
                                    <td>{{ number_format($stats['total_discount'], 2) }}</td>
                                    <td>—</td>
                                    <td>{{ number_format($stats['total_vat'], 2) }}</td>
                                    <td>{{ number_format($stats['total_sum'], 2) }}</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

        </div>{{-- /.report-card --}}
    </div>
</div>

{{-- ══════════════════ CHARTS (below table) ══════════════════ --}}

{{-- Build monthly data from $invoices collection in PHP (no raw SQL needed) --}}
@php
    $arabicMonths = [
        1=>'يناير', 2=>'فبراير', 3=>'مارس', 4=>'أبريل',
        5=>'مايو', 6=>'يونيو', 7=>'يوليو', 8=>'أغسطس',
        9=>'سبتمبر', 10=>'أكتوبر', 11=>'نوفمبر', 12=>'ديسمبر',
    ];

    $monthlyGroups = [];
    foreach ($invoices as $inv) {
        if (!$inv->invoice_date) continue;
        $d    = \Carbon\Carbon::parse($inv->invoice_date);
        $key  = $d->year . '-' . str_pad($d->month, 2, '0', STR_PAD_LEFT);
        $label = ($arabicMonths[$d->month] ?? $d->month) . ' ' . $d->year;
        if (!isset($monthlyGroups[$key])) {
            $monthlyGroups[$key] = ['label' => $label, 'count' => 0, 'total' => 0];
        }
        $monthlyGroups[$key]['count']++;
        $monthlyGroups[$key]['total'] += (float) $inv->total;
    }
    ksort($monthlyGroups);

    $bladeChartLabels = array_column(array_values($monthlyGroups), 'label');
    $bladeChartCounts = array_column(array_values($monthlyGroups), 'count');
    $bladeChartTotals = array_map(fn($v) => round($v, 2), array_column(array_values($monthlyGroups), 'total'));
@endphp

<div class="row mt-4">

    {{-- ── Status Donut Chart ── --}}
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="report-card card h-100">
            <div class="rcard-header d-flex align-items-center justify-content-between"
                 style="padding:16px 22px; background:#fff; border-bottom:1px solid #f0f4f8;">
                <h5 class="rcard-title">
                    <i class="fas fa-chart-pie text-primary ml-1"></i>
                    توزيع الحالات
                </h5>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center p-3"
                 style="min-height:260px;">
                @if(collect($invoices)->count() > 0)
                    <canvas id="statusDonutChart" style="max-height:240px;"></canvas>
                @else
                    <div class="chart-empty-state">
                        <i class="fas fa-chart-pie"></i>
                        <p class="mb-1">لا توجد بيانات</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Monthly Bar + Line Chart ── --}}
    <div class="col-lg-8 col-md-12 mb-4">
        <div class="report-card card h-100">
            <div class="rcard-header d-flex align-items-center justify-content-between"
                 style="padding:16px 22px; background:#fff; border-bottom:1px solid #f0f4f8;">
                <h5 class="rcard-title">
                    <i class="fas fa-chart-bar text-primary ml-1"></i>
                    التوزيع الشهري
                </h5>
                <small class="text-muted">المبالغ وعدد الفواتير شهرياً</small>
            </div>
            <div class="card-body p-3" style="min-height:260px;">
                @if(count($bladeChartLabels) > 0)
                    <canvas id="monthlyBarChart" style="height:240px; max-height:240px;"></canvas>
                @else
                    <div class="chart-empty-state">
                        <i class="fas fa-chart-bar"></i>
                        <p class="mb-1">لا توجد بيانات شهرية</p>
                        <small class="text-muted">تأكد أن الفواتير تحتوي على تاريخ إصدار</small>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

</div>{{-- /container --}}
</div>{{-- /main-content --}}
@endsection

@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            
            // ── AJAX for Products Dropdown based on Section Selection ──
            $('select[name="section_id"]').on('change', function() {
                var sectionId = $(this).val();
                if (sectionId) {
                    $.ajax({
                        url: "{{ URL::to('section') }}/" + sectionId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="product"]').empty();
                            $('select[name="product"]').append('<option value="">جميع المنتجات</option>');
                            $.each(data, function(key, value) {
                                $('select[name="product"]').append('<option value="' + value + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });

            // ── DataTable ────────────────────────────────────
            var table = $('#invoicesReportTable').DataTable({
                responsive: true,
                dom: 'lfrtip',
                language: {
                    search:       "بحث:",
                    lengthMenu:   "عرض _MENU_ سجل",
                    info:         "عرض _START_ إلى _END_ من أصل _TOTAL_ سجل",
                    infoEmpty:    "لا توجد سجلات",
                    infoFiltered: "(مصفاة من _MAX_)",
                    zeroRecords:  "لا توجد نتائج",
                    paginate: { first:"الأول", last:"الأخير", next:"التالي", previous:"السابق" },
                },
                order: [[2, 'desc']],
                pageLength: 25,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'تقارير العملاء',
                        exportOptions: { columns: ':visible:not(:last-child)' }
                    },
                    {
                        extend: 'print',
                        title: 'تقارير العملاء',
                        exportOptions: { columns: ':visible:not(:last-child)' }
                    }
                ]
            });

            $('#btnExcel').on('click', function () { table.button(0).trigger(); });
            $('#btnPrint').on('click', function () { table.button(1).trigger(); });

            $('#filterPanel').on('show.bs.collapse', function () {
                $('#filterToggleBtn').attr('aria-expanded', 'true');
            }).on('hide.bs.collapse', function () {
                $('#filterToggleBtn').attr('aria-expanded', 'false');
            });

            // ── Status Donut Chart ────────────────────────────
            @if(collect($invoices)->count() > 0)
            (function () {
                var ctx = document.getElementById('statusDonutChart');
                if (!ctx) return;
                new Chart(ctx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['مدفوعة', 'غير مدفوعة', 'مدفوعة جزئياً'],
                        datasets: [{
                            data: [
                                {{ $stats['paid_count'] }},
                                {{ $stats['unpaid_count'] }},
                                {{ $stats['partial_count'] }}
                            ],
                            backgroundColor: ['#22c03c', '#f93a5a', '#fb923c'],
                            hoverBackgroundColor: ['#16a34a', '#dc2626', '#ea580c'],
                            borderWidth: 3,
                            borderColor: '#fff',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        cutoutPercentage: 68,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: { family: 'Tajawal, sans-serif', size: 13 },
                                    color: '#475569',
                                    padding: 16,
                                    usePointStyle: true,
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(ctx) {
                                        var total = ctx.dataset.data.reduce((a,b)=>a+b,0);
                                        var pct = total > 0 ? ((ctx.parsed / total)*100).toFixed(1) : 0;
                                        return ' ' + ctx.label + ': ' + ctx.parsed + ' (' + pct + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            })();
            @endif

            // ── Monthly Bar + Line Chart ──────────────────────
            @if(count($bladeChartLabels) > 0)
            (function () {
                var ctx = document.getElementById('monthlyBarChart');
                if (!ctx) return;
                new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($bladeChartLabels) !!},
                        datasets: [
                            {
                                label: 'إجمالي المبالغ (ر.س)',
                                data: {!! json_encode($bladeChartTotals) !!},
                                backgroundColor: 'rgba(1,98,232,.75)',
                                borderColor: '#0162e8',
                                borderWidth: 0,
                                borderRadius: 6,
                                yAxisID: 'y',
                            },
                            {
                                label: 'عدد الفواتير',
                                data: {!! json_encode($bladeChartCounts) !!},
                                type: 'line',
                                backgroundColor: 'rgba(34,197,94,.1)',
                                borderColor: '#22c03c',
                                borderWidth: 2.5,
                                yAxisID: 'y1',
                                tension: 0.4,
                                pointBackgroundColor: '#22c03c',
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                fill: true,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: { family: 'Tajawal, sans-serif', size: 13 },
                                    color: '#475569',
                                    padding: 18,
                                    usePointStyle: true,
                                }
                            }
                        },
                        scales: {
                            y: {
                                type: 'linear', position: 'left',
                                grid: { color: '#f1f5f9' },
                                ticks: {
                                    font: { family: 'Tajawal, sans-serif' },
                                    color: '#475569',
                                    callback: function(v) { return v.toLocaleString('ar-SA') + ' ر.س'; }
                                }
                            },
                            y1: {
                                type: 'linear', position: 'right',
                                grid: { drawOnChartArea: false },
                                ticks: {
                                    font: { family: 'Tajawal, sans-serif' },
                                    color: '#22c03c',
                                    stepSize: 1,
                                    precision: 0,
                                }
                            },
                            x: {
                                grid: { color: '#f1f5f9' },
                                ticks: {
                                    font: { family: 'Tajawal, sans-serif' },
                                    color: '#475569'
                                }
                            }
                        }
                    }
                });
            })();
            @endif

        }); // end ready
    </script>
@endsection
