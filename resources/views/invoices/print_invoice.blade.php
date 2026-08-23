@extends('layouts.master')
@section('css')
    <style>
        @@media print {
            /* إخفاء كل عناصر الموقع */
            .app-sidebar,
            .app-sidebar__overlay,
            .main-header,
            .main-footer,
            .breadcrumb-header,
            .invoice-actions,
            .sidebar.sidebar-left,
            .modal,
            .modal-backdrop,
            #global-loader {
                display: none !important;
                height: 0 !important;
                overflow: hidden !important;
            }

            /* إزالة الـ margin بتاع السايد بار */
            .main-content.app-content {
                margin-right: 0 !important;
                margin-left: 0 !important;
                padding: 0 !important;
            }

            .container-fluid {
                padding: 0 !important;
                margin: 0 !important;
            }

            body, html {
                background: #fff !important;
                padding: 0 !important;
                margin: 0 !important;
                height: auto !important;
                overflow: visible !important;
            }

            .invoice-wrapper {
                box-shadow: none !important;
                border-radius: 0 !important;
                margin: 0 !important;
            }

            /* منع صفحة فاضية إضافية */
            .row { margin: 0 !important; }
            .col-xl-12 { padding: 0 !important; }
        }
    </style>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }

        /* Invoice wrapper */
        .invoice-wrapper {
            background: #fff;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 8px 32px rgba(0, 0, 0, 0.04);
            margin-bottom: 20px;
        }

        /* Header */
        .invoice-header {
            background: #1e40af;
            padding: 36px 44px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .company-info {
            color: #fff;
        }

        .company-name {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .company-sub {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
        }

        .invoice-label .word {
            font-size: 34px;
            font-weight: 700;
            color: #fff;
            line-height: 1;
            display: block;
            opacity: 0.95;
        }

        .invoice-label .number {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 6px;
            display: block;
            direction: ltr;
            text-align: right;
        }

        /* Meta bar */
        .invoice-meta {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 18px 44px;
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
        }

        .meta-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #94a3b8;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .meta-value {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        .status-chip {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-paid {
            background: #dcfce7;
            color: #15803d;
        }

        .status-unpaid {
            background: #fee2e2;
            color: #dc2626;
        }

        .status-partial {
            background: #fef3c7;
            color: #b45309;
        }

        /* Body */
        .invoice-body {
            padding: 40px 44px;
        }

        /* Parties */
        .parties {
            margin-bottom: 36px;
        }

        .party-heading {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #94a3b8;
            font-weight: 600;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
        }

        .party-name {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .party-detail {
            font-size: 13px;
            color: #64748b;
            line-height: 1.8;
        }

        /* Table */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 36px;
        }

        .invoice-table thead tr {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }

        .invoice-table th {
            padding: 12px 16px;
            text-align: right;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #64748b;
        }

        .invoice-table td {
            padding: 16px;
            font-size: 14px;
            color: #1e293b;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .invoice-table tbody tr:last-child td {
            border-bottom: none;
        }

        .product-name {
            font-weight: 600;
        }

        .product-section {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 2px;
        }

        /* Totals */
        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .totals-box {
            width: 300px;
        }

        .totals-line {
            display: flex;
            justify-content: space-between;
            padding: 9px 0;
            font-size: 14px;
            color: #475569;
            border-bottom: 1px solid #f1f5f9;
        }

        .totals-line .t-label {
            color: #64748b;
        }

        .totals-line .t-value {
            font-weight: 600;
            color: #1e293b;
        }

        .totals-total {
            display: flex;
            justify-content: space-between;
            padding: 14px 16px;
            margin-top: 6px;
            background: #1e40af;
            border-radius: 6px;
            font-size: 17px;
            font-weight: 700;
            color: #fff;
        }

        /* Notes */
        .invoice-notes {
            margin-top: 30px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .notes-heading {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #94a3b8;
            margin-bottom: 8px;
        }

        .notes-text {
            font-size: 13px;
            color: #64748b;
            line-height: 1.8;
        }

        /* Footer */
        .invoice-footer {
            padding: 18px 44px;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-note {
            font-size: 12px;
            color: #94a3b8;
        }

        /* Action buttons */
        .invoice-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        @media print {

            .invoice-actions,
            .breadcrumb-header,
            .app-sidebar,
            .app-header,
            .main-sidemenu,
            .main-header,
            nav {
                display: none !important;
            }

            .main-content,
            .container,
            .container-fluid {
                padding: 0 !important;
                margin: 0 !important;
            }

            .invoice-wrapper {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
@endsection

@section('title')
طباعة فاتورة {{ $invoice->invoice_number }}
@stop

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طباعة الفاتورة</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            {{-- Action Buttons --}}
            <div class="invoice-actions">
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print mr-2"></i> طباعة
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right mr-2"></i> رجوع
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">

            {{-- Invoice Card --}}
            <div class="invoice-wrapper">

                {{-- Header --}}
                <div class="invoice-header">
                    <div class="company-info">
                        <div class="company-name">InvoicePro</div>
                        <div class="company-sub">نظام متكامل لإدارة الفواتير</div>
                    </div>
                    <div class="invoice-label">
                        <span class="word">فاتورة</span>
                        <span class="number"># {{ $invoice->invoice_number }}</span>
                    </div>
                </div>

                {{-- Meta Bar --}}
                <div class="invoice-meta">
                    <div>
                        <div class="meta-label">تاريخ الإصدار</div>
                        <div class="meta-value">{{ $invoice->invoice_date }}</div>
                    </div>
                    <div>
                        <div class="meta-label">تاريخ الاستحقاق</div>
                        <div class="meta-value">{{ $invoice->due_date }}</div>
                    </div>
                    @if($invoice->payment_date && $invoice->payment_date !== 'not implemented')
                        <div>
                            <div class="meta-label">تاريخ الدفع</div>
                            <div class="meta-value">{{ $invoice->payment_date }}</div>
                        </div>
                    @endif
                    <div>
                        <div class="meta-label">الحالة</div>
                        <div class="meta-value">
                            @if($invoice->value_status == 1)
                                <span class="status-chip status-paid">{{ $invoice->status }}</span>
                            @elseif($invoice->value_status == 2)
                                <span class="status-chip status-unpaid">{{ $invoice->status }}</span>
                            @else
                                <span class="status-chip status-partial">{{ $invoice->status }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Body --}}
                <div class="invoice-body">

                    {{-- Party Info --}}
                    <div class="parties">
                        <div class="party-heading">معلومات الفاتورة</div>
                        <div class="party-name">{{ $invoice->section->section_name }}</div>
                        <div class="party-detail">
                            القسم: {{ $invoice->section->section_name }}<br>
                            منشئ الفاتورة: {{ $invoice->user }}
                        </div>
                    </div>

                    {{-- Table --}}
                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th style="width: 35%">المنتج / الخدمة</th>
                                <th>مبلغ التحصيل</th>
                                <th>مبلغ العمولة</th>
                                <th>الخصم</th>
                                <th>الصافي</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="product-name">{{ $invoice->product }}</div>
                                    <div class="product-section">{{ $invoice->section->section_name }}</div>
                                </td>
                                <td>{{ number_format($invoice->amount_collection, 2) }}</td>
                                <td>{{ number_format($invoice->amount_commission, 2) }}</td>
                                <td>{{ number_format($invoice->discount, 2) }}</td>
                                <td>{{ number_format(($invoice->amount_commission - $invoice->discount), 2) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- Totals --}}
                    <div class="totals-section">
                        <div class="totals-box">
                            <div class="totals-line">
                                <span class="t-label">الإجمالي قبل الضريبة</span>
                                <span
                                    class="t-value">{{ number_format(($invoice->amount_commission - $invoice->discount), 2) }}</span>
                            </div>
                            <div class="totals-line">
                                <span class="t-label">ضريبة القيمة المضافة ({{ $invoice->rate_vat }})</span>
                                <span class="t-value">{{ number_format($invoice->value_vat, 2) }}</span>
                            </div>
                            <div class="totals-total">
                                <span>الإجمالي الكلي</span>
                                <span>{{ number_format($invoice->total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Notes --}}
                    @if($invoice->note)
                        <div class="invoice-notes">
                            <div class="notes-heading">ملاحظات</div>
                            <div class="notes-text">{{ $invoice->note }}</div>
                        </div>
                    @endif

                </div>

                {{-- Footer --}}
                <div class="invoice-footer">
                    <span class="footer-note">تم إنشاء هذه الفاتورة آلياً — لا تحتاج إلى توقيع</span>
                    <span class="footer-note" style="direction: ltr;">{{ $invoice->invoice_number }}</span>
                </div>

            </div>

        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
@endsection