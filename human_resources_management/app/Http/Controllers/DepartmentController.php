<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller {
    
    public function index()
    {
        return response()->json([
            Department::all()
        ]);
    }
    
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $newDepartment = Department::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return response()->json([
            'message' => 'Department added successfully',
            'department' => $newDepartment
        ], 200);
    }

    public function show(string $id)
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json([
                'message' => 'Department not found!'
            ], 404);
        }
    }

    public function edit(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $department = Department::find($id);
        if (!$department) {
            return response()->json([
                'message' => 'Department not found!'
            ], 404);
        }
        $department->update([
            'name' => $request->input('name')
        ]);
        return response()->json([
            'message' => 'Department updated successfully',
            'department' => $department
        ], 200);

    }
    public function destroy(string $id)
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json([
                'message' => 'Department not found!'
            ], 404);
        }
        $department->delete();
        return response()->json([
            'message' => 'Department deleted successfully'
        ], 200);
    }
}