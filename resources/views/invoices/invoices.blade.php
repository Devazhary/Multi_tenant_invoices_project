@extends('layouts.master')
@section('title')
    قائمة الفواتير
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <style>
        .btn-modern-dropdown {
            background-color: transparent;
            color: #6c757d;
            border: none;
            border-radius: 8px;
            padding: 5px 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease-in-out;
            font-size: 14px;
        }

        .btn-modern-dropdown:hover,
        .btn-modern-dropdown:focus {
            background-color: #f3f6f9;
            color: #0162e8;
            outline: none;
        }

        .modern-dropdown-menu {
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            padding: 8px 0;
        }

        .modern-dropdown-item {
            padding: 8px 20px;
            font-size: 13.5px;
            color: #495057;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            background: transparent;
            border: none;
            width: 100%;
            text-align: right;
        }

        .modern-dropdown-item:hover,
        .modern-dropdown-item:focus {
            background-color: #f8f9fc;
            color: #0162e8;
            outline: none;
        }

        .modern-dropdown-item i {
            margin-left: 10px;
            font-size: 15px;
        }

        .btn-modern-excel {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff !important;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
            transition: all 0.3s ease;
            margin-right: 15px;
            text-decoration: none;
        }

        .btn-modern-excel:hover, .btn-modern-excel:focus {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            outline: none;
        }
        
        .btn-modern-excel i {
            font-size: 16px;
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    الفواتير</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a class="btn ripple btn-primary" href="{{ route('invoices.create') }}">اضافة فاتورة <i class="fa fa-plus"
                    aria-hidden="true"></i></a>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">قائمة الفواتير</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                    <th class="wd-15p border-bottom-0">تاريخ الفاتورة</th>
                                    <th class="wd-15p border-bottom-0">تاريخ الاستحقاق</th>
                                    <th class="wd-15p border-bottom-0">المنتج</th>
                                    <th class="wd-15p border-bottom-0">القسم</th>
                                    <th class="wd-15p border-bottom-0">الخصم</th>
                                    <th class="wd-15p border-bottom-0">نسبة الضريبة</th>
                                    <th class="wd-15p border-bottom-0">قيمة الضريبة</th>
                                    <th class="wd-15p border-bottom-0">الاجمالي</th>
                                    <th class="wd-15p border-bottom-0">الحالة</th>
                                    <th class="wd-15p border-bottom-0">ملاحظات</th>
                                    <th class="wd-15p border-bottom-0">العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a
                                                href="{{ route('invoices.details', $invoice->id) }}">{{ $invoice->invoice_number }}</a>
                                        </td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td>{{ $invoice->section->section_name }}</td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ $invoice->rate_vat }}</td>
                                        <td>{{ $invoice->value_vat }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        <td>
                                            @if ($invoice->value_status == 1)
                                                <span class="text-success">{{ $invoice->status }}</span>
                                            @elseif($invoice->value_status == 2)
                                                <span class="text-danger">{{ $invoice->status }}</span>
                                            @else
                                                <span class="text-warning">{{ $invoice->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $invoice->note }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn-modern-dropdown" data-toggle="dropdown" type="button">
                                                    العمليات <i class="fas fa-angle-down mr-1"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right modern-dropdown-menu">
                                                    <a class="dropdown-item modern-dropdown-item"
                                                        href="{{ route('invoices.edit', $invoice->id) }}">
                                                        <i class="text-info fas fa-pen"></i> تعديل الفاتورة
                                                    </a>
                                                    <x-delete-confirm
                                                        action="{{ route('invoices.destroy', $invoice->id) }}"
                                                        title="تأكيد حذف الفاتورة"
                                                        message="هل أنت متأكد من رغبتك في حذف الفاتورة '{{ $invoice->invoice_number }}'؟">
                                                        <button class="dropdown-item modern-dropdown-item" title="حذف">
                                                            <i class="text-info fas fa-trash"></i> حذف الفاتورة
                                                        </button>
                                                    </x-delete-confirm>
                                                    <a class="dropdown-item modern-dropdown-item"
                                                        href="{{ route('invoices.status_show', $invoice->id) }}">
                                                        <i class="text-info fas fa-credit-card"></i> حالة الدفع
                                                    </a>
                                                    <a class="dropdown-item modern-dropdown-item"
                                                        href="{{ route('invoices.archive', $invoice->id) }}">
                                                        <i class="text-info fas fa-archive"></i> ارشيف الفاتورة
                                                    </a>
                                                    <a class="dropdown-item modern-dropdown-item"
                                                        href="{{ route('invoices.print', $invoice->id) }}">
                                                        <i class="text-info fas fa-print"></i> طباعة الفاتورة
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center">لا توجد فواتير</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
    <!-- Internal Data tables -->
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
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                let exportBtn = '<a class="btn-modern-excel" href="{{ route('invoices.export') }}">تصدير اكسيل <i class="fas fa-file-excel"></i></a>';
                $('#example1_length').append(exportBtn);
                $('#example1_length').css({
                    'display': 'flex',
                    'align-items': 'center'
                });
            }, 100);
        });
    </script>
@endsection
