@extends('layouts.master')
@section('title')
    تعديل مستخدم
@endsection
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <style>
        /* Card & Layout */
        .custom-card {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            background-color: #ffffff;
        }

        .form-group {
            margin-bottom: 1.8rem;
        }

        .form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 14px;
            display: inline-block;
        }

        /* Modern Input Group */
        .input-group-modern {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group-modern i {
            position: absolute;
            right: 16px;
            color: #9ca3af;
            font-size: 16px;
            transition: all 0.3s ease;
            z-index: 5;
            pointer-events: none;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 12px 16px;
            font-size: 14.5px;
            transition: all 0.3s ease;
            background-color: #f9fafb;
            height: 48px;
            width: 100%;
            padding-right: 42px !important;
            color: #111827;
        }

        .form-control::placeholder {
            color: #9ca3af;
            font-size: 13.5px;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            outline: none;
        }

        .form-control:focus + i,
        .input-group-modern input:focus ~ i {
            color: #3b82f6;
        }

        /* The Button */
        .btn-modern {
            border-radius: 8px;
            padding: 12px 30px;
            font-size: 15px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            letter-spacing: 0.3px;
        }

        .btn-primary-modern {
            background-color: #2563eb;
            color: white;
            border: none;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.15);
        }

        .btn-primary-modern i {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary-modern:hover {
            background-color: #1d4ed8;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3), 0 4px 6px -2px rgba(37, 99, 235, 0.15);
        }

        .btn-primary-modern:hover i {
            transform: scale(1.15) rotate(-5deg);
        }
        
        .btn-primary-modern:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.15);
        }

        .btn-light-modern {
            background-color: #ffffff;
            color: #4b5563;
            border: 1px solid #d1d5db;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            padding: 10px 20px;
        }

        .btn-light-modern:hover {
            background-color: #f3f4f6;
            color: #111827;
        }

        /* Section Titles */
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
        }

        .section-title i {
            color: #6b7280;
            margin-left: 10px;
            font-size: 17px;
            background: #f3f4f6;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        /* Status Toggle Group (Segmented Control) */
        .status-toggle-group {
            display: flex;
            gap: 12px;
        }

        .status-toggle-group input[type="radio"] {
            display: none;
        }

        .status-btn {
            flex: 1;
            padding: 11px 15px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            background-color: #f9fafb;
            color: #4b5563;
            font-size: 14.5px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
            height: 48px;
        }

        .status-btn i {
            font-size: 16px;
            transition: transform 0.2s ease;
        }

        /* Active State for 'مفعل' */
        .status-toggle-group input[id="status-active"]:checked + .active-btn {
            background-color: #ecfdf5;
            border-color: #10b981;
            color: #047857;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.1);
        }

        .status-toggle-group input[id="status-active"]:checked + .active-btn i {
            color: #10b981;
            transform: scale(1.1);
        }

        /* Active State for 'غير مفعل' */
        .status-toggle-group input[id="status-inactive"]:checked + .inactive-btn {
            background-color: #fef2f2;
            border-color: #ef4444;
            color: #b91c1c;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.1);
        }

        .status-toggle-group input[id="status-inactive"]:checked + .inactive-btn i {
            color: #ef4444;
            transform: scale(1.1);
        }

        .status-btn:hover {
            background-color: #f3f4f6;
        }

        /* Select2 Smoothness */
        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            background-color: #f9fafb;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: #111827;
        }

        .select2-container--default .select2-selection--single {
            height: 48px;
            display: flex;
            align-items: center;
            padding: 0 15px;
        }

        .select2-container--default .select2-selection--multiple {
            min-height: 48px;
            padding: 4px 10px;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            background-color: #ffffff;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
            right: 12px;
        }

        /* Multi-select Tags */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            border-radius: 6px;
            padding: 4px 10px;
            margin-top: 6px;
            margin-left: 6px;
            font-size: 13.5px;
            font-weight: 500;
            display: flex;
            align-items: center;
            flex-direction: row-reverse;
            transition: all 0.2s ease;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice:hover {
            background-color: #dbeafe;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #3b82f6;
            margin-right: 8px;
            margin-left: 0;
            font-weight: bold;
            font-size: 16px;
            border-right: 1px solid #bfdbfe;
            padding-right: 6px;
            background: transparent;
            border-left: none;
            padding-left: 0;
            transition: all 0.2s ease;
        }
        
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #dc2626;
            background: transparent;
        }

        .select2-dropdown {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            padding: 4px 0;
            overflow: hidden;
            animation: dropdownFade 0.2s ease-out;
        }
        
        @keyframes dropdownFade {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #eff6ff;
            color: #1d4ed8;
        }

        .select2-results__option {
            padding: 8px 16px;
            font-size: 14.5px;
            transition: background-color 0.1s ease;
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل
                    بيانات المستخدم</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a class="btn btn-light-modern btn-modern" href="{{ route('users.index') }}">
                <i class="fas fa-arrow-right ml-1"></i> العودة للقائمة
            </a>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card custom-card">
                <div class="card-body p-4 p-md-5">
                    <!-- Assuming $user is passed to the view -->
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4" style="border-radius:8px;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Section 1: Basic Info -->
                        <div class="section-title">
                            <i class="fas fa-user-edit"></i>
                            البيانات الأساسية
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>اسم المستخدم <span class="text-danger">*</span></label>
                                    <div class="input-group-modern">
                                        <input type="text" name="name" class="form-control" required value="{{ old('name', $user->name ?? '') }}" placeholder="مثال: أحمد محمد">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>البريد الإلكتروني <span class="text-danger">*</span></label>
                                    <div class="input-group-modern">
                                        <input type="email" name="email" class="form-control" required value="{{ old('email', $user->email ?? '') }}" placeholder="example@company.com">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Login Info -->
                        <div class="section-title mt-2">
                            <i class="fas fa-lock"></i>
                            بيانات الدخول <small class="text-muted mr-2" style="font-weight: normal; font-size: 13px;">(اترك الحقول فارغة إذا لم ترد تغيير كلمة المرور)</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>كلمة المرور الجديدة</label>
                                    <div class="input-group-modern">
                                        <input type="password" name="password" class="form-control" placeholder="أدخل كلمة مرور جديدة">
                                        <i class="fas fa-key"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>تأكيد كلمة المرور الجديدة</label>
                                    <div class="input-group-modern">
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="أعد إدخال كلمة المرور للمطابقة">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Roles and Status -->
                        <div class="section-title mt-2">
                            <i class="fas fa-id-badge"></i>
                            الصلاحيات والحالة
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>حالة الحساب <span class="text-danger">*</span></label>
                                    <div class="status-toggle-group">
                                        @php
                                            $status = old('status', $user->status ?? 'active');
                                        @endphp
                                        <input type="radio" name="status" id="status-active" value="active" {{ $status == 'active' ? 'checked' : '' }}>
                                        <label for="status-active" class="status-btn active-btn">
                                            <i class="fas fa-check-circle"></i> مفعل
                                        </label>
                                        
                                        <input type="radio" name="status" id="status-inactive" value="inactive" {{ $status == 'inactive' ? 'checked' : '' }}>
                                        <label for="status-inactive" class="status-btn inactive-btn">
                                            <i class="fas fa-times-circle"></i> غير مفعل
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>صلاحيات المستخدم <span class="text-danger">*</span> <small class="text-muted" style="font-size: 11.5px; font-weight: normal;">(يمكنك اختيار أكثر من صلاحية)</small></label>
                                    <select name="roles[]" class="form-control select2" multiple="multiple">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ in_array($role->name, $userRoles) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-4 border-top" style="border-color: #e5e7eb !important;">
                            <button type="submit" class="btn btn-primary-modern btn-modern">
                                <i class="fas fa-save"></i>
                                <span>تحديث بيانات المستخدم</span>
                            </button>
                        </div>
                    </form>
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
    <!-- Internal Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "اضغط للاختيار من القائمة",
                dir: "rtl",
                width: '100%',
                language: {
                    noResults: function () {
                        return "لم يتم العثور على نتائج";
                    }
                }
            });
        });
    </script>
@endsection