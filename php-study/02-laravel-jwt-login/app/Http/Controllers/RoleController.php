<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array{
        return [
            new Middleware('role:admin|manager|employee'),
            new Middleware('permission:view-role', only: ['index', 'show']),
            new Middleware('permission:create-role', only: ['create', 'store']),
            new Middleware('permission:edit-role', only: ['edit', 'update']),
            new Middleware('permission:delete-role', only: ['destroy']),
        ];
    }
    
    public function index()
    {
        return response()->json([
            Role::all()
        ]);
    }
    
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);
        $newRole = Role::create([
            'name' => $request->name
        ]);
        if($request->has('permissions')){
            $newRole->givePermissionTo($request->permissions);
        }
        return response()->json([
            'message' => 'Role added successfully',
            'Role' => $newRole,
            'Permissions' => $newRole->permissions
        ], 200);
    }

    public function show(string $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json([
                'message' => 'Role not found!'
            ], 404);
        }
        return response()->json([
            'Role' => $role->pluck('name'),
            'Permissions' => $role->permissions->pluck('name')->implode(', ')
        ], 200);
    }

    public function edit(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);
        $role = Role::find($id);
        $role->name = $request->name;
        if($request->has('permissions')){
            $role->syncPermissions($request->permissions);
        }
        $role->save();
        return response()->json([
            'message' => 'Role updated successfully',
            'Role' => $role,
            'Permissions' => $role->permissions
        ], 200);
    }
    
    public function destroy(string $id)
    {
        $Role = Role::find($id);
        if (!$Role) {
            return response()->json([
                'message' => 'Role not found!'
            ], 404);
        }
        $Role->delete();
        return response()->json([
            'message' => 'Role deleted successfully'
        ], 200);
    }
}