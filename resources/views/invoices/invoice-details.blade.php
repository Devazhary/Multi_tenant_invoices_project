@extends('layouts.master')
@section('css')
    <style>
        .premium-tab-content {
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
            border: 1px solid #f1f1f1;
        }

        /* Table 1: Info Table */
        .premium-info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e9ecef;
        }

        .premium-info-table th {
            background-color: #f8f9fa;
            color: #6c757d;
            font-weight: 600;
            padding: 16px 20px;
            border-bottom: 1px solid #e9ecef;
            border-left: 1px solid #e9ecef;
            width: 12%;
            text-align: right;
            vertical-align: middle;
        }

        .premium-info-table td {
            background-color: #ffffff;
            color: #343a40;
            font-weight: 600;
            padding: 16px 20px;
            border-bottom: 1px solid #e9ecef;
            border-left: 1px solid #e9ecef;
            text-align: right;
            vertical-align: middle;
        }

        .premium-info-table th:last-child,
        .premium-info-table td:last-child {
            border-left: none;
        }

        .premium-info-table tr:last-child th,
        .premium-info-table tr:last-child td {
            border-bottom: none;
        }

        /* Table 2 & 3: Data Tables */
        .premium-data-table {
            border-collapse: separate;
            border-spacing: 0 12px;
            width: 100%;
            margin-top: -12px;
        }

        .premium-data-table thead th {
            background: transparent;
            color: #a3aab1;
            font-weight: 700;
            font-size: 13px;
            padding: 10px 20px;
            border: none;
            text-align: center;
        }

        .premium-data-table tbody tr {
            background: #ffffff;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.04);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .premium-data-table tbody tr:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .premium-data-table tbody td {
            padding: 18px 20px;
            border: none;
            vertical-align: middle;
            color: #495057;
            font-weight: 600;
            text-align: center;
        }

        .premium-data-table tbody td:first-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .premium-data-table tbody td:last-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .action-btns {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .action-btns .btn {
            border-radius: 8px;
            padding: 8px 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 13px;
        }

        .action-btns .btn i {
            margin-right: 5px;
            /* RTL spacing */
        }

        .action-btns .btn:hover {
            transform: scale(1.05);
        }

        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 12px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .custom-file-upload {
            border: 2px dashed #0162e8;
            background-color: #f8f9ff;
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            width: 100%;
        }

        .custom-file-upload:hover {
            background-color: #eef2ff;
            border-color: #0050c0;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .custom-file-upload i {
            font-size: 40px;
            color: #0162e8;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .custom-file-upload:hover i {
            transform: scale(1.1);
        }

        .custom-file-upload p {
            margin: 0;
            font-weight: 600;
            color: #495057;
            font-size: 15px;
        }

        .file-input-hidden {
            display: none;
        }

        .btn-upload {
            padding: 12px 25px;
            font-weight: bold;
            font-size: 16px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(1, 98, 232, 0.2);
            transition: all 0.3s ease;
        }

        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(1, 98, 232, 0.3);
        }
    </style>
@endsection
@section('title')
    تفاصيل الفاتورة
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل الفاتورة</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a class="btn btn-primary" href="{{ redirect()->back()->getTargetUrl() }}">رجوع</a>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="panel panel-primary tabs-style-3">
                <div class="tab-menu-heading">
                    <div class="tabs-menu ">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li class=""><a href="#tab11" class="active" data-toggle="tab">معلومات الفاتورة</a></li>
                            <li><a href="#tab12" data-toggle="tab">حالات الدفع</a></li>
                            <li><a href="#tab13" data-toggle="tab">المرفقات</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body">
                    <div class="tab-content premium-tab-content">
                        <div class="tab-pane active" id="tab11">
                            <div class="table-responsive">
                                <table class="premium-info-table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">رقم الفاتورة</th>
                                            <td><span class="text-primary">{{ $invoice->invoice_number }}</span></td>
                                            <th scope="row">تاريخ الاصدار</th>
                                            <td>{{ $invoice->invoice_date }}</td>
                                            <th scope="row">تاريخ الاستحقاق</th>
                                            <td>{{ $invoice->due_date }}</td>
                                            <th scope="row">القسم</th>
                                            <td>{{ $invoice->section->section_name }}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">المنتج</th>
                                            <td>{{ $invoice->product }}</td>
                                            <th scope="row">مبلغ التحصيل</th>
                                            <td>{{ $invoice->amount_collection }}</td>
                                            <th scope="row">مبلغ العمولة</th>
                                            <td>{{ $invoice->amount_commission }}</td>
                                            <th scope="row">الخصم</th>
                                            <td>{{ $invoice->discount }}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">نسبة الضريبة</th>
                                            <td>{{ $invoice->rate_vat }}</td>
                                            <th scope="row">قيمة الضريبة</th>
                                            <td>{{ $invoice->value_vat }}</td>
                                            <th scope="row">الاجمالي مع الضريبة</th>
                                            <td><span class="text-success">{{ $invoice->total }}</span></td>
                                            <th scope="row">الحالة الحالية</th>
                                            <td>
                                                @if ($invoice->value_status == 1)
                                                    <span class="badge badge-success status-badge">{{ $invoice->status }}</span>
                                                @elseif($invoice->value_status == 2)
                                                    <span class="badge badge-danger status-badge">{{ $invoice->status }}</span>
                                                @else
                                                    <span
                                                        class="badge badge-warning status-badge text-white">{{ $invoice->status }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">ملاحظات</th>
                                            <td colspan="7">{{ $invoice->note ?: 'لا توجد ملاحظات' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab12">
                            <div class="table-responsive">
                                <table class="premium-data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>رقم الفاتورة</th>
                                            <th>نوع المنتج</th>
                                            <th>القسم</th>
                                            <th>حالة الدفع</th>
                                            <th>تاريخ الدفع</th>
                                            <th>ملاحظات</th>
                                            <th>تاريخ الاضافة</th>
                                            <th>المستخدم</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoiceDetails as $details)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $details->invoice_number }}</td>
                                                <td>{{ $details->product }}</td>
                                                <td>{{ $details->section }}</td>
                                                <td>
                                                    @if ($details->value_status == 1)
                                                        <span class="badge badge-success status-badge">{{ $details->status }}</span>
                                                    @elseif($details->value_status == 2)
                                                        <span class="badge badge-danger status-badge">{{ $details->status }}</span>
                                                    @else
                                                        <span
                                                            class="badge badge-warning status-badge text-white">{{ $details->status }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $details->payment_date }}</td>
                                                <td>{{ $details->note }}</td>
                                                <td>{{ $details->created_at }}</td>
                                                <td>{{ $details->user }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab13">
                            <!-- Add Attachment Form -->
                            <div class="card mb-4 border-0"
                                style="border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.03);">
                                <div class="card-header bg-white border-0 text-center"
                                    style="border-radius: 15px; padding: 20px;">
                                    <button
                                        class="btn btn-primary d-inline-flex justify-content-between align-items-center px-4"
                                        type="button" data-toggle="collapse" data-target="#collapseAddAttachment"
                                        aria-expanded="false" aria-controls="collapseAddAttachment"
                                        style="border-radius: 12px; font-size: 15px; font-weight: bold; padding: 12px 20px; box-shadow: 0 4px 10px rgba(1, 98, 232, 0.2); min-width: 250px;">
                                        <span><i class="fas fa-paperclip mr-2"></i> إضافة مرفق جديد للفاتورة</span>
                                        <i class="fas fa-chevron-down ml-3"></i>
                                    </button>
                                </div>
                                <div class="collapse" id="collapseAddAttachment">
                                    <div class="card-body p-4 pt-0">
                                        <form action="{{ route('invoice-attachments.store') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row align-items-center">
                                                <div class="col-12 mb-4">
                                                    <input type="file" name="file_name" id="file_name"
                                                        class="file-input-hidden" required
                                                        onchange="document.getElementById('file-name-display').innerText = this.files[0].name">
                                                    <label for="file_name" class="custom-file-upload m-0">
                                                        <i class="fas fa-cloud-upload-alt"></i>
                                                        <p>اسحب وأفلت الملف هنا أو <span class="text-primary">تصفح
                                                                لرفعه</span></p>
                                                        <span id="file-name-display"
                                                            class="d-block mt-3 text-success font-weight-bold"
                                                            style="font-size: 16px;"></span>
                                                    </label>
                                                </div>
                                                <div class="col-12 text-center">
                                                    <button type="submit" class="btn btn-primary btn-upload px-5">
                                                        رفع المرفق <i class="fas fa-arrow-up ml-2"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="invoice_number"
                                                value="{{ $invoice->invoice_number }}">
                                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="premium-data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>رقم الفاتورة</th>
                                            <th>اسم المرفق</th>
                                            <th>تم الاضافة بواسطة</th>
                                            <th>الاجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($invoiceAttachments as $attachment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $attachment->invoice_number }}</td>
                                                <td>{{ $attachment->file_name }}</td>
                                                <td>{{ $attachment->Created_by }}</td>
                                                <td>
                                                    <div class="action-btns">
                                                        <a class="btn btn-outline-success btn-sm"
                                                            href="{{ route('invoices.show_file', $attachment->id) }}" target="_blank"
                                                            role="button">
                                                            عرض <i class="fas fa-eye"></i>
                                                        </a>

                                                        <a class="btn btn-outline-info btn-sm"
                                                            href="{{ route('invoices.download_file', $attachment->id) }}"
                                                            role="button">
                                                            تحميل <i class="fas fa-download"></i>
                                                        </a>

                                                        <x-delete-confirm
                                                            action="{{ route('invoice-attachments.destroy', $attachment->id) }}"
                                                            title="تأكيد حذف المرفق"
                                                            message="هل أنت متأكد من رغبتك في حذف المرفق '{{ $attachment->file_name }}'؟">
                                                            <button class="btn btn-sm btn-outline-danger" title="حذف">حذف <i
                                                                    class="fa fa-trash"></i></button>
                                                        </x-delete-confirm>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">لا توجد مرفقات</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
@endsection