@extends('layouts.master')
@section('title')
    قائمة المستخدمين
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

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-active {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .status-inactive {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .status-active::before, .status-inactive::before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: currentColor;
        }

        .user-info-cell {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: bold;
            margin-left: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .avatar-blue { background: rgba(1, 98, 232, 0.1); color: #0162e8; }
        .avatar-green { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .avatar-purple { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
        .avatar-orange { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }

        .user-name {
            font-weight: 600;
            color: #1c273c;
            margin-bottom: 2px;
            font-size: 14px;
        }

        .user-email {
            font-size: 12px;
            color: #8f9cca;
            margin-bottom: 0;
        }

        .roles-cell {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            align-items: center;
        }

        .role-badge {
            background-color: #eff6ff;
            color: #2563eb;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #bfdbfe;
            white-space: nowrap;
            display: inline-block;
        }

        .custom-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 25px rgba(0,0,0,0.03);
            overflow: hidden;
        }

        .table th {
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            background-color: #f8f9fc;
            border-bottom: 2px solid #e9ecef !important;
            padding: 15px !important;
        }

        .table td {
            vertical-align: middle;
            padding: 15px !important;
            border-bottom: 1px solid #f0f2f8;
        }
        
        .table tbody tr:hover {
            background-color: #fcfdfd;
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    قائمة المستخدمين</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a class="btn ripple btn-primary" href="{{ route('users.create') }}">اضافة مستخدم <i class="fa fa-plus"
                    aria-hidden="true"></i></a>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header pb-0 bg-transparent pt-4 px-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mg-b-5">قائمة المستخدمين</h4>
                            <p class="tx-13 text-muted mb-0">إدارة المستخدمين والصلاحيات الخاصة بهم في النظام</p>
                        </div>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>
                <div class="card-body px-4 pt-3">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-hover" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">#</th>
                                    <th class="wd-25p border-bottom-0">المستخدم</th>
                                    <th class="wd-20p border-bottom-0">تاريخ الإضافة</th>
                                    <th class="wd-15p border-bottom-0">حالة الحساب</th>
                                    <th class="wd-15p border-bottom-0">الصلاحيات</th>
                                    <th class="wd-10p border-bottom-0 text-center">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($users) && count($users) > 0)
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="user-info-cell">
                                                    @php
                                                        $colors = ['avatar-blue', 'avatar-green', 'avatar-purple', 'avatar-orange'];
                                                        $randomColor = $colors[array_rand($colors)];
                                                    @endphp
                                                    <div class="user-avatar {{ $randomColor }}">
                                                        {{ mb_substr($user->name, 0, 1, 'UTF-8') }}
                                                    </div>
                                                    <div>
                                                        <h6 class="user-name">{{ $user->name }}</h6>
                                                        <p class="user-email">{{ $user->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : 'N/A' }}</td>
                                            <td>
                                                @if ($user->status == 'active')
                                                    <span class="status-badge status-active">مفعل</span>
                                                @else
                                                    <span class="status-badge status-inactive">غير مفعل</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="roles-cell">
                                                    @forelse($user->getRoleNames() as $v)
                                                        <span class="role-badge">{{ $v }}</span>
                                                    @empty
                                                        <span class="text-muted" style="font-size:13px;">— لا توجد صلاحية</span>
                                                    @endforelse
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button aria-expanded="false" aria-haspopup="true"
                                                        class="btn-modern-dropdown" data-toggle="dropdown" type="button">
                                                        العمليات <i class="fas fa-angle-down mr-1"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right modern-dropdown-menu">
                                                        <a class="dropdown-item modern-dropdown-item" href="{{ route('users.edit', $user->id) }}">
                                                            <i class="text-info fas fa-pen"></i> تعديل بيانات
                                                        </a>
                                                        <x-delete-confirm
                                                            :action="route('users.destroy', $user->id)"
                                                            title="حذف المستخدم"
                                                            :message="'هل أنت متأكد من حذف المستخدم «' . $user->name . '»؟ لا يمكن التراجع عن هذا الإجراء.'"
                                                        >
                                                            <button type="button" class="dropdown-item modern-dropdown-item text-danger" style="border:none;background:transparent;width:100%;text-align:right;">
                                                                <i class="text-danger fas fa-trash"></i> حذف المستخدم
                                                            </button>
                                                        </x-delete-confirm>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <!-- Dummy data for UI showcase -->
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <div class="user-info-cell">
                                                <div class="user-avatar avatar-blue">أ</div>
                                                <div>
                                                    <h6 class="user-name">أحمد محمد</h6>
                                                    <p class="user-email">ahmed@example.com</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>2024-03-15</td>
                                        <td>
                                            <span class="status-badge status-active">مفعل</span>
                                        </td>
                                        <td>
                                            <span class="role-badge">مدير النظام</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn-modern-dropdown" data-toggle="dropdown" type="button">
                                                    العمليات <i class="fas fa-angle-down mr-1"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right modern-dropdown-menu">
                                                    <a class="dropdown-item modern-dropdown-item" href="#">
                                                        <i class="text-info fas fa-pen"></i> تعديل بيانات
                                                    </a>
                                                    <a class="dropdown-item modern-dropdown-item text-danger" href="#">
                                                        <i class="text-danger fas fa-trash"></i> حذف المستخدم
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>
                                            <div class="user-info-cell">
                                                <div class="user-avatar avatar-purple">س</div>
                                                <div>
                                                    <h6 class="user-name">سارة علي</h6>
                                                    <p class="user-email">sara@example.com</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>2024-03-20</td>
                                        <td>
                                            <span class="status-badge status-active">مفعل</span>
                                        </td>
                                        <td>
                                            <span class="role-badge">مستخدم</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn-modern-dropdown" data-toggle="dropdown" type="button">
                                                    العمليات <i class="fas fa-angle-down mr-1"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right modern-dropdown-menu">
                                                    <a class="dropdown-item modern-dropdown-item" href="#">
                                                        <i class="text-info fas fa-pen"></i> تعديل بيانات
                                                    </a>
                                                    <a class="dropdown-item modern-dropdown-item text-danger" href="#">
                                                        <i class="text-danger fas fa-trash"></i> حذف المستخدم
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>
                                            <div class="user-info-cell">
                                                <div class="user-avatar avatar-orange">م</div>
                                                <div>
                                                    <h6 class="user-name">محمود حسن</h6>
                                                    <p class="user-email">mahmoud@example.com</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>2024-04-05</td>
                                        <td>
                                            <span class="status-badge status-inactive">غير مفعل</span>
                                        </td>
                                        <td>
                                            <span class="role-badge">مستخدم</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn-modern-dropdown" data-toggle="dropdown" type="button">
                                                    العمليات <i class="fas fa-angle-down mr-1"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right modern-dropdown-menu">
                                                    <a class="dropdown-item modern-dropdown-item" href="#">
                                                        <i class="text-info fas fa-pen"></i> تعديل بيانات
                                                    </a>
                                                    <a class="dropdown-item modern-dropdown-item text-danger" href="#">
                                                        <i class="text-danger fas fa-trash"></i> حذف المستخدم
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
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
@endsection