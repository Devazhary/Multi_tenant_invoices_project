@extends('layouts.master')
@section('title')
    صلاحيات المستخدمين
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <style>
        /* Shared Styles */
        body {
            background-color: #f4f7fe;
        }

        .page-header {
            margin-bottom: 1.5rem !important;
        }

        .btn-primary-custom {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14.5px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.1);
        }

        .btn-primary-custom:hover {
            background-color: #1d4ed8;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 6px 10px -1px rgba(37, 99, 235, 0.2);
        }

        /* View Toggle Switch */
        .view-switch {
            display: inline-flex;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 4px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .view-btn {
            background: transparent;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            color: #6b7280;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .view-btn.active {
            background-color: #eff6ff;
            color: #2563eb;
        }

        /* Container Visibility */
        #grid-view-container {
            display: none; /* Grid hidden by default */
        }
        
        #table-view-container {
            display: block; /* Table active by default */
        }

        /* --- Premium Table Design --- */
        .custom-table-card {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            background: #ffffff;
            overflow: hidden;
        }

        .custom-table-card .card-body {
            padding: 0;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            font-weight: 600;
            color: #6b7280;
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb !important;
            border-top: none !important;
            padding: 16px 24px !important;
            font-size: 12.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 18px 24px !important;
            border-bottom: 1px solid #f3f4f6;
            color: #111827;
            font-size: 14.5px;
        }
        
        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Soft Badges */
        .badge-soft-blue {
            background-color: #eff6ff;
            color: #2563eb;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            border: 1px solid #bfdbfe;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .badge-soft-purple {
            background-color: #f3e8ff;
            color: #9333ea;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            border: 1px solid #e9d5ff;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Action Icons Table */
        .icon-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            color: #6b7280;
            background: transparent;
            transition: all 0.2s ease;
            margin: 0 2px;
            border: 1px solid transparent;
        }

        .icon-action:hover {
            background-color: #f3f4f6;
            color: #111827;
            border-color: #e5e7eb;
        }

        .icon-action.edit:hover {
            background-color: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }

        .icon-action.delete:hover {
            background-color: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        /* DataTable layout fixes */
        .dataTables_wrapper .row {
            padding: 10px 24px;
        }
        
        .dataTables_wrapper .row:first-child {
            padding-top: 24px;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .dataTables_wrapper .row:last-child {
            padding-bottom: 24px;
            border-top: 1px solid #f3f4f6;
        }


        /* --- Premium Cards Design --- */
        .role-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .role-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }

        /* Dropdown menu on card top left */
        .card-menu-btn {
            position: absolute;
            top: 20px;
            left: 20px; 
            color: #9ca3af;
            cursor: pointer;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: background 0.2s;
            border: none;
            background: transparent;
        }
        
        .card-menu-btn:hover {
            background: #f3f4f6;
            color: #4b5563;
        }
        
        .dropdown-menu-custom {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            padding: 8px 0;
        }

        .dropdown-menu-custom .dropdown-item {
            padding: 8px 20px;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .dropdown-menu-custom .dropdown-item:hover {
            background-color: #f3f4f6;
        }
        
        .dropdown-menu-custom .dropdown-item.text-danger:hover {
            background-color: #fef2f2;
        }

        .role-card-header {
            margin-bottom: 24px;
        }

        .role-icon-box {
            width: 48px;
            height: 48px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .role-title {
            font-size: 17px;
            font-weight: 700;
            color: #111827;
            margin: 0 0 4px 0;
        }

        .role-desc {
            font-size: 13.5px;
            color: #6b7280;
            margin: 0;
        }

        .role-stats-box {
            background: #f8fafc;
            border-radius: 10px;
            padding: 16px;
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
            flex-grow: 1;
            border: 1px solid #f1f5f9;
        }

        .stat-group {
            text-align: center;
            width: 45%;
        }

        .stat-val {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            display: block;
            margin-bottom: 2px;
        }

        .stat-label {
            font-size: 12.5px;
            font-weight: 600;
            color: #64748b;
        }
        
        .stat-divider {
            width: 1px;
            background: #e2e8f0;
        }

        .btn-view-role {
            width: 100%;
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            color: #374151;
            padding: 10px;
            border-radius: 8px;
            font-size: 14.5px;
            font-weight: 600;
            transition: all 0.2s ease;
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .btn-view-role:hover {
            background-color: #f9fafb;
            color: #111827;
            border-color: #9ca3af;
            text-decoration: none;
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between page-header">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إدارة
                    الصلاحيات والأدوار</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a class="btn-primary-custom" href="{{ route('roles.create') }}">
                <i class="fa fa-plus"></i> اضافة دور
            </a>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <!-- Controls Row -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <p class="text-muted mb-0" style="font-size: 14.5px; font-weight: 500;">أدوار النظام والصلاحيات المخصصة للمستخدمين للتحكم في الوصول.</p>
            </div>
            
            <!-- View Toggle Switch -->
            <div class="view-switch">
                <button class="view-btn active" id="btn-table-view">
                    <i class="fas fa-list"></i> جدول
                </button>
                <button class="view-btn" id="btn-grid-view">
                    <i class="fas fa-th-large"></i> بطاقات
                </button>
            </div>
        </div>
    </div>

    @php
        // Dummy Data for UI Showcase
        $rolesData = [
            ['id' => 1, 'name' => 'مدير النظام (Admin)', 'permissions_count' => 125, 'users_count' => 3, 'desc' => 'له الصلاحية الكاملة على جميع أجزاء النظام'],
            ['id' => 2, 'name' => 'محاسب (Accountant)', 'permissions_count' => 45, 'users_count' => 8, 'desc' => 'صلاحية إدارة الفواتير وتقارير الحسابات'],
            ['id' => 3, 'name' => 'مستخدم عادي (User)', 'permissions_count' => 12, 'users_count' => 45, 'desc' => 'يمكنه عرض الفواتير الخاصة به فقط'],
            ['id' => 4, 'name' => 'مراقب (Observer)', 'permissions_count' => 30, 'users_count' => 5, 'desc' => 'صلاحية القراءة والمراقبة بدون إمكانية التعديل'],
        ];

        // Use real $roles if provided by controller
        $displayRoles = isset($roles) ? $roles : $rolesData;
    @endphp

    <!-- Table View Container (DEFAULT) -->
    <div id="table-view-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-table-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap" id="example1">
                                <thead>
                                    <tr>
                                        <th class="wd-10p">رقم</th>
                                        <th class="wd-30p">الدور (الصلاحية)</th>
                                        <th class="wd-20p text-center">الأذونات</th>
                                        <th class="wd-20p text-center">المستخدمين</th>
                                        <th class="wd-20p text-center">إجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($displayRoles as $role)
                                        @php 
                                            $rName = is_array($role) ? $role['name'] : $role->name; 
                                            $rPerms = is_array($role) ? $role['permissions_count'] : (isset($role->permissions) ? count($role->permissions) : 0);
                                            $rUsers = is_array($role) ? $role['users_count'] : 0;
                                            $rId = is_array($role) ? $role['id'] : $role->id;
                                            $rDesc = is_array($role) && isset($role['desc']) ? $role['desc'] : 'وصف الصلاحية غير متاح حالياً';
                                        @endphp
                                        <tr>
                                            <td style="color: #6b7280; font-weight: 500;">#{{ $rId }}</td>
                                            <td>
                                                <div style="font-weight: 700; color: #111827; margin-bottom: 4px;">{{ $rName }}</div>
                                                <div style="font-size: 13px; color: #6b7280;">{{ $rDesc }}</div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge-soft-purple">
                                                    <i class="fas fa-shield-alt"></i> {{ $rPerms }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge-soft-blue">
                                                    <i class="fas fa-users"></i> {{ $rUsers }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="#" class="icon-action edit" title="تعديل">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a href="#" class="icon-action delete" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">لا توجد أدوار مسجلة حالياً</td>
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

    <!-- Grid View Container -->
    <div id="grid-view-container">
        <div class="row">
            @forelse($displayRoles as $role)
                @php 
                    $rName = is_array($role) ? $role['name'] : $role->name; 
                    $rPerms = is_array($role) ? $role['permissions_count'] : (isset($role->permissions) ? count($role->permissions) : 0);
                    $rUsers = is_array($role) ? $role['users_count'] : 0;
                    $rId = is_array($role) ? $role['id'] : $role->id;
                    $rDesc = is_array($role) && isset($role['desc']) ? $role['desc'] : 'وصف الصلاحية غير متاح حالياً';
                @endphp
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="role-card">
                        
                        <!-- Dropdown Menu -->
                        <div class="dropdown">
                            <button class="card-menu-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-custom">
                                <a class="dropdown-item" href="#"><i class="fas fa-pen text-primary"></i> تعديل الصلاحية</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#"><i class="fas fa-trash"></i> حذف الصلاحية</a>
                            </div>
                        </div>

                        <div class="role-card-header">
                            <div class="role-icon-box">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <h5 class="role-title">{{ $rName }}</h5>
                            <p class="role-desc">{{ $rDesc }}</p>
                        </div>
                        
                        <div class="role-stats-box">
                            <div class="stat-group">
                                <span class="stat-val">{{ $rUsers }}</span>
                                <span class="stat-label">مستخدم</span>
                            </div>
                            <div class="stat-divider"></div>
                            <div class="stat-group">
                                <span class="stat-val">{{ $rPerms }}</span>
                                <span class="stat-label">إذن / صلاحية</span>
                            </div>
                        </div>

                        <a href="#" class="btn-view-role">
                            استعراض الصلاحية <i class="fas fa-arrow-left ml-1" style="font-size: 12px;"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h5 class="text-muted">لا توجد أدوار مسجلة حالياً</h5>
                </div>
            @endforelse
        </div>
    </div>

    <!-- row closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

    <!-- View Toggle Logic -->
    <script>
        $(document).ready(function() {
            $('#btn-grid-view').click(function() {
                if($(this).hasClass('active')) return; 
                
                $('.view-btn').removeClass('active');
                $(this).addClass('active');
                
                $('#table-view-container').hide();
                $('#grid-view-container').fadeIn(250);
            });

            $('#btn-table-view').click(function() {
                if($(this).hasClass('active')) return; 
                
                $('.view-btn').removeClass('active');
                $(this).addClass('active');
                
                $('#grid-view-container').hide();
                $('#table-view-container').fadeIn(250);
            });
        });
    </script>
@endsection