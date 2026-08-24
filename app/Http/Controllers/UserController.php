<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index()
    {
        $users = User::with('roles')->orderBy('id', 'DESC')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.add-user', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'status'   => $request->status,
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('users.index')
            ->with('success', 'تم إضافة المستخدم "' . $user->name . '" بنجاح.');
    }

    /**
     * Show the form for editing an existing user.
     */
    public function edit(User $user)
    {
        $roles     = Role::all();
        $userRoles = $user->roles->pluck('name')->toArray();
        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')
            ->with('success', 'تم تحديث بيانات المستخدم "' . $user->name . '" بنجاح.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth('web')->user()->id) {
            return redirect()->route('users.index')
                ->with('error', 'لا يمكنك حذف حسابك الخاص.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'تم حذف المستخدم "' . $userName . '" بنجاح.');
    }
}
