@extends('layouts.master')
@section('title')
    اضافة دور
@endsection
@section('css')
    <style>
        /* Shared Styles */
        body {
            background-color: #f4f7fe;
        }

        .page-header {
            margin-bottom: 1.5rem !important;
        }

        .custom-card {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            background: #ffffff;
            margin-bottom: 24px;
        }

        /* Form Inputs */
        .form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 14.5px;
        }

        .form-control-modern {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 12px 16px;
            font-size: 14.5px;
            background-color: #f9fafb;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control-modern:focus {
            background-color: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            outline: none;
        }

        /* Permission Cards */
        .perm-group-card {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: #ffffff;
            height: 100%;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .perm-group-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .perm-group-header {
            background-color: #f8fafc;
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .perm-group-icon {
            width: 36px;
            height: 36px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .perm-group-title {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .perm-group-body {
            padding: 16px 20px;
        }

        /* iOS Style Toggle Switch */
        .perm-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .perm-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .perm-label {
            font-size: 14.5px;
            font-weight: 500;
            color: #374151;
            margin: 0;
            cursor: pointer;
        }

        .custom-switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 26px;
        }

        .custom-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .3s cubic-bezier(0.4, 0.0, 0.2, 1);
            border-radius: 26px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            right: 3px; /* Start on the right for RTL */
            bottom: 3px;
            background-color: white;
            transition: .3s cubic-bezier(0.4, 0.0, 0.2, 1);
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        input:checked + .slider {
            background-color: #10b981; /* Green */
        }

        input:checked + .slider:before {
            transform: translateX(-20px); /* Move left in RTL */
        }

        /* The Save Button */
        .btn-modern {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.15);
            cursor: pointer;
        }

        .btn-modern:hover {
            background-color: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 8px 12px -3px rgba(37, 99, 235, 0.25);
        }
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between page-header">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة
                    دور</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a class="btn btn-light" style="border-radius: 8px; font-weight: 600;" href="{{ route('roles.index') }}">
                <i class="fas fa-arrow-right ml-1"></i> العودة للقائمة
            </a>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <form action="#" method="POST">
        @csrf
        
        <!-- Role Name Section -->
        <div class="row">
            <div class="col-12">
                <div class="card custom-card p-4">
                    <div class="form-group mb-0">
                        <label>اسم الدور / الصلاحية <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control-modern" required placeholder="مثال: مدير المبيعات، محاسب، موظف فواتير...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Permissions Section -->
        <h5 class="mb-4" style="font-weight: 700; color: #1f2937;">تخصيص الصلاحيات والأذونات:</h5>
        
        <div class="row">
            
            <!-- Invoices Module -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="perm-group-card">
                    <div class="perm-group-header">
                        <div class="perm-group-icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h6 class="perm-group-title">نظام الفواتير</h6>
                    </div>
                    <div class="perm-group-body">
                        @php
                            $invoicePerms = ['الفواتير', 'قائمة الفواتير', 'إضافة فاتورة', 'تعديل فاتورة', 'حذف فاتورة', 'تصدير اكسيل', 'حالة الدفع', 'طباعة فاتورة', 'الفواتير المدفوعة', 'الفواتير الغير مدفوعة', 'الفواتير المدفوعة جزئيا'];
                        @endphp
                        
                        @foreach($invoicePerms as $index => $perm)
                            <div class="perm-item">
                                <label class="perm-label" for="perm_inv_{{ $index }}">{{ $perm }}</label>
                                <label class="custom-switch">
                                    <input type="checkbox" name="permission[]" value="{{ $perm }}" id="perm_inv_{{ $index }}">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Archive Module -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="perm-group-card">
                    <div class="perm-group-header">
                        <div class="perm-group-icon" style="background: #fef2f2; color: #dc2626;">
                            <i class="fas fa-archive"></i>
                        </div>
                        <h6 class="perm-group-title">الأرشيف والمحذوفات</h6>
                    </div>
                    <div class="perm-group-body">
                        @php
                            $archivePerms = ['ارشيف فاتورة', 'الغاء ارشيف فاتورة', 'قائمة الفواتير المؤرشفة', 'حذف الفواتير المؤرشفة'];
                        @endphp
                        
                        @foreach($archivePerms as $index => $perm)
                            <div class="perm-item">
                                <label class="perm-label" for="perm_arc_{{ $index }}">{{ $perm }}</label>
                                <label class="custom-switch">
                                    <input type="checkbox" name="permission[]" value="{{ $perm }}" id="perm_arc_{{ $index }}">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Products & Sections Module -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="perm-group-card">
                    <div class="perm-group-header">
                        <div class="perm-group-icon" style="background: #fef3c7; color: #d97706;">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <h6 class="perm-group-title">الأقسام والمنتجات</h6>
                    </div>
                    <div class="perm-group-body">
                        @php
                            $prodPerms = ['الاعدادات', 'الاقسام', 'اضافة قسم', 'تعديل قسم', 'حذف قسم', 'المنتجات', 'اضافة منتج', 'تعديل منتج', 'حذف منتج'];
                        @endphp
                        
                        @foreach($prodPerms as $index => $perm)
                            <div class="perm-item">
                                <label class="perm-label" for="perm_prod_{{ $index }}">{{ $perm }}</label>
                                <label class="custom-switch">
                                    <input type="checkbox" name="permission[]" value="{{ $perm }}" id="perm_prod_{{ $index }}">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Users & Roles Module -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="perm-group-card">
                    <div class="perm-group-header">
                        <div class="perm-group-icon" style="background: #f3e8ff; color: #9333ea;">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <h6 class="perm-group-title">إدارة المستخدمين والأدوار</h6>
                    </div>
                    <div class="perm-group-body">
                        @php
                            $userPerms = ['المستخدمين', 'قائمة المستخدمين', 'اضافة مستخدم', 'تعديل مستخدم', 'حذف مستخدم', 'صلاحيات المستخدمين'];
                        @endphp
                        
                        @foreach($userPerms as $index => $perm)
                            <div class="perm-item">
                                <label class="perm-label" for="perm_usr_{{ $index }}">{{ $perm }}</label>
                                <label class="custom-switch">
                                    <input type="checkbox" name="permission[]" value="{{ $perm }}" id="perm_usr_{{ $index }}">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div> <!-- End row -->

        <!-- Save Button -->
        <div class="row mt-3 mb-5">
            <div class="col-12 text-center">
                <hr style="border-color: #e5e7eb; margin-bottom: 24px;">
                <button type="submit" class="btn-modern">
                    <i class="fas fa-save"></i> اضافة دور
                </button>
            </div>
        </div>

    </form>
@endsection
@section('js')
    <!-- Script to toggle label color based on switch status -->
    <script>
        $(document).ready(function() {
            $('.custom-switch input').change(function() {
                var label = $(this).closest('.perm-item').find('.perm-label');
                if($(this).is(':checked')) {
                    label.css('color', '#10b981').css('font-weight', '700');
                } else {
                    label.css('color', '#374151').css('font-weight', '500');
                }
            });
        });
    </script>
@endsection