@extends('layouts.master')
@section('title')
    عرض دور
@endsection
@section('css')
    <style>
        body {
            background-color: #f4f7fe;
        }

        .page-header {
            margin-bottom: 1.5rem !important;
        }

        /* Role Info Card */
        .role-info-card {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
            background: #ffffff;
            padding: 28px 32px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .role-info-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .role-big-icon {
            width: 60px;
            height: 60px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            flex-shrink: 0;
        }

        .role-name {
            font-size: 22px;
            font-weight: 800;
            color: #111827;
            margin: 0 0 6px 0;
        }

        .role-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .meta-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13.5px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
        }

        .meta-badge.blue {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }

        .meta-badge.purple {
            background: #f3e8ff;
            color: #9333ea;
            border: 1px solid #e9d5ff;
        }

        .role-action-btns {
            display: flex;
            gap: 10px;
        }

        .btn-edit-role {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14.5px;
            font-weight: 600;
            background: #2563eb;
            color: white;
            border: none;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-edit-role:hover {
            background: #1d4ed8;
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-delete-role {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14.5px;
            font-weight: 600;
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-delete-role:hover {
            background: #fee2e2;
            color: #b91c1c;
            text-decoration: none;
        }

        /* Permission Display Cards */
        .perm-group-card {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: #ffffff;
            height: 100%;
            overflow: hidden;
        }

        .perm-group-header {
            background-color: #f8fafc;
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .perm-group-header-left {
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
            font-size: 15px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .perm-count-badge {
            background: #e0f2fe;
            color: #0369a1;
            font-size: 12px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .perm-group-body {
            padding: 8px 20px 16px;
        }

        /* Individual Permission Row */
        .perm-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 11px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .perm-item:last-child {
            border-bottom: none;
        }

        .perm-name {
            font-size: 14.5px;
            font-weight: 500;
            color: #374151;
        }

        /* Status Indicator */
        .perm-status {
            width: 46px;
            height: 26px;
            border-radius: 26px;
            display: flex;
            align-items: center;
            position: relative;
            flex-shrink: 0;
        }

        .perm-status.on {
            background-color: #10b981;
            justify-content: flex-start;
            padding-right: 3px;
        }

        .perm-status.off {
            background-color: #cbd5e1;
            justify-content: flex-end;
            padding-left: 3px;
        }

        .perm-status-dot {
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .perm-status.on .perm-name-indicator {
            color: #10b981;
            font-weight: 700;
        }

        /* Users section */
        .users-card {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .users-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
            font-weight: 700;
            color: #111827;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .users-list {
            padding: 16px 24px;
        }

        .user-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .user-row:last-child {
            border-bottom: none;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 14.5px;
            font-weight: 600;
            color: #111827;
        }

        .user-email {
            font-size: 13px;
            color: #6b7280;
        }

        .empty-users {
            text-align: center;
            padding: 30px;
            color: #9ca3af;
            font-size: 14px;
        }
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between page-header">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الصلاحيات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ عرض دور</span>
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

    @php
        // Dummy data for UI preview — replace with $role from controller
        $roleName      = isset($role) ? $role->name : 'محاسب';
        $usersCount    = isset($role) ? $role->users->count() : 4;
        $permsCount    = isset($role) ? $role->permissions->count() : 8;
        $currentPerms  = isset($role) ? $role->permissions->pluck('name')->toArray()
                       : ['الفواتير', 'قائمة الفواتير', 'إضافة فاتورة', 'تعديل فاتورة', 'حالة الدفع', 'طباعة فاتورة', 'الفواتير المدفوعة', 'الفواتير الغير مدفوعة'];

        $dummyUsers = [
            ['name' => 'أحمد محمد',   'email' => 'ahmed@company.com',   'initial' => 'أ'],
            ['name' => 'سارة علي',    'email' => 'sara@company.com',    'initial' => 'س'],
            ['name' => 'خالد يوسف',   'email' => 'khaled@company.com',  'initial' => 'خ'],
            ['name' => 'منى إبراهيم', 'email' => 'mona@company.com',    'initial' => 'م'],
        ];

        $users = isset($role) && $role->users->count() ? $role->users : $dummyUsers;
    @endphp

    <!-- Role Info Header Card -->
    <div class="role-info-card">
        <div class="role-info-left">
            <div class="role-big-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <h3 class="role-name">{{ $roleName }}</h3>
                <div class="role-meta">
                    <span class="meta-badge purple">
                        <i class="fas fa-shield-alt"></i> {{ $permsCount }} إذن ممنوح
                    </span>
                    <span class="meta-badge blue">
                        <i class="fas fa-users"></i> {{ $usersCount }} مستخدم مرتبط
                    </span>
                </div>
            </div>
        </div>
        <div class="role-action-btns">
            <a href="{{ route('roles.edit', isset($role) ? $role->id : 0) }}" class="btn-edit-role">
                <i class="fas fa-pen"></i> تعديل الدور
            </a>
            <form action="{{ route('roles.destroy', isset($role) ? $role->id : 0) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل انت متأكد من حذف هذه الصلاحية؟');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete-role">
                    <i class="fas fa-trash"></i> حذف
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Permissions Column -->
        <div class="col-xl-8 col-lg-7">
            <h5 class="mb-3" style="font-weight: 700; color: #1f2937;">الصلاحيات والأذونات الممنوحة:</h5>

            <div class="row">
                <!-- Invoices -->
                @php
                    $groups = [
                        ['title' => 'نظام الفواتير', 'icon' => 'fas fa-file-invoice-dollar', 'color' => '#eff6ff', 'iconColor' => '#2563eb',
                         'perms' => ['الفواتير', 'قائمة الفواتير', 'إضافة فاتورة', 'تعديل فاتورة', 'حذف فاتورة', 'تصدير اكسيل', 'حالة الدفع', 'طباعة فاتورة', 'الفواتير المدفوعة', 'الفواتير الغير مدفوعة', 'الفواتير المدفوعة جزئيا']],
                        ['title' => 'الأرشيف والمحذوفات', 'icon' => 'fas fa-archive', 'color' => '#fef2f2', 'iconColor' => '#dc2626',
                         'perms' => ['ارشيف فاتورة', 'الغاء ارشيف فاتورة', 'قائمة الفواتير المؤرشفة', 'حذف الفواتير المؤرشفة']],
                        ['title' => 'الأقسام والمنتجات', 'icon' => 'fas fa-boxes', 'color' => '#fef3c7', 'iconColor' => '#d97706',
                         'perms' => ['الاعدادات', 'الاقسام', 'اضافة قسم', 'تعديل قسم', 'حذف قسم', 'المنتجات', 'اضافة منتج', 'تعديل منتج', 'حذف منتج']],
                        ['title' => 'إدارة المستخدمين', 'icon' => 'fas fa-users-cog', 'color' => '#f3e8ff', 'iconColor' => '#9333ea',
                         'perms' => ['المستخدمين', 'قائمة المستخدمين', 'اضافة مستخدم', 'تعديل مستخدم', 'حذف مستخدم', 'صلاحيات المستخدمين']],
                        ['title' => 'التقارير', 'icon' => 'fas fa-chart-line', 'color' => '#e0f2fe', 'iconColor' => '#0284c7',
                         'perms' => ['التقارير', 'تقرير الفواتير', 'تقرير العملاء']],
                    ];
                @endphp

                @foreach($groups as $group)
                    @php
                        $activeCount = count(array_intersect($group['perms'], $currentPerms));
                    @endphp
                    <div class="col-md-6 mb-4">
                        <div class="perm-group-card">
                            <div class="perm-group-header">
                                <div class="perm-group-header-left">
                                    <div class="perm-group-icon" style="background: {{ $group['color'] }}; color: {{ $group['iconColor'] }};">
                                        <i class="{{ $group['icon'] }}"></i>
                                    </div>
                                    <h6 class="perm-group-title">{{ $group['title'] }}</h6>
                                </div>
                                <span class="perm-count-badge">{{ $activeCount }}/{{ count($group['perms']) }}</span>
                            </div>
                            <div class="perm-group-body">
                                @foreach($group['perms'] as $perm)
                                    @php $active = in_array($perm, $currentPerms); @endphp
                                    <div class="perm-item">
                                        <span class="perm-name" style="{{ $active ? 'color:#10b981; font-weight:600;' : 'color:#9ca3af;' }}">
                                            {{ $perm }}
                                        </span>
                                        <div class="perm-status {{ $active ? 'on' : 'off' }}">
                                            <div class="perm-status-dot"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Users Column -->
        <div class="col-xl-4 col-lg-5">
            <h5 class="mb-3" style="font-weight: 700; color: #1f2937;">المستخدمون المرتبطون:</h5>
            <div class="users-card">
                <div class="users-card-header">
                    <i class="fas fa-users" style="color:#2563eb;"></i>
                    المستخدمون الحاملون لهذا الدور
                    <span class="perm-count-badge mr-auto">{{ $usersCount }}</span>
                </div>
                <div class="users-list">
                    @forelse($users as $user)
                        @php
                            $uName    = is_array($user) ? $user['name']    : $user->name;
                            $uEmail   = is_array($user) ? $user['email']   : $user->email;
                            $uInitial = is_array($user) ? $user['initial'] : mb_substr($user->name, 0, 1);
                        @endphp
                        <div class="user-row">
                            <div class="user-avatar">{{ $uInitial }}</div>
                            <div>
                                <div class="user-name">{{ $uName }}</div>
                                <div class="user-email">{{ $uEmail }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-users">
                            <i class="fas fa-user-slash mb-2" style="font-size: 28px; display:block;"></i>
                            لا يوجد مستخدمون مرتبطون بهذا الدور
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
@endsection