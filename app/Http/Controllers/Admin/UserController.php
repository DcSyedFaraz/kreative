<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Arr;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Http\Request;
use Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // If the request is AJAX, return JSON data for DataTables
        if ($request->ajax()) {
            $data = User::with('roles')->latest()->get();
            return DataTables::of($data)
                // For full name, you could either create a computed property in the model or combine here:
                ->addColumn('full_name', fn($user) => "{$user->fname} {$user->lname}")
                // Format the verified column with badges:
                ->editColumn('email_verified_at', fn($user) => $user->email_verified_at
                    ? '<span class="badge bg-success">Verified</span>'
                    : '<span class="badge bg-warning text-dark">Pending</span>')
                // Compute the role column:
                ->addColumn('role', fn($user) => $user->roles->count() > 0
                    ? '<span class="badge bg-primary text-capitalize">' . $user->roles->first()->name . '</span>'
                    : '<span class="badge bg-secondary">No role</span>')
                // Format the created_at column:
                ->editColumn('created_at', function ($user) {
                    return $user->created_at->format('M d, Y');
                })
                ->addColumn('action', function ($user) {
                    $btn = '<div class="btn-group" role="group">';
                    $btn .= '<a href="' . route('users.show', $user->id) . '" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>';
                    $btn .= '<a href="' . route('users.edit', $user->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>';
                    // Delete button with a class and the delete route as a data attribute
                    $btn .= '<button type="button" class="btn btn-sm btn-danger btn-delete" data-route="' . route('users.destroy', $user->id) . '"><i class="fas fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['email_verified_at', 'role', 'action'])
                ->make(true);

        }

        // For non-AJAX requests, load the view normally
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }


    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = new User();
            $user->username = $request->username;
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            // Set email verification timestamp if the checkbox is checked
            if ($request->has('verify_email')) {
                $user->email_verified_at = Carbon::now();
            }

            $user->save();

            // Assign role to user
            if ($request->role) {
                $user->assignRole($request->role);
            }

            DB::commit();

            return redirect()->route('users.index')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create user. ' . $e->getMessage());
        }
    }
    public function show(string $id)
    {
        $user = User::find($id);
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $userRole = $user->roles->first();

        return view('admin.user.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        DB::beginTransaction();

        try {
            $user->username = $request->username;
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->email = $request->email;

            // Update password only if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // Update email verification status
            if ($request->has('verify_email') && !$user->email_verified_at) {
                $user->email_verified_at = Carbon::now();
            } elseif (!$request->has('verify_email') && $user->email_verified_at) {
                $user->email_verified_at = null;
            }

            $user->save();

            // Update user role - remove all existing roles and assign the new one
            if ($request->role) {
                // Sync roles (removes all existing roles and assigns the new one)
                $user->syncRoles($request->role);
            } else {
                // Remove all roles if none selected
                $user->syncRoles([]);
            }

            DB::commit();

            return redirect()->route('users.show', $user)
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update user. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // dd($user);
        DB::beginTransaction();

        try {
            // Prevent deletion of the currently authenticated user
            if (auth()->id() === $user->id) {
                throw new \Exception("You cannot delete your own account.");
            }

            $user->delete();

            DB::commit();

            return redirect()->route('users.index')
                ->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Failed to delete user. ' . $e->getMessage());
        }
    }

    /**
     * Search for users based on query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        $users = User::where('username', 'like', "%{$query}%")
            ->orWhere('fname', 'like', "%{$query}%")
            ->orWhere('lname', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->paginate(15);

        return view('admin.user.index', compact('users', 'query'));
    }
}
