<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array{
        return [
            // new Middleware('role:admin|manager|employee'),
            // new Middleware('permission:view-user', only: ['index', 'show']),
            // new Middleware('permission:create-user', only: ['create', 'store']),
            // new Middleware('permission:edit-user', only: ['edit', 'update']),
            // new Middleware('permission:delete-user', only: ['destroy']),
            new Middleware('role:admin|manager|employee', only: ['index', 'show']),
            new Middleware('role:admin|manager', except: ['index', 'show']),
        ];
    } 
    
    public function index()
    {
        return response()->json([
            User::all()
        ]);
    }
    
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
            
        ]);
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('123456')
        ]);
        if($request->has('roles')){
            $newUser->assignRole($request->roles);
        }
        return response()->json([
            'message' => 'User added successfully',
            'user' => $newUser
        ], 200);
    }

    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found!'
            ], 404);
        }
    }

    public function edit(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            // 'email' => 'required|email|unique:users,email,'.$id.',id'
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
        ]);
        
        if (!$user) {
            return response()->json([
                'message' => 'User not found!'
            ], 404);
        }
        $user->update([
            'name' => $request->input('name')
        ]);
        if($request->has('roles')){
            $user->syncRoles($request->roles);
        }
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user,
            'roles' => $user->roles->pluck('name')->implode(', ')
        ], 200);

    }
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found!'
            ], 404);
        }
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }
}