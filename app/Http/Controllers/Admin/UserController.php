<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Arr;
use Hash;
use Illuminate\Http\Request;
use Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('permissions')->get();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {

    }
    /**
     * Display the specified resource.
     */

    public function store(Request $request)
    {

    }
    public function show(string $id)
    {
        $user = User::find($id);
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $users = User::find($id);
        $allPermissions = Permission::all();
        $roles = Role::get();

        return view('admin.user.edit', compact('users', 'roles', 'allPermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate( $request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'exists:roles,id',
            'permissions' => 'exists:permissions,id',
        ]);

        $input = $request->all();

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,['password']);
        }

        $user = User::findOrFail($id);

        $user->update($input);

        $role = Role::findOrFail($request->role);
        $permission = Permission::findOrFail($request->permissions);
        $user->syncRoles($role->name);
        $user->syncPermissions($permission);

        return redirect()->route('users.index')->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User Deleted Successfully');
    }
}
