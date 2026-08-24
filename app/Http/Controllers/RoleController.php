<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
        
        // Optional: Middleware for permissions
        // $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        // $this->middleware('permission:role-create', ['only' => ['create','store']]);
        // $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $roles = $this->roleService->getAllRoles();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array',
        ], [
            'name.required' => 'يرجي ادخال اسم الصلاحية',
            'name.unique' => 'اسم الصلاحية مسجل مسبقا',
            'permission.required' => 'يرجي اختيار صلاحية واحدة على الأقل',
        ]);

        try {
            $this->roleService->createRole($request->all());
            return redirect()->route('roles.index')->with('success', 'تم اضافة الصلاحية بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ اثناء الحفظ');
        }
    }

    public function show($id)
    {
        $role = $this->roleService->findRoleById($id);
        $rolePermissions = $role->permissions->pluck('name')->all();
        
        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id)
    {
        $role = $this->roleService->findRoleById($id);
        $rolePermissions = $role->permissions->pluck('name')->all();

        return view('roles.edit', compact('role', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
            'permission' => 'required|array',
        ], [
            'name.required' => 'يرجي ادخال اسم الصلاحية',
            'name.unique' => 'اسم الصلاحية مسجل مسبقا',
            'permission.required' => 'يرجي اختيار صلاحية واحدة على الأقل',
        ]);

        try {
            $this->roleService->updateRole($id, $request->all());
            return redirect()->route('roles.index')->with('success', 'تم تحديث الصلاحية بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ اثناء التحديث');
        }
    }

    public function destroy($id)
    {
        try {
            $this->roleService->deleteRole($id);
            return redirect()->route('roles.index')->with('success', 'تم حذف الصلاحية بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ اثناء الحذف');
        }
    }
}
