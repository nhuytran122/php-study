<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array{
        return [
            // new Middleware('role:admin|manager|employee'),
            // new Middleware('permission:view-permission', only: ['index', 'show']),
            // new Middleware('permission:create-permission', only: ['create', 'store']),
            // new Middleware('permission:edit-permission', only: ['edit', 'update']),
            // new Middleware('permission:delete-permission', only: ['destroy']),
            new Middleware('role:admin|manager|employee', only: ['index', 'show']),
            new Middleware('role:admin', except: ['index', 'show']),
        ];
        
    }
    
    public function index()
    {
        return response()->json([
            Permission::all()
        ]);
    }
    
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);
        $newPermission = Permission::create([
            'name' => $request->name
        ]);
        return response()->json([
            'message' => 'Permission added successfully',
            'permission' => $newPermission
        ], 200);
    }

    public function show(string $id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            return response()->json([
                'message' => 'Permission not found!'
            ], 404);
        }
    }

    public function edit(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string'
        ]);
        $permission = Permission::find($id);
        if (!$permission) {
            return response()->json([
                'message' => 'Permission not found!'
            ], 404);
        }
        $permission->update([
            'name' => $request->input('name')
        ]);
        return response()->json([
            'message' => 'Permission updated successfully',
            'permission' => $permission
        ], 200);

    }
    public function destroy(string $id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            return response()->json([
                'message' => 'Permission not found!'
            ], 404);
        }
        $permission->delete();
        return response()->json([
            'message' => 'Permission deleted successfully'
        ], 200);
    }
}